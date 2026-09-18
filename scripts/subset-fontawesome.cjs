#!/usr/bin/env node
/**
 * Font Awesome subsetter.
 *
 * The vendored FA Pro 6.4.2 CSS ships the full icon fonts: fa-solid-900.woff2
 * is 320 KiB and fa-brands-400.woff2 is 108 KiB, and both are downloaded on
 * every page load. The site uses ~20 glyphs. Subsetting to just those takes the
 * pair from 429 KiB to a few KiB, which matters doubly here because fonts are
 * part of what the page's render/load path waits on.
 *
 * Glyphs come from THREE sources, and all three matter - an icon missed here
 * renders as an invisible box in production:
 *   1. `fa-*` class names in blade views  (e.g. <i class="fa-solid fa-phone">)
 *   2. `fa-*` class names in JS           (owl carousel navText injects markup)
 *   3. raw `content: "\fXXX"` codepoints in our own SCSS, where a pseudo-element
 *      draws a glyph directly without ever naming a fa-* class
 *
 * Run via `npm run build` (wired as a prebuild step) or standalone:
 *   node scripts/subset-fontawesome.cjs
 *
 * Writes subset fonts next to the originals as fa-*-subset.woff2. The
 * @font-face src in resources/scss/components/_fontawesome.scss points at
 * those; the originals are left on disk untouched so this is reversible.
 */
const fs = require('fs');
const path = require('path');
const { execFileSync } = require('child_process');

const ROOT = path.resolve(__dirname, '..');
const FA_CSS = path.join(ROOT, 'resources/scss/components/_fontawesome.scss');
const FONT_DIR = path.join(ROOT, 'resources/fonts');

const SCAN = [
  { dir: 'resources/views', exts: ['.blade.php'] },
  { dir: 'resources/js', exts: ['.js'] },
  { dir: 'resources/scss', exts: ['.scss'], skip: ['_fontawesome.scss'] },
];

function walk(dir, exts, skip = []) {
  const out = [];
  for (const e of fs.readdirSync(dir, { withFileTypes: true })) {
    const p = path.join(dir, e.name);
    if (e.isDirectory()) out.push(...walk(p, exts, skip));
    else if (exts.some((x) => e.name.endsWith(x)) && !skip.includes(e.name)) out.push(p);
  }
  return out;
}

// ---- collect every source file's text -------------------------------------
let corpus = '';
for (const s of SCAN) {
  const dir = path.join(ROOT, s.dir);
  if (!fs.existsSync(dir)) continue;
  for (const f of walk(dir, s.exts, s.skip)) corpus += fs.readFileSync(f, 'utf8') + '\n';
}

// ---- source 1+2: fa-* class names -> codepoints, resolved via the FA CSS ---
const faCss = fs.readFileSync(FA_CSS, 'utf8');

// Build name -> codepoint map from the FA stylesheet's own glyph rules.
//
// Match the whole rule, not just one selector: FA writes `::before` (double
// colon), puts `content:` on the following line, and aliases icons by grouping
// selectors with commas -
//     .fa-search::before,
//     .fa-magnifying-glass::before {
//       content: "\f002"; }
// A pattern anchored to a single selector immediately before `{` silently
// resolves only the LAST name in each group, which is how an earlier version of
// this script produced a subset missing nearly every icon on the site.
const nameToCp = new Map();
const ruleRe = /([^{}]+)\{\s*content:\s*"\\([0-9a-fA-F]{3,5})"\s*;?\s*\}/g;
for (let m; (m = ruleRe.exec(faCss)); ) {
  const cp = parseInt(m[2], 16);
  for (const sel of m[1].split(',')) {
    const hit = sel.trim().match(/^\.fa-([a-z0-9-]+)::?before$/);
    if (hit) nameToCp.set(hit[1], cp);
  }
}

