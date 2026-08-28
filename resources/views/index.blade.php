@extends('layouts.base', ['logo5' => true])

@section('title', 'JaipurBnB - Authentic Jaipur Stays')

@section('content')
  @include('layouts.partials.navbar')
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
                  <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
                    <span class="play-btn"><i class="fa-solid fa-play"></i></span>
                    <span class="text">Video</span>
                  </a>
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
                  <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
                    <span class="play-btn"><i class="fa-solid fa-play"></i></span>
                    <span class="text">Video</span>
                  </a>
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
                  <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
                    <span class="play-btn"><i class="fa-solid fa-play"></i></span>
                    <span class="text">Video</span>
                  </a>
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
                  <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube"><img src="/img/all-images/about/about-img5.png" alt="" /></a>
                </div>
                <div class="play-btn">
                  <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube"><i class="fa-solid fa-play"></i></a>
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
              <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
                <span class="play-btn"><i class="fa-solid fa-play"></i></span>
                <span class="text">Video</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== OTHERS AREA ENDS ======= -->

  @include('layouts.partials.footer')
@endsection
