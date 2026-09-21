(() => {
  const r = (el) => {
    if (!el) return null;
    const b = el.getBoundingClientRect();
    return { x: Math.round(b.x), y: Math.round(b.y), w: Math.round(b.width), h: Math.round(b.height) };
  };
  const slide = document.querySelector('.header-carousel-area3 .owl-item.active .main-hero-area')
             || document.querySelector('.header-carousel-area3 .main-hero-area');
  const q = (sel) => slide ? slide.querySelector(sel) : null;

  const nav = document.querySelector('.jb-nav');
  const navInner = document.querySelector('.jb-nav__inner');
  const toggle = document.querySelector('.jb-nav__toggle');
  const logo = document.querySelector('.jb-nav__brand img, .jb-nav__brand');
  const book = document.querySelector('.jb-nav__book-mobile');

  return {
    viewport: { w: innerWidth, h: innerHeight, dpr: devicePixelRatio },
    docScrollW: document.documentElement.scrollWidth,
    hero: {
      area: r(slide),
      img1: r(q('.img1')),
      h2: r(q('.header-heading2 h2')),
      p: r(q('.header-heading2 p')),
      h5: r(q('.header-heading2 h5')),
      btn: r(q('.btn-area1')),
    },
    header: {
      nav: r(nav),
      inner: r(navInner),
      navHeight: nav ? Math.round(nav.getBoundingClientRect().height) : null,
      toggle: r(toggle),
      logo: r(logo),
      bookNow: r(book),
    },
  };
})();
