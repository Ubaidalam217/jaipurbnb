@extends('layouts.landing')

@section('content')
  <!-- ===== HERO AREA STARTS ======= -->
  <div class="inner-main-hero-area">
    <div class="img1">
    <img src="/img/all-images/hero/hero-img1.png" alt="" />
    </div>
    <div class="img2 d-lg-block d-none">
    <img src="/img/all-images/hero/hero-img2.png" alt="" />
    </div>
    <div class="container">
    <div class="row">
      <div class="col-lg-6">
      <div class="inner-heading header-heading">
        <h2>Diamond Apartment</h2>
        <div class="space24"></div>
        <p>
        <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a>Apartment <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/apartment/v1') }}">Diamond Apartment</a>
        </p>
      </div>
      </div>
      <div class="col-lg-2"></div>
      <div class="col-lg-4">
      <div class="auhtor-box d-lg-block d-none">
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
  <div class="apartment-details-left sp6">
    <div class="container">
    <div class="row">
      <div class="col-lg-5">
      <div class="details-leftarea">
        <div class="search-area">
        <h3>Search Apartment</h3>
        <div class="space28"></div>
        <form action="#">
          @csrf
          <input type="text" placeholder="Search...." />
          <button type="submit" class="header-btn4">Search Now</button>
        </form>
        </div>
        <div class="space40"></div>
        <div class="apartment-details-list">
        <h3>New Apartment</h3>
        <div class="space30"></div>
        <div class="row align-items-center">
          <div class="col-lg-5 col-md-6">
          <div class="img1">
            <img src="/img/all-images/apartment/apartment-img21.png" alt="" />
          </div>
          </div>
          <div class="col-lg-7 col-md-6">
          <div class="content-area">
            <a href="{{ url('/apartment/single') }}">Diamond Apartment</a>
            <div class="space16"></div>
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
            <div class="space20"></div>
            <p>
            <a href="#">$25,000</a><s>$28,000</s>
            </p>
          </div>
          </div>
        </div>
        <div class="space30"></div>
        <div class="row align-items-center">
          <div class="col-lg-5 col-md-6">
          <div class="img1">
            <img src="/img/all-images/apartment/apartment-img22.png" alt="" />
          </div>
          </div>
          <div class="col-lg-7 col-md-6">
          <div class="content-area">
            <a href="{{ url('/apartment/single') }}">Luxury Suite Villa</a>
            <div class="space16"></div>
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
            <div class="space20"></div>
            <p>
            <a href="#">$25,000</a><s>$28,000</s>
            </p>
          </div>
          </div>
        </div>
        <div class="space30"></div>
        <div class="row align-items-center">
          <div class="col-lg-5 col-md-6">
          <div class="img1">
            <img src="/img/all-images/apartment/apartment-img23.png" alt="" />
          </div>
          </div>
          <div class="col-lg-7 col-md-6">
          <div class="content-area">
            <a href="{{ url('/apartment/single') }}">Apartment Complex</a>
            <div class="space16"></div>
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
            <div class="space20"></div>
            <p>
            <a href="#">$25,000</a><s>$28,000</s>
            </p>
          </div>
          </div>
        </div>
        <div class="space30"></div>
        <div class="row align-items-center">
          <div class="col-lg-5 col-md-6">
          <div class="img1">
            <img src="/img/all-images/apartment/apartment-img24.png" alt="" />
          </div>
          </div>
          <div class="col-lg-7 col-md-6">
          <div class="content-area">
            <a href="{{ url('/apartment/single') }}">Green Apartment</a>
            <div class="space16"></div>
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
            <div class="space20"></div>
            <p>
            <a href="#">$25,000</a><s>$28,000</s>
            </p>
          </div>
          </div>
        </div>
        </div>
        <div class="space40"></div>
        <div class="details-area">
        <h3>Apartment Gallery</h3>
        <div class="space32"></div>
        <div class="details-slider owl-carousel">
          <div class="img1">
          <img src="/img/all-images/apartment/apartment-img25.png" alt="" />
          </div>
          <div class="img1">
          <img src="/img/all-images/apartment/apartment-img25.png" alt="" />
          </div>
          <div class="img1">
          <img src="/img/all-images/apartment/apartment-img25.png" alt="" />
          </div>
        </div>
        </div>
      </div>
      </div>
      <div class="col-lg-7">
      <div class="apartment-author-area pdleft">
        <div class="img1">
        <img src="/img/all-images/apartment/apartment-img26.png" alt="" />
        </div>
        <div class="space40"></div>
        <h2>Diamond Apartment</h2>
        <div class="space20"></div>
        <p>Nestled in the heart of the city, Diamond Apartments offer a perfect blend of luxury and convenience. These elegantly designed residence boast spacious layouts, modern amenities, and stunning city views, providing a sanctuary.</p>
        <div class="space16"></div>
        <p>Each apartment features high-end finishes, including granite countertops, stainless steel appliances, hardwood floors, ensuring both style comfort.</p>
        <div class="space40"></div>
        <h3>Diamond Apartment Property Amenities</h3>
        <div class="space20"></div>
        <p>Apartments provide range of exceptional amenities designed to enhance the quality of life for its residents. Here’s a we have list of the amenities offered:</p>
        <div class="space20"></div>
        <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="list-area">
          <div class="icons">
            <img src="/img/icons/apartment-icon1.svg" alt="" />
          </div>
          <div class="text">
            <a href="#">Lock On Bedroom</a>
          </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="list-area">
          <div class="icons">
            <img src="/img/icons/apartment-icon2.svg" alt="" />
          </div>
          <div class="text">
            <a href="#">Private Entrance</a>
          </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="list-area">
          <div class="icons">
            <img src="/img/icons/apartment-icon3.svg" alt="" />
          </div>
          <div class="text">
            <a href="#">Outdoor Dining Area</a>
          </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="list-area">
          <div class="icons">
            <img src="/img/icons/apartment-icon4.svg" alt="" />
          </div>
          <div class="text">
            <a href="#">Patio Or Balcony</a>
          </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6">
          <div class="list-area">
          <div class="icons">
            <img src="/img/icons/apartment-icon5.svg" alt="" />
          </div>
          <div class="text">
            <a href="#">Building Wifi Free</a>
          </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="list-area">
          <div class="icons">
            <img src="/img/icons/apartment-icon6.svg" alt="" />
          </div>
          <div class="text">
            <a href="#">Sun Loungers</a>
          </div>
          </div>
        </div>
        </div>
        <div class="space40"></div>
        <h3>360° Video Visual Tour Of Diamond Apartment</h3>
        <div class="space20"></div>
        <p>Apartments provide range of exceptional amenities designed to enhance the quality of life for its residents. Here’s a we have list of the amenities offered:</p>
        <div class="space10"></div>
        <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="images-area">
          <div class="img2">
            <img src="/img/all-images/apartment/apartment-img27.png" alt="" />
            <div class="play">
            <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube"><i class="fa-solid fa-play"></i></a>
            </div>
          </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="images-area">
          <div class="img1">
            <img src="/img/all-images/apartment/apartment-img28.png" alt="" />
          </div>
          </div>
        </div>
        </div>
        <div class="space32"></div>
        <div class="apartment-contactbox">
        <h3>Send Us A Message</h3>
        <div class="space16"></div>
        <div class="row">
          <div class="col-lg-6">
          <div class="input-area">
            <input type="text" placeholder="Your Name*" />
          </div>
          </div>
          <div class="col-lg-6">
          <div class="input-area">
            <input type="number" placeholder="Mobile Number" />
          </div>
          </div>
          <div class="col-lg-12">
          <div class="input-area">
            <textarea name="#" id="#" placeholder="Your Message"></textarea>
          </div>
          </div>
          <div class="space24"></div>
          <div class="col-lg-12">
          <div class="input-area text-end">
            <button type="submit" class="header-btn4">Send Message</button>
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