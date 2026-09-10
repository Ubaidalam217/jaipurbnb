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
       lifts contrast for the white text. */
    .header-carousel-area3 .main-hero-area .img1::after {
      background: linear-gradient(
        to right,
        #2F3E46 0%,
        rgba(47, 62, 70, .82) 18%,
        rgba(47, 62, 70, .34) 45%,
        rgba(47, 62, 70, .10) 72%,
        rgba(47, 62, 70, .22) 100%
      );
      opacity: 1;
    }

    /* Bottom vignette across the whole hero - stops the image bleeding into
       the section below and reads as more deliberate/premium. */
    .header-carousel-area3 .main-hero-area .img1 {
      box-shadow: inset 0 -90px 90px -60px rgba(47, 62, 70, .85);
    }

    @media (max-width: 767.98px) {
      /* On mobile the image is full-width behind the copy, so it needs a flat
         scrim rather than a directional one. */
      .header-carousel-area3 .main-hero-area .img1::after {
        background: linear-gradient(
          to bottom,
          rgba(47, 62, 70, .74) 0%,
          rgba(47, 62, 70, .82) 100%
        );
        opacity: 1;
      }
    }

    /* Eyebrow above the headline ("N Neighborhoods Covered", "Verified Local
       Hosts"). Was inheriting a template colour; pin it to brand terracotta.

       NOTE: this deliberately carries no ::before / ::after rule. A short gold
       accent bar used to sit after the text; the client read it as a stray
       dash, so it is gone. Icon and text only - do not reintroduce one. */
    .header-carousel-area3 .main-hero-area .header-heading2 h5 {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: #E07A5F;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      letter-spacing: .04em;
    }

    .header-carousel-area3 .main-hero-area .header-heading2 h5 i {
      color: #E07A5F;
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
  </style>

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="header-carousel-area3 owl-carousel">
    <div class="main-hero-area">
      <div class="img1">
        <img src="/img/all-images/hero/hero-img6.png" alt="" />
      </div>
      <div class="bg-elements">
        <img src="/img/elements/elements7.png" alt="" class="elements2" />
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-9">
            <div class="header-content-area header-heading">
              <div class="elements">
                <img src="/img/elements/elements3.png" alt="" />
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
                  <img src="/img/all-images/others/others-img1.png" alt="" />
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
        <img src="/img/all-images/hero/hero-img5.png" alt="" />
      </div>
      <div class="bg-elements">
        <img src="/img/elements/elements7.png" alt="" class="elements2" />
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-9">
            <div class="header-content-area header-heading">
              <div class="elements">
                <img src="/img/elements/elements3.png" alt="" />
              </div>
              <div class="header-heading2">
                <h5><i class="fa-solid fa-location-dot"></i>Verified Local Hosts</h5>
                <div class="space20"></div>
                <h2>Authentic Stays. Personal Service.</h2>
                <div class="space20"></div>
                <p>Every property on JaipurBnB is checked by our local team. No surprises, just genuine Jaipur hospitality.</p>
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
                  <img src="/img/all-images/others/others-img1.png" alt="" />
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
        <img src="/img/all-images/hero/hero-img1.png" alt="" />
      </div>
      <div class="bg-elements">
        <img src="/img/elements/elements7.png" alt="" class="elements2" />
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-9">
            <div class="header-content-area header-heading">
              <div class="elements">
                <img src="/img/elements/elements3.png" alt="" />
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
                  <img src="/img/all-images/others/others-img1.png" alt="" />
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
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== PROPERTY AREA STARTS ======= -->
  <div class="property3-section-area sp6">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="property-images-area">
            <div class="img1 reveal image-anime">
              <img src="/img/all-images/property/property-img4.png" alt="" />
            </div>
            <div class="img2 reveal image-anime">
              <img src="/img/all-images/property/property-img5.png" alt="" />
            </div>
            <div class="elements reveal image-anime">
              <img src="/img/elements/elements9.png" alt="" />
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
            <p data-aos="fade-left" data-aos-duration="1000">Every listing is checked by our local team, and you speak to the host directly. No booking fees, no middlemen.</p>
            <div class="space32"></div>
            <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
              <a href="{{ url('/apartment/v4') }}" class="header-btn4">View Our Property</a>
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
              <img src="/img/all-images/service/service-img4.png" alt="" />
            </div>
            <div class="space32"></div>
            <div class="content-area">
              <a href="{{ url('/apartment/v4') }}">Verified Local Hosts</a>
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
              <img src="/img/all-images/service/service-img5.png" alt="" />
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
              <img src="/img/all-images/service/service-img7.png" alt="" />
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
              <img src="/img/all-images/service/service-img8.png" alt="" />
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
              <img src="/img/all-images/about/about-img3.png" alt="" />
            </div>
            <div class="img1 reveal image-anime">
              <img src="/img/all-images/about/about-img3.png" alt="" />
            </div>
            <div class="img1 reveal image-anime">
              <img src="/img/all-images/about/about-img3.png" alt="" />
            </div>
            <div class="img1 reveal image-anime">
              <img src="/img/all-images/about/about-img3.png" alt="" />
            </div>

            <div class="img1 reveal image-anime">
              <img src="/img/all-images/about/about-img3.png" alt="" />
            </div>
            <div class="img1 reveal image-anime">
              <img src="/img/all-images/about/about-img3.png" alt="" />
            </div>
            <div class="img1 reveal image-anime">
              <img src="/img/all-images/about/about-img3.png" alt="" />
            </div>
            <div class="img1 reveal image-anime">
              <img src="/img/all-images/about/about-img3.png" alt="" />
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
                  <img src="/img/all-images/about/about-img5.png" alt="" />
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
                <img src="{{ $featured?->coverImage?->display_url ?? '/img/all-images/about/about-img4.png' }}" alt="{{ $featured?->title ?? '' }}" />
              </a>
            </div>
            <div class="content-area">
              <div class="text">
                <a href="{{ $jbFeaturedUrl }}">{{ $featured?->title ?? 'Browse Jaipur stays' }}</a>
                <div class="space20"></div>
                <ul>
                  <li>
                    <span><img src="/img/icons/bed-icon1.svg" alt="" /> {{ $featured?->stay_type ?? 'Heritage stays' }}</span>
                  </li>
                  @if ($featured)
                    <li>
                      <span>|</span> <span><img src="/img/icons/squre-icon1.svg" alt="" /> {{ $featured->neighborhood }}</span>
                    </li>
                  @endif
                </ul>
              </div>
              <div class="arrow">
                <a href="{{ $jbFeaturedUrl }}" aria-label="View {{ $featured?->title ?? 'properties' }}"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
            <div class="elements3">
              <img src="/img/elements/elements3.png" alt="" />
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
            <img src="/img/all-images/gallery/gallery-img1.png" alt="Jaipur heritage property" style="width:100%;height:auto;display:block;" />
            <img src="/img/elements/elements3.png" alt="" class="elements3" />
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
              <img src="/img/all-images/others/others-img11.png" alt="" />
            </div>
            <div class="img2 image-anime reveal">
              <img src="/img/all-images/others/others-img12.png" alt="" />
            </div>
            <div class="elements">
              <img src="/img/elements/elements8.png" alt="" />
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
