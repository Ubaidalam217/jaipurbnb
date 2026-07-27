@extends('layouts.base', ['logo1' => true])

@section('body_attribute')
  class="homepage1-body"
@endsection

@section('content')
  @include('layouts.partials.header.navbar3')

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="header-carousel-area owl-carousel">
    <div class="main-hero-area">
    <div class="img1">
      <img src="/img/all-images/hero/hero-img1.png" alt="" />
    </div>
    <div class="img2">
      <img src="/img/all-images/hero/hero-img2.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
      <div class="col-lg-5">
        <div class="header-boxarea">
        <h5><span><img src="/img/icons/target-icon1.svg" alt="" /></span>60002 Just Meadow East Alfonso</h5>
        <div class="space20"></div>
        <h2>Luxury Suite Villa</h2>
        <div class="space28"></div>
        <p>
          <s>$1.900,000</s> $1.800,000
        </p>
        <div class="space32"></div>
        <div class="btn-area1">
          <a href="{{ url('/pages/contact') }}" class="header-btn1">Schedule A Visit</a>
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

    <div class="main-hero-area">
    <div class="img1">
      <img src="/img/all-images/hero/hero-img5.png" alt="" />
    </div>
    <div class="img2">
      <img src="/img/all-images/hero/hero-img4.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
      <div class="col-lg-5">
        <div class="header-boxarea">
        <h5><span><img src="/img/icons/target-icon1.svg" alt="" /></span>60002 Just Meadow East Alfonso</h5>
        <div class="space20"></div>
        <h2>Luxury Suite Villa</h2>
        <div class="space28"></div>
        <p>
          <s>$1.900,000</s> $1.800,000
        </p>
        <div class="space32"></div>
        <div class="btn-area1">
          <a href="{{ url('/pages/contact') }}" class="header-btn1">Schedule A Visit</a>
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

    <div class="main-hero-area">
    <div class="img1">
      <img src="/img/all-images/hero/hero-img1.png" alt="" />
    </div>
    <div class="img2">
      <img src="/img/all-images/hero/hero-img3.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
      <div class="col-lg-5">
        <div class="header-boxarea">
        <h5><span><img src="/img/icons/target-icon1.svg" alt="" /></span>60002 Just Meadow East Alfonso</h5>
        <div class="space20"></div>
        <h2>Luxury Suite Villa</h2>
        <div class="space28"></div>
        <p>
          <s>$1.900,000</s> $1.800,000
        </p>
        <div class="space32"></div>
        <div class="btn-area1">
          <a href="{{ url('/pages/contact') }}" class="header-btn1">Schedule A Visit</a>
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
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== ABOUT AREA STARTS ======= -->
  <div class="about1-section-area sp1">
    <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
      <div class="about-images">
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/about/about-img1.png" alt="" />
        </div>
        <div class="img2 reveal image-anime">
        <img src="/img/all-images/about/about-img2.png" alt="" />
        </div>
        <div class="elements">
        <img src="/img/elements/elements1.png" alt="" />
        </div>
      </div>
      </div>
      <div class="col-lg-1"></div>
      <div class="col-lg-5">
      <div class="about-header heading1">
        <h5 data-aos="fade-left" data-aos-duration="800">Property Overview</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Embrace The Elegance Of Our Exclusive Property.</h2>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="900">Experience the pinnacle of luxury living at our exclusive property, where every detail has been meticulously crafted to provide an unparalleled retreat. Nestled in the heart of, this haven offers.</p>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="1100">Discover the essence of luxury our exclusive property in Dallas, where timeless elegance and modern best comfort converge.</p>
        <div class="space32"></div>
        <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
        <a href="{{ url('/apartment/v1') }}" class="header-btn1">View Our Property</a>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== ABOUT AREA ENDS ======= -->

  <!-- ===== OTHERS FACT AREA STARTS ======= -->
  <div class="others1-section-area sp4">
    <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-duration="800">
      <div class="others-box">
        <div class="icons">
        <img src="/img/icons/others-icon1.svg" alt="" />
        </div>
        <div class="space16"></div>
        <p>24/7 Support</p>
      </div>
      <div class="space30 d-lg-none d-block"></div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="fade-down" data-aos-duration="1000">
      <div class="others-box">
        <div class="icons">
        <img src="/img/icons/others-icon2.svg" alt="" />
        </div>
        <div class="space16"></div>
        <p>Swimming Pool</p>
      </div>
      <div class="space30 d-lg-none d-block"></div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-duration="1100">
      <div class="others-box">
        <div class="icons">
        <img src="/img/icons/others-icon3.svg" alt="" />
        </div>
        <div class="space16"></div>
        <p>GYM & Fitness</p>
      </div>
      <div class="space30 d-md-none d-block"></div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="fade-down" data-aos-duration="1200">
      <div class="others-box">
        <div class="icons">
        <img src="/img/icons/others-icon4.svg" alt="" />
        </div>
        <div class="space16"></div>
        <p>CAR Storage</p>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== OTHERS FACT AREA ENDS ======= -->

  <!-- ===== SERVICE AREA STARTS ======= -->
  <div class="service1-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-4">
      <div class="service-header heading1 space-margin60">
        <h5 data-aos="fade-left" data-aos-duration="800">Building amenities</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">
        Outstanding Way <br class="d-lg-block d-none" />
        Of Luxury Life
        </h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
      <div class="service-slider-area owl-carousel">
        <div class="service-slider-box">
        <div class="img1">
          <img src="/img/all-images/service/service-img1.png" alt="" />
        </div>
        <div class="content">
          <a href="{{ url('/apartment/v1') }}">Swimming Pool</a>
        </div>
        <div class="btn-area1">
          <a href="{{ url('/apartment/v1') }}">View</a>
        </div>
        </div>

        <div class="service-slider-box">
        <div class="img2">
          <img src="/img/all-images/service/service-img2.png" alt="" />
        </div>
        <div class="content2">
          <a href="{{ url('/apartment/v1') }}">Smart Living</a>
        </div>
        <div class="btn-area1">
          <a href="{{ url('/apartment/v1') }}">View</a>
        </div>
        </div>

        <div class="service-slider-box">
        <div class="img3">
          <img src="/img/all-images/service/service-img3.png" alt="" />
        </div>
        <div class="content">
          <a href="{{ url('/apartment/v1') }}">New Construction</a>
        </div>
        <div class="btn-area1">
          <a href="{{ url('/apartment/v1') }}">View</a>
        </div>
        </div>

        <div class="service-slider-box">
        <div class="img1">
          <img src="/img/all-images/service/service-img1.png" alt="" />
        </div>
        <div class="content">
          <a href="{{ url('/apartment/v1') }}">Swimming Pool</a>
        </div>
        <div class="btn-area1">
          <a href="{{ url('/apartment/v1') }}">View</a>
        </div>
        </div>

        <div class="service-slider-box">
        <div class="img2">
          <img src="/img/all-images/service/service-img2.png" alt="" />
        </div>
        <div class="content2">
          <a href="{{ url('/apartment/v1') }}">Smart Living</a>
        </div>
        <div class="btn-area1">
          <a href="{{ url('/apartment/v1') }}">View</a>
        </div>
        </div>

        <div class="service-slider-box">
        <div class="img3">
          <img src="/img/all-images/service/service-img3.png" alt="" />
        </div>
        <div class="content">
          <a href="{{ url('/apartment/v1') }}">New Construction</a>
        </div>
        <div class="btn-area1">
          <a href="{{ url('/apartment/v1') }}">View</a>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== SERVICE AREA ENDS ======= -->

  <!-- ===== PROPERTIES AREA STARTS ======= -->
  <div class="property-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-10 m-auto">
      <div class="row">
        <div class="col-lg-6">
        <div class="property-header heading1">
          <h5 data-aos="fade-left" data-aos-duration="800">Property plans</h5>
          <div class="space20"></div>
          <h2 class="text-anime-style-3">Your Apartment Plan</h2>
          <div class="space16"></div>
          <p data-aos="fade-left" data-aos-duration="1000">Experience the pinnacle of luxury living at our exclusive property, where every detail has been meticulously crafted to provide an unparalleled retreat.</p>
          <div class="space6"></div>
          <ul data-aos="fade-left" data-aos-duration="1100">
          <li>
            <span>Floor</span> <span>03</span>
          </li>
          <li>
            <span>Rooms</span> <span>08</span>
          </li>
          <li>
            <span>Area M2</span> <span>03</span>
          </li>
          <li>
            <span>Parking</span> <span>03</span>
          </li>
          <li>
            <span>Pricing</span> <span>$7000/M2</span>
          </li>
          </ul>
          <div class="space32"></div>
          <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
          <a href="{{ url('/pages/contact') }}" class="header-btn1">Schedule Visit Now</a>
          </div>
        </div>
        </div>

        <div class="col-lg-6">
        <div class="property-images-area">
          <div class="img1 reveal image-anime">
          <img src="/img/all-images/property/property-img1.png" alt="" />
          </div>
          <div class="img2" data-aos="fade-down" data-aos-duration="1000">
          <img src="/img/all-images/property/property-img2.png" alt="" />
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== PROPERTIES AREA ENDS ======= -->

  <!-- ===== APARTMENT AREA STARTS ======= -->
  <div class="apartment1-section-area sp2">
    <div class="container">
    <div class="row">
      <div class="col-lg-4 m-auto">
      <div class="apartment-header space-margin60 text-center heading1">
        <h5 data-aos="fade-left" data-aos-duration="800">Apartment List</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Choose An Apartment</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="800">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img1.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/v1') }}">Apartment Complex</a>
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
      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="900">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img2.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/v1') }}">Diamond Apartment</a>
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

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img3.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/v1') }}">Luxury Suite Villa</a>
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
      <div class="col-lg-4 col-md-6 d-lg-none d-block" data-aos="zoom-in-up" data-aos-duration="1100">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img5.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/v1') }}">Villa Grean Complex</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />x2</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />x2</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />1100 sq</a>
          </li>
        </ul>
        </div>
        <div class="arrow">
        <a href="{{ url('/apartment/v1') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-8 col-md-12" data-aos="zoom-in-up" data-aos-duration="1200">
      <div class="apartment-boxarea">
        <div class="img2">
        <img src="/img/all-images/apartment/apartment-img4.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/v1') }}">Modern Industrial Apartement</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />x2</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />x2</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />2000 sq</a>
          </li>
        </ul>
        </div>
        <div class="arrow2">
        <a href="{{ url('/apartment/v1') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6 d-lg-block d-none" data-aos="zoom-in-up" data-aos-duration="1300">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img5.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/v1') }}">Villa Grean Complex</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />x2</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />x2</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />1100 sq</a>
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

  <!-- ===== GALLERY AREA STARTS ======= -->
  <div class="gallery1-section-area">
    <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
      <div class="gallery-header heading1 text-center">
        <h5 data-aos="fade-left" data-aos-duration="800">gallery</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Residence Building View</h2>
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
        <iframe src="https://momento360.com/e/u/c59c61d079694bba8fadfec6653faf14?utm_campaign=embed&utm_source=other&heading=0&pitch=0&field-of-view=67&size=medium&display-plan=true"></iframe>
        <img src="/img/elements/elements3.png" alt="" class="elements3" />
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== GALLERY AREA ENDS ======= -->

  <!-- ===== TESTIMONIAL AREA STARTS ======= -->
  <div class="testimonial1-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-5">
      <div class="testimonial-header space-margin60 heading1">
        <h5 data-aos="fade-left" data-aos-duration="800">testimonial</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">What Our Client Says</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
      <div class="testimonialmain-slider">
        <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="images-area slider2">
          <div class="img1 reveal image-anime">
            <img src="/img/all-images/testimonial/testimonial-img1.png" alt="" />
          </div>
          <div class="img1 reveal image-anime">
            <img src="/img/all-images/testimonial/testimonial-img1.png" alt="" />
          </div>
          <div class="img1 reveal image-anime">
            <img src="/img/all-images/testimonial/testimonial-img1.png" alt="" />
          </div>
          <div class="img1 reveal image-anime">
            <img src="/img/all-images/testimonial/testimonial-img1.png" alt="" />
          </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="testimonial-slider-area slider1">
          <div class="testimonial-box">
            <img src="/img/icons/quoto-icon1.svg" alt="" />
            <div class="space16"></div>
            <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It was like our own private paradise—beautifully designed and impeccably maintained.”</p>
            <div class="space32"></div>
            <div class="auhtor-area">
            <div class="img1">
              <img src="/img/all-images/testimonial/testimonial-img2.png" alt="" />
            </div>
            <div class="text">
              <a href="#">Shakib Mahmud</a>
              <div class="space10"></div>
              <p>Happy Client</p>
            </div>
            </div>
          </div>
          <div class="testimonial-box">
            <img src="/img/icons/quoto-icon1.svg" alt="" />
            <div class="space16"></div>
            <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It was like our own private paradise—beautifully designed and impeccably maintained.”</p>
            <div class="space32"></div>
            <div class="auhtor-area">
            <div class="img1">
              <img src="/img/all-images/testimonial/testimonial-img2.png" alt="" />
            </div>
            <div class="text">
              <a href="#">Shakib Mahmud</a>
              <div class="space10"></div>
              <p>Happy Client</p>
            </div>
            </div>
          </div>

          <div class="testimonial-box">
            <img src="/img/icons/quoto-icon1.svg" alt="" />
            <div class="space16"></div>
            <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It was like our own private paradise—beautifully designed and impeccably maintained.”</p>
            <div class="space32"></div>
            <div class="auhtor-area">
            <div class="img1">
              <img src="/img/all-images/testimonial/testimonial-img2.png" alt="" />
            </div>
            <div class="text">
              <a href="#">Shakib Mahmud</a>
              <div class="space10"></div>
              <p>Happy Client</p>
            </div>
            </div>
          </div>

          <div class="testimonial-box">
            <img src="/img/icons/quoto-icon1.svg" alt="" />
            <div class="space16"></div>
            <p>“This property exceeded all our expectations, especially the magnificent swimming pool. It was like our own private paradise—beautifully designed and impeccably maintained.”</p>
            <div class="space32"></div>
            <div class="auhtor-area">
            <div class="img1">
              <img src="/img/all-images/testimonial/testimonial-img2.png" alt="" />
            </div>
            <div class="text">
              <a href="#">Shakib Mahmud</a>
              <div class="space10"></div>
              <p>Happy Client</p>
            </div>
            </div>
          </div>
          </div>
          <div class="testimonial-arrows">
          <div class="prev-arrow">
            <button><i class="fa-solid fa-arrow-left"></i></button>
          </div>
          <div class="next-arrow">
            <button><i class="fa-solid fa-arrow-right"></i></button>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== TESTIMONIAL AREA ENDS ======= -->

  <!-- ===== FOOTER AREA STARTS ======= -->
  <div class="footer1-section-area">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="footer-instagram-area">
        <div class="row">
        <div class="col-lg-5 m-auto">
          <div class="instagram-header text-center">
          <h5 data-aos="fade-left" data-aos-duration="800">INSTAGRAM</h5>
          <h2 class="text-anime-style-3">Follow @hosue.property</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12" data-aos="zoom-in-up" data-aos-duration="1000">
          <div class="instagram-posts-slider owl-carousel">
            <div class="instagram-posts">
            <div class="img1">
              <img src="/img/all-images/others/others-img2.png" alt="" />
            </div>
            <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
            </div>
            <div class="instagram-posts">
            <div class="img1">
              <img src="/img/all-images/others/others-img3.png" alt="" />
            </div>
            <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
            </div>
            <div class="instagram-posts">
            <div class="img1">
              <img src="/img/all-images/others/others-img4.png" alt="" />
            </div>
            <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
            </div>
            <div class="instagram-posts">
            <div class="img1">
              <img src="/img/all-images/others/others-img5.png" alt="" />
            </div>
            <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
            </div>
            <div class="instagram-posts">
            <div class="img1">
              <img src="/img/all-images/others/others-img6.png" alt="" />
            </div>
            <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
            </div>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <div class="footer-bottom-section">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="footer-bottom-area">
        <div class="footer-menu-area">
        <div class="footer-logo">
          <img src="/img/logo/logo1.png" alt="" />
        </div>
        <div class="footer-menu">
          <ul>
          <li>
            <a href="{{ url('/apartment/v1') }}">Properties</a>
          </li>
          <li>
            <a href="{{ url('/pages/gallery-v1') }}">Gallery</a>
          </li>
          <li>
            <a href="{{ url('/blogs/blog') }}">Blog</a>
          </li>
          <li>
            <a href="{{ url('/pages/contact') }}">Contact</a>
          </li>
          </ul>
        </div>
        <div class="footer-btn">
          <a href="{{ url('/pages/contact') }}" class="header-btn1">Schedule Visit Now</a>
        </div>
        </div>
        <div class="space40"></div>
        <div class="row">
        <div class="col-lg-12">
          <div class="mapouter">
          <div class="gmap_canvas">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4506257.120552435!2d88.67021924228865!3d21.954385721237916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1704088968016!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          </div>
          <div class="space40"></div>
          <div class="copyright-area">
          <p>© 2024 Hosue -Single Property Template.</p>
          <div class="privacy">
            <p>
            <a href="#">Privacy Policy</a> <span>|</span> <a href="#">Terms & Condition</a>
            </p>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== FOOTER AREA ENDS ======= -->
@endsection