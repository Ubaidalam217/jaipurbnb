@extends('layouts.base', ['logo5' => true])

{{-- The title and meta-description sections are deliberately NOT declared
     here at the top of the file. Both are built from values computed in the
     raw PHP block below, and Blade compiles a template top to bottom, so
     declaring them above that block would read variables that do not exist
     yet. They live in the meta group immediately after it.

     Note for whoever edits this comment: do not write Blade's raw-PHP opener
     literally in a comment anywhere in this file. BladeCompiler runs
     storeUncompiledBlocks() BEFORE it strips comments, so an unpaired opener
     inside a comment pairs with the real closer further down, swallows
     everything between them, and silently deletes that span from the
     compiled view. --}}

@section('body_attribute')
  class="homepage5-body" data-property-id="{{ $property->id }}"
@endsection

@php
  // Photo helpers. A listing can legally have zero images (the host may
  // have removed them all after approval), so every img falls back to a
  // template asset rather than rendering a broken tile.
  $jbCover = $property->images->firstWhere('is_cover', true) ?? $property->images->first();
  $jbCoverUrl = $jbCover ? $jbCover->display_url : '/img/all-images/apartment/apartment-img1.webp';
  $jbGallery = $property->images->where('id', '!=', $jbCover?->id)->values();
  $jbPrice = 'Approx Rs ' . number_format($property->approx_price) . ' / night';

  // data-property-id on <body> above is read by main.js on page load to
  // fire a profile_view beacon - see resources/js/main.js.

  // SEO strings. neighborhood is required at the Form Request layer, but a
  // row seeded before that rule existed could still be blank, and a title
  // ending "- Jaipur BnB Stay in " reads as a bug - so the suffix is dropped
  // rather than left dangling.
  $jbNeighborhood = trim((string) $property->neighborhood);
  $jbMetaTitle = $jbNeighborhood !== ''
      ? $property->title . ' - Jaipur BnB Stay in ' . $jbNeighborhood
      : $property->title . ' - Jaipur BnB Stay';

  // 150 chars, then the call to action. Str::limit's own ellipsis is left in
  // place: it is the honest signal that the blurb is truncated. Total lands
  // around 190 chars, which Google will clip in the SERP - that is expected
  // and fine, the CTA is there for the social card and for the crawler.
  $jbMetaDescription = \Illuminate\Support\Str::limit(strip_tags($property->description), 150)
      . ' Book directly with host on WhatsApp.';
@endphp

@section('title', $jbMetaTitle)
@section('meta_description', $jbMetaDescription)
@section('og_type', 'article')
@section('og_image', $jbCoverUrl)

{{--
  LodgingBusiness schema for the listing.

  priceRange, not "price": approx_price is the host's own estimate and
  booking happens off-platform over WhatsApp, so quoting it as a firm
  Offer price would be a claim JaipurBnB cannot honour. A range is the
  honest shape and is what Google expects for a lodging entity.
--}}
@push('jsonld')
  <script type="application/ld+json">
    {!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'LodgingBusiness',
        'name' => $property->title,
        'url' => route('properties.show', $property->id),
        'description' => \Illuminate\Support\Str::limit(strip_tags($property->description), 300),
        'image' => \Illuminate\Support\Str::startsWith($jbCoverUrl, ['http://', 'https://']) ? $jbCoverUrl : url($jbCoverUrl),
        'priceRange' => 'Approx Rs ' . number_format($property->approx_price) . ' per night',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => $property->neighborhood,
            'addressRegion' => 'Rajasthan',
            'addressCountry' => 'IN',
        ],
        'numberOfRooms' => $property->bedrooms,
        'petsAllowed' => null,
    ], fn ($v) => $v !== null && $v !== ''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
  </script>

  {{--
    Product schema, client-requested, sitting alongside the LodgingBusiness
    block above rather than replacing it. Two separate <script> blocks is
    valid JSON-LD - crawlers read every block on the page - and the two
    describe the listing from different angles: LodgingBusiness is what the
    place IS, Product is what is being advertised.

    CAVEAT on the Offer price, and it is a real one. approx_price is the
    host's own indicative nightly rate; booking happens off-platform over
    WhatsApp and JaipurBnB never takes payment, so this is not a price the
    site can be held to the way a shop's checkout price can. That is why the
    LodgingBusiness block above states a priceRange instead, and why the
    Offer here is explicitly scoped:

      - availability is InStock, not a stock count we cannot know
      - priceValidUntil is omitted rather than invented
      - url points at this page, where the "approx" wording is visible

    If Google ever flags the price as mismatched, drop the offers key and
    keep name/image/description - those are the parts that earn the rich
    result anyway.
  --}}
  <script type="application/ld+json">
    {!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $jbMetaTitle,
        'description' => \Illuminate\Support\Str::limit(strip_tags($property->description), 300),
        'image' => \Illuminate\Support\Str::startsWith($jbCoverUrl, ['http://', 'https://']) ? $jbCoverUrl : url($jbCoverUrl),
        'category' => $property->stay_type,
        'brand' => [
            '@type' => 'Brand',
            'name' => 'JaipurBnB',
        ],
        'offers' => [
            '@type' => 'Offer',
            'price' => (string) $property->approx_price,
            'priceCurrency' => 'INR',
            'availability' => 'https://schema.org/InStock',
            'url' => route('properties.show', $property->id),
        ],
    ], fn ($v) => $v !== null && $v !== ''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
  </script>
