@extends('layouts.base', ['logo5' => true])

@section('body_attribute')
  class="homepage5-body"
@endsection

@section('content')
  @include('layouts.partials.header-single.navbar5')

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="space80"></div>
  <div class="hero5-area">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="hero-header header-heading3">
            <h2 class="text-anime-style-3">Enjoy An Perfect Blend Of Comfort And Community.</h2>
            <div class="space20"></div>
            <p data-aos="fade-left" data-aos-duration="800">Nestled in the heart of Diamond Property offers an living experience where comfort meets diamond community.</p>
            <div class="space32"></div>
            <form action="#" data-aos="fade-left" data-aos-duration="1000">
              @csrf
              <input type="text" placeholder="Enter Key Word" />
              <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
          </div>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-4">
          <div class="header-boxarea" data-aos="zoom-in-up" data-aos-duration="1000">
            <h4>$14,000<s>$18,000</s></h4>
            <div class="space20"></div>
            <h3>Villa Diamond Property</h3>
            <div class="space20"></div>
            <p>New York City, CA 2400PXY , USA</p>
            <div class="space20"></div>
            <div class="box-lists">
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
              <a href="#" class="heart"><i class="fa-regular fa-heart"></i></a>
            </div>
            <div class="space24"></div>
            <div class="btn-area1">
              <a href="#" class="header-btn6">Buy Now <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== OTHERS AREA STARTS ======= -->
  <div class="others-author-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 m-auto">
          <div class="auhtor-tabs-area">
            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon5.svg" alt="" />
              </div>
              <div class="content">
                <a href="{{ url('/apartment/single') }}">Swimming Pool</a>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon6.svg" alt="" />
              </div>
              <div class="content">
                <a href="{{ url('/apartment/single') }}">Playing Ground</a>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon7.svg" alt="" />
              </div>
              <div class="content">
                <a href="{{ url('/apartment/single') }}">ECO Construction</a>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon8.svg" alt="" />
              </div>
              <div class="content">
                <a href="{{ url('/apartment/single') }}">New Construction</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== OTHERS AREA ENDS ======= -->

  <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary rounded-2" tabindex="0">
    <!-- ===== PROPERTY AREA STARTS ======= -->
    <div class="property5-section-area sp6" id="property">
      <div class="img1">
        <img src="/img/all-images/property/property-img6.png" alt="" data-aos="zoom-in-up" data-aos-duration="1000" />
      </div>
      <div class="img2">
        <img src="/img/all-images/property/property-img7.png" alt="" data-aos="zoom-in-up" data-aos-duration="1200" />
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-7"></div>
          <div class="col-lg-5">
            <div class="property-header heading5">
              <h5 data-aos="fade-left" data-aos-duration="800">Property Overview</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Elegance Every Detail Welcome Diamond V.</h2>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="900">Experience the pinnacle of luxury living at our exclusive property, where every detail has been meticulously crafted to provide an unparalleled retreat. Nestled in the heart of, this haven offers.</p>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="1000">Discover the essence of luxury our exclusive property in Dallas, where timeless elegance and modern best comfort converge.</p>
              <div class="space32"></div>
              <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                <a href="{{ url('/pages/contact') }}" class="header-btn6">Schedule A Visit <i class="fa-solid fa-arrow-right"></i></a>
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

    <!-- ===== SERVICE AREA STARTS ======= -->
    <div class="service5-section-area sp6" id="amenities">
      <div class="side-img">
        <img src="/img/all-images/apartment/apartment-img9.png" alt="" data-aos="zoom-in-up" data-aos-duration="1000" />
      </div>
      <div class="side-img2">
        <img src="/img/all-images/apartment/apartment-img10.png" alt="" data-aos="zoom-in-up" data-aos-duration="1200" />
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="service-heading space-margin60">
              <div class="heading5">
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
                  <div class="heading5 author-header">
                    <p data-aos="fade-up" data-aos-duration="800">We offer the best city apartments tailored to your urban lifestyle. Whether you're seeking a chic downtown loft or a serene uptown retreat, our diverse portfolio ensures.</p>
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

                      <div class="box1" style="margin: 0;" data-aos="fade-up" data-aos-duration="1100">
                        <h2>1X</h2>
                        <div class="space16"></div>
                        <p>Fitness Room</p>
                      </div>
                    </div>
                    <div class="space10"></div>
                    <div class="list-area" data-aos="fade-up" data-aos-duration="1000">
                      <ul>
                        <li>
                          <a href="#"><img src="/img/icons/check1.svg" alt="" /> ECO Construction</a>
                        </li>
                        <li>
                          <a href="#"><img src="/img/icons/check1.svg" alt="" /> New Construction</a>
                        </li>
                      </ul>
                      <ul>
                        <li>
                          <a href="#"><img src="/img/icons/check1.svg" alt="" /> Fitness Facilities</a>
                        </li>
                        <li>
                          <a href="#"><img src="/img/icons/check1.svg" alt="" /> Swimming Pool</a>
                        </li>
                      </ul>
                    </div>
                    <div class="space40"></div>
                    <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
                      <a href="{{ url('/pages/contact') }}" class="header-btn6">Schedule A Visit <i class="fa-solid fa-arrow-right"></i></a>
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
    <div class="apartment5-area sp6" id="apartment">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="apartment-header heading5 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">recent added apartment</h5>
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
                      <a href="#" class="header-btn6">$820,000</a>
                    </div>
                    <div class="love">
                      <a href="javascript:void(0)"><img src="/img/icons/heart1.svg" alt="" class="heart1" /><img src="/img/icons/heart2.svg" alt="" class="heart2" /></a>
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
                      <a href="#" class="header-btn6">$820,000</a>
                    </div>
                    <div class="love">
                      <a href="javascript:void(0)"><img src="/img/icons/heart1.svg" alt="" class="heart1" /><img src="/img/icons/heart2.svg" alt="" class="heart2" /></a>
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
                      <a href="#" class="header-btn6">$820,000</a>
                    </div>
                    <div class="love">
                      <a href="javascript:void(0)"><img src="/img/icons/heart1.svg" alt="" class="heart1" /><img src="/img/icons/heart2.svg" alt="" class="heart2" /></a>
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
                      <a href="#" class="header-btn6">$820,000</a>
                    </div>
                    <div class="love">
                      <a href="javascript:void(0)"><img src="/img/icons/heart1.svg" alt="" class="heart1" /><img src="/img/icons/heart2.svg" alt="" class="heart2" /></a>
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
    <div class="gallery5-section-area sp6" id="gallery">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 m-auto">
            <div class="galler-header text-center heading5 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">our gallery</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Diamond Apartment Gallery</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
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
    <div class="testimonial5-area sp6" id="testimonials">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 m-auto">
            <div class="testimonial-header text-center heading5 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">testimonial</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Hear What Our Client Say About Property</h2>
            </div>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-lg-2"></div>
          <div class="col-lg-4">
            <div class="slider-area">
              <div class="slider-boxarea">
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img6.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Alex Henderson</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Alexy Queen</a>
                    <div class="space16"></div>
                    <p>Owner SP Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Antonio Rudiger</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>

                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img6.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Alex Henderson</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Alexy Queen</a>
                    <div class="space16"></div>
                    <p>Owner SP Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Antonio Rudiger</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>

                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img6.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Alex Henderson</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Alexy Queen</a>
                    <div class="space16"></div>
                    <p>Owner SP Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Antonio Rudiger</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>
              </div>
              <div class="testimonial-arrows">
                <div class="prev-arrow">
                  <button><i class="fa-solid fa-angle-up"></i></button>
                </div>
                <div class="next-arrow">
                  <button><i class="fa-solid fa-angle-down"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="testimonial-horizental-slider">
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
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
                      <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                    </div>
                    <div class="text">
                      <a href="#">Alexy Queen</a>
                      <p>Happy Client</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
                      <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                    </div>
                    <div class="text">
                      <a href="#">Alexy Queen</a>
                      <p>Happy Client</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
                      <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                    </div>
                    <div class="text">
                      <a href="#">Alexy Queen</a>
                      <p>Happy Client</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
                      <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                    </div>
                    <div class="text">
                      <a href="#">Alexy Queen</a>
                      <p>Happy Client</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
                      <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                    </div>
                    <div class="text">
                      <a href="#">Alexy Queen</a>
                      <p>Happy Client</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
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
    <div class="contact5-section-area sp5">
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
                <a href="{{ url('/pages/contact') }}" class="header-btn6">Schedule A Consultation <i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-3"></div>
          <div class="col-lg-4">
            <div class="contact-img1" data-aos="flip-right" data-aos-duration="1000">
              <img src="/img/all-images/contact/contact-img1.png" alt="" />
              <div class="btn-area1">
                <a href="tel:+1(488)344-0117" class="header-btn6"><i class="fa-solid fa-phone-volume"></i> +1 (488) 344-0117</a>
                <img src="/img/elements/elements4.png" alt="" class="elements4" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== CONTACT AREA ENDS ======= -->

    <!-- ===== BLOG AREA STARTS ======= -->
    <div class="blog5-section-area sp7" id="blogs">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 m-auto">
            <div class="blog-header text-center heading5 space-margin60">
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
                <a href="{{ url('/blogs/single') }}">How Luxury Suite Offers the Perfect Blend the Comfort</a>
                <div class="space24"></div>
                <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="blog-boxarea">
              <div class="img1 image-anime">
                <img src="/img/all-images/blog/blog-img2.png" alt="" />
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
    <div class="footer5-bottom-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="footer-bottom-area">
              <div class="footer-menu-area">
                <div class="footer-logo">
                  <img src="/img/logo/logo5.png" alt="" />
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
    <div class="footer5-section-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="footer-instagram-area">
              <div class="row">
                <div class="col-lg-12">
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
    <!-- ===== FOOTER AREA ENDS ======= -->
  </div>
@endsection
