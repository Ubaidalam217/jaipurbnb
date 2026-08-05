@extends('layouts.base', ['logo5' => true])

@section('title', $property->title . ' - JaipurBnB')

@section('body_attribute')
  class="homepage5-body"
@endsection

@php
  // Photo helpers. A listing can legally have zero images (the host may
  // have removed them all after approval), so every img falls back to a
  // template asset rather than rendering a broken tile.
  $jbCover = $property->images->firstWhere('is_cover', true) ?? $property->images->first();
  $jbCoverUrl = $jbCover ? Storage::url($jbCover->image_url) : '/img/all-images/apartment/apartment-img1.png';
  $jbGallery = $property->images->where('id', '!=', $jbCover?->id)->values();
  $jbPrice = 'Approx Rs ' . number_format($property->approx_price) . ' / night';

  // MILESTONE 3 wires these to real wa.me / tel: links plus lead logging
  // (lead_analytics.whatsapp_click / call_click). Deliberately inert for now.
  $jbContactHref = '#';
@endphp

@section('content')
  @include('layouts.partials.navbar')

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="space80"></div>
  <div class="hero5-area">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="hero-header header-heading3">
            <h2 class="text-anime-style-3">{{ $property->title }}</h2>
            <div class="space20"></div>
            <p data-aos="fade-left" data-aos-duration="800">{{ Str::limit($property->description, 220) }}</p>
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
              @if ($property->is_verified)
                <span class="heart" title="Verified by the JaipurBnB team"><i class="fa-solid fa-circle-check"></i></span>
              @endif
            </div>
            <div class="space24"></div>
            <div class="btn-area1">
              <a href="{{ $jbContactHref }}" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#25D366;color:#0F3D2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;margin-right:12px;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><a href="{{ $jbContactHref }}" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#B34D33;color:#fff;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;"><i class="fa-solid fa-phone"></i> Call</a>
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
                <img src="/img/icons/others-icon5.svg" alt="" />
              </div>
              <div class="content">
                <span>{{ $property->stay_type }}</span>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon6.svg" alt="" />
              </div>
              <div class="content">
                <span>{{ $property->neighborhood }}</span>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon7.svg" alt="" />
              </div>
              <div class="content">
                <span>{{ $jbPrice }}</span>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon8.svg" alt="" />
              </div>
              <div class="content">
                <span>{{ $property->is_verified ? 'Verified Listing' : 'Hosted by ' . $property->host->name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== OTHERS AREA ENDS ======= -->

  <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary rounded-2" tabindex="0">
    <!-- ===== PROPERTY AREA STARTS ======= -->
    <div class="property5-section-area sp6" id="property">
      <div class="img1">
        <img src="{{ $jbCoverUrl }}" alt="{{ $property->title }}" data-aos="zoom-in-up" data-aos-duration="1000" />
      </div>
      @if ($jbGallery->isNotEmpty())
      <div class="img2">
        <img src="{{ Storage::url($jbGallery->first()->image_url) }}" alt="{{ $property->title }}" data-aos="zoom-in-up" data-aos-duration="1200" />
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
                <a href="{{ $jbContactHref }}" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#25D366;color:#0F3D2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;margin-right:12px;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><a href="{{ $jbContactHref }}" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#B34D33;color:#fff;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;"><i class="fa-solid fa-phone"></i> Call</a>
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
                <div class="col-lg-5">
                  <div class="img1 image-anime reveal">
                    <img src="{{ $jbGallery->isNotEmpty() ? Storage::url($jbGallery->first()->image_url) : $jbCoverUrl }}" alt="{{ $property->title }}" />
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="heading5 author-header">
                    <p data-aos="fade-up" data-aos-duration="800">{{ Str::limit($property->description, 300) }}</p>
                    <div class="space24"></div>
                    <div class="list-area" data-aos="fade-up" data-aos-duration="1000">
                      <ul>
                        <li>
                          <span><img src="/img/icons/check1.svg" alt="" /> {{ $property->stay_type }}</span>
                        </li>
                        <li>
                          <span><img src="/img/icons/check1.svg" alt="" /> {{ $property->neighborhood }}, Jaipur</span>
                        </li>
                      </ul>
                      <ul>
                        <li>
                          <span><img src="/img/icons/check1.svg" alt="" /> {{ $jbPrice }}</span>
                        </li>
                        <li>
                          <span><img src="/img/icons/check1.svg" alt="" /> Hosted by {{ $property->host->name }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="space40"></div>
                    <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
                      <a href="{{ $jbContactHref }}" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#25D366;color:#0F3D2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;margin-right:12px;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><a href="{{ $jbContactHref }}" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#B34D33;color:#fff;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;"><i class="fa-solid fa-phone"></i> Call</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== DETAILS AREA ENDS ======= -->

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
                  <img src="{{ $other->coverImage ? Storage::url($other->coverImage->image_url) : '/img/all-images/apartment/apartment-img6.png' }}" alt="{{ $other->title }}" />
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
                  <img src="{{ Storage::url($image->image_url) }}" alt="{{ $property->title }}" />
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
        <div class="row">
          <div class="col-lg-5">
            <div class="heading2">
              <h5 data-aos="fade-left" data-aos-duration="800">Contact Us</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Contact the Host Directly</h2>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="1000">Message {{ $property->host->name }} on WhatsApp or call directly to check dates and agree a price. JaipurBnB takes no booking fee and no commission — you deal with the host, not us.</p>
              <div class="space32"></div>
              <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                <a href="{{ $jbContactHref }}" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#25D366;color:#0F3D2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;margin-right:12px;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><a href="{{ $jbContactHref }}" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#B34D33;color:#fff;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;"><i class="fa-solid fa-phone"></i> Call</a>
              </div>
            </div>
          </div>
          <div class="col-lg-3"></div>
          <div class="col-lg-4">
            <div class="contact-img1" data-aos="flip-right" data-aos-duration="1000">
              <img src="{{ $jbCoverUrl }}" alt="{{ $property->title }}" />
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
                      <a href="#">Neighborhoods</a>
                    </li>
                  </ul>
                </div>
                <div class="footer-menu">
                  <ul>
                    <li>
                      <a href="#">List Your Property</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="#">How It Works</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="#">Contact</a>
                    </li>
                  </ul>
                </div>
                <div class="footer-menu2">
                  <ul>
                    <li>
                      <a href="#"><span><i class="fa-solid fa-location-dot"></i></span> <span>Jaipur, Rajasthan <br /> India</span></a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="tel:+91XXXXXXXXXX"><span><i class="fa-solid fa-phone"></i></span> <span>+91 XXXXX XXXXX</span></a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="mailto:hello@jaipurbnb.com" style="text-transform: none"><span><i class="fa-solid fa-envelope"></i></span> <span>hello@jaipurbnb.com</span></a>
                    </li>
                  </ul>
                </div>
                <div class="footer-social">
                  <ul>
                    <li>
                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa-brands fa-google-plus-g"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </li>
                  </ul>
                </div>
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
