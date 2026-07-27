@extends('layouts.base', ['logo8' => true])

@section('body_attribute')
  class="homepage8-body"
@endsection

@section('content')
  @include('layouts.partials.header.navbar8')

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="space80"></div>
  <div class="header3-slick-slider">
    <div class="hero8-main-area">
    <div class="bg-img1">
      <img src="/img/bg/header-bg4.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
      <div class="col-lg-12">
        <div class="play-btn-area">
        <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
          <img src="/img/elements/elements11.png" alt="" />
          <span><i class="fa-solid fa-play"></i></span>
        </a>
        </div>
      </div>
      </div>
    </div>
    </div>

    <div class="hero8-main-area">
    <div class="bg-img1">
      <img src="/img/bg/header-bg5.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
      <div class="col-lg-3"></div>
      <div class="col-lg-2">
        <div class="play-btn-area">
        <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
          <img src="/img/elements/elements11.png" alt="" />
          <span><i class="fa-solid fa-play"></i></span>
        </a>
        </div>
      </div>
      </div>
    </div>
    </div>

    <div class="hero8-main-area">
    <div class="bg-img1">
      <img src="/img/bg/header-bg6.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
      <div class="col-lg-3"></div>
      <div class="col-lg-2">
        <div class="play-btn-area">
        <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
          <img src="/img/elements/elements11.png" alt="" />
          <span><i class="fa-solid fa-play"></i></span>
        </a>
        </div>
      </div>
      </div>
    </div>
    </div>

    <div class="hero8-main-area">
    <div class="bg-img1">
      <img src="/img/bg/header-bg4.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
      <div class="col-lg-3"></div>
      <div class="col-lg-2">
        <div class="play-btn-area">
        <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
          <img src="/img/elements/elements11.png" alt="" />
          <span><i class="fa-solid fa-play"></i></span>
        </a>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>

  <div class="slick3-button-area d-flex">
    <div class="img1">
    <img src="/img/all-images/hero/hero-img15.png" alt="" />
    </div>

    <div class="img1">
    <img src="/img/all-images/hero/hero-img16.png" alt="" />
    </div>

    <div class="img1">
    <img src="/img/all-images/hero/hero-img14.png" alt="" />
    </div>

    <div class="img1">
    <img src="/img/all-images/hero/hero-img15.png" alt="" />
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== PROPERTY AREA STARTS ======= -->
  <div class="property8-section-area sp6">
    <div class="img1">
    <img src="/img/all-images/property/property-img6.png" alt="" />
    </div>
    <div class="img2">
    <img src="/img/all-images/property/property-img7.png" alt="" />
    </div>
    <div class="container">
    <div class="row">
      <div class="col-lg-7"></div>
      <div class="col-lg-5">
      <div class="property-header heading8">
        <h5 data-aos="fade-left" data-aos-duration="800">Property Overview</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Elegance Every Detail Welcome Diamond V.</h2>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="900">Experience the pinnacle of luxury living at our exclusive property, where every detail has been meticulously crafted to provide an unparalleled retreat. Nestled in the heart of, this haven offers.</p>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="1000">Discover the essence of luxury our exclusive property in Dallas, where timeless elegance and modern best comfort converge.</p>
        <div class="space32"></div>
        <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
        <a href="{{ url('/pages/contact') }}" class="header-btn9">Schedule A Visit <i class="fa-solid fa-arrow-right"></i></a>
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
  <!-- ===== PROPERTY AREA ENDS ======= -->

  <!-- ===== ABOUT AREA STARTS ======= -->
  <div class="about8-author-section-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
      <div class="about-header text-center heading8 space-margin60">
        <h5 data-aos="fade-left" data-aos-duration="800">our best properties</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Explore Our Premier Of Single Property Retreat</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
      <div class="about8-slider-area owl-carousel">
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
          <h2><span class="counter">25</span>+</h2>
          <div class="space12"></div>
          <p>Years Of Experience</p>
          <div class="space20"></div>
          <img src="/img/all-images/about/about-img6.png" alt="" />
          <div class="space18"></div>
          <p>Our Happy Clients</p>
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
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/about/about-img4.png" alt="" />
        </div>
        <div class="content-area">
        <div class="text">
          <a href="{{ url('/apartment/single') }}">Luxury Suite Villa</a>
          <div class="space20"></div>
          <ul>
          <li>
            <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> x2</a> <span>|</span>
          </li>
          <li>
            <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> x2</a> <span>|</span>
          </li>
          <li>
            <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" /> 2000 sq</a>
          </li>
          </ul>
        </div>
        <div class="arrow">
          <a href="{{ url('/apartment/single') }}"><i class="fa-solid fa-arrow-right"></i></a>
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

  <!-- ===== ABOUT AREA STARTS ======= -->
  <div class="about8-section-area sp6">
    <div class="side-img">
    <img src="/img/all-images/about/about-img10.png" alt="" />
    </div>
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="service-images-area">
        <div class="row">
        <div class="col-lg-6">
          <div class="img1 image-anime reveal">
          <img src="/img/all-images/about/about-img11.png" alt="" />
          </div>
        </div>
        <div class="col-lg-6">
          <div class="heading7 author-header heading8">
          <h5 data-aos="fade-left" data-aos-duration="800">About apartment</h5>
          <div class="space20"></div>
          <h2 class="text-anime-style-3">Embrace The Elegance Our Exclusive Property</h2>
          <div class="space20"></div>
          <p data-aos="1000">We offer the best city apartments tailored to your urban lifestyle. Whether you're seeking a chic downtown loft or a serene uptown retreat, our diverse portfolio ensures.</p>
          <div class="space24"></div>
          <div class="others-area">
            <div class="box1" data-aos="fade-up" data-aos-duration="800">
            <h2>4X</h2>
            <div class="space16"></div>
            <p>BedRooms</p>
            </div>
            <div class="box1" data-aos="fade-up" data-aos-duration="900">
            <h2>3X</h2>
            <div class="space16"></div>
            <p>BathRoom</p>
            </div>

            <div class="box1" data-aos="fade-up" data-aos-duration="1000" style="margin: 0;">
            <h2>1X</h2>
            <div class="space16"></div>
            <p>Fitness Room</p>
            </div>
          </div>
          <div class="space10"></div>
          <div class="list-area" data-aos="fade-up" data-aos-duration="1100">
            <ul>
            <li>
              <a href="#"><img src="/img/icons/check4.svg" alt="" /> ECO Construction</a>
            </li>
            <li>
              <a href="#"><img src="/img/icons/check4.svg" alt="" /> New Construction</a>
            </li>
            </ul>
            <ul>
            <li>
              <a href="#"><img src="/img/icons/check4.svg" alt="" /> Fitness Facilities</a>
            </li>
            <li>
              <a href="#"><img src="/img/icons/check4.svg" alt="" /> Swimming Pool</a>
            </li>
            </ul>
          </div>
          <div class="space40"></div>
          <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
            <a href="{{ url('/pages/contact') }}" class="header-btn9">Schedule A Visit <i class="fa-solid fa-arrow-right"></i></a>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== ABOUT AREA ENDS ======= -->

  <!-- ===== GALLERY AREA STARTS ======= -->
  <div class="gallery8-section-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
      <div class="galler-header text-center heading8 space-margin60">
        <h5 data-aos="fade-left" data-aos-duration="800">our gallery</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Diamond Apartment Gallery</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000">
      <div class="gallery-slider-area owl-carousel">
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
          <img src="/img/all-images/gallery/gallery-img5.png" alt="" />
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
      <div class="space30"></div>
      <div class="gallery2-slider-area owl-carousel">
        <div class="content-area">
        <div class="img1">
          <img src="/img/all-images/gallery/gallery-img7.png" alt="" />
        </div>
        <div class="icons">
          <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-plus"></i></a>
        </div>
        </div>

        <div class="content-area">
        <div class="img1">
          <img src="/img/all-images/gallery/gallery-img8.png" alt="" />
        </div>
        <div class="icons">
          <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-plus"></i></a>
        </div>
        </div>

        <div class="content-area">
        <div class="img1">
          <img src="/img/all-images/gallery/gallery-img9.png" alt="" />
        </div>
        <div class="icons">
          <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-plus"></i></a>
        </div>
        </div>
        <div class="content-area">
        <div class="img1">
          <img src="/img/all-images/gallery/gallery-img7.png" alt="" />
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

  <!-- ===== TESTIMONIAL AREA STARTS ======= -->
  <div class="testimonial8-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-5">
      <div class="testimonial-header space-margin60 heading8">
        <h5 data-aos="fade-left" data-aos-duration="800">client feedback</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Hear What Our Client Say About Property</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-10">
      <div class="testimonial8-area owl-carousel">
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
          <img src="/img/icons/quoto-icon6.svg" alt="" />
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
            <img src="/img/all-images/testimonial/testimonial-img4.png" alt="" />
          </div>
          <div class="text">
            <a href="#">Alexy Queen</a>
            <p>Happy Client</p>
          </div>
          </div>
          <div class="quito">
          <img src="/img/icons/quoto-icon6.svg" alt="" />
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
            <img src="/img/all-images/testimonial/testimonial-img4.png" alt="" />
          </div>
          <div class="text">
            <a href="#">Alexy Queen</a>
            <p>Happy Client</p>
          </div>
          </div>
          <div class="quito">
          <img src="/img/icons/quoto-icon6.svg" alt="" />
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
            <img src="/img/all-images/testimonial/testimonial-img4.png" alt="" />
          </div>
          <div class="text">
            <a href="#">Alexy Queen</a>
            <p>Happy Client</p>
          </div>
          </div>
          <div class="quito">
          <img src="/img/icons/quoto-icon6.svg" alt="" />
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
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== TESTIMONIAL AREA ENDS ======= -->

  <!-- ===== CONTACT AREA STARTS ======= -->
  <div class="contact8-section-area sp5">
    <div class="container">
    <div class="row">
      <div class="col-lg-5">
      <div class="heading2">
        <h5 data-aos="fade-left" data-aos-duration="800">Contact Us</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Schedule A Visit Now</h2>
        <div class="space16"></div>
        <p data-aos="fade-left" data-aos-duration="1000">Are you ready to discover your dream home? Schedule visit to our luxurious villa apartments today experience firsthand the elegance comfort we offer. Here's how arrange your visit:</p>
        <div class="space32"></div>
        <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
        <a href="{{ url('/pages/contact') }}" class="header-btn9">Schedule A Consultation <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
      </div>
      <div class="col-lg-3"></div>
      <div class="col-lg-4">
      <div class="contact-img1" data-aos="flip-right" data-aos-duration="1000">
        <img src="/img/all-images/contact/contact-img1.png" alt="" />
        <div class="btn-area1">
        <a href="tel:+1(488)344-0117" class="header-btn9"><i class="fa-solid fa-phone-volume"></i> +1 (488) 344-0117</a>
        <img src="/img/elements/elements4.png" alt="" class="elements4" />
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== CONTACT AREA ENDS ======= -->

  <!-- ===== BLOG AREA STARTS ======= -->
  <div class="blog8-section-area sp7">
    <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
      <div class="blog-header text-center heading8 space-margin60">
        <h5 data-aos="fade-left" data-aos-duration="800">Our Blog</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Our News & Articles</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
      <div class="blog-boxarea">
        <div class="img1 image-anime">
        <img src="/img/all-images/blog/blog-img3.png" alt="" />
        </div>
        <div class="content-area">
        <ul>
          <li>
          <a href="#"><img src="/img/icons/user.svg" alt="" /> Joe Root</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/calender.svg" alt="" /> 16 April, 2024</a>
          </li>
        </ul>
        <div class="space20"></div>
        <a href="{{ url('/blogs/single') }}">How Luxury Suite Offers the Perfect Blend the Comfort</a>
        <div class="space24"></div>
        <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
      <div class="blog-boxarea">
        <div class="img1 image-anime">
        <img src="/img/all-images/blog/blog-img4.png" alt="" />
        </div>
        <div class="content-area">
        <ul>
          <li>
          <a href="#"><img src="/img/icons/user.svg" alt="" /> Joe Root</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/calender.svg" alt="" /> 16 April, 2024</a>
          </li>
        </ul>
        <div class="space20"></div>
        <a href="{{ url('/blogs/single') }}">Guest Spotlight: Memorable Moments at Luxury Suite Villa</a>
        <div class="space24"></div>
        <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
      <div class="blog-boxarea">
        <div class="img1 image-anime">
        <img src="/img/all-images/blog/blog-img5.png" alt="" />
        </div>
        <div class="content-area">
        <ul>
          <li>
          <a href="#"><img src="/img/icons/user.svg" alt="" /> Joe Root</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/calender.svg" alt="" /> 16 April, 2024</a>
          </li>
        </ul>
        <div class="space20"></div>
        <a href="{{ url('/blogs/single') }}">Behind the Scenes: The Art of Creating Luxury Suite Villa</a>
        <div class="space24"></div>
        <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== BLOG AREA ENDS ======= -->

  <!-- ===== FOOTER AREA STARTS ======= -->
  <div class="footer8-section-area">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="footer-instagram-area">
        <div class="row">
        <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
          <div class="footer-contact-box">
          <h3>Send Us A Message</h3>
          <div class="space16"></div>
          <div class="row">
            <div class="col-lg-6">
            <div class="space16"></div>
            <div class="input-area">
              <input type="text" placeholder="Your Name*" />
            </div>
            </div>
            <div class="col-lg-6">
            <div class="space16"></div>
            <div class="input-area">
              <input type="number" placeholder="Mobile Number*" />
            </div>
            </div>
            <div class="col-lg-12">
            <div class="space16"></div>
            <div class="input-area">
              <textarea name="#" id="#" placeholder="Your Message*"></textarea>
            </div>
            </div>
            <div class="col-lg-12">
            <div class="space32"></div>
            <div class="input-area text-end">
              <button type="submit" class="header-btn9">Send Message <i class="fa-solid fa-arrow-right"></i></button>
            </div>
            </div>
          </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="instagram-images">
          <div class="row">
            <div class="col-lg-5 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
            <div class="instagram-posts">
              <div class="img1">
              <img src="/img/all-images/others/others-img7.png" alt="" />
              </div>
              <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
            </div>
            <div class="col-lg-7 col-md-6" data-aos="zoom-in-up" data-aos-duration="900">
            <div class="instagram-posts">
              <div class="img1">
              <img src="/img/all-images/others/others-img8.png" alt="" />
              </div>
              <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
            </div>

            <div class="col-lg-7 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="instagram-posts">
              <div class="img1">
              <img src="/img/all-images/others/others-img9.png" alt="" />
              </div>
              <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
            </div>

            <div class="col-lg-5 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
            <div class="instagram-posts">
              <div class="img1">
              <img src="/img/all-images/others/others-img10.png" alt="" />
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
    <div class="space40"></div>
    <div class="footer8-bottom-section">
    <div class="container">
      <div class="row">
      <div class="col-lg-12">
        <div class="footer-bottom-area">
        <div class="footer-menu-area">
          <div class="footer-logo">
          <a href="{{ url('/') }}"><img src="/img/logo/logo8.png" alt="" /></a>
          </div>
          <div class="footer-menu">
          <ul>
            <li>
            <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="space24"></li>
            <li>
            <a href="{{ url('/apartment/v1') }}">Properties</a>
            </li>
            <li class="space24"></li>
            <li>
            <a href="{{ url('/pages/gallery-v1') }}">Gallery</a>
            </li>
          </ul>
          </div>
          <div class="footer-menu">
          <ul>
            <li>
            <a href="{{ url('/blogs/blog') }}">Blog</a>
            </li>
            <li class="space24"></li>
            <li>
            <a href="#">Pages</a>
            </li>
            <li class="space24"></li>
            <li>
            <a href="{{ url('/pages/contact') }}">Contact</a>
            </li>
          </ul>
          </div>
          <div class="footer-menu2">
          <ul>
            <li>
            <a href="#"><span><i class="fa-solid fa-location-dot"></i></span> <span>65, Brand Tower <br /> New York, USA</span></a>
            </li>
            <li class="space24"></li>
            <li>
            <a href="tel:123-456-7890"><span><i class="fa-solid fa-phone"></i></span> <span>123-456-7890</span></a>
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
            <p>© 2024 Hosue -Single Property Template.</p>
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