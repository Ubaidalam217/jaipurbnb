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
        <h2>Apartment V3</h2>
        <div class="space24"></div>
        <p>
        <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/apartment/v1') }}">Apartment V3</a>
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
  <div class="apartment-inner2-section-area sp7 bg2">
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
          <a href="#"><img src="/img/icons/location1.svg" alt="" />538 Joanie Fort Apt.</a>
          </li>
        </ul>
        </div>
        <div class="arrow">
        <a href="{{ url('/apartment/single') }}">View</a>
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
          <a href="#"><img src="/img/icons/location1.svg" alt="" />65242 Stark Circles Apt.</a>
          </li>
        </ul>
        </div>
        <div class="arrow">
        <a href="{{ url('/apartment/single') }}">View</a>
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
          <a href="#"><img src="/img/icons/location1.svg" alt="" />6435 Ned Corner Apt.</a>
          </li>
        </ul>
        </div>
        <div class="arrow">
        <a href="{{ url('/apartment/single') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6 d-lg-none d-block" data-aos="zoom-in-up" data-aos-duration="1100">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img5.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">Villa Grean Complex</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/location1.svg" alt="" />78016 Gusikowski Village.</a>
          </li>
        </ul>
        </div>
        <div class="arrow">
        <a href="{{ url('/apartment/single') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6 d-lg-block d-none" data-aos="zoom-in-up" data-aos-duration="1300">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img5.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">Villa Grean Complex</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/location1.svg" alt="" />33374 Vivienne Centers Suite 267.</a>
          </li>
        </ul>
        </div>
        <div class="arrow">
        <a href="{{ url('/apartment/single') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-8 col-md-12" data-aos="zoom-in-up" data-aos-duration="1200">
      <div class="apartment-boxarea">
        <div class="img2">
        <img src="/img/all-images/apartment/apartment-img4.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">Modern Industrial Apartement</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/location1.svg" alt="" />33374 Vivienne Centers Suite 267.</a>
          </li>
        </ul>
        </div>
        <div class="arrow2">
        <a href="{{ url('/apartment/single') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-8 col-md-12" data-aos="zoom-in-up" data-aos-duration="1200">
      <div class="apartment-boxarea">
        <div class="img2">
        <img src="/img/all-images/apartment/apartment-img16.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">Modern Industrial Apartement</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/location1.svg" alt="" />78016 Gusikowski Village.</a>
          </li>
        </ul>
        </div>
        <div class="arrow2">
        <a href="{{ url('/apartment/single') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6 d-lg-block d-none" data-aos="zoom-in-up" data-aos-duration="1300">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img15.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/apartment/single') }}">Villa Grean Complex</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/location1.svg" alt="" />538 Joanie Fort Apt.</a>
          </li>
        </ul>
        </div>
        <div class="arrow">
        <a href="{{ url('/apartment/single') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-12">
      <div class="space30"></div>
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