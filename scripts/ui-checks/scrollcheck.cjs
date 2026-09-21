// Sweeps pages x widths in ONE Chrome session and reports every element that
// is actually painting a vertical scrollbar.
//
// Ground truth is offsetWidth - clientWidth - borders > 0: a scrollbar
// consumes horizontal space inside the border box. Inline boxes are excluded
// because offsetWidth/clientWidth are meaningless for them (clientHeight 0).
//
// node scrollcheck.cjs <base> <path,path,...> <width,width,...>

const { spawn } = require('child_process');
const net = require('net');

const CHROME = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const PORT = 9444;

const PROBE = `(() => {
  const bar = (el) => {
    const cs = getComputedStyle(el);
    if (cs.display === 'inline') return 0;
    const b = (parseFloat(cs.borderLeftWidth)||0) + (parseFloat(cs.borderRightWidth)||0);
    return Math.round(el.offsetWidth - el.clientWidth - b);
  };
  const name = (el) => {
    let s = el.tagName.toLowerCase();
    if (el.id) s += '#' + el.id;
    else if (el.className && typeof el.className === 'string') {
      const c = el.className.trim().split(/\\s+/).slice(0,2).join('.');
      if (c) s += '.' + c;
    }
    return s;
  };
  const de = document.documentElement;
  const out = [];
  for (const el of document.querySelectorAll('*')) {
    if (el === de) continue;
    if (el.clientHeight <= 0) continue;
    const w = bar(el);
    const cs = getComputedStyle(el);
    const scrollable = cs.overflowY === 'auto' || cs.overflowY === 'scroll';
    if (w > 0 && scrollable && el.scrollHeight - el.clientHeight > 1) {
      out.push({ sel: name(el), bar: w, oy: cs.overflowY,
                 clientH: el.clientHeight, scrollH: el.scrollHeight });
    }
  }
  return {
    innerScrollers: out,
    doc: { clientH: de.clientHeight, scrollH: de.scrollHeight,
           clientW: de.clientWidth, scrollW: de.scrollWidth },
    horizontalOverflow: de.scrollWidth - de.clientWidth,
    bodyClientH: document.body.clientHeight,
    bodyScrollH: document.body.scrollHeight,
    // Bottom-most visible content, to prove nothing got clipped off the end.
    lastContentBottom: (() => {
      let max = 0;
      for (const el of document.body.querySelectorAll('*')) {
        const cs = getComputedStyle(el);
        if (cs.display === 'none' || cs.position === 'fixed') continue;
        const r = el.getBoundingClientRect();
        if (!r.height) continue;
        const bo = r.bottom + scrollY;
        if (bo > max) max = bo;
      }
      return Math.round(max);
    })(),
  };
})()`;

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

function waitForPort(port, t = 20000) {
  const t0 = Date.now();
  return new Promise((res, rej) => {
    const tick = () => {
      const s = net.connect(port, '127.0.0.1');
      s.on('connect', () => { s.destroy(); res(); });
      s.on('error', () => { s.destroy();
        if (Date.now() - t0 > t) return rej(new Error('no CDP'));
        setTimeout(tick, 200); });
    };
    tick();
  });
}

function connect(wsUrl) {
  return new Promise((resolve, reject) => {
    const ws = new WebSocket(wsUrl);
    let id = 0; const pending = new Map();
    ws.addEventListener('open', () => resolve({
      send(method, params = {}) {
        const m = ++id;
        ws.send(JSON.stringify({ id: m, method, params }));
        return new Promise((res, rej) => pending.set(m, { res, rej }));
      },
      close: () => ws.close(),
    }));
    ws.addEventListener('message', (ev) => {
      const m = JSON.parse(ev.data);
      if (m.id && pending.has(m.id)) {
        const { res, rej } = pending.get(m.id); pending.delete(m.id);
        m.error ? rej(new Error(JSON.stringify(m.error))) : res(m.result);
      }
    });
    ws.addEventListener('error', reject);
  });
}

async function main() {
  const base = process.argv[2];
  const paths = process.argv[3].split(',');
  const widths = process.argv[4].split(',').map(Number);

  const chrome = spawn(CHROME, [
    `--remote-debugging-port=${PORT}`,
    `--user-data-dir=${require('os').tmpdir()}\\cdp-scrollcheck`,
    '--headless=new', '--no-first-run', '--no-default-browser-check',
    '--force-device-scale-factor=1', '--window-size=1280,900', 'about:blank',
  ], { stdio: 'ignore' });   // scrollbars deliberately NOT hidden

  let bad = 0;
  try {
    await waitForPort(PORT);
    const list = await (await fetch(`http://127.0.0.1:${PORT}/json/list`)).json();
    const c = await connect(list.find((t) => t.type === 'page').webSocketDebuggerUrl);
    await c.send('Page.enable'); await c.send('Runtime.enable');

    for (const w of widths) {
      await c.send('Emulation.setDeviceMetricsOverride', {
        width: w, height: 900, deviceScaleFactor: 1, mobile: w < 768 });
      for (const p of paths) {
        await c.send('Page.navigate', { url: base + p });
        await sleep(4200);
        const r = (await c.send('Runtime.evaluate',
          { expression: PROBE, returnByValue: true })).result.value;
        const extra = r.innerScrollers.length;
        if (extra > 0) bad++;
        const clipped = r.lastContentBottom > r.doc.scrollH + 2;
        if (clipped) bad++;
        console.log(
          `${String(w).padStart(5)}px ${p.padEnd(13)} ` +
          `innerScrollbars=${extra} ${extra ? JSON.stringify(r.innerScrollers) : ''}` +
          ` docScrollH=${r.doc.scrollH} lastContentBottom=${r.lastContentBottom}` +
          `${clipped ? '  *** CONTENT CLIPPED ***' : ''}` +
          `${r.horizontalOverflow > 0 ? `  *** H-OVERFLOW ${r.horizontalOverflow} ***` : ''}`
        );
      }
    }
    c.close();
  } finally { chrome.kill(); }

  console.log(bad === 0
    ? '\nPASS - exactly one scrollbar (the window) on every page/width, nothing clipped.'
    : `\nFAIL - ${bad} problem(s).`);
  process.exit(bad === 0 ? 0 : 1);
}

main().catch((e) => { console.error('ERR', e.message); process.exit(1); });
