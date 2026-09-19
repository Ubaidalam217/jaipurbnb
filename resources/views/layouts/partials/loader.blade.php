{{--
  PRELOADER REMOVED (perf) - do not reinstate.

  The template shipped a <div class="preloader"> here: an opaque white
  position:fixed overlay at 100%x100%, z-index 999999, torn down by
  main.js on $(window).on("load") + a 200ms setTimeout.

  window.load waits for EVERY subresource - all ~31 images (~2MB), the
  Font Awesome woff2s, the JS bundle. So the entire viewport stayed blank
  white until the last byte of the heaviest below-fold gallery image
  landed, then the finished page appeared all at once. Lighthouse's
  filmstrip showed exactly that step function (pure white at 1125ms,
  fully complete at 2250ms), which is what Speed Index penalises hardest -
  SI was 5.0-5.9s while FCP/LCP were already fine at ~1.9s.

  There is nothing to replace it with: the page renders progressively on
  its own now. If a loading indicator is ever wanted again, it must not
  cover content and must not be gated on window.load.
--}}

<!--===== PROGRESS STARTS=======-->
{{--
  Scroll-to-top overrides.

  Kept here rather than in layout/pages/_others.scss for the same reason the
  homepage hero overrides live in index.blade.php: Hostinger has no Node and
  public/build is gitignored, so an SCSS edit costs a local `npm run build`
  plus a manual bundle upload, while this deploys as a plain file copy. The
  SCSS block carries a pointer comment back to here so the two do not drift.

  Two separate problems are fixed below.
--}}
<style>
    /* 1. STACKING. _others.scss ships z-index:10000, which is above every
          Bootstrap layer - so the button floated on top of the open mobile
          nav drawer (.offcanvas, z-index 1045) and would cover any modal
          (1055) too. 1020 puts it under the sticky navbar (1030, set in
          navbar.blade.php), the drawer, and modals, while still clearing
          ordinary page content. */
    .progress-wrap {
        z-index: 1020;

        /* 2. STACKING WITH THE WHATSAPP FLOAT. The floating WhatsApp button
              (layouts/partials/whatsapp-float.blade.php) occupies the
              bottom-right corner: 56px square, inset 24px. This one is lifted
              clear above it rather than sharing the corner.

                bottom = 24 (float inset) + 56 (float height) + 16 (gap) = 96px

              right is pulled from the SCSS default of 30px to 24px so both
              buttons are 56px wide on the same 24px gutter and their centres
              line up vertically. Change one inset and you must change the
              other - the numbers are load-bearing in both files. */
        right: 24px;
        bottom: 96px;
    }

    @media (max-width: 767.98px) {
        /* 3. OVERLAP. At 56px inset 30px from each edge the button sat
              directly over the right-hand end of the full-width WhatsApp /
              Call buttons on listing cards and over footer links. Shrinking
              to 44px and tucking it into the corner moves it clear of both.
              44px is the floor here - it is the minimum comfortable touch
              target, so do not shrink this further.

              The safe-area inset keeps it above the iOS home indicator on
              notched iPhones; it evaluates to 0px everywhere else, so the
              effective offset stays 14px on Android and on desktop Chrome's
              device emulation.

              Offsets again mirror the mobile WhatsApp float, which is 52px
              at right:14px / bottom:14px there:

                bottom = 14 (float inset) + 52 (float height) + 10 (gap) = 76px
                right  = 14 + 52/2 - 44/2 = 18px, i.e. centred on the 52px
                         circle below it despite being 8px narrower. */
        .progress-wrap {
            right: 18px;
            bottom: calc(76px + env(safe-area-inset-bottom, 0px));
            height: 44px;
            width: 44px;
        }

        /* The arrow glyph is drawn by ::after (and ::before on hover), both
           hardcoded to 56px with a matching line-height. Left alone they
           would render a 56px box inside a 44px circle - the arrow sits low
           and right of centre and the hover swap misaligns. */
        .progress-wrap::after,
        .progress-wrap::before {
            height: 44px;
            width: 44px;
            line-height: 44px;
            font-size: 15px;
        }
    }
</style>
<div class="paginacontainer">
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
</div>
<!--===== PROGRESS ENDS=======-->