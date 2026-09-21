// One Chrome session; for every (width, slide) pair captures the hero with the
// copy hidden plus the copy's real bounding boxes. A companion PHP pass then
// reads the PNGs and reports the worst contrast white text would have against
// what is actually painted behind it.
//
// node measure.js <url> <tag> [width,width,...]

const { spawn } = require('child_process');
const fs = require('fs');
const net = require('net');

const CHROME = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const PORT = 9333;

const FORCE = `(() => {
  let s = document.getElementById('__force');
  if (!s) { s = document.createElement('style'); s.id = '__force'; document.head.appendChild(s); }
  s.textContent = \`
    .owl-item.active .header-heading2 h5,
    .owl-item.active .header-heading2 h2,
    .owl-item.active .header-heading2 p,
    .owl-item.active .btn-area1,
    .owl-item.active .img1,
    .owl-item.active .bg-elements {
      opacity: 1 !important; transform: none !important; transition: none !important;
    }
    .owl-item:not(.active) .header-heading2, .owl-item:not(.active) .btn-area1 {
      visibility: hidden !important;
    }\`;
  return 'ok';
})()`;

const HIDE_COPY = `(() => {
  let s = document.getElementById('__hide');
  if (!s) { s = document.createElement('style'); s.id = '__hide'; document.head.appendChild(s); }
  s.textContent = '.owl-item.active .header-heading2 h5,' +
    '.owl-item.active .header-heading2 h2,' +
    '.owl-item.active .header-heading2 p,' +
    '.owl-item.active .btn-area1 { visibility: hidden !important; }';
  return 'ok';
})()`;

const SHOW_COPY = `(() => { const s = document.getElementById('__hide'); if (s) s.textContent=''; return 'ok'; })()`;

const RECTS = `(() => {
  const slide = document.querySelector('.owl-item.active .main-hero-area')
             || document.querySelector('.header-carousel-area3 .main-hero-area');
  const r = (sel) => {
    const el = slide && slide.querySelector(sel);
    if (!el) return null;
    const b = el.getBoundingClientRect();
    return { x: Math.round(b.x), y: Math.round(b.y), w: Math.round(b.width), h: Math.round(b.height) };
  };
  return {
    headline: r('.header-heading2 h2'),
    body: r('.header-heading2 p'),
    eyebrow: r('.header-heading2 h5'),
    text: (slide && slide.querySelector('.header-heading2 h2')) ? slide.querySelector('.header-heading2 h2').textContent.trim().slice(0,40) : null,
  };
})()`;

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

function waitForPort(port, timeoutMs = 20000) {
  const t0 = Date.now();
  return new Promise((resolve, reject) => {
    const tick = () => {
      const s = net.connect(port, '127.0.0.1');
      s.on('connect', () => { s.destroy(); resolve(); });
      s.on('error', () => {
        s.destroy();
        if (Date.now() - t0 > timeoutMs) return reject(new Error('no CDP'));
        setTimeout(tick, 200);
      });
    };
    tick();
  });
}

function connect(wsUrl) {
  return new Promise((resolve, reject) => {
    const ws = new WebSocket(wsUrl);
    let id = 0;
    const pending = new Map();
    ws.addEventListener('open', () => resolve({
      send(method, params = {}) {
        const msgId = ++id;
        ws.send(JSON.stringify({ id: msgId, method, params }));
        return new Promise((res, rej) => pending.set(msgId, { res, rej }));
      },
      close: () => ws.close(),
    }));
    ws.addEventListener('message', (ev) => {
      const m = JSON.parse(ev.data);
      if (m.id && pending.has(m.id)) {
        const { res, rej } = pending.get(m.id);
        pending.delete(m.id);
        m.error ? rej(new Error(JSON.stringify(m.error))) : res(m.result);
      }
    });
    ws.addEventListener('error', reject);
  });
}

async function main() {
  const url = process.argv[2];
  const tag = process.argv[3] || 'local';
  const widths = (process.argv[4] || '390,768,1440').split(',').map(Number);

  const chrome = spawn(CHROME, [
    `--remote-debugging-port=${PORT}`,
    `--user-data-dir=${require('os').tmpdir()}\\cdp-measure`,
    '--headless=new', '--hide-scrollbars', '--no-first-run',
    '--no-default-browser-check', '--force-device-scale-factor=1',
    '--window-size=1280,900', 'about:blank',
  ], { stdio: 'ignore' });

  const manifest = [];
  try {
    await waitForPort(PORT);
    const list = await (await fetch(`http://127.0.0.1:${PORT}/json/list`)).json();
    const c = await connect(list.find((t) => t.type === 'page').webSocketDebuggerUrl);
    await c.send('Page.enable');
    await c.send('Runtime.enable');

    for (const width of widths) {
      await c.send('Emulation.setDeviceMetricsOverride', {
        width, height: 900, deviceScaleFactor: 1, mobile: width < 768,
      });
      await c.send('Page.navigate', { url });
      await sleep(10000);            // clear the 8000ms hero transform
      await c.send('Runtime.evaluate', { expression: FORCE });

      for (const slide of (process.argv[5] || '0,1,2').split(',').map(Number)) {
        await c.send('Runtime.evaluate', {
          expression: `window.jQuery && window.jQuery('.header-carousel-area3').trigger('to.owl.carousel', [${slide}, 0, true]); 'ok'`,
        });
        await sleep(1400);
        await c.send('Runtime.evaluate', { expression: FORCE });
        await sleep(300);

        const rects = await c.send('Runtime.evaluate', { expression: RECTS, returnByValue: true });

        await c.send('Runtime.evaluate', { expression: HIDE_COPY });
        await sleep(400);
        const { data } = await c.send('Page.captureScreenshot', { format: 'png' });
        const file = `bg-${tag}-${width}-s${slide}.png`;
        fs.writeFileSync(file, Buffer.from(data, 'base64'));
        await c.send('Runtime.evaluate', { expression: SHOW_COPY });

        manifest.push({ width, slide, file, ...rects.result.value });
        console.error(`  captured ${width}px slide ${slide}: ${rects.result.value.text}`);
      }
    }
    c.close();
  } finally {
    chrome.kill();
  }

  fs.writeFileSync(`manifest-${tag}.json`, JSON.stringify(manifest, null, 2));
  console.log(`manifest-${tag}.json`);
}

main().catch((e) => { console.error('ERR', e.message); process.exit(1); });
