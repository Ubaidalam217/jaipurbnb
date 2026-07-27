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
        <h2>Apartment V2</h2>
        <div class="space24"></div>
        <p>
        <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/apartment/v1') }}">Apartment V2</a>
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

  <!-- ===== APARTMENT AREA STARTS ======= -->
  <div class="about3-section-area sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-9">
      <div class="apartment-list-area space-margin60">
        <div class="select-area">
        <select name="country" class="nice-select">
          <option value="1" data-display="All USA City">All USA City</option>
          <option value="">New York City, New York</option>
          <option value="">Los Angeles, California</option>
          <option value="">Chicago, Illinois</option>
          <option value="">Houston, Texas</option>
          <option value="">Phoenix, Arizona</option>
          <option value="">Philadelphia, Pennsylvania</option>
        </select>
        </div>

        <div class="select-area2">
        <select name="country" class="nice-select">
          <option value="1" data-display="Min Price">$90000</option>
          <option value="">$100000</option>
          <option value="">$110000</option>
          <option value="">$120000</option>
          <option value="">$130000</option>
          <option value="">$140000</option>
        </select>
        </div>

        <div class="select-area2">
        <select name="country" class="nice-select">
          <option value="1" data-display="Max Price">$90000</option>
          <option value="">$100000</option>
          <option value="">$110000</option>
          <option value="">$120000</option>
          <option value="">$130000</option>
          <option value="">$140000</option>
        </select>
        </div>
        <div class="btn-area1">
        <button type="submit" class="header-btn4">Search Now</button>
        </div>
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
      </div>
      </div>
      <div class="col-lg-6">
      <div class="space30"></div>
      <div class="about-widget-images">
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img17.png" alt="" />
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
      </div>
      </div>
      <div class="col-lg-6">
      <div class="space30"></div>
      <div class="about-slider-area owl-carousel">
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img18.png" alt="" />
        </div>
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img18.png" alt="" />
        </div>
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img18.png" alt="" />
        </div>
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img18.png" alt="" />
        </div>

        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img18.png" alt="" />
        </div>
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img18.png" alt="" />
        </div>
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img18.png" alt="" />
        </div>
        <div class="img1 reveal image-anime">
        <img src="/img/all-images/apartment/apartment-img18.png" alt="" />
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
      <div class="col-lg-12">
      <div class="space-margin60"></div>
      <div class="pagination-area">
        <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous"><i class="fa-solid fa-angle-left"></i></a>
          </li>
          <li class="page-item">
          <a class="page-link active" href="#">1</a>
          </li>
          <li class="page-item">
          <a class="page-link" href="#">2</a>
          </li>
          <li class="page-item">
          <a class="page-link" href="#">...</a>
          </li>
          <li class="page-item">
          <a class="page-link" href="#">12</a>
          </li>
          <li class="page-item">
          <a class="page-link m-0" href="#" aria-label="Next"><i class="fa-solid fa-angle-right"></i></a>
          </li>
        </ul>
        </nav>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== APARTMENT AREA ENDS ======= -->

  <!-- ===== SERVICE AREA STARTS ======= -->
  <div class="service3-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
      <div class="heading3 text-center space-margin60">
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
        <div class="space32"></div>
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">New Construction</a>
        <div class="space18"></div>
        <p>
          Discover the epitome of luxury living at Luxury, <br class="d-lg-block d-block" /> every detail .
        </p>
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
        <a href="{{ url('/apartment/single') }}">Swimming Pool</a>
        <div class="space18"></div>
        <p>
          Explore our meticulously best <br class="d-lg-block d-block" /> designed spaces and indulge.
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
        <a href="{{ url('/apartment/single') }}">Fitness Facilities</a>
        <div class="space18"></div>
        <p>
          Uncover the essence of luxury <br class="d-lg-block d-block" /> as you explore our exclusive.
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
        <a href="{{ url('/apartment/single') }}">Eco Construction</a>
        <div class="space18"></div>
        <p>
          Step into sophistication and <br class="d-lg-block d-block" /> serenity at new construction.
        </p>
        <h3>04</h3>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== SERVICE AREA ENDS ======= -->
@endsection