@extends('layouts.base', ['logo7' => true])

@section('body_attribute')
  class="homepage7-body"
@endsection

@section('content')
  @include('layouts.partials.header.navbar7')

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="space80"></div>
  <div class="header2-slick-slider">
    <div class="hero6-main-area">
    <div class="bg-img1">
      <video data-speed=".7" class="play-video" loop="" muted="" autoplay="" playsinline="" style="scale: none; will-change: transform;" data-lag="0">
      <source src="/img/all-images/video/video-2.mp4" type="video/mp4" />
      </video>
    </div>
    <div class="container">
      <div class="row">
      <div class="col-lg-7"></div>
      <div class="col-lg-5">
        <div class="header-contact-box" data-aos="zoom-in-up" data-aos-duration="1000">
        <h3>Make An Enquiry</h3>
        <div class="space32"></div>
        <div class="input-area">
          <input type="text" placeholder="Full Name*" />
        </div>
        <div class="space24"></div>
        <div class="input-area">
          <input type="number" placeholder="Phone Number*" />
        </div>
        <div class="space24"></div>
        <div class="input-area">
          <textarea name="#" id="#" placeholder="Your Message*"></textarea>
        </div>
        <div class="space32"></div>
        <div class="input-area text-end">
          <button type="submit" class="header-btn8">Submit Now <i class="fa-solid fa-arrow-right"></i></button>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== ABOUT AREA STARTS ======= -->
  <div class="about7-section-area sp6">
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
          <div class="heading7 author-header heading6">
          <h5 data-aos="fade-left" data-aos-duration="800">About apartment</h5>
          <div class="space20"></div>
          <h2 class="text-anime-style-3">Embrace The Elegance Our Exclusive Property</h2>
          <div class="space20"></div>
          <p data-aos="fade-left" data-aos-duration="1000">We offer the best city apartments tailored to your urban lifestyle. Whether you're seeking a chic downtown loft or a serene uptown retreat, our diverse portfolio ensures.</p>
          <div class="space24"></div>
          <div class="others-area">
            <div class="box1" data-aos="fade-up" data-aos-duration="900">
            <h2>4X</h2>
            <div class="space16"></div>
            <p>BedRooms</p>
            </div>
            <div class="box1" data-aos="fade-up" data-aos-duration="1000">
            <h2>3X</h2>
            <div class="space16"></div>
            <p>BathRoom</p>
            </div>

            <div class="box1" data-aos="fade-up" data-aos-duration="1200" style="margin: 0;">
            <h2>1X</h2>
            <div class="space16"></div>
            <p>Fitness Room</p>
            </div>
          </div>
          <div class="space10"></div>
          <div class="list-area" data-aos="fade-up" data-aos-duration="1000">
            <ul>
            <li>
              <a href="#"><img src="/img/icons/check3.svg" alt="" /> ECO Construction</a>
            </li>
            <li>
              <a href="#"><img src="/img/icons/check3.svg" alt="" /> New Construction</a>
            </li>
            </ul>
            <ul>
            <li>
              <a href="#"><img src="/img/icons/check3.svg" alt="" /> Fitness Facilities</a>
            </li>
            <li>
              <a href="#"><img src="/img/icons/check3.svg" alt="" /> Swimming Pool</a>
            </li>
            </ul>
          </div>
          <div class="space40"></div>
          <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
            <a href="{{ url('/pages/contact') }}" class="header-btn8">Schedule A Visit <i class="fa-solid fa-arrow-right"></i></a>
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

  <!-- ===== APARTMENT AREA STARTS ======= -->
  <div class="apartment7-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-6">
      <div class="apartment-header heading7 space-margin60">
        <h5 data-aos="fade-left" data-aos-duration="1000">recent added apartment</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Our Latest Featured Listing</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000">
      <div class="arpart-slider-area owl-carousel">
        <div class="apartment-boxarea">
        <div class="img1 image-anime">
          <img src="/img/all-images/apartment/apartment-img6.png" alt="" />
        </div>
        <div class="content">
          <a href="{{ url('/apartment/single') }}">Apartment Complex</a>
          <div class="space16"></div>
          <p>Los Angeles City, CA, USA</p>
          <div class="space24"></div>
          <ul>
          <li>
            <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> x2</a>
          </li>
          <li>
            <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> x2</a>
          </li>
          <li>
            <a href="#" class="m-0"><img src="/img/icons/squre-icon1.svg" alt="" /> 1200 sq</a>
          </li>
          </ul>
          <div class="space28"></div>
          <div class="btn-area1">
          <div class="single-btn">
            <a href="#" class="header-btn8">$820,000</a>
          </div>
          <div class="love">
            <a href="javascript:void(0)"><img src="/img/icons/heart5.svg" alt="" class="heart1" /><img src="/img/icons/heart6.svg" alt="" class="heart2" /></a>
          </div>
          </div>
        </div>
        </div>

        <div class="apartment-boxarea">
        <div class="img1 image-anime">
          <img src="/img/all-images/apartment/apartment-img7.png" alt="" />
        </div>
        <div class="content">
          <a href="{{ url('/apartment/single') }}">Diamond Apartment</a>
          <div class="space16"></div>
          <p>Los Angeles City, CA, USA</p>
          <div class="space24"></div>
          <ul>
          <li>
            <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> x2</a>
          </li>
          <li>
            <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> x2</a>
          </li>
          <li>
            <a href="#" class="m-0"><img src="/img/icons/squre-icon1.svg" alt="" /> 1200 sq</a>
          </li>
          </ul>
          <div class="space28"></div>
          <div class="btn-area1">
          <div class="single-btn">
            <a href="#" class="header-btn8">$820,000</a>
          </div>
          <div class="love">
            <a href="javascript:void(0)"><img src="/img/icons/heart5.svg" alt="" class="heart1" /><img src="/img/icons/heart6.svg" alt="" class="heart2" /></a>
          </div>
          </div>
        </div>
        </div>

        <div class="apartment-boxarea">
        <div class="img1 image-anime">
          <img src="/img/all-images/apartment/apartment-img8.png" alt="" />
        </div>
        <div class="content">
          <a href="{{ url('/apartment/single') }}">Luxury Suite Villa</a>
          <div class="space16"></div>
          <p>Los Angeles City, CA, USA</p>
          <div class="space24"></div>
          <ul>
          <li>
            <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> x2</a>
          </li>
          <li>
            <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> x2</a>
          </li>
          <li>
            <a href="#" class="m-0"><img src="/img/icons/squre-icon1.svg" alt="" /> 1200 sq</a>
          </li>
          </ul>
          <div class="space28"></div>
          <div class="btn-area1">
          <div class="single-btn">
            <a href="#" class="header-btn8">$820,000</a>
          </div>
          <div class="love">
            <a href="javascript:void(0)"><img src="/img/icons/heart5.svg" alt="" class="heart1" /><img src="/img/icons/heart6.svg" alt="" class="heart2" /></a>
          </div>
          </div>
        </div>
        </div>
        <div class="apartment-boxarea">
        <div class="img1 image-anime">
          <img src="/img/all-images/apartment/apartment-img8.png" alt="" />
        </div>
        <div class="content">
          <a href="{{ url('/apartment/single') }}">Luxury Suite Villa</a>
          <div class="space16"></div>
          <p>Los Angeles City, CA, USA</p>
          <div class="space24"></div>
          <ul>
          <li>
            <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> x2</a>
          </li>
          <li>
            <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> x2</a>
          </li>
          <li>
            <a href="#" class="m-0"><img src="/img/icons/squre-icon1.svg" alt="" /> 1200 sq</a>
          </li>
          </ul>
          <div class="space28"></div>
          <div class="btn-area1">
          <div class="single-btn">
            <a href="#" class="header-btn8">$820,000</a>
          </div>
          <div class="love">
            <a href="javascript:void(0)"><img src="/img/icons/heart5.svg" alt="" class="heart1" /><img src="/img/icons/heart6.svg" alt="" class="heart2" /></a>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== APARTMENT AREA ENDS ======= -->

  <!-- ===== SERVICE AREA STARTS ======= -->
  <div class="service7-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
      <div class="heading7 text-center">
        <h5 data-aos="fade-left" data-aos-duration="800">Villa amenities</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Our Property Amenities</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
      <div class="amenities-boxarea">
        <div class="img1">
        <img src="/img/all-images/service/service-img4.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">New Construction</a>
        <div class="space18"></div>
        <p>Discover the epitome of luxury living at Luxury, every detail .</p>
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
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">Swimming Pool</a>
        <div class="space18"></div>
        <p>Explore our meticulously best designed spaces and indulge.</p>
        <h3>02</h3>
        </div>
      </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1100">
      <div class="amenities-boxarea">
        <div class="img1">
        <img src="/img/all-images/service/service-img7.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">Fitness Facilities</a>
        <div class="space18"></div>
        <p>Uncover the essence of luxury as you explore our exclusive.</p>
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
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">Eco Construction</a>
        <div class="space18"></div>
        <p>Step into sophistication and serenity at new construction.</p>
        <h3>04</h3>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== SERVICE AREA ENDS ======= -->

  <!-- ===== PROPERTY FACT AREA STARTS ======= -->
  <div class="property7-author-section-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="property-header heading6 space-margin60">
        <div class="heading7">
        <h5 data-aos="fade-left" data-aos-duration="800">Property Overview</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Elegance Every Detail <br class="d-lg-block d-none" /> Welcome Suite Villa</h2>
        </div>
        <div class="author-box" data-aos="zoom-in-up" data-aos-duration="1000">
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

    <div class="row">
      <div class="col-lg-8">
      <div class="rotate-img">
        <iframe src="https://momento360.com/e/u/a5776ef4aada433aba026bdfd69e0138?utm_campaign=embed&utm_source=other&heading=0&pitch=0&field-of-view=75&size=medium&display-plan=true"></iframe>
      </div>
      </div>
      <div class="col-lg-4">
      <div class="property-accordion">
        <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item" data-aos="fade-left" data-aos-duration="800">
          <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">First Floor</button></h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">Kitchen appliances are essential tools that simplify and enhance our culinary experiences, transforming routine.</div>
          <ul class="list">
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
        </div>
        <div class="space20"></div>
        <div class="accordion-item" data-aos="fade-left" data-aos-duration="1000">
          <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">Second Floor</button></h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">Kitchen appliances are essential tools that simplify and enhance our culinary experiences, transforming routine.</div>
          <ul class="list">
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
        </div>
        <div class="space20"></div>
        <div class="accordion-item" data-aos="fade-left" data-aos-duration="1100">
          <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">Swimming Pool</button></h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">Kitchen appliances are essential tools that simplify and enhance our culinary experiences, transforming routine.</div>
          <ul class="list">
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
        </div>
        <div class="space20"></div>
        <div class="accordion-item" data-aos="fade-left" data-aos-duration="1200">
          <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">Kitchen Appliances</button></h2>
          <div id="flush-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">Kitchen appliances are essential tools that simplify and enhance our culinary experiences, transforming routine.</div>
          <ul class="list">
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
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== PROPERTY FACT AREA ENDS ======= -->

  <!-- ===== PROPERTIES AREA STARTS ======= -->
  <div class="property7-section-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="row align-items-center">
        <div class="col-lg-6">
        <div class="property-header heading7">
          <h5 data-aos="fade-left" data-aos-duration="800">Property plans</h5>
          <div class="space20"></div>
          <h2 class="text-anime-style-3">Your Apartment Plan</h2>
          <div class="space16"></div>
          <p data-aos="fade-left" data-aos-duration="1000">When developing property plans for a villa, it is essential to consider several key elements to ensure the design is both functional and aesthetically pleasing.</p>
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
          <a href="{{ url('/pages/contact') }}" class="header-btn8">Schedule Visit Now <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="property-images">
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
    </div>
  </div>
  <!-- ===== PROPERTIES AREA ENDS ======= -->

  <!-- ===== TESTIMONIAL AREA STARTS ======= -->
  <div class="testimonial7-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-5">
      <div class="testimonial-header space-margin60 heading7">
        <h5 data-aos="fade-left" data-aos-duration="800">client feedback</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Hear What Our Client Say About Property</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-10">
      <div class="testimonial7-area owl-carousel">
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
          <img src="/img/icons/quoto5.svg" alt="" />
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
          <img src="/img/icons/quoto5.svg" alt="" />
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
          <img src="/img/icons/quoto5.svg" alt="" />
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
          <img src="/img/icons/quoto5.svg" alt="" />
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
  <div class="contact7-section-area sp5">
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
        <a href="{{ url('/pages/contact') }}" class="header-btn8">Schedule A Consultation <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
      </div>
      <div class="col-lg-3"></div>
      <div class="col-lg-4">
      <div class="contact-img1" data-aos="flip-right" data-aos-duration="1000">
        <img src="/img/all-images/contact/contact-img1.png" alt="" />
        <div class="btn-area1">
        <a href="tel:+1(488)344-0117" class="header-btn8"><i class="fa-solid fa-phone-volume"></i> +1 (488) 344-0117</a>
        <img src="/img/elements/elements4.png" alt="" class="elements4" />
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== CONTACT AREA ENDS ======= -->

  <!-- ===== BLOG AREA STARTS ======= -->
  <div class="blog7-section-area sp7">
    <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
      <div class="blog-header text-center heading7 space-margin60">
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
  <div class="footer7-section-area">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="footer-instagram-area">
        <div class="row">
        <div class="col-lg-6 m-auto">
          <div class="instagram-header text-center">
          <h5 data-aos="fade-left" data-aos-duration="800">INSTAGRAM</h5>
          <h2 class="text-anime-style-3">Follow @hosue.property</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000">
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
  <div class="footer7-bottom-section">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="footer-bottom-area">
        <div class="footer-menu-area">
        <div class="footer-logo">
          <img src="/img/logo/logo7.png" alt="" />
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
          <a href="{{ url('/pages/contact') }}" class="header-btn8">Schedule Visit Now <i class="fa-solid fa-arrow-right"></i></a>
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