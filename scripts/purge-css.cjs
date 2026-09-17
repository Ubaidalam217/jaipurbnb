// Post-build CSS purge. Run with `node scripts/purge-css.cjs` after
// `npm run build` - see purgecss.config.cjs for what/why.
const fs = require('fs');
const path = require('path');
const { PurgeCSS } = require('purgecss');
const safelist = require('../purgecss.config.cjs').safelist;

async function main() {
    const manifestPath = path.join(__dirname, '..', 'public', 'build', 'manifest.json');
    const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
    const cssEntry = manifest['resources/scss/main.scss'];
    if (!cssEntry || !cssEntry.file) {
        console.error('Could not find main.scss CSS output in manifest.json');
        process.exit(1);
    }
    const cssPath = path.join(__dirname, '..', 'public', 'build', cssEntry.file);
    const beforeSize = fs.statSync(cssPath).size;

    const root = path.join(__dirname, '..').replace(/\\/g, '/');
    const cssGlobPath = cssPath.replace(/\\/g, '/');
    const result = await new PurgeCSS().purge({
        content: [
            `${root}/resources/views/**/*.blade.php`,
            `${root}/resources/js/**/*.js`,
        ],
        css: [cssGlobPath],
        safelist,
        defaultExtractor: (content) => content.match(/[\w-/:%.]+(?<!:)/g) || [],
    });

    fs.writeFileSync(cssPath, result[0].css);
    const afterSize = fs.statSync(cssPath).size;
    console.log(`${cssEntry.file}: ${(beforeSize / 1024).toFixed(1)}KB -> ${(afterSize / 1024).toFixed(1)}KB (-${(100 * (1 - afterSize / beforeSize)).toFixed(0)}%)`);
}

main();
