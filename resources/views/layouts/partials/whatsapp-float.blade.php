{{--
  Floating WhatsApp support button - rendered on EVERY page from
  layouts/base.blade.php.

  Points at JaipurBnB's own support line (config('contact.whatsapp'), set
  via CONTACT_WHATSAPP in .env), NOT at a host's number. Per-listing guest
  to host contact stays on the WhatsApp/Call buttons inside each listing -
  see layouts/partials/contact-buttons.blade.php. Those are the product;
  this one is "I need help using the site".

  The glyph is an INLINE SVG rather than <i class="fa-brands fa-whatsapp">
  on purpose. Font Awesome is subset at build time by
  scripts/subset-fontawesome.cjs and the CSS bundle is gitignored, so
  anything icon-font based would need a local `npm run build` plus a manual
  bundle upload to Hostinger (no Node on that box). An inline SVG deploys as
  a plain file copy, and paints with the HTML instead of waiting on a webfont.

  Styles are in this partial for the same reason - see the matching notes in
  navbar.blade.php and loader.blade.php.
--}}

@php
    $jbWaNumber = config('contact.whatsapp');
    $jbWaMessage = 'Hi, I need help with booking a stay in Jaipur';
    $jbWaHref = 'https://wa.me/' . $jbWaNumber . '?text=' . rawurlencode($jbWaMessage);
@endphp

<style>
    .jb-wa-float {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 9999;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        /* WhatsApp's own brand green, same value as the per-listing button in
           contact-buttons.blade.php. Deliberately NOT recoloured to brand
           terracotta - the whole point of this control is that it is
           instantly recognisable as WhatsApp. */
        background: #25D366;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .22);
        transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .jb-wa-float:hover,
    .jb-wa-float:focus {
        background: #1EBE58;
        color: #fff;
        text-decoration: none;
        transform: scale(1.08);
        box-shadow: 0 8px 22px rgba(37, 211, 102, .42);
    }

    .jb-wa-float:active {
        transform: scale(1.02);
    }

    .jb-wa-float:focus-visible {
        outline: 3px solid #0B4F2B;
        outline-offset: 3px;
    }

    .jb-wa-float__icon {
        display: block;
        width: 30px;
        height: 30px;
        fill: currentColor;
    }

    /*
      z-index is 9999, which is above Bootstrap's offcanvas (1045) and modal
      (1055) layers. That is intentional for ordinary page content, but it
      would also park a green circle on top of the open mobile nav drawer and
      on top of any modal - exactly the bug that forced .progress-wrap down to
      1020 (see loader.blade.php). Rather than lower this below the drawer and
      lose it behind sticky page furniture, the button is simply taken out of
      play while an overlay is open.

      :has() is unsupported in pre-2023 browsers; there the button stays put,
      which is the same behaviour as before this rule existed. No layout
      depends on it.
    */
    body:has(.offcanvas.show) .jb-wa-float,
    body:has(.modal.show) .jb-wa-float {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    @media (max-width: 767.98px) {
        /* Slightly smaller and tucked further into the corner so it clears
           the full-width WhatsApp / Call buttons on listing cards and the
           footer links. The safe-area inset keeps it above the iOS home
           indicator; it is 0px everywhere else.

           If these numbers change, the .progress-wrap offsets in
           loader.blade.php must change with them - the scroll-to-top button
           is positioned to sit directly ABOVE this one. */
        .jb-wa-float {
            right: 14px;
            bottom: calc(14px + env(safe-area-inset-bottom, 0px));
            width: 52px;
            height: 52px;
        }

        .jb-wa-float__icon {
            width: 28px;
            height: 28px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .jb-wa-float {
            transition: none;
        }

        .jb-wa-float:hover,
        .jb-wa-float:focus {
            transform: none;
        }
    }
</style>

<a class="jb-wa-float"
   href="{{ $jbWaHref }}"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Chat with JaipurBnB on WhatsApp"
   title="Chat with us on WhatsApp">
    <svg class="jb-wa-float__icon" viewBox="0 0 448 512" aria-hidden="true" focusable="false">
        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
    </svg>
</a>
