// Headless-Chrome driver over raw CDP.
//
// --window-size does NOT give a real small layout viewport on Windows (there is
// a ~500px window floor, so a 390px request lays out at 512 and merely crops).
// Emulation.setDeviceMetricsOverride is the only thing that produces a true
// mobile viewport here.
//
// Usage:
//   node cdp.js shot <url> <width> <outfile> [--full] [--dpr=2]
//   node cdp.js eval <url> <width> <jsFile>
//
// The hero copy reveals via CSS transitions gated on the .active class Owl
// adds; those never settle under automation, so the hero screenshots blank
// unless we force them visible. That injection is applied for both modes.

const { spawn } = require('child_process');
const fs = require('fs');
const net = require('net');

const CHROME = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const PORT = 9222 + (parseInt(process.env.CDP_PORT_OFFSET || '0', 10));

const FORCE_HERO = `
  (function () {
    const s = document.createElement('style');
    s.id = '__cdp_force_hero';
    // Scope to the ACTIVE slide only. Forcing every slide visible stacks all
    // three headlines on top of each other (the ghost "...nal Service." from
    // slide 2), which is an artifact of the instrumentation, not the site.
    s.textContent = \`
      .owl-item.active .header-heading2 h5,
      .owl-item.active .header-heading2 h2,
      .owl-item.active .header-heading2 p,
      .owl-item.active .btn-area1,
      .owl-item.active .img1,
      .owl-item.active .bg-elements {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
      }
      .owl-item:not(.active) .header-heading2,
      .owl-item:not(.active) .btn-area1 { visibility: hidden !important; }
      [data-aos] { opacity: 1 !important; transform: none !important; }
      .reveal { opacity: 1 !important; }
    \`;
    document.head.appendChild(s);
  })();
`;

function waitForPort(port, timeoutMs = 20000) {
  const started = Date.now();
  return new Promise((resolve, reject) => {
    const tick = () => {
      const sock = net.connect(port, '127.0.0.1');
      sock.on('connect', () => { sock.destroy(); resolve(); });
      sock.on('error', () => {
        sock.destroy();
        if (Date.now() - started > timeoutMs) return reject(new Error('CDP port never opened'));
        setTimeout(tick, 200);
      });
    };
    tick();
  });
}

async function getWsUrl(port) {
  const res = await fetch(`http://127.0.0.1:${port}/json/list`);
  const tabs = await res.json();
  const page = tabs.find((t) => t.type === 'page');
  if (!page) throw new Error('no page target');
  return page.webSocketDebuggerUrl;
}

function connect(wsUrl) {
  return new Promise((resolve, reject) => {
    const ws = new WebSocket(wsUrl);
    let id = 0;
    const pending = new Map();

    ws.addEventListener('open', () => {
      resolve({
        send(method, params = {}) {
          const msgId = ++id;
          ws.send(JSON.stringify({ id: msgId, method, params }));
          return new Promise((res, rej) => pending.set(msgId, { res, rej }));
        },
        close: () => ws.close(),
      });
    });

    ws.addEventListener('message', (ev) => {
      const msg = JSON.parse(ev.data);
      if (msg.id && pending.has(msg.id)) {
        const { res, rej } = pending.get(msg.id);
        pending.delete(msg.id);
        msg.error ? rej(new Error(JSON.stringify(msg.error))) : res(msg.result);
      }
    });

    ws.addEventListener('error', reject);
  });
}

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

