#!/usr/bin/env node
/**
 * Download the Poppins woff2 files Google Fonts would serve, for self-hosting.
 *
 * Why self-host: the <link> to fonts.googleapis.com is render-blocking AND
 * cross-origin, so first paint waits on DNS + TLS + the CSS round trip to a
 * third party before it can even discover the font URLs on a SECOND origin
 * (fonts.gstatic.com). preconnect hides some of that but not the serial
 * dependency. Self-hosted, the @font-face rules ship inside the already-inlined
 * critical CSS, so there is no blocking request at all and the font files are
 * same-origin, cache-controlled by us, and served over the connection that is
 * already open.
 *
 * Only the `latin` unicode-range subset is taken. Google serves latin,
 * latin-ext and devanagari per weight; this is an English-language site for a
 * single Indian city and the Devanagari subset alone is larger than everything
 * else combined.
 *
 * Re-run manually if the weight list changes. Not wired into the build: it hits
 * the network, and the files it writes are committed.
 */
const fs = require('fs');
const path = require('path');

const WEIGHTS = [300, 400, 500, 600, 700];
// public/, not resources/: these are served as static files with stable
// unhashed names so they can be <link rel=preload>ed by name. See the src
// comment in resources/scss/critical.scss.
const OUT_DIR = path.resolve(__dirname, '../public/fonts/poppins');

// A real desktop Chrome UA. Google Fonts serves .ttf (4x bigger) to any UA it
// does not recognise as woff2-capable - which is exactly what happened when a
// Lighthouse run went out under a UA it did not know.
const UA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 ' +
           '(KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36';

(async () => {
  fs.mkdirSync(OUT_DIR, { recursive: true });

  const cssUrl = `https://fonts.googleapis.com/css2?family=Poppins:wght@${WEIGHTS.join(';')}&display=swap`;
  const css = await (await fetch(cssUrl, { headers: { 'User-Agent': UA } })).text();

  // Each @font-face block carries a /* subset */ comment before it.
  const blocks = css.split('/*').slice(1);
  let got = 0;

  for (const raw of blocks) {
    const subset = raw.slice(0, raw.indexOf('*/')).trim();
    if (subset !== 'latin') continue;

    const weight = raw.match(/font-weight:\s*(\d+)/)?.[1];
    const url = raw.match(/url\((https:[^)]+\.woff2)\)/)?.[1];
    if (!weight || !url) continue;

    const buf = Buffer.from(await (await fetch(url)).arrayBuffer());
    const file = path.join(OUT_DIR, `poppins-${weight}-latin.woff2`);
    fs.writeFileSync(file, buf);
    console.log(`  poppins-${weight}-latin.woff2  ${(buf.length / 1024).toFixed(1)} KiB`);
    got++;
  }

  if (got !== WEIGHTS.length) {
    console.error(`Expected ${WEIGHTS.length} latin faces, got ${got}. Not overwriting the SCSS.`);
    process.exit(1);
  }
  console.log(`\n${got} files written to resources/fonts/poppins/`);
})();
