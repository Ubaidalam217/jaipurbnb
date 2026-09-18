@extends('layouts.base', ['logo5' => true])

@section('title', 'JaipurBnB - Authentic Jaipur Stays')

@section('meta_description', 'Find verified homestays, heritage havelis, boutique apartments and luxury villas across Jaipur. Browse free and contact hosts directly on WhatsApp or by phone.')

{{--
  Organization schema. Built as a PHP array and json_encode()d rather than
  hand-written JSON so the contact details, which come from config, are
  escaped properly - an unescaped quote in a value would otherwise produce
  invalid JSON-LD that Google silently discards.
--}}
@push('jsonld')
  <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'JaipurBNB',
        'url' => url('/'),
        'logo' => asset('img/jaipurbnb-logo.svg'),
        'email' => config('contact.email'),
        'telephone' => config('contact.phone_tel'),
        'description' => 'A paid listing directory for verified Jaipur stays. Hosts subscribe to list; guests browse free and contact hosts directly.',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '401, Kings Avenue, Kings Road, Nirman Nagar AB',
            'addressLocality' => 'Jaipur',
            'addressRegion' => 'Rajasthan',
            'postalCode' => '302019',
            'addressCountry' => 'IN',
        ],
        'areaServed' => [
            '@type' => 'City',
            'name' => 'Jaipur',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
  </script>
@endpush

@push('preload')
  {{--
    LCP element: hero slide 1 (see the fetchpriority="high" <picture> below).
    imagesrcset/imagesizes mirror that <source> exactly so the preload fetches
    the SAME candidate the browser will actually render, not a guess at one
    fixed size - a mismatched preload just wastes bandwidth on an extra
    download. type filters this to browsers that will use the webp <source>;
    everything else falls through to the plain <img> with no preload hint,
    which is fine since it is not this render's LCP-critical fetch anyway.
  --}}
  <link rel="preload" as="image" type="image/webp"
        imagesrcset="/img/all-images/hero/hero-img6-400w.webp 400w,
                      /img/all-images/hero/hero-img6-800w.webp 800w,
                      /img/all-images/hero/hero-img6-1200w.webp 1200w"
        imagesizes="100vw">
@endpush

@section('content')
  @include('layouts.partials.navbar')

  {{--
    Hero polish, scoped to this page.

    Kept in a <style> block rather than _hero.scss on purpose: Hostinger has
    no Node and public/build is gitignored, so every SCSS edit costs a local
    `npm run build` plus a manual bundle upload. Colour-token changes have to
    go through SCSS (they compile into variables), but page-level overrides
    like these deploy as a plain file copy. Same pattern as contact.blade.php
    and the legal pages.
  --}}
  <style>
    /* The hero image occupies the right 50% and previously butted straight
       up against the flat charcoal panel - a hard vertical seam down the
       middle of the fold. The template's own ::after overlay is opacity:0 on
       desktop, so it was doing nothing. Give it a real gradient: opaque
       charcoal at the seam, clearing by ~45% across the image. This softens
       the join AND darkens the region nearest the headline, which is what
       lifts contrast for the white text.

       Two stacked layers now. The first (topmost) is the seam softener, and
       its mid-stops are warm burnt-orange rather than charcoal - that is
       what stops the fold reading as grey and ties the photo back to the
       terracotta brand. The second is a golden-hour wash: warm light at the
       top of the frame falling to shadow at the bottom, which is the Pink
       City at dusk rather than a flat scrim. Charcoal is still the anchor at
       0% so the seam itself stays perfectly opaque. */
    .header-carousel-area3 .main-hero-area .img1::after {
      background:
        linear-gradient(
          to right,
          #2F3E46 0%,
          rgba(47, 62, 70, .84) 15%,
          rgba(120, 50, 0, .35) 42%,
          rgba(120, 50, 0, .14) 68%,
          rgba(0, 0, 0, .38) 100%
        ),
        linear-gradient(
          to bottom,
          rgba(224, 168, 106, .18) 0%,
          rgba(224, 122, 95, .07) 45%,
          rgba(0, 0, 0, .34) 100%
        );
      opacity: 1;
    }

    /* Vibrance on the photograph itself. These are the client's own Jaipur
       property shots and several were shot flat; a modest saturate/contrast
       lift makes the sandstone and pink render the way the city actually
       looks. Kept low - past ~1.2 saturation the terracotta overlay above
       starts to clip into orange. */
    .header-carousel-area3 .main-hero-area .img1 img {
      filter: saturate(1.14) contrast(1.06) brightness(1.02);
    }

    /* <picture> is an inline wrapper by default, which would collapse the
       height:100% the template gives the inner <img>. */
    .header-carousel-area3 .main-hero-area .img1 picture {
      display: block;
      height: 100%;
      width: 100%;
    }

    /* Bottom vignette across the whole hero - stops the image bleeding into
       the section below and reads as more deliberate/premium. Warmed to
       match the overlay above; a neutral charcoal vignette over a warm
       gradient reads as dirt. */
    .header-carousel-area3 .main-hero-area .img1 {
      box-shadow: inset 0 -90px 90px -60px rgba(38, 24, 16, .88);
    }

    @media (max-width: 767.98px) {
      /* On mobile the image is full-width *behind* the copy, so it needs a
         flat scrim rather than a directional one. Warm in the middle band
         where the photo shows through, but deliberately heavy at both ends:
         white body text sits on this, so the scrim carries the contrast. */
      .header-carousel-area3 .main-hero-area .img1::after {
        background: linear-gradient(
          to bottom,
          rgba(47, 62, 70, .74) 0%,
          rgba(107, 45, 10, .72) 48%,
          rgba(20, 26, 30, .86) 100%
        );
        opacity: 1;
      }
    }

    /* Eyebrow above the headline ("N Neighborhoods Covered", "Verified Local
       Hosts"). Was inheriting a template colour; pin it to brand terracotta.

       NOTE: this deliberately carries no ::before / ::after rule. A short gold
       accent bar used to sit after the text; the client read it as a stray
       dash, so it is gone. Icon and text only - do not reintroduce one. The
       pill below is a background on the h5 itself, NOT a pseudo-element, so
       it cannot regress into anything dash-like.

       Colour is #F2A88E, a lighter tint of brand #E07A5F. Flat #E07A5F on the
       charcoal panel is only ~3.5:1, under AA for text this small; the tint
       is ~5.5:1. The brand terracotta is still what you read - it is the same
       hue, just lifted for the dark ground. */
    .header-carousel-area3 .main-hero-area .header-heading2 h5 {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: #F2A88E;
      font-family: 'Poppins', sans-serif;
      font-size: 13px;
      font-weight: 600;
      line-height: 1;
      text-transform: uppercase;
      letter-spacing: .1em;
      padding: 9px 18px;
      border-radius: 999px;
      background: rgba(224, 122, 95, .15);
      border: 1px solid rgba(224, 122, 95, .38);
      -webkit-backdrop-filter: blur(6px);
      backdrop-filter: blur(6px);
    }

    .header-carousel-area3 .main-hero-area .header-heading2 h5 i {
      color: #F2A88E;
      font-size: 12px;
    }

    /* Headline. The template leaves this at the global h2 size, which on a
       1440px screen is smaller than the section headings further down the
       page - the fold read as the quietest thing on the homepage. Size it
       explicitly and tighten the leading/tracking so it holds together as a
       display line. The shadow is what keeps it legible over the brightest
       part of the photo on mobile, where the copy sits on the image. */
    .header-carousel-area3 .main-hero-area .header-heading2 h2 {
      font-size: 60px;
      line-height: 1.08;
      font-weight: 700;
      letter-spacing: -.02em;
      color: #fff;
      text-shadow: 0 2px 26px rgba(0, 0, 0, .38);
    }

    /* Subheading. Light weight against the bold headline is the whole point
       of the hierarchy - do not raise this to 400.

       Opacity is NOT set here on purpose: _hero.scss animates this paragraph
       from opacity:0 to 0.9 !important on the active slide, so the rendered
       result is already the white/90 we want. Overriding it would freeze the
       reveal animation mid-flight. */
    .header-carousel-area3 .main-hero-area .header-heading2 p {
      font-size: 19px;
      line-height: 1.7;
      font-weight: 300;
      color: #fff;
      max-width: 34em;
    }

    @media (max-width: 1199.98px) {
      .header-carousel-area3 .main-hero-area .header-heading2 h2 { font-size: 48px; }
    }

    @media (max-width: 991.98px) {
      .header-carousel-area3 .main-hero-area .header-heading2 h2 { font-size: 42px; }
    }

    @media (max-width: 767.98px) {
      .header-carousel-area3 .main-hero-area .header-heading2 h2 { font-size: 34px; }
      .header-carousel-area3 .main-hero-area .header-heading2 p  { font-size: 17px; }
      .header-carousel-area3 .main-hero-area .header-heading2 h5 {
        font-size: 11px;
        padding: 8px 14px;
        letter-spacing: .08em;
      }
    }

    /* CTA. Already a terracotta pill from the template; what it lacked was
       lift off the photo. Shadow plus a hover rise.

       The translate is safe on the anchor: _hero.scss runs the slide-in
       transform on the parent .btn-area1, not on this element.

       Now a secondary action - the search bar below is the primary one - so
       it deliberately keeps the lighter brand terracotta rather than the
       deeper #B34D33 of the Search button. */
    .header-carousel-area3 .main-hero-area .btn-area1 .header-btn3 {
      padding: 19px 34px;
      box-shadow: 0 14px 30px -12px rgba(0, 0, 0, .55);
    }

    /* theme/_comon.scss seeds this button's hover with a 40px pale circle
       (::after, #F0C4B5 at left:5px/top:5px) that expands to 94% width on
       hover. At rest it sits over the first letter and reads as a smudge -
       the same complaint the client raised about the eyebrow accent dash.
       Drop it and drive the hover from the background instead. */
    .header-carousel-area3 .main-hero-area .btn-area1 .header-btn3::after {
      content: none;
    }

    /* The hover background MUST be restated here. _comon.scss switches to
       --ztc-bg-bg-7 (#081511, near-black) on the assumption that the
       terracotta ::after expands to cover it; with ::after gone that would
       leave charcoal text on near-black. #B34D33 + white is 5.2:1. */
    .header-carousel-area3 .main-hero-area .btn-area1 .header-btn3:hover {
      background: #B34D33;
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 20px 38px -14px rgba(0, 0, 0, .6);
    }

    /* _hero.scss pads the hero 280px top / 148px bottom. That was fine when
       the fold ended at the CTA, but the navbar already takes ~100px above
       it, so the headline did not start until ~380px down and the new search
       bar landed below the fold on a 900px-tall laptop - the least prominent
       possible place for the page's primary action. It also left a large
       empty charcoal field above the headline, which is most of what made
       the hero read as dull.

       Desktop only: _hero.scss already uses 200px/120px at $md and $xs, and
       on a phone the search bar sits in normal flow below the hero anyway. */
    @media (min-width: 992px) {
      .header-carousel-area3 .main-hero-area {
        padding: 180px 0 140px;
      }
    }

    /* ------------------------------------------------------------------ *
     * Hero search bar.
     *
     * Lives OUTSIDE .header-carousel-area3, not inside a slide. Owl runs
     * with loop:true, which clones slides into .owl-item.cloned - a form
     * inside a slide would be duplicated 2-3x in the DOM, giving repeated
     * ids and repeated <label for>. One instance, floated over the hero's
     * bottom edge instead.
     *
     * It is a plain GET form at properties.browse using that page's own
     * query parameters (neighborhood / stay_type / guests), so submitting
     * lands on a pre-filtered browse page with no new controller code.
     * ------------------------------------------------------------------ */
    .jb-hero-search {
      position: relative;
      z-index: 5;
      margin-top: -46px;
    }

    .jb-hero-search-form {
      display: flex;
      align-items: stretch;
      max-width: 860px;
      padding: 8px 8px 8px 4px;
      border-radius: 999px;
      background: #fff;
      box-shadow:
        0 24px 60px -24px rgba(20, 26, 30, .55),
        0 2px 8px rgba(20, 26, 30, .08);
    }

    .jb-hsf-field {
      flex: 1 1 0;
      min-width: 0;
      padding: 8px 20px;
      border-right: 1px solid rgba(47, 62, 70, .12);
    }

    .jb-hsf-field:last-of-type {
      border-right: 0;
    }

    .jb-hsf-field label {
      display: block;
      margin-bottom: 1px;
      font-family: 'Poppins', sans-serif;
      font-size: 11px;
      font-weight: 600;
      line-height: 1.4;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: #6B7A82;
      cursor: pointer;
    }

    /* Native <select>, kept native by .jb-native-select - main.js otherwise
       runs niceSelect() over every select on the page and swaps it for a
       styled div, which would not survive the pill layout. Same opt-out the
       host property forms use. */
    .jb-hsf-field select {
      width: 100%;
      padding: 0 20px 0 0;
      border: 0;
      background-color: transparent;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' fill='none' stroke='%239AA6AC' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right center;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      font-weight: 500;
      line-height: 1.5;
      color: #2F3E46;
      text-overflow: ellipsis;
      cursor: pointer;
      outline: none;
    }

    /* #B34D33 is the deep-terracotta CTA token from utils/_colors.scss.
       Brand #E07A5F would only be 2.6:1 behind white label text; this is
       5.2:1 and still unmistakably the same hue. */
    .jb-hsf-submit {
      display: inline-flex;
      flex: 0 0 auto;
      align-self: stretch;
      align-items: center;
      gap: 10px;
      margin-left: 8px;
      padding: 0 32px;
      border: 0;
      border-radius: 999px;
      background: #B34D33;
      box-shadow: 0 10px 22px -10px rgba(179, 77, 51, .8);
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      font-weight: 600;
      color: #fff;
      cursor: pointer;
      transition: background .25s ease, transform .25s ease, box-shadow .25s ease;
    }

    .jb-hsf-submit:hover {
      background: #9B4029;
      transform: translateY(-1px);
      box-shadow: 0 16px 28px -12px rgba(179, 77, 51, .85);
    }

    .jb-hsf-field select:focus-visible,
    .jb-hsf-submit:focus-visible {
      outline: 2px solid #B34D33;
      outline-offset: 3px;
    }

    /* The featured-stay pill is absolutely positioned at bottom:50px inside
       the hero, which the floating search card would clip through. Lift it
       clear. _hero.scss already hides this card entirely below 992px, so
       this only needs to apply on desktop. Both the resting and .active
       selectors are set so the slide-in animation has nothing to animate
       between. */
    @media (min-width: 992px) {
      .header-carousel-area3 .main-hero-area .auhtor-box,
      .header-carousel-area3 .active .main-hero-area .auhtor-box {
        bottom: 104px;
      }
    }

    /* Tablet: the three fields still fit side by side, but the pill is too
       wide for the button to sit inline, so it wraps to its own full-width
       row. The 999px radius has to go with it - on a two-row block it bows
       the short sides into an oval. */
    @media (max-width: 991.98px) {
      .jb-hero-search {
        margin-top: -28px;
      }

      .jb-hero-search-form {
        flex-wrap: wrap;
        max-width: 100%;
        padding: 10px;
        border-radius: 24px;
      }

      .jb-hsf-field {
        padding: 12px 16px;
      }

      .jb-hsf-submit {
        flex: 1 0 100%;
        justify-content: center;
        margin: 10px 0 0;
        padding: 16px 24px;
      }
    }

    /* Phone: three fields in a row would be ~100px each. Stack them, and swap
       the dividers from vertical to horizontal to match. */
    @media (max-width: 767.98px) {
      .jb-hsf-field {
        flex: 1 1 100%;
        border-right: 0;
        border-bottom: 1px solid rgba(47, 62, 70, .12);
      }

      .jb-hsf-field:last-of-type {
        border-bottom: 0;
      }
    }

    /* Belt and braces: kill any decorative rule the template attaches to the
       hero eyebrow, so nothing dash-like can come back through the cascade. */
    .header-carousel-area3 .main-hero-area .header-heading2 h5::before,
    .header-carousel-area3 .main-hero-area .header-heading2 h5::after {
      content: none;
      display: none;
    }

    /* ------------------------------------------------------------------ *
     * Mobile image alignment.
     *
     * .reveal (utils/_typography.scss) is display:-webkit-inline-box, so
     * these wrappers shrink-wrap to their content instead of filling the
     * column. On a 390px screen that left them 312px and 197px wide, hugging
     * the left edge with dead space to the right, which is what reads as
     * "not centered". .about-video-area .img1 is the worse of the two: it
     * has no width rule at all, only one on its inner <img>.
     *
     * !important is needed because the reveal animation writes an inline
     * width while it runs. Forcing the width also means the images simply
     * appear at full size on mobile rather than animating - the right
     * trade-off on a phone.
     * ------------------------------------------------------------------ */
    @media (max-width: 767.98px) {
      .property3-section-area .property-images-area .img1,
      .property3-section-area .property-images-area .img2,
      .about-video-area .img1,
      .about-widget-images .img1,
      .others3-section-area .images-area .img1,
      .others3-section-area .images-area .img2 {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        margin-left: auto !important;
        margin-right: auto !important;
      }

      .property3-section-area .property-images-area .img1 img,
      .property3-section-area .property-images-area .img2 img,
      .about-video-area .img1 img,
      .about-widget-images .img1 img {
        width: 100%;
        object-fit: cover;
        object-position: center;
      }

      /* "Ready to Explore" needs !important on the <img> as well as the
         wrapper. _others.scss pins these to width:250px and height:100% and
         only relaxes them inside its own $xs block, which the inline-box
         wrapper's shrink-to-fit sizing defeats - the image stayed 280px in a
         351px column, flush to the screen edge. height:auto lets the photo
         keep its aspect ratio once it spans the full width.

         These are NOT overlapping on mobile: _others.scss already zeroes the
         desktop offsets (margin-left:140px / margin-top:-370px / top:-70px)
         at $xs, so the pair stacks. Only the width was wrong. */
      .others3-section-area .images-area .img1 img,
      .others3-section-area .images-area .img2 img {
        width: 100% !important;
        height: auto !important;
        object-fit: cover;
        object-position: center;
      }

      /* Catches any inline-level leftovers inside these blocks. */
      .property3-section-area .property-images-area,
      .about-video-area,
      .about-widget-images,
      .others3-section-area .images-area {
        text-align: center;
      }

      /* The stats card and the image beside it are separate Bootstrap columns;
         give them the same rhythm so the pair reads as one centred stack. */
      .experience-box {
        width: 100%;
        margin: 0 auto;
        text-align: center;
      }
    }
    /* CLS floor for the hero carousel specifically - the generic
       "show only slide 1 before Owl loads" fix lives in
       resources/scss/components/_owl-cls-fix.scss and applies to every
       owl-carousel on the site. This is just a minimum height for the
       rare case slide 1's own content renders unexpectedly short (e.g.
       before its webp decodes), and the charcoal background so there is
       no white flash while the hero photo is still decoding instead of a
       bright flash-then-darken. */
    .header-carousel-area3.owl-carousel {
      min-height: 600px;
    }
    .header-carousel-area3.owl-carousel .main-hero-area {
      background-color: #2F3E46;
    }
    @media (max-width: 767.98px) {
      .header-carousel-area3.owl-carousel {
        min-height: 300px;
      }
    }
  </style>

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="header-carousel-area3 owl-carousel">
    <div class="main-hero-area">
      {{--
        WebP with a PNG fallback. The three client hero photos were 8.0 MB of
        PNG between them, all fetched up front because Owl builds every slide
        into the DOM - the single worst thing on the homepage. Re-encoded at
        q82 they total 0.87 MB. The .png files stay on disk as the <source>
        fallback; do not delete them.

        Slide 1 is the LCP image: eager + high priority. Slides 2 and 3 are
        behind the fade and carry loading="lazy".
      --}}
      <div class="img1">
        <picture>
          <source type="image/webp"
                  srcset="/img/all-images/hero/hero-img6-400w.webp 400w,
                          /img/all-images/hero/hero-img6-800w.webp 800w,
                          /img/all-images/hero/hero-img6-1200w.webp 1200w"
                  sizes="100vw">
          <img src="/img/all-images/hero/hero-img6.png"
               alt="Lantern-lit haveli courtyard in Jaipur with a pool and bougainvillea at dusk"
               width="1448" height="1086"
               fetchpriority="high" decoding="async" />
        </picture>
      </div>
      <div class="bg-elements">
        <img src="/img/elements/elements7.webp" alt="" class="elements2" width="800" height="517" />
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-9">
            <div class="header-content-area header-heading">
              <div class="elements">
                <img src="/img/elements/elements3.webp" alt="" width="666" height="665" />
              </div>
              <div class="header-heading2">
                <h5><i class="fa-solid fa-location-dot"></i>Serving all of Jaipur, Rajasthan</h5>
                <div class="space20"></div>
                <h2>Discover Jaipur's Hidden Gems</h2>
                <div class="space20"></div>
                <p>Browse verified heritage havelis, boutique apartments and villas across Jaipur. Contact hosts directly on WhatsApp.</p>
                <div class="space32"></div>
                <div class="btn-area1">
                  <a href="{{ url('/apartment/v4') }}" class="header-btn3">Browse Properties</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2"></div>
          <div class="col-lg-4">
            <div class="auhtor-box">
              <div class="others-box">
                <div class="img3">
                  <img src="/img/all-images/others/others-img1.webp" alt="" width="240" height="180" />
                </div>
                <div class="text">
                  <h3>The Royal Walled City Haveli</h3>
                  <div class="space10"></div>
                  <p>Approx Rs 2,500 / night</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="main-hero-area">
      <div class="img1">
        <picture>
          <source type="image/webp"
                  srcset="/img/all-images/hero/hero-img5-400w.webp 400w,
                          /img/all-images/hero/hero-img5-800w.webp 800w,
                          /img/all-images/hero/hero-img5-1200w.webp 1200w"
                  sizes="100vw">
          <img src="/img/all-images/hero/hero-img5.png"
               alt="Marble haveli courtyard in Jaipur with a carved fountain and candle lanterns"
               width="1448" height="1086"
               loading="lazy" decoding="async" />
        </picture>
      </div>
      <div class="bg-elements">
        <img src="/img/elements/elements7.webp" alt="" class="elements2" width="800" height="517" />
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-9">
            <div class="header-content-area header-heading">
              <div class="elements">
                <img src="/img/elements/elements3.webp" alt="" width="666" height="665" />
              </div>
              <div class="header-heading2">
                <h5><i class="fa-solid fa-location-dot"></i>Local Jaipur Hosts</h5>
                <div class="space20"></div>
                <h2>Authentic Stays. Personal Service.</h2>
                <div class="space20"></div>
                <p>Every property on JaipurBnB is reviewed by our admin team before going live. No surprises, just genuine Jaipur hospitality.</p>
                <div class="space32"></div>
                <div class="btn-area1">
                  <a href="{{ url('/apartment/v4') }}" class="header-btn3">Browse Properties</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2"></div>
          <div class="col-lg-4">
            <div class="auhtor-box">
              <div class="others-box">
                <div class="img3">
                  <img src="/img/all-images/others/others-img1.webp" alt="" width="240" height="180" />
                </div>
                <div class="text">
                  <h3>The Royal Walled City Haveli</h3>
                  <div class="space10"></div>
                  <p>Approx Rs 2,500 / night</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="main-hero-area">
      <div class="img1">
        <picture>
          <source type="image/webp"
                  srcset="/img/all-images/hero/hero-img1-400w.webp 400w,
                          /img/all-images/hero/hero-img1-800w.webp 800w,
                          /img/all-images/hero/hero-img1-1200w.webp 1200w"
                  sizes="100vw">
          <img src="/img/all-images/hero/hero-img1.png"
               alt="Jaipur suite living room looking out over Hawa Mahal at sunset"
               width="1448" height="1086"
               loading="lazy" decoding="async" />
        </picture>
      </div>
      <div class="bg-elements">
        <img src="/img/elements/elements7.webp" alt="" class="elements2" width="800" height="517" />
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-9">
            <div class="header-content-area header-heading">
              <div class="elements">
                <img src="/img/elements/elements3.webp" alt="" width="666" height="665" />
              </div>
              <div class="header-heading2">
                @php
                    // Live count of distinct neighborhoods that have a visible
                    // listing. Was a hardcoded "17" that contradicted the browse
                    // page's hardcoded "22". While nothing is live, fall back to
                    // a claim-free line rather than boasting "0 Neighborhoods".
                    $jbCoverage = $neighborhoodCount > 0
                        ? $neighborhoodCount.' '.Str::plural('Neighborhood', $neighborhoodCount).' Covered'
                        : 'Neighborhoods Across Jaipur';
                @endphp
                <h5><i class="fa-solid fa-location-dot"></i>{{ $jbCoverage }}</h5>
                <div class="space20"></div>
                <h2>From Walled City to Amer, Find Your Perfect Stay</h2>
                <div class="space20"></div>
                <p>Whether you want a heritage haveli in the old city or a modern apartment in C-Scheme, we have you covered.</p>
                <div class="space32"></div>
                <div class="btn-area1">
                  <a href="{{ url('/apartment/v4') }}" class="header-btn3">Browse Properties</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2"></div>
          <div class="col-lg-4">
            <div class="auhtor-box">
              <div class="others-box">
                <div class="img3">
                  <img src="/img/all-images/others/others-img1.webp" alt="" width="240" height="180" />
                </div>
                <div class="text">
                  <h3>The Royal Walled City Haveli</h3>
                  <div class="space10"></div>
                  <p>Approx Rs 2,500 / night</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{--
    Hero search bar. Deliberately a sibling of the carousel, not a child of a
    slide: Owl runs loop:true and clones slides, so a form inside one would be
    duplicated in the DOM along with its ids and <label for> targets.

    No new backend. This is a GET form at properties.browse using that page's
    own parameter names, and PublicPropertyController re-validates each value
    against the same constants supplied here, so an edited query string just
    falls back to "no filter" rather than erroring.
  --}}
  <div class="jb-hero-search">
    <div class="container">
      <form method="GET" action="{{ route('properties.browse') }}" class="jb-hero-search-form" role="search" aria-label="Search Jaipur stays">
        <div class="jb-hsf-field">
          <label for="jb-hero-neighborhood">Where</label>
          {{-- .jb-native-select opts out of the global niceSelect() in main.js. --}}
          <select name="neighborhood" id="jb-hero-neighborhood" class="jb-native-select">
            <option value="">All of Jaipur</option>
            @foreach ($neighborhoods as $neighborhood)
              <option value="{{ $neighborhood }}">{{ $neighborhood }}</option>
            @endforeach
          </select>
        </div>

        <div class="jb-hsf-field">
          <label for="jb-hero-stay-type">Stay type</label>
          <select name="stay_type" id="jb-hero-stay-type" class="jb-native-select">
            <option value="">Any type</option>
            @foreach ($stayTypes as $stayType)
              <option value="{{ $stayType }}">{{ $stayType }}</option>
            @endforeach
          </select>
        </div>

        <div class="jb-hsf-field">
          <label for="jb-hero-guests">Guests</label>
          <select name="guests" id="jb-hero-guests" class="jb-native-select">
            <option value="">Any</option>
            @foreach ($guestOptions as $option)
              <option value="{{ $option }}">{{ $option }}+ guests</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="jb-hsf-submit">
          <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
          <span>Search</span>
        </button>
      </form>
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== PROPERTY AREA STARTS ======= -->
  <div class="property3-section-area sp6">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="property-images-area">
            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/property/property-img4.webp" alt="" width="1320" height="880" />
            </div>
            <div class="img2 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/property/property-img5.webp" alt="" width="1320" height="1014" />
            </div>
            <div class="elements reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/elements/elements9.webp" alt="" width="666" height="665" />
            </div>
          </div>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-5">
          <div class="property-content heading3">
            <h5 data-aos="fade-left" data-aos-duration="800">Property Overview</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">Authentic Jaipur Experiences</h2>
            <div class="space16"></div>
            <p data-aos="fade-left" data-aos-duration="900">Discover the essence of Jaipur through our verified properties. From heritage havelis in the Walled City to modern apartments in C-Scheme, find a stay that matches your journey.</p>
            <div class="space16"></div>
            <p data-aos="fade-left" data-aos-duration="1000">Every listing is reviewed by our admin team, and you speak to the host directly. No booking fees, no middlemen.</p>
            <div class="space32"></div>
            <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
              <a href="{{ url('/apartment/v4') }}" class="header-btn4">Browse Properties</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== PROPERTY AREA ENDS ======= -->

  <!-- ===== SERVICE AREA STARTS ======= -->
  {{-- Anchor target for the footer's "How It Works" link (/#how-it-works). --}}
  <div class="service3-section-area sp1" id="how-it-works">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 m-auto">
          <div class="heading3 text-center space-margin60">
            <h5 data-aos="fade-left" data-aos-duration="800">Why JaipurBnB</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">Why Choose JaipurBnB</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
          <div class="amenities-boxarea">
            <div class="img1">
              <img loading="lazy" decoding="async" src="/img/all-images/service/service-img4.webp" alt="" width="480" height="344" />
            </div>
            <div class="space32"></div>
            <div class="content-area">
              <a href="{{ url('/apartment/v4') }}">Local Jaipur Hosts</a>
              <div class="space18"></div>
              <p>Every listing is reviewed by our team before it goes live.</p>
              <h3>01</h3>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
          <div class="space40 d-lg-block d-none"></div>
          <div class="amenities-boxarea">
            <div class="img1">
              <img loading="lazy" decoding="async" src="/img/all-images/service/service-img5.webp" alt="" width="396" height="316" />
            </div>
            <div class="space32"></div>
            <div class="content-area">
              <a href="{{ url('/apartment/v4') }}">Direct Host Contact</a>
              <div class="space18"></div>
              <p>
                Message or call the host <br class="d-lg-block d-block" /> directly. No booking fees.
              </p>
              <h3>02</h3>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1100">
          <div class="amenities-boxarea">
            <div class="img1">
              <img loading="lazy" decoding="async" src="/img/all-images/service/service-img7.webp" alt="" width="480" height="360" />
            </div>
            <div class="space32"></div>
            <div class="content-area">
              <a href="{{ url('/apartment/v4') }}">Availability Calendar</a>
              <div class="space18"></div>
              <p>
                Hosts mark blocked dates <br class="d-lg-block d-block" /> on each listing's calendar.
              </p>
              <h3>03</h3>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
          <div class="space40 d-lg-block d-none"></div>
          <div class="amenities-boxarea">
            <div class="img1">
              <img loading="lazy" decoding="async" src="/img/all-images/service/service-img8.webp" alt="" width="480" height="360" />
            </div>
            <div class="space32"></div>
            <div class="content-area">
              <a href="{{ url('/apartment/v4') }}">Authentic Jaipur Stays</a>
              <div class="space18"></div>
              <p>
                Heritage havelis and homestays <br class="d-lg-block d-block" /> run by local families.
              </p>
              <h3>04</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== SERVICE AREA ENDS ======= -->

  <!-- ===== ABOUT AREA STARTS ======= -->
  <div class="about3-section-area sp6">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 m-auto">
          <div class="about-header text-center heading3 space-margin60">
            <h5 data-aos="fade-left" data-aos-duration="800">our best stays</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">Featured Stays in Jaipur</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="about-slider-area owl-carousel">
            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/about/about-img3.webp" alt="" width="1448" height="1086" />
            </div>
            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/about/about-img3.webp" alt="" width="1448" height="1086" />
            </div>
            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/about/about-img3.webp" alt="" width="1448" height="1086" />
            </div>
            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/about/about-img3.webp" alt="" width="1448" height="1086" />
            </div>

            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/about/about-img3.webp" alt="" width="1448" height="1086" />
            </div>
            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/about/about-img3.webp" alt="" width="1448" height="1086" />
            </div>
            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/about/about-img3.webp" alt="" width="1448" height="1086" />
            </div>
            <div class="img1 reveal image-anime">
              <img loading="lazy" decoding="async" src="/img/all-images/about/about-img3.webp" alt="" width="1448" height="1086" />
            </div>
          </div>
          <div class="space30"></div>
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="experience-box">
                {{-- Real count of live listings. Was a hardcoded "500+". --}}
                <h2><span class="counter">{{ $listingCount }}</span></h2>
                <div class="space12"></div>
                <p>{{ $listingCount === 1 ? 'Live Listing' : 'Live Listings' }}</p>
                {{-- Removed with the testimonials: the "Our Happy Guests" avatar
                     strip was stock template faces standing in for guests we
                     have never had. --}}
              </div>
              <div class="space30 d-md-none d-block"></div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="about-video-area">
                <div class="img1 image-anime reveal">
                  <img loading="lazy" decoding="async" src="/img/all-images/about/about-img5.webp" alt="" width="870" height="652" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="space30 d-lg-none d-block"></div>
          <div class="about-widget-images">
            @php
                // Real listing when one is live, otherwise fall back to the
                // browse page rather than the legacy /single/index5 URL,
                // which redirects to /browse and never opens a property.
                $jbFeaturedUrl = $featured
                    ? route('properties.show', $featured)
                    : route('properties.browse');
            @endphp
            {{-- Photo is clickable too, not just the title and arrow. --}}
            <div class="img1 reveal image-anime">
              <a href="{{ $jbFeaturedUrl }}" style="display:block;" aria-label="View {{ $featured?->title ?? 'properties' }}">
                <img loading="lazy" decoding="async" src="{{ $featured?->coverImage?->display_url ?? '/img/all-images/about/about-img4.webp' }}" alt="{{ $featured?->title ?? '' }}" />
              </a>
            </div>
            <div class="content-area">
              <div class="text">
                <a href="{{ $jbFeaturedUrl }}">{{ $featured?->title ?? 'Browse Jaipur stays' }}</a>
                <div class="space20"></div>
                <ul>
                  <li>
                    <span><img loading="lazy" decoding="async" src="/img/icons/bed-icon1.svg" alt="" width="18" height="18" /> {{ $featured?->stay_type ?? 'Heritage stays' }}</span>
                  </li>
                  @if ($featured)
                    <li>
                      <span>|</span> <span><img loading="lazy" decoding="async" src="/img/icons/squre-icon1.svg" alt="" width="18" height="18" /> {{ $featured->neighborhood }}</span>
                    </li>
                  @endif
                </ul>
              </div>
              <div class="arrow">
                <a href="{{ $jbFeaturedUrl }}" aria-label="View {{ $featured?->title ?? 'properties' }}"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
            <div class="elements3">
              <img loading="lazy" decoding="async" src="/img/elements/elements3.webp" alt="" width="666" height="665" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== ABOUT AREA ENDS ======= -->

  <!-- ===== GALLERY AREA STARTS ======= -->
  <div class="gallery3-section-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 m-auto">
          <div class="gallery-header heading2 text-center">
            <h5 data-aos="fade-left" data-aos-duration="800">Property Gallery</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">Jaipur Heritage Views</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="rotate-img-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 m-auto">
          <div class="rotate-img">
            <img loading="lazy" decoding="async" src="/img/all-images/gallery/gallery-img1.webp" alt="Jaipur heritage property" style="width:100%;height:auto;display:block;" width="1448" height="1086" />
            <img loading="lazy" decoding="async" src="/img/elements/elements3.webp" alt="" class="elements3" width="666" height="665" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="space100 d-lg-block d-none"></div>
  <div class="space50 d-lg-none d-block"></div>
  <!-- ===== GALLERY AREA ENDS ======= -->

  {{-- Guest reviews / testimonials removed: the whole block was demo copy
       shipped with the template (invented names, photos and 5-star ratings).
       JaipurBnB has no reviews feature and no real guest feedback yet, so
       nothing replaces it. Rebuild here once genuine reviews exist. --}}

  <!-- ===== OTHERS AREA STARTS ======= -->
  <div class="others3-section-area sp5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="images-area">
            <div class="img1 image-anime reveal">
              <img loading="lazy" decoding="async" src="/img/all-images/others/others-img11.webp" alt="" width="951" height="634" />
            </div>
            <div class="img2 image-anime reveal">
              <img loading="lazy" decoding="async" src="/img/all-images/others/others-img12.webp" alt="" width="954" height="733" />
            </div>
            <div class="elements">
              <img loading="lazy" decoding="async" src="/img/elements/elements8.webp" alt="" width="479" height="479" />
            </div>
          </div>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-5">
          <div class="others-header heading3">
            <h5 data-aos="fade-left" data-aos-duration="800">start exploring</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">Ready to Explore Jaipur?</h2>
            <div class="space16"></div>
            <p data-aos="fade-left" data-aos-duration="1000">Browse verified stays across every neighborhood of the Pink City.</p>
            <div class="space24"></div>
            <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
              <a href="{{ url('/apartment/v4') }}" class="header-btn3">Browse Properties</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== OTHERS AREA ENDS ======= -->

  @include('layouts.partials.footer')
@endsection
