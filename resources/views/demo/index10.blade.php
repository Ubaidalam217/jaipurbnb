@extends('layouts.base', ['logo10' => true])

@section('body_attribute')
  class="homepage10-body"
@endsection

@section('content')
  @include('layouts.partials.header.navbar10')

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="hero10-section-area">
    <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-5">
      <div class="hero10-header">
        <h5 data-aos="fade-left" data-aos-duration="800"><i class="fa-solid fa-location-dot"></i> 538 Joanie Fort Apt. 933 Louisiana</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-2">Welcome to Your Luxurious Haven</h2>
        <div class="space32"></div>
        <div class="btn-area1" data-aos="fade-left" data-aos-duration="1000">
        <a href="{{ url('/pages/contact') }}" class="header-btn11">Schedule A Visit Now <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
      </div>
      <div class="col-lg-2"></div>
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
        <textarea placeholder="Your Message*"></textarea>
        </div>
        <div class="space32"></div>
        <div class="input-area text-end">
        <button type="submit" class="header-btn11">Submit Now <i class="fa-solid fa-arrow-right"></i></button>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== SERVICE AREA STARTS ======= -->
  <div class="service10-section-area sp6">
    <div class="side-img">
    <img src="/img/all-images/apartment/apartment-img9.png" alt="" data-aos="fade-right" data-aos-duration="1000" />
    </div>
    <div class="side-img2">
    <img src="/img/all-images/apartment/apartment-img10.png" alt="" data-aos="fade-left" data-aos-duration="1200" />
    </div>
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="service-heading space-margin60">
        <div class="heading10">
        <h5 data-aos="fade-left" data-aos-duration="800">Villa amenities</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Discover Our D.Villa's <br class="d-lg-block d-none" /> Exceptional Amenities</h2>
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
      <div class="col-lg-12">
      <div class="service-images-area">
        <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-5">
          <div class="img1 image-anime reveal">
          <img src="/img/all-images/apartment/apartment-img11.png" alt="" />
          </div>
        </div>
        <div class="col-lg-5">
          <div class="heading10 author-header">
          <p data-aos="fade-left" data-aos-duration="800">We offer the best city apartments tailored to your urban lifestyle. Whether you're seeking a chic downtown loft or a serene uptown retreat, our diverse portfolio ensures.</p>
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

            <div class="box1" style="margin: 0;" data-aos="fade-up" data-aos-duration="1000">
            <h2>1X</h2>
            <div class="space16"></div>
            <p>Fitness Room</p>
            </div>
          </div>
          <div class="space10"></div>
          <div class="list-area" data-aos="fade-up" data-aos-duration="1100">
            <ul>
            <li>
              <a href="#"><img src="/img/icons/check5.svg" alt="" /> ECO Construction</a>
            </li>
            <li>
              <a href="#"><img src="/img/icons/check5.svg" alt="" /> New Construction</a>
            </li>
            </ul>
            <ul>
            <li>
              <a href="#"><img src="/img/icons/check5.svg" alt="" /> Fitness Facilities</a>
            </li>
            <li>
              <a href="#"><img src="/img/icons/check5.svg" alt="" /> Swimming Pool</a>
            </li>
            </ul>
          </div>
          <div class="space40"></div>
          <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
            <a href="{{ url('/pages/contact') }}" class="header-btn11">Schedule A Visit <i class="fa-solid fa-arrow-right"></i></a>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== SERVICE AREA ENDS ======= -->

  <!-- ===== APARTMENT AREA STARTS ======= -->
  <div class="apartment10-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-6">
      <div class="apartment-header heading10 space-margin60">
        <h5 data-aos="fade-left" data-aos-duration="800">recent added apartment</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-2">Our Latest Featured Listing</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
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
            <a href="#" class="header-btn11">$820,000</a>
          </div>
          <div class="love">
            <a href="javascript:void(0)"><img src="/img/icons/heart9.svg" alt="" class="heart1" /><img src="/img/icons/heart10.svg" alt="" class="heart2" /></a>
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
            <a href="#" class="header-btn11">$820,000</a>
          </div>
          <div class="love">
            <a href="javascript:void(0)"><img src="/img/icons/heart9.svg" alt="" class="heart1" /><img src="/img/icons/heart10.svg" alt="" class="heart2" /></a>
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
            <a href="#" class="header-btn11">$820,000</a>
          </div>
          <div class="love">
            <a href="javascript:void(0)"><img src="/img/icons/heart9.svg" alt="" class="heart1" /><img src="/img/icons/heart10.svg" alt="" class="heart2" /></a>
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
            <a href="#" class="header-btn11">$820,000</a>
          </div>
          <div class="love">
            <a href="javascript:void(0)"><img src="/img/icons/heart9.svg" alt="" class="heart1" /><img src="/img/icons/heart10.svg" alt="" class="heart2" /></a>
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

  <!-- ===== GALLERY AREA STARTS ======= -->
  <div class="gallery10-section-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
      <div class="galler-header text-center heading10 space-margin60">
        <h5 data-aos="fade-left" data-aos-duration="800">our gallery</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-2">Diamond Apartment Gallery</h2>
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

  <!-- ===== PROPERTIES AREA STARTS ======= -->
  <div class="property10-section-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="row align-items-center">
        <div class="col-lg-6">
        <div class="property-header heading10">
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
          <a href="{{ url('/pages/contact') }}" class="header-btn11">Schedule Visit Now <i class="fa-solid fa-arrow-right"></i></a>
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
          <img src="/img/elements/elements14.png" alt="" />
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
  <div class="testimonial10-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-5">
      <div class="testimonial-header space-margin60 heading10">
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
            <img src="/img/icons/quoto-icon8.svg" alt="" />
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
            <img src="/img/icons/quoto-icon8.svg" alt="" />
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
            <img src="/img/icons/quoto-icon8.svg" alt="" />
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
            <img src="/img/icons/quoto-icon8.svg" alt="" />
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

  <!-- ===== BLOG AREA STARTS ======= -->
  <div class="blog10-section-area sp7">
    <div class="container">
    <div class="row">
      <div class="col-lg-5 m-auto">
      <div class="blog-header text-center heading10 space-margin60">
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
  <div class="footer10-section-area">
    <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="footer-instagram-area">
        <div class="row">
        <div class="col-lg-6" data-aos="zoom-in-down" data-aos-duration="1000">
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
              <textarea placeholder="Your Message*"></textarea>
            </div>
            </div>
            <div class="col-lg-12">
            <div class="space32"></div>
            <div class="input-area text-end">
              <button type="submit" class="header-btn11">Send Message <i class="fa-solid fa-arrow-right"></i></button>
            </div>
            </div>
          </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="instagram-images">
          <div class="row">
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-duration="800">
            <div class="instagram-posts">
              <div class="img1">
              <img src="/img/all-images/others/others-img7.png" alt="" />
              </div>
              <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
            </div>
            <div class="col-lg-7 col-md-6" data-aos="fade-up" data-aos-duration="1000">
            <div class="instagram-posts">
              <div class="img1">
              <img src="/img/all-images/others/others-img8.png" alt="" />
              </div>
              <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
            </div>

            <div class="col-lg-7 col-md-6" data-aos="fade-up" data-aos-duration="1200">
            <div class="instagram-posts">
              <div class="img1">
              <img src="/img/all-images/others/others-img9.png" alt="" />
              </div>
              <div class="icons">
              <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
            </div>

            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-duration="1000">
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
    <div class="footer10-bottom-section">
    <div class="container">
      <div class="row">
      <div class="col-lg-12">
        <div class="footer-bottom-area">
        <div class="footer-menu-area">
          <div class="footer-logo">
          <a href="{{ url('/') }}"><img src="/img/logo/logo10.png" alt="" /></a>
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