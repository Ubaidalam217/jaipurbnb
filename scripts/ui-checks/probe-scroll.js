(() => {
  // Every element that is actually producing a vertical scrollbar of its own:
  // it overflows AND its computed overflow-y lets it scroll. Anything else
  // may overflow but renders no bar.
  const path = (el) => {
    const parts = [];
    for (let n = el; n && n.nodeType === 1 && parts.length < 5; n = n.parentElement) {
      let s = n.tagName.toLowerCase();
      if (n.id) s += '#' + n.id;
      else if (n.className && typeof n.className === 'string') {
        const c = n.className.trim().split(/\s+/).slice(0, 3).join('.');
        if (c) s += '.' + c;
      }
      parts.unshift(s);
    }
    return parts.join(' > ');
  };

  const scrollers = [];
  const overflowing = [];

  for (const el of document.querySelectorAll('*')) {
    const cs = getComputedStyle(el);
    const oy = cs.overflowY;
    const ox = cs.overflowX;
    const vOver = el.scrollHeight - el.clientHeight;
    const hOver = el.scrollWidth - el.clientWidth;

    const canScrollY = oy === 'auto' || oy === 'scroll' || (oy === 'hidden' && false);
    if (canScrollY && vOver > 1 && el.clientHeight > 0) {
      scrollers.push({
        sel: path(el),
        overflowY: oy, overflowX: ox,
        clientH: el.clientHeight, scrollH: el.scrollHeight, excess: vOver,
        height: cs.height, maxHeight: cs.maxHeight,
        position: cs.position,
        rect: (() => { const b = el.getBoundingClientRect(); return [Math.round(b.x), Math.round(b.y), Math.round(b.width), Math.round(b.height)]; })(),
      });
    }

    // Anything with an explicit non-visible overflow-y, even if not currently
    // overflowing - these are the candidates that become a second bar as soon
    // as content grows.
    if ((oy === 'auto' || oy === 'scroll') && el !== document.documentElement && el !== document.body) {
      overflowing.push({ sel: path(el), overflowY: oy, height: cs.height, maxHeight: cs.maxHeight, vOver });
    }
  }

  const de = document.documentElement;
  return {
    url: location.pathname,
    viewport: { w: innerWidth, h: innerHeight },
    docEl: {
      overflow: getComputedStyle(de).overflow,
      overflowX: getComputedStyle(de).overflowX,
      overflowY: getComputedStyle(de).overflowY,
      clientH: de.clientHeight, scrollH: de.scrollHeight,
      clientW: de.clientWidth, scrollW: de.scrollWidth,
    },
    body: {
      overflow: getComputedStyle(document.body).overflow,
      overflowX: getComputedStyle(document.body).overflowX,
      overflowY: getComputedStyle(document.body).overflowY,
      height: getComputedStyle(document.body).height,
      clientH: document.body.clientHeight, scrollH: document.body.scrollHeight,
    },
    actualScrollers: scrollers,
    declaredScrollables: overflowing,
  };
})();
