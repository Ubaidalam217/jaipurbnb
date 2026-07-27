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
        <h2>About Agent</h2>
        <div class="space24"></div>
        <p>
        <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/pages/about') }}">About Agent</a>
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

  <!-- ===== PROPERTY AREA STARTS ======= -->
  <div class="property3-section-area sp6">
    <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
      <div class="property-images-area">
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/property/property-img13.png" alt="" />
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
        <h5 data-aos="fade-left" data-aos-duration="800">Real Estate Agent</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Hi, I'm Alex Roy, Your Apartment Agent</h2>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="900">Hello, I'm Alex Roy, dedicated apartment agent at House. With years of experience in the real estate market, I am committed to finding you the perfect apartment that suits your needs and lifestyle. Whether you're looking for a cozy studio or spacious.</p>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="1000">Discover the essence of luxury our exclusive property in Dallas, where timeless elegance and modern best comfort converge.</p>
        <div class="space32"></div>
        <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
        <a href="{{ url('/apartment/v1') }}" class="header-btn4">View Our Property</a>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== PROPERTY AREA ENDS ======= -->

  <!-- ===== ABOUT AREA STARTS ======= -->
  <div class="about1-section-area sp1 bg1">
    <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-5">
      <div class="about-header heading3">
        <h5 data-aos="fade-left" data-aos-duration="800">CITY APARTMENT</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">We Offer The Best City Apartments</h2>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="900">We offer the best city apartments tailored to your urban lifestyle. Whether you're seeking a chic downtown loft or a serene uptown retreat, our diverse portfolio ensures.</p>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="1100">Dedicated apartment specialists, we are committed to providing personalized service, guiding you through an every step of your apartment search with expertise.</p>
        <div class="space32"></div>
        <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
        <a href="{{ url('/apartment/v1') }}" class="header-btn4">View Our Property</a>
        </div>
      </div>
      </div>
      <div class="col-lg-1"></div>
      <div class="col-lg-6">
      <div class="space60 d-lg-none d-block"></div>
      <div class="about-images">
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/about/about-img1.png" alt="" />
        </div>
        <div class="img2 reveal image-anime">
        <img src="/img/all-images/about/about-img2.png" alt="" />
        </div>
        <div class="elements">
        <img src="/img/elements/elements12.png" alt="" />
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== ABOUT AREA ENDS ======= -->

  <!-- ===== TESTIMONIAL AREA STARTS ======= -->
  <div class="testimonial3-section-area sp6 bg2">
    <div class="container">
    <div class="row">
      <div class="col-lg-5">
      <div class="testimonia-header heading3">
        <h5 data-aos="fade-left" data-aos-duration="800">client feedback</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Hear What Our Client Say About Property</h2>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="1000">
        Indulge in the epitome of luxury living at Luxury, where every <br class="d-lg-block d-none" /> amenity is meticulously designed to elevate your lifestyle.
        </p>
        <div class="space32"></div>
        <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
        <a href="{{ url('/pages/testimonial') }}" class="header-btn4">View All Testimonials</a>
        </div>
      </div>
      <div class="space86"></div>
      <div class="testimonial-video-area" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class="img1">
        <img src="/img/all-images/testimonial/testimonial-img3.png" alt="" />
        </div>
        <div class="icons">
        <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube"><i class="fa-solid fa-play"></i></a>
        </div>
      </div>
      </div>
      <div class="col-lg-1"></div>
      <div class="col-lg-6">
      <div class="testimonial-arrow-area" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class="testimonial3-vertical-slider">
        <div class="testimonial-vertical">
          <div class="verical-boxarea">
          <div class="images-area">
            <div class="img1">
            <img src="/img/all-images/testimonial/testimonial-img4.png" alt="" />
            </div>
            <div class="text">
            <a href="#">Alexy Queen</a>
            <p>Happy Client</p>
            </div>
          </div>
          <div class="quito">
            <img src="/img/icons/quoto-icon2.svg" alt="" />
          </div>
          </div>
          <div class="space24"></div>
          <span>Highly recommend Suite Luxury Suite Villa!</span>
          <div class="space16"></div>
          <p>“After staying at Luxury, I can confidently say it was one of the most luxurious best experiences of luxury villa.”</p>
          <div class="space24"></div>
          <ul>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          </ul>
        </div>
        <div class="testimonial-vertical">
          <div class="verical-boxarea">
          <div class="images-area">
            <div class="img1">
            <img src="/img/all-images/testimonial/testimonial-img5.png" alt="" />
            </div>
            <div class="text">
            <a href="#">Jofra Archer</a>
            <p>Happy Client</p>
            </div>
          </div>
          <div class="quito">
            <img src="/img/icons/quoto-icon2.svg" alt="" />
          </div>
          </div>
          <div class="space24"></div>
          <span>Unforgettable Experience Of Luxury & Comfort!</span>
          <div class="space16"></div>
          <p>"Celebrated my anniversary at Property Villa, and it was beyond magical. The attention to detail, the of serene.”</p>
          <div class="space24"></div>
          <ul>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          </ul>
        </div>
        <div class="testimonial-vertical">
          <div class="verical-boxarea">
          <div class="images-area">
            <div class="img1">
            <img src="/img/all-images/testimonial/testimonial-img4.png" alt="" />
            </div>
            <div class="text">
            <a href="#">Alexy Queen</a>
            <p>Happy Client</p>
            </div>
          </div>
          <div class="quito">
            <img src="/img/icons/quoto-icon2.svg" alt="" />
          </div>
          </div>
          <div class="space24"></div>
          <span>Highly recommend Suite Luxury Suite Villa!</span>
          <div class="space16"></div>
          <p>“After staying at Luxury, I can confidently say it was one of the most luxurious best experiences of luxury villa.”</p>
          <div class="space24"></div>
          <ul>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          </ul>
        </div>
        <div class="testimonial-vertical">
          <div class="verical-boxarea">
          <div class="images-area">
            <div class="img1">
            <img src="/img/all-images/testimonial/testimonial-img5.png" alt="" />
            </div>
            <div class="text">
            <a href="#">Jofra Archer</a>
            <p>Happy Client</p>
            </div>
          </div>
          <div class="quito">
            <img src="/img/icons/quoto-icon2.svg" alt="" />
          </div>
          </div>
          <div class="space24"></div>
          <span>Unforgettable Experience Of Luxury & Comfort!</span>
          <div class="space16"></div>
          <p>"Celebrated my anniversary at Property Villa, and it was beyond magical. The attention to detail, the of serene.”</p>
          <div class="space24"></div>
          <ul>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          </ul>
        </div>
        <div class="testimonial-vertical">
          <div class="verical-boxarea">
          <div class="images-area">
            <div class="img1">
            <img src="/img/all-images/testimonial/testimonial-img4.png" alt="" />
            </div>
            <div class="text">
            <a href="#">Alexy Queen</a>
            <p>Happy Client</p>
            </div>
          </div>
          <div class="quito">
            <img src="/img/icons/quoto-icon2.svg" alt="" />
          </div>
          </div>
          <div class="space24"></div>
          <span>Highly recommend Suite Luxury Suite Villa!</span>
          <div class="space16"></div>
          <p>“After staying at Luxury, I can confidently say it was one of the most luxurious best experiences of luxury villa.”</p>
          <div class="space24"></div>
          <ul>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          </ul>
        </div>
        <div class="testimonial-vertical">
          <div class="verical-boxarea">
          <div class="images-area">
            <div class="img1">
            <img src="/img/all-images/testimonial/testimonial-img5.png" alt="" />
            </div>
            <div class="text">
            <a href="#">Jofra Archer</a>
            <p>Happy Client</p>
            </div>
          </div>
          <div class="quito">
            <img src="/img/icons/quoto-icon2.svg" alt="" />
          </div>
          </div>
          <div class="space24"></div>
          <span>Unforgettable Experience Of Luxury & Comfort!</span>
          <div class="space16"></div>
          <p>"Celebrated my anniversary at Property Villa, and it was beyond magical. The attention to detail, the of serene.”</p>
          <div class="space24"></div>
          <ul>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          <li>
            <i class="fa-solid fa-star"></i>
          </li>
          </ul>
        </div>
        </div>
        <div class="testimonial-arrows">
        <div class="testimonial-prev-arrow">
          <button><i class="fa-solid fa-angle-up"></i></button>
        </div>
        <div class="testimonial-next-arrow">
          <button><i class="fa-solid fa-angle-down"></i></button>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== TESTIMONIAL AREA ENDS ======= -->

  <!-- ===== APARTMENT AREA STARTS ======= -->
  <div class="apartment-inner-section-area sp2 bg1">
    <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
      <div class="apartment-header space-margin60 text-center heading3">
        <h5 data-aos="fade-left" data-aos-duration="800">Apartment List</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Our Latest Property</h2>
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
      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="900">
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

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
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