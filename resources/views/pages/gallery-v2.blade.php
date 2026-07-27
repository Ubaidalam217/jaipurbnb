@extends('layouts.landing')

@section('content')
  <!-- ===== HERO AREA STARTS ======= -->
  <div class="inner-main-hero-area">
    <div class="img1">
      <img src="/img/all-images/hero/hero-img1.png" alt="" />
    </div>
    <div class="img2">
      <img src="/img/all-images/hero/hero-img2.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="inner-heading header-heading">
            <h2>Our Gallery V2</h2>
            <div class="space24"></div>
            <p>
              <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/blogs/blog') }}"'">Our Gallery V2</a>
            </p>
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
                <h3>Luxury Suite Villa</h3>
                <div class="space10"></div>
                <p>$1.800,000</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== GALLERY AREA STARTS ======= -->
  <div class="gallery-v2-section-area sp6">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="galler-header heading3 space-margin60">
            <h5>our gallery</h5>
            <div class="space20"></div>
            <h2>Our Gallery V2</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="gallery3-slider-area owl-carousel">
            <div class="content-area">
              <div class="img1">
                <img src="/img/all-images/gallery/gallery-img2.png" alt="" />
              </div>
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-plus"></i></a>
              </div>
            </div>

            <div class="content-area">
              <div class="img1">
                <img src="/img/all-images/gallery/gallery-img3.png" alt="" />
              </div>
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-plus"></i></a>
              </div>
            </div>

            <div class="content-area">
              <div class="img1">
                <img src="/img/all-images/gallery/gallery-img10.png" alt="" />
              </div>
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-plus"></i></a>
              </div>
            </div>
            <div class="content-area">
              <div class="img1">
                <img src="/img/all-images/gallery/gallery-img6.png" alt="" />
              </div>
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-plus"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== GALLERY AREA ENDS ======= -->

  <!-- ===== APARTMENT AREA STARTS ======= -->
  <div class="apartment-inner2-section-area sp7 bg1">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 m-auto">
          <div class="heading3 space-margin60 text-center">
            <h5>Apartment</h5>
            <div class="space20"></div>
            <h2>Our Latest Property</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="apartment-boxarea">
            <div class="img1">
              <img src="/img/all-images/apartment/apartment-img1.png" alt="" />
            </div>
            <div class="content-area">
              <a href="{{ url('/apartment/single') }}">Apartment Complex</a>
              <div class="space16"></div>
              <ul>
                <li>
                  <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />x2</a> <span>|</span>
                </li>
                <li>
                  <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />x2</a> <span>|</span>
                </li>
                <li>
                  <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />1200 sq</a>
                </li>
              </ul>
            </div>
            <div class="arrow">
              <a href="{{ url('/apartment/v1') }}">View</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="apartment-boxarea">
            <div class="img1">
              <img src="/img/all-images/apartment/apartment-img2.png" alt="" />
            </div>
            <div class="content-area">
              <a href="{{ url('/apartment/single') }}">Diamond Apartment</a>
              <div class="space16"></div>
              <ul>
                <li>
                  <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />x2</a> <span>|</span>
                </li>
                <li>
                  <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />x2</a> <span>|</span>
                </li>
                <li>
                  <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />1400 sq</a>
                </li>
              </ul>
            </div>
            <div class="arrow">
              <a href="{{ url('/apartment/v1') }}">View</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="apartment-boxarea">
            <div class="img1">
              <img src="/img/all-images/apartment/apartment-img3.png" alt="" />
            </div>
            <div class="content-area">
              <a href="{{ url('/apartment/single') }}">Luxury Suite Villa</a>
              <div class="space16"></div>
              <ul>
                <li>
                  <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />x2</a> <span>|</span>
                </li>
                <li>
                  <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />x2</a> <span>|</span>
                </li>
                <li>
                  <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />1600 sq</a>
                </li>
              </ul>
            </div>
            <div class="arrow">
              <a href="{{ url('/apartment/v1') }}">View</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== APARTMENT AREA ENDS ======= -->
@endsection