@endpush

@section('content')
  @include('layouts.partials.navbar')

  {{--
    Styles for the sections this listing page adds beyond the template:
    amenities grid, address panel and the Google Maps embed. Inline,
    jb- prefixed, zero dependency on the template SCSS - same convention
    as contact-buttons.blade.php and apartment/v4.blade.php.
  --}}
  <style>
    .jb-pet-badge2 {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-left: 10px;
      padding: 4px 12px;
      border-radius: 999px;
      background: rgba(47, 62, 70, .08);
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 13px;
      font-weight: 600;
    }

    /* Sample-listing marker. A badge alone is not enough on the detail page:
       this is where the Call / WhatsApp buttons live, and the demo host's
       number is a real, reachable line. A guest must not be able to get here
       and send an enquiry about a property that does not exist. So the badge
       is paired with an explicit sentence next to the contact buttons.

       Amber, not brand terracotta - it is a system warning, not a feature. */
    .jb-demo-badge {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      margin-bottom: 14px;
      padding: 6px 14px;
      border-radius: 999px;
      background: #B45309;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
    }

    .jb-demo-note {
      margin: 0 0 4px;
      padding: 10px 14px;
      border-radius: 10px;
      border: 1px solid rgba(180, 83, 9, .3);
      background: rgba(180, 83, 9, .08);
      color: #7A3B06;
      font-family: 'Poppins', sans-serif;
      font-size: 12.5px;
      line-height: 1.55;
    }

    .jb-amenities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 14px 20px;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .jb-amenities-grid li {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
    }

    .jb-amenities-grid li i {
      width: 20px;
      color: #B34D33;
      text-align: center;
    }

    .jb-address-panel {
      padding: 24px;
      border: 1px solid rgba(47, 62, 70, .12);
      border-radius: 14px;
      background: #fff;
      margin-top: 24px;
    }

    .jb-address-panel p {
      margin: 0;
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      line-height: 1.7;
    }

    /* Wrapper owns the border/radius/clipping; the iframe just fills it.
       overflow:hidden here is the literal "cannot bleed" guard the client
       asked for - belt and braces on top of the section height fix below,
       which is the fix that actually stops the map colliding with
       Availability. Fixed height (not aspect-ratio) so the map is the same
       size regardless of how wide its column happens to be - at a 1440px
       viewport the old aspect-ratio box rendered 577px tall, which is most
       of what pushed this section past its old fixed height in the first
       place. */
    .jb-map-wrap {
      overflow: hidden;
      border-radius: 14px;
      border: 1px solid rgba(47, 62, 70, .12);
      margin-top: 20px;
    }

    .jb-map-embed {
      display: block;
      width: 100%;
      height: 350px;
      border: 0;
    }

    @media (max-width: 575.98px) {
      .jb-map-embed {
        height: 300px;
      }
    }

    .jb-map-link {
      /* 40px bottom clearance is the client's explicit ask ("min mb-5 or
         40px") so the Availability heading starts cleanly below even if the
         section-height fix above were ever reverted. */
      margin: 14px 0 40px;
      font-family: 'Poppins', sans-serif;
      font-size: 13.5px;
    }

    .jb-map-link a {
      color: #B34D33;
      font-weight: 600;
    }

    .jb-map-link i {
      font-size: 11px;
      margin-left: 3px;
    }

    /* ------------------------------------------------------------------ *
     * Section height - this is the actual cause of the map/Availability
     * overlap, not the map itself.
     *
     * components/_service.scss sets `.service5-section-area { height:
     * 1360px }` with `overflow: visible` (only relaxed to auto at $md/$xs,
     * i.e. below 992px). That is a fixed pixel height baked in for the
     * template's original demo content. This blade reuses the class for
     * "At a Glance", whose real content - gallery photo, description,
     * amenities grid, address panel, map - runs well past 1360px on every
     * property (measured ~1985px on a 6-amenity listing at 1440px wide).
     *
     * Because overflow stays visible, nothing gets clipped - the content
     * keeps rendering past the box's bottom edge. But the NEXT section
     * starts immediately after where the box claims to end, at 1360px, not
     * after where the content actually stops. The result is the map (or
     * amenities, or the address text, depending on a listing's specific
     * amount of content) visually sitting on top of "Check Available
     * Dates". Fixing the map's own size does not fix this - a listing with
     * more amenities or a longer address would push the SAME overlap onto
     * a different element. The section has to size to its own content.
     * ------------------------------------------------------------------ */
    .service5-section-area {
      height: auto !important;
    }

    /* ------------------------------------------------------------------ *
     * "At a Glance" alignment.
     *
     * components/_about.scss pins .service-images-area .img1 img to a fixed
     * height of 635px, while the details column next to it is only ~310px
     * tall. Bootstrap rows are align-items:stretch by default, so the
     * details column was top-aligned against an image twice its height and
     * left ~320px of dead space beneath it - the two halves read as
     * unrelated rather than as a pair.
     * ------------------------------------------------------------------ */
    /* NOTE ON SPECIFICITY: the rules being overridden live in
       components/_service.scss nested under .service5-section-area, so they
       compile to three-class selectors like
       `.service5-section-area .service-images-area .img1 img` (0,3,1).
       Overrides here MUST carry the .service5-section-area prefix too - a
       two-class selector loses on specificity no matter that this <style>
       block comes later in the document. */

    /* .jb-glance-row is the image+details row itself: col-lg-6 image, col-lg-6
       details. Named explicitly (rather than matching bare .row) because it
       now sits nested inside the .col-lg-2/.col-lg-10 wrapper that keeps this
       row's left edge aligned with the amenities and address rows below it -
       a bare ".service-images-area .row" selector would also match that
       outer wrapper row. */
    .service5-section-area .service-images-area .jb-glance-row {
      align-items: center;
    }

    /* The details column carries padding:0 0 0 100px. Inside a col-lg-5 that
       leaves ~425px for a three-column flex list, so "Sleeps 6" and
       "3 bedrooms" each wrapped mid-phrase. Less padding plus wrapping lets
       each item sit on one line; the gap replaces the per-ul right margin so
       the last column is not pushed out of alignment. */
    .service5-section-area .service-images-area .author-header {
      padding-left: 56px;
    }

    .service5-section-area .service-images-area .author-header .list-area {
      flex-wrap: wrap;
      align-items: flex-start;
      gap: 0 28px;
    }

    .service5-section-area .service-images-area .author-header .list-area ul {
      margin-right: 0;
    }

    /* 992-1199 is the gap _service.scss leaves uncovered: its $md and $xs
       blocks zero this padding, but neither matches that range, so the full
       100px was still being applied in the narrowest desktop layout. */
    @media (max-width: 1199.98px) {
      .service5-section-area .service-images-area .author-header {
        padding-left: 32px;
      }
    }

    /* Below 992px Bootstrap stacks the columns, so centring no longer applies
       and the image should stop being a 635px monolith sitting above the
       text. */
    @media (max-width: 991.98px) {
      .service5-section-area .service-images-area .author-header {
        padding-left: 0;
        padding-top: 32px;
      }

      /* .reveal (utils/_typography.scss) is display:-webkit-inline-box, so
         this wrapper shrink-wraps instead of filling the stacked column - it
         measured 560px inside a 696px column, sitting left with dead space
         beside it. Same defect and same fix as the homepage blocks handled
         in index.blade.php.

         !important because the reveal animation writes an inline width while
         it runs; forcing the width means the image simply appears at full
         size rather than animating, which is the right trade on a phone. */
      .service5-section-area .service-images-area .img1 {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
      }

      .service5-section-area .service-images-area .img1 img {
        height: 420px;
      }
    }

    @media (max-width: 575.98px) {
      .service5-section-area .service-images-area .img1 img {
        height: 300px;
      }
    }

    /* CLS fix: .apartment5-area pins .owl-stage-outer to position:absolute
       on desktop (so .img1's own height doesn't affect layout there), but
       switches it to position:relative on tablet/mobile - and .img1 itself
       has no height set anywhere, only `img{height:100%}`. Below 992px
       these related-listing cards had no reserved space until each one's
       own (host-uploaded, arbitrary-ratio) photo loaded. Same fix as the
       browse grid: fixed aspect-ratio instead of a guessed pixel height,
       since these render at a different column width than the browse page. */
    @media (max-width: 991.98px) {
      .apartment5-area .arpart-slider-area .apartment-boxarea .img1 {
        aspect-ratio: 3 / 2;
      }

      .apartment5-area .arpart-slider-area .apartment-boxarea .img1 img {
        height: 100%;
        width: 100%;
        object-fit: cover;
      }
    }
  </style>

  <!-- ===== HERO AREA STARTS ======= -->
  {{--
    The hero background is THIS listing's cover photo.

    components/_hero.scss pins .hero5-area to a hardcoded template image
    (hero-bg-img1.png), so before this every property detail page opened on
    the same stock building regardless of which property you were looking at.
    An inline background-image outranks the stylesheet without needing an
    SCSS rebuild - and _hero.scss already lays a 70%-opacity charcoal ::after
    over this area, so the white heading stays legible on any photo.
  --}}
  <div class="space80"></div>
  <div class="hero5-area" style="background-image: url('{{ $jbCoverUrl }}');">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="hero-header header-heading3">
            @if ($property->is_demo)
              <span class="jb-demo-badge"><i class="fa-solid fa-flask" aria-hidden="true"></i> Demo listing</span>
            @endif
            <h2 class="text-anime-style-3">{{ $property->title }}</h2>
            <div class="space20"></div>
            <p data-aos="fade-left" data-aos-duration="800">{{ \Illuminate\Support\Str::limit($property->description, 220) }}</p>
            <div class="space32"></div>
            <div class="btn-area1" data-aos="fade-left" data-aos-duration="1000">
              <a href="{{ route('properties.browse', ['neighborhood' => $property->neighborhood]) }}" class="header-btn6">More stays in {{ $property->neighborhood }}</a>
            </div>
          </div>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-4">
          <div class="header-boxarea" data-aos="zoom-in-up" data-aos-duration="1000">
            <h4>{{ $jbPrice }}</h4>
            <div class="space20"></div>
            <h3>{{ $property->title }}</h3>
            <div class="space20"></div>
            <p>{{ $property->neighborhood }}, Jaipur</p>
            <div class="space20"></div>
            <div class="box-lists">
              <ul>
                <li>
                  <span>{{ $property->stay_type }}</span>
                </li>
              </ul>
              {{-- Admin approval is the ONLY thing that earns this badge.
                   Reads Property::isVerified() (listing_status = approved),
                   not the is_verified column, which a seeder or manual DB
                   edit can flip without any admin having reviewed it. --}}
              @if ($property->isVerified())
                <span class="heart" title="Verified by the JaipurBnB team"><i class="fa-solid fa-circle-check"></i></span>
              @endif
              @if ($property->is_pet_friendly)
                <span class="jb-pet-badge2"><i class="fa-solid fa-paw" aria-hidden="true"></i> Pet-friendly</span>
              @endif
            </div>
            <div class="space24"></div>
            @if ($property->is_demo)
              <p class="jb-demo-note">
                This is sample content used to demonstrate the site. The property
                is not real and the contact details below belong to a demo
                account &mdash; please do not send a booking enquiry.
              </p>
              <div class="space16"></div>
            @endif
            <div class="btn-area1">
              @include('layouts.partials.contact-buttons', ['property' => $property])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== OTHERS AREA STARTS ======= -->
  <div class="others-author-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 m-auto">
          <div class="auhtor-tabs-area">
            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon5.svg" alt="" width="26" height="26" />
              </div>
              <div class="content">
                <span>{{ $property->stay_type }}</span>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon6.svg" alt="" width="26" height="26" />
              </div>
              <div class="content">
                <span>{{ $property->neighborhood }}</span>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon7.svg" alt="" width="24" height="24" />
              </div>
              <div class="content">
                <span>{{ $jbPrice }}</span>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon8.svg" alt="" width="24" height="24" />
              </div>
              <div class="content">
                <span>{{ $property->isVerified() ? 'Verified Listing' : 'Hosted by ' . $property->host->name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== OTHERS AREA ENDS ======= -->

  <div>
    <!-- ===== PROPERTY AREA STARTS ======= -->
    <div class="property5-section-area sp6" id="property">
      <div class="img1">
        <img src="{{ $jbCoverUrl }}" alt="{{ $property->title }}" data-aos="zoom-in-up" data-aos-duration="1000" />
      </div>
      @if ($jbGallery->isNotEmpty())
      <div class="img2">
        <img src="{{ $jbGallery->first()->display_url }}" alt="{{ $property->title }}" data-aos="zoom-in-up" data-aos-duration="1200" />
      </div>
      @endif
      <div class="container">
        <div class="row">
          <div class="col-lg-7"></div>
          <div class="col-lg-5">
            <div class="property-header heading5">
              <h5 data-aos="fade-left" data-aos-duration="800">Property Overview</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">{{ $property->stay_type }} in {{ $property->neighborhood }}</h2>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="900" style="white-space: pre-line;">{{ $property->description }}</p>
              <div class="space32"></div>
              <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                @include('layouts.partials.contact-buttons', ['property' => $property])
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== PROPERTY AREA ENDS ======= -->

    <!-- ===== DETAILS AREA STARTS ======= -->
    <div class="service5-section-area sp6" id="amenities">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="service-heading space-margin60">
              <div class="heading5">
                <h5 data-aos="fade-left" data-aos-duration="800">Listing details</h5>
                <div class="space20"></div>
                <h2 class="text-anime-style-3">At a Glance</h2>
              </div>
              <div class="author-box" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="others-box">
                  <div class="img3">
                    <img src="{{ $jbCoverUrl }}" alt="{{ $property->title }}" />
                  </div>
                  <div class="text">
                    <h3>{{ $property->title }}</h3>
                    <div class="space10"></div>
                    <p>{{ $jbPrice }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="service-images-area">
              <div class="row">
                <div class="col-lg-2"></div>
                {{--
                  col-lg-10 wrapper keeps this row's left edge aligned with
                  the amenities and "Where you'll be" rows below, which use
                  the same col-lg-2 offset. The actual 2-column layout - image
                  col-lg-6, details col-lg-6, vertically centred via
                  .jb-glance-row - is the nested row inside it.
                --}}
                <div class="col-lg-10">
                  <div class="row jb-glance-row">
                    <div class="col-lg-6">
                      <div class="img1 image-anime reveal">
                        <img src="{{ $jbGallery->isNotEmpty() ? $jbGallery->first()->display_url : $jbCoverUrl }}" alt="{{ $property->title }}" />
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="heading5 author-header">
                        <p data-aos="fade-up" data-aos-duration="800">{{ \Illuminate\Support\Str::limit($property->description, 300) }}</p>
                        <div class="space24"></div>
                        <div class="list-area" data-aos="fade-up" data-aos-duration="1000">
                          <ul>
                            <li>
                              <span><img src="/img/icons/check1.svg" alt="" width="21" height="21" /> {{ $property->stay_type }}</span>
                            </li>
                            <li>
                              <span><img src="/img/icons/check1.svg" alt="" width="21" height="21" /> {{ $property->neighborhood }}, Jaipur</span>
                            </li>
                          </ul>
                          <ul>
                            <li>
                              <span><img src="/img/icons/check1.svg" alt="" width="21" height="21" /> {{ $jbPrice }}</span>
                            </li>
                            <li>
                              <span><img src="/img/icons/check1.svg" alt="" width="21" height="21" /> Hosted by {{ $property->host->name }}</span>
                            </li>
                          </ul>
                          {{-- Capacity from the listing itself. --}}
                          <ul>
                            <li>
                              <span><img src="/img/icons/bed-icon1.svg" alt="" width="18" height="18" /> Sleeps {{ $property->max_guests }}</span>
                            </li>
                            <li>
                              <span><img src="/img/icons/squre-icon1.svg" alt="" width="18" height="18" /> {{ $property->bedrooms }} {{ Str::plural('bedroom', $property->bedrooms) }}</span>
                            </li>
                            <li>
                              <span><img src="/img/icons/bat-icon1.svg" alt="" width="18" height="18" /> {{ $property->bathrooms }} {{ Str::plural('bathroom', $property->bathrooms) }}</span>
                            </li>
                          </ul>
                        </div>
                        <div class="space40"></div>
                        <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
                          @include('layouts.partials.contact-buttons', ['property' => $property])
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @if ($property->amenities->isNotEmpty())
            <div class="row">
              <div class="col-lg-2"></div>
              <div class="col-lg-10">
                <div class="space40"></div>
                <h3 style="font-family:'Poppins',sans-serif;font-size:22px;font-weight:700;color:#2F3E46;">What this place offers</h3>
                <div class="space20"></div>
                <ul class="jb-amenities-grid">
                  @foreach ($property->amenities as $amenity)
                    <li>
                      @if ($amenity->icon)<i class="{{ $amenity->icon }}" aria-hidden="true"></i>@endif
                      {{ $amenity->name }}
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
            @endif

            <div class="row">
              <div class="col-lg-2"></div>
              <div class="col-lg-10">
                <div class="jb-address-panel">
                  <h3 style="margin:0 0 10px;font-family:'Poppins',sans-serif;font-size:20px;font-weight:700;color:#2F3E46;">Where you'll be</h3>
                  <p>
                    @if ($property->full_address){{ $property->full_address }}<br>@endif
                    {{ $property->neighborhood }}, {{ $property->city }}, {{ $property->state }}
                    @if ($property->pincode) - {{ $property->pincode }} @endif
                  </p>
                  {{--
                    OpenStreetMap, not Google. See Property::mapEmbedUrl():
                    Google's keyless embed now 301s with
                    X-Frame-Options: SAMEORIGIN, so the browser blocked the
                    iframe and this panel rendered empty on every listing.
                    OSM needs no API key and sets no frame headers.
                  --}}
                  @if ($property->mapEmbedUrl())
                    <div class="jb-map-wrap">
                      <iframe class="jb-map-embed"
                              loading="lazy"
                              referrerpolicy="no-referrer-when-downgrade"
                              src="{{ $property->mapEmbedUrl() }}"
                              title="Map showing the location of {{ $property->title }} in {{ $property->neighborhood }}, Jaipur"></iframe>
                    </div>
                    <p class="jb-map-link">
                      <a href="{{ $property->mapLinkUrl() }}" target="_blank" rel="noopener noreferrer">
                        View larger map <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                      </a>
                    </p>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== DETAILS AREA ENDS ======= -->

    <!-- ===== AVAILABILITY AREA STARTS ======= -->
    <div class="apartment5-area sp6" id="availability">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="apartment-header heading5 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">availability</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Check Available Dates</h2>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="900">
                Dates the host has already blocked are greyed out. Message them on WhatsApp to
                confirm before you plan around it, because bookings are agreed directly with the host.
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000">
            @include('layouts.partials.jb-calendar', ['calendar' => $calendar])
          </div>
        </div>
      </div>
    </div>
    <!-- ===== AVAILABILITY AREA ENDS ======= -->

    <!-- ===== RELATED LISTINGS AREA STARTS ======= -->
    @if ($related->isNotEmpty())
    <div class="apartment5-area sp6" id="apartment">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="apartment-header heading5 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">more places to stay</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Other Listings in Jaipur</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000">
            <div class="arpart-slider-area owl-carousel">
              @foreach ($related as $other)
              <div class="apartment-boxarea">
                <div class="img1 image-anime">
                  <img src="{{ $other->coverImage ? $other->coverImage->display_url : '/img/all-images/apartment/apartment-img6.webp' }}" alt="{{ $other->title }}" />
                </div>
                <div class="content">
                  <a href="{{ route('properties.show', $other) }}">{{ $other->title }}</a>
                  <div class="space16"></div>
                  <p>{{ $other->neighborhood }}, Jaipur</p>
                  <div class="space24"></div>
                  <ul>
                    <li>
                      <span>{{ $other->stay_type }}</span>
                    </li>
                  </ul>
                  <div class="space28"></div>
                  <div class="btn-area1">
                    <div class="single-btn">
                      <a href="{{ route('properties.show', $other) }}" class="header-btn6">Approx Rs {{ number_format($other->approx_price) }} / night</a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!-- ===== RELATED LISTINGS AREA ENDS ======= -->

    <!-- ===== GALLERY AREA STARTS ======= -->
    @if ($jbGallery->isNotEmpty())
    <div class="gallery5-section-area sp6" id="gallery">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 m-auto">
            <div class="galler-header text-center heading5 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">our gallery</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">{{ $property->title }} Gallery</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="gallery-slider-area owl-carousel">
              @foreach ($jbGallery as $image)
              <div class="content-area">
                <div class="img1">
                  <img src="{{ $image->display_url }}" alt="{{ $property->title }}" />
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!-- ===== GALLERY AREA ENDS ======= -->

    <!-- ===== CONTACT AREA STARTS ======= -->
    <div class="contact5-section-area sp5">
      <div class="container">
        {{--
          Text and buttons only. The cover photo that used to sit in a
          col-lg-4 on the right was removed at client request: by this point
          on the page the same image has already appeared in the hero, the
          At a Glance panel and the gallery, so a fourth copy added nothing
          and pushed the WhatsApp/Call buttons into a narrow column.

          The column is col-lg-8 rather than the old col-lg-5 so the
          paragraph keeps a readable measure instead of becoming a narrow
          ribbon with half the band empty beside it.
        --}}
        <div class="row">
          <div class="col-lg-8">
            <div class="heading2">
              <h5 data-aos="fade-left" data-aos-duration="800">Contact Us</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Contact the Host Directly</h2>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="1000">Message {{ $property->host->name }} on WhatsApp or call directly to check dates and agree a price. JaipurBnB takes no booking fee and no commission, so you deal with the host, not us.</p>
              <div class="space32"></div>
              <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                @include('layouts.partials.contact-buttons', ['property' => $property])
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== CONTACT AREA ENDS ======= -->

    <!-- ===== FOOTER AREA STARTS ======= -->
    <div class="footer5-bottom-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="footer-bottom-area">
              <div class="footer-menu-area">
                <div class="footer-logo">
                  <a href="{{ url('/') }}" style="color:#E07A5F;font-family:'Poppins',sans-serif;font-size:24px;font-weight:700;letter-spacing:-.02em;text-decoration:none;">JaipurBnB</a>
                </div>
                <div class="footer-menu">
                  <ul>
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="{{ route('properties.browse') }}">Browse Properties</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="{{ route('properties.browse') }}">Neighborhoods</a>
                    </li>
                  </ul>
                </div>
                <div class="footer-menu">
                  <ul>
                    <li>
                      <a href="{{ route('register') }}">List Your Property</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="{{ url('/#how-it-works') }}">How It Works</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="{{ route('contact') }}">Contact</a>
                    </li>
                  </ul>
                </div>
                <div class="footer-menu2">
                  <ul>
                    <li>
                      <span><span><i class="fa-solid fa-location-dot"></i></span> <span>Jaipur, Rajasthan <br /> India</span></span>
                    </li>
                    <li class="space24"></li>
                    <li>
                      {{-- Platform support line from CONTACT_PHONE in .env, not the
                           host's number - the host is reached via the buttons above. --}}
                      <a href="tel:{{ config('contact.phone_tel') }}"><span><i class="fa-solid fa-phone"></i></span> <span>{{ config('contact.phone') }}</span></a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="mailto:{{ config('contact.email') }}" style="text-transform: none"><span><i class="fa-solid fa-envelope"></i></span> <span>{{ config('contact.email') }}</span></a>
                    </li>
                  </ul>
                </div>
                {{-- Social icons removed: all four pointed at "#" and JaipurBnB has no
                     social profiles yet. Restore with real URLs when the client has them. --}}
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="space48"></div>
                  <div class="copyright-area">
                    <p>© {{ now()->year }} JaipurBnB. All rights reserved.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== FOOTER AREA ENDS ======= -->
  </div>
@endsection
