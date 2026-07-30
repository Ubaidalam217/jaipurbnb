@extends('layouts.base', ['logo5' => true])

@section('title', 'Browse Properties in Jaipur - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
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
        <h2>Browse Properties in Jaipur</h2>
        <div class="space24"></div>
        <p>
        <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/apartment/v4') }}">Browse Properties</a>
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
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== APARTMENT AREA STARTS ======= -->
  <div class="apartment-inner2-section-area sp7 bg2">
    <div class="container">
    <div class="row">
      <div class="col-lg-9">
      <div class="apartment-list-area space-margin60">
        <div class="select-area">
        <select name="country" class="nice-select">
          <option value="1" data-display="All Neighborhoods">All Neighborhoods</option>
          <option value="">Walled City</option>
          <option value="">Amer</option>
          <option value="">Nahargarh</option>
          <option value="">C-Scheme</option>
          <option value="">Civil Lines</option>
          <option value="">Bani Park</option>
          <option value="">Vaishali Nagar</option>
          <option value="">Mansarovar</option>
          <option value="">Malviya Nagar</option>
          <option value="">Jagatpura</option>
          <option value="">Raja Park</option>
          <option value="">Sitapura</option>
          <option value="">Tonk Road</option>
          <option value="">Sanganer</option>
          <option value="">Delhi Road</option>
          <option value="">Ajmer Road</option>
          <option value="">Agra Road</option>
        </select>
        </div>

        <div class="select-area2">
        <select name="country" class="nice-select">
          <option value="1" data-display="Min Price">Any</option>
          <option value="">Rs 1,000</option>
          <option value="">Rs 2,000</option>
          <option value="">Rs 3,000</option>
          <option value="">Rs 5,000</option>
          <option value="">Rs 10,000</option>
        </select>
        </div>

        <div class="select-area2">
        <select name="country" class="nice-select">
          <option value="1" data-display="Max Price">Any</option>
          <option value="">Rs 3,000</option>
          <option value="">Rs 5,000</option>
          <option value="">Rs 10,000</option>
          <option value="">Rs 15,000</option>
          <option value="">Rs 25,000+</option>
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
        <a href="{{ url('/single/index5') }}">The Royal Walled City Haveli Room</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />2 BR</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />2 BA</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />1200 sq ft</a>
          </li>
        </ul>
        <div class="space20"></div>
        <div class="price-area">
          <a href="#">Approx Rs 2,500 / night</a>
          <p>Walled City</p>
        </div>
        </div>
        <div class="arrow">
        <a href="{{ url('/single/index5') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="900">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img2.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/single/index5') }}">Premium Terrace Studio near Central Cafes</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />1 BR</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />1 BA</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />800 sq ft</a>
          </li>
        </ul>
        <div class="space20"></div>
        <div class="price-area">
          <a href="#">Approx Rs 3,800 / night</a>
          <p>C-Scheme</p>
        </div>
        </div>
        <div class="arrow">
        <a href="{{ url('/single/index5') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img3.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/single/index5') }}">Aravali Hills View Family Escape</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />4 BR</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />3 BA</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />2500 sq ft</a>
          </li>
        </ul>
        <div class="space20"></div>
        <div class="price-area">
          <a href="#">Approx Rs 6,500 / night</a>
          <p>Delhi Road</p>
        </div>
        </div>
        <div class="arrow">
        <a href="{{ url('/single/index5') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1100">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img5.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/single/index5') }}">Cozy Amer Fort View Homestay</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />1 BR</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />1 BA</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />900 sq ft</a>
          </li>
        </ul>
        <div class="space20"></div>
        <div class="price-area">
          <a href="#">Approx Rs 1,800 / night</a>
          <p>Amer</p>
        </div>
        </div>
        <div class="arrow">
        <a href="{{ url('/single/index5') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1300">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img15.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/single/index5') }}">Bani Park Boutique Getaway</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />2 BR</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />2 BA</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />1100 sq ft</a>
          </li>
        </ul>
        <div class="space20"></div>
        <div class="price-area">
          <a href="#">Approx Rs 3,200 / night</a>
          <p>Bani Park</p>
        </div>
        </div>
        <div class="arrow">
        <a href="{{ url('/single/index5') }}">View</a>
        </div>
      </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1300">
      <div class="apartment-boxarea">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img20.png" alt="" />
        </div>
        <div class="content-area">
        <a href="{{ url('/single/index5') }}">Nahargarh Heritage Retreat</a>
        <div class="space16"></div>
        <ul>
          <li>
          <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" />3 BR</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" />3 BA</a> <span>|</span>
          </li>
          <li>
          <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" />1800 sq ft</a>
          </li>
        </ul>
        <div class="space20"></div>
        <div class="price-area">
          <a href="#">Approx Rs 5,500 / night</a>
          <p>Nahargarh</p>
        </div>
        </div>
        <div class="arrow">
        <a href="{{ url('/single/index5') }}">View</a>
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
        <h5 data-aos="fade-left" data-aos-duration="800">Why JaipurBnB</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Why Guests Choose Us</h2>
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
        <a href="#">Verified Listings</a>
        <div class="space18"></div>
        <p>
          Every property is checked in person <br class="d-lg-block d-block" /> by our Jaipur team.
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
        <a href="#">Local Support</a>
        <div class="space18"></div>
        <p>
          A Jaipur-based team on hand <br class="d-lg-block d-block" /> if anything goes wrong.
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
        <a href="#">Airport Pickup</a>
        <div class="space18"></div>
        <p>
          Many hosts arrange transfers <br class="d-lg-block d-block" /> from Jaipur airport on request.
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
        <a href="#">Home-Cooked Meals</a>
        <div class="space18"></div>
        <p>
          Traditional Rajasthani cooking <br class="d-lg-block d-block" /> offered by many families.
        </p>
        <h3>04</h3>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== SERVICE AREA ENDS ======= -->

  @include('layouts.partials.footer')
@endsection