// Structural/style classes that are not icons
const NOT_ICONS = new Set([
  'solid', 'regular', 'light', 'thin', 'duotone', 'brands', 'sharp', 'fw', 'lg', 'sm', 'xs',
  '2x', '3x', '4x', '5x', 'spin', 'pulse', 'border', 'pull-left', 'pull-right', 'inverse',
  'stack', 'stack-1x', 'stack-2x', 'beat', 'fade', 'flip', 'rotate-90', 'rotate-180',
  'rotate-270', 'li', 'ul', 'beat-fade', 'bounce', 'shake', 'spin-pulse', 'spin-reverse',
]);

const usedNames = new Set();
for (const m of corpus.matchAll(/\bfa-([a-z0-9-]+)\b/g)) {
  if (!NOT_ICONS.has(m[1])) usedNames.add(m[1]);
}

const codepoints = new Set();
const unresolved = [];
for (const n of usedNames) {
  if (nameToCp.has(n)) codepoints.add(nameToCp.get(n));
  else unresolved.push(n);
}

// ---- source 3: raw `content: "\fXXX"` written directly in our own SCSS -----
const rawCps = new Set();
for (const m of corpus.matchAll(/content:\s*"\\([0-9a-fA-F]{3,5})"/g)) {
  const cp = parseInt(m[1], 16);
  // ignore non-icon private-use-adjacent noise like \201c quotes
  if (cp >= 0xe000) { codepoints.add(cp); rawCps.add(cp); }
}

// ---- safety margin --------------------------------------------------------
// Directional chevrons/arrows get injected by plugins at runtime in markup that
// does not always exist in source. They are ~40 bytes each in the subset; the
// cost of guessing wrong is a visibly broken control.
const SAFETY = ['angle-up', 'angle-down', 'angle-left', 'angle-right', 'arrow-up', 'arrow-down',
  'arrow-left', 'arrow-right', 'xmark', 'check', 'star', 'star-half-stroke', 'bars',
  'chevron-up', 'chevron-down', 'chevron-left', 'chevron-right'];
for (const n of SAFETY) if (nameToCp.has(n)) codepoints.add(nameToCp.get(n));

const sorted = [...codepoints].sort((a, b) => a - b);
const unicodesArg = sorted.map((c) => 'U+' + c.toString(16).toUpperCase()).join(',');

console.log(`Font Awesome subset: ${usedNames.size} fa-* class names seen, ` +
            `${rawCps.size} raw content codepoints, ${sorted.length} glyphs total`);
if (unresolved.length) {
  console.log(`  note: ${unresolved.length} fa-* token(s) had no glyph in the FA CSS ` +
              `(usually style/utility classes): ${unresolved.slice(0, 12).join(', ')}`);
}

// ---- subset ---------------------------------------------------------------
// Only the two faces the site actually downloads. The other FA faces
// (thin/light/regular/duotone) are declared in the CSS but no rule that ships
// references them, so no browser ever fetches them.
const FACES = ['fa-solid-900', 'fa-brands-400'];
let before = 0, after = 0;

for (const face of FACES) {
  const src = path.join(FONT_DIR, `${face}.woff2`);
  const dst = path.join(FONT_DIR, `${face}-subset.woff2`);
  if (!fs.existsSync(src)) { console.error(`  MISSING: ${src}`); process.exitCode = 1; continue; }

  execFileSync('python', [
    '-m', 'fontTools.subset', src,
    `--unicodes=${unicodesArg}`,
    '--flavor=woff2',
    '--layout-features=',      // icon fonts need no GSUB/GPOS
    '--no-hinting',
    '--desubroutinize',
    `--output-file=${dst}`,
  ], { stdio: 'inherit' });

  const b = fs.statSync(src).size, a = fs.statSync(dst).size;
  before += b; after += a;
  console.log(`  ${face}: ${(b / 1024).toFixed(1)} KiB -> ${(a / 1024).toFixed(1)} KiB ` +
              `(-${(100 - (a / b) * 100).toFixed(1)}%)`);
}

console.log(`  TOTAL: ${(before / 1024).toFixed(1)} KiB -> ${(after / 1024).toFixed(1)} KiB ` +
            `(saved ${((before - after) / 1024).toFixed(1)} KiB)`);
