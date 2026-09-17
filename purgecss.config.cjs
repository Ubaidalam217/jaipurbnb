// Post-build step: strips unused CSS from the compiled Vite bundle.
//
// Run AFTER `npm run build`, targeting the hashed output file directly
// (path resolved by scripts/purge-css.cjs from public/build/manifest.json).
// Bootstrap's own bloat is already gone at the source level (see
// resources/scss/vendor/_bootstrap-custom.scss) - this pass is for the
// leftover custom SCSS from removed template pages (extra hero variants,
// testimonials, gallery v1/v2, about/blog/team sections) that never got
// deleted when their blade markup did.
//
// The safelist covers classes that exist only at runtime, added by JS
// libraries or plugins, and would never appear in a static content scan:
//   - Owl Carousel: builds its whole DOM structure (.owl-stage, .owl-item,
//     .owl-dot, .owl-nav, ...) from JS, only .owl-carousel itself is in
//     blade source
//   - nice-select: replaces the <select> with its own .nice-select/.list/
//     .option/.selected/.open markup
//   - AOS: adds .aos-animate on scroll
//   - Bootstrap Offcanvas: toggles .show/.showing/.hiding
//   - main.js's own scroll/click handlers: .sticky, .active, .open,
//     .loaded (hero reveal), .body-overlay's .active variant
module.exports = {
    safelist: {
        standard: [
            /^owl-/,
            /^aos-/,
            /^nice-select/,
            'list', 'option', 'selected', 'open', 'disabled', 'current',
            'show', 'showing', 'hiding', 'sticky', 'active', 'loaded',
            'fade', 'collapsing',
        ],
        deep: [/^owl-/, /^nice-select/],
    },
};