async function main() {
  const [mode, url, widthArg, outArg, ...rest] = process.argv.slice(2);
  const width = parseInt(widthArg, 10);
  const full = rest.includes('--full');
  const dprArg = rest.find((a) => a.startsWith('--dpr='));
  const dpr = dprArg ? parseFloat(dprArg.split('=')[1]) : 1;
  const height = parseInt((rest.find((a) => a.startsWith('--h=')) || '--h=900').split('=')[1], 10);
  const mobile = width < 768;

  const userDir = require('os').tmpdir() + '\\cdp-profile-' + PORT;
  const chrome = spawn(CHROME, [
    `--remote-debugging-port=${PORT}`,
    `--user-data-dir=${userDir}`,
    '--headless=new',
    '--hide-scrollbars',
    '--no-first-run',
    '--no-default-browser-check',
    '--disable-extensions',
    '--force-device-scale-factor=1',
    '--window-size=1280,900',
    'about:blank',
  ], { stdio: 'ignore' });

  try {
    await waitForPort(PORT);
    const ws = await getWsUrl(PORT);
    const c = await connect(ws);

    await c.send('Page.enable');
    await c.send('Runtime.enable');
    await c.send('Emulation.setDeviceMetricsOverride', {
      width, height, deviceScaleFactor: dpr, mobile,
    });
    await c.send('Page.addScriptToEvaluateOnNewDocument', { source: FORCE_HERO });

    const slideArg = rest.find((a) => a.startsWith('--slide='));
    const hideCopy = rest.includes('--hide-copy');

    await c.send('Page.navigate', { url });
    // The hero img1 rides an 8000ms transform transition; anything under
    // ~9s captures it mid-slide and the photo is still offset.
    await sleep(mode === 'shot' ? 10000 : 9500);
    if (slideArg) {
      const n = parseInt(slideArg.split('=')[1], 10);
      await c.send('Runtime.evaluate', {
        expression: `window.jQuery('.header-carousel-area3').trigger('to.owl.carousel', [${n}, 0, true]); 'ok'`,
      });
      await sleep(1500);
    }

    await c.send('Runtime.evaluate', { expression: FORCE_HERO });

    if (hideCopy) {
      // Leaves the copy's layout box intact (visibility, not display) so the
      // measured rect still matches the real render - we just want to see
      // what is BEHIND the glyphs.
      await c.send('Runtime.evaluate', {
        expression: `(() => {
          const s = document.createElement('style');
          s.textContent = '.owl-item.active .header-heading2 h5,' +
            '.owl-item.active .header-heading2 h2,' +
            '.owl-item.active .header-heading2 p,' +
            '.owl-item.active .btn-area1 { visibility: hidden !important; }';
          document.head.appendChild(s); return 'ok';
        })()`,
      });
    }

    await sleep(600);

    if (mode === 'eval') {
      const js = fs.readFileSync(outArg, 'utf8');
      const r = await c.send('Runtime.evaluate', {
        expression: js, returnByValue: true, awaitPromise: true,
      });
      console.log(JSON.stringify(r.result.value, null, 2));
    } else {
      if (full) {
        const m = await c.send('Page.getLayoutMetrics');
        const h = Math.min(Math.ceil(m.cssContentSize.height), 16000);
        await c.send('Emulation.setDeviceMetricsOverride', {
          width, height: h, deviceScaleFactor: dpr, mobile,
        });
        await sleep(1200);
      }
      // --to=<selector> scrolls that element to the top of the viewport, so a
      // section further down the page can be captured at viewport size
      // instead of as a giant full-page PNG.
      const toArg = rest.find((a) => a.startsWith('--to='));
      if (toArg) {
        const sel = toArg.slice(5);
        await c.send('Runtime.evaluate', {
          expression: `(() => {
            const el = document.querySelector(${JSON.stringify(sel)});
            if (!el) return 'missing';
            window.scrollTo(0, window.scrollY + el.getBoundingClientRect().top - ${
              (rest.find((a) => a.startsWith('--pad=')) || '--pad=0').split('=')[1]
            });
            return 'ok';
          })()`,
        });
        await sleep(2000);   // let lazy images in view decode
      }

      const { data } = await c.send('Page.captureScreenshot', {
        format: 'png', captureBeyondViewport: false,
      });
      fs.writeFileSync(outArg, Buffer.from(data, 'base64'));
      console.log('wrote ' + outArg);
    }

    c.close();
  } finally {
    chrome.kill();
  }
}

main().catch((e) => { console.error('ERR', e.message); process.exit(1); });
