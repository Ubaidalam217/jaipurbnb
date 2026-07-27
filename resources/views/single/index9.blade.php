@extends('layouts.base', ['logo9' => true])

@section('body_attribute')
  class="homepage9-body"
@endsection

@section('content')
  @include('layouts.partials.header-single.navbar9')

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="hero9-section-area">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="hero-header">
            <h1 class="text-anime-style-2">Wellcome To Our</h1>
            <div class="space28 d-md-block d-none"></div>
            <div class="space16 d-md-none d-block"></div>
            <h2 class="text-anime-style-2"><img src="/img/all-images/others/others-img14.png" alt="" /> Luxury Villa</h2>
          </div>
        </div>
        <div class="col-lg-4"></div>
        <div class="col-lg-2">
          <div class="play-btn-area">
            <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
              <img src="/img/elements/elements13.png" alt="" />
              <span><i class="fa-solid fa-play"></i></span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="hero9-author-area">
    <div class="img1">
      <img src="/img/all-images/hero/hero-img17.png" alt="" data-aos="fade-right" data-aos-duration="1000" />
    </div>
    <div class="img2 text-end image-anime">
      <img src="/img/all-images/hero/hero-img18.png" alt="" data-aos="fade-left" data-aos-duration="1000" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="hero-boxarea">
            <h5><span><img src="/img/icons/target-icon1.svg" alt="" /></span>60002 Just Meadow East Alfonso</h5>
            <div class="space20"></div>
            <h2>Luxury Suite Villa</h2>
            <div class="space24"></div>
            <ul>
              <li>
                <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> x2</a>
              </li>
              <li>
                <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> x2</a>
              </li>
              <li>
                <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" /> 1200sq</a>
              </li>
              <li>
                <a href="#"><img src="/img/icons/poll.svg" alt="" /> 2 Pool</a>
              </li>
            </ul>
            <div class="space28"></div>
            <p>
              <s>$1.900,000</s> $1.800,000
            </p>
            <div class="space32"></div>
            <div class="btn-area1">
              <a href="{{ url('/apartment/v1') }}" class="header-btn10">View Our Property</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6"></div>
      </div>
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary rounded-2" tabindex="0">
    <!-- ===== PROPERTY AREA STARTS ======= -->
    <div class="property3-section-area sp6" id="property">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="property-images-area">
              <div class="img1 reveal image-anime">
                <img src="/img/all-images/property/property-img8.png" alt="" />
              </div>
              <div class="img2 reveal image-anime">
                <img src="/img/all-images/property/property-img9.png" alt="" />
              </div>
              <div class="elements reveal image-anime">
                <img src="/img/elements/elements9.png" alt="" />
              </div>
            </div>
          </div>
          <div class="col-lg-1"></div>
          <div class="col-lg-5">
            <div class="property-content heading9">
              <h5 data-aos="fade-left" data-aos-duration="800">Property Overview</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Elegance Every Detail Welcome Suite Villa</h2>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="900">Experience the pinnacle of luxury living at our exclusive property, where every detail has been meticulously crafted to provide an unparalleled retreat. Nestled in the heart of, this haven offers.</p>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="1000">Discover the essence of luxury our exclusive property in Dallas, where timeless elegance and modern best comfort converge.</p>
              <div class="space32"></div>
              <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                <a href="{{ url('/apartment/v1') }}" class="header-btn10">View Our Property</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== PROPERTY AREA ENDS ======= -->

    <!-- ===== APARTMENT AREA STARTS ======= -->
    <div class="apartment9-section-area sp6" id="apartment">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 m-auto">
            <div class="apartmrnt-header text-center heading9 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">recent added apartment</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Our Latest Featured Listing</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="apartment-featured-area" data-aos="zoom-in-down" data-aos-duration="800">
              <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                  <div class="img1 image-anime reveal">
                    <img src="/img/all-images/apartment/apartment-img12.png" alt="" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="content-area">
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
                        <a href="#" class="header-btn10">$820,000</a>
                      </div>
                      <div class="love">
                        <a href="javascript:void(0)"><img src="/img/icons/heart7.svg" alt="" class="heart1" /><img src="/img/icons/heart8.svg" alt="" class="heart2" /></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="space40"></div>
            <div class="apartment-featured-area" data-aos="zoom-in-down" data-aos-duration="1000">
              <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                  <div class="img1 image-anime reveal">
                    <img src="/img/all-images/apartment/apartment-img13.png" alt="" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="content-area">
                    <a href="{{ url('/apartment/single') }}">Dimond Apartment</a>
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
                        <a href="#" class="header-btn10">$921,000</a>
                      </div>
                      <div class="love">
                        <a href="javascript:void(0)"><img src="/img/icons/heart7.svg" alt="" class="heart1" /><img src="/img/icons/heart8.svg" alt="" class="heart2" /></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="space40"></div>
            <div class="apartment-featured-area" data-aos="zoom-in-down" data-aos-duration="1200">
              <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                  <div class="img1 image-anime reveal">
                    <img src="/img/all-images/apartment/apartment-img14.png" alt="" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="content-area">
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
                        <a href="#" class="header-btn10">$665,000</a>
                      </div>
                      <div class="love">
                        <a href="javascript:void(0)"><img src="/img/icons/heart7.svg" alt="" class="heart1" /><img src="/img/icons/heart8.svg" alt="" class="heart2" /></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="space30 d-lg-none d-block"></div>
            <div class="maps-area">
              <div class="gmap_canvas" data-aos="zoom-in-up" data-aos-duration="800">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4506257.120552435!2d88.67021924228865!3d21.954385721237916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1704088968016!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
              <div class="space30"></div>
              <div class="gmap_canvas" data-aos="zoom-in-up" data-aos-duration="1000">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4506257.120552435!2d88.67021924228865!3d21.954385721237916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1704088968016!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
              <div class="space30"></div>
              <div class="gmap_canvas" data-aos="zoom-in-up" data-aos-duration="1200">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4506257.120552435!2d88.67021924228865!3d21.954385721237916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1704088968016!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== APARTMENT AREA ENDS ======= -->

    <!-- ===== GALLERY AREA STARTS ======= -->
    <div class="gallery9-section-area sp6" id="gallery">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 m-auto">
            <div class="gallery-header text-center heading9 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">Our Gallery</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Our Property Gallery</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="space40"></div>
      <div class="wrapper">
        <div class="center-slider2">
          <div>
            <div class="img1">
              <img src="/img/all-images/gallery/gallery-img10.png" alt="" />
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div>
            <div class="img1">
              <img src="/img/all-images/gallery/gallery-img11.png" alt="" />
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div>
            <div class="img1">
              <img src="/img/all-images/gallery/gallery-img12.png" alt="" />
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div>
            <div class="img1">
              <img src="/img/all-images/gallery/gallery-img13.png" alt="" />
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div>
            <div class="img1">
              <img src="/img/all-images/gallery/gallery-img10.png" alt="" />
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div>
            <div class="img1">
              <img src="/img/all-images/gallery/gallery-img11.png" alt="" />
              <div class="icons">
                <a href="{{ url('/pages/gallery-v1') }}"><i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== GALLERY AREA ENDS ======= -->

    <!-- ===== TESTIMONIAL AREA STARTS ======= -->
    <div class="testimonial9-area sp6" id="testimonial">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 m-auto">
            <div class="testimonial-header text-center heading9 space-margin60">
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
              <div class="slider-boxarea2">
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img6.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Alex Henderson</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Alexy Queen</a>
                    <div class="space16"></div>
                    <p>Owner SP Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Antonio Rudiger</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>

                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img6.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Alex Henderson</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Alexy Queen</a>
                    <div class="space16"></div>
                    <p>Owner SP Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Antonio Rudiger</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>

                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img6.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Alex Henderson</a>
                    <div class="space16"></div>
                    <p>Owner Suite Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Alexy Queen</a>
                    <div class="space16"></div>
                    <p>Owner SP Villa</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="javascript:void(0)">Antonio Rudiger</a>
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
            <div class="testimonial-horizental-slider2">
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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
                    <img src="/img/icons/quoto-icon7.svg" alt="" />
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

    <!-- ===== OTHERS AREA STARTS ======= -->
    <div class="others9-section-area sp6" id="follow">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 m-auto">
            <div class="others-header text-center heading9 space-margin60">
              <h5 data-aos="fade-left" data-aos-duration="800">instagram follow</h5>
              <div class="space20"></div>
              <h2 class="text-anime-style-3">Follow @hosue.property</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
            <div class="instagram-posts">
              <div class="img1">
                <img src="/img/all-images/others/others-img2.png" alt="" />
              </div>
              <div class="icons">
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="instagram-posts">
              <div class="img1">
                <img src="/img/all-images/others/others-img3.png" alt="" />
              </div>
              <div class="icons">
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-5 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
            <div class="instagram-posts">
              <div class="img1">
                <img src="/img/all-images/others/others-img5.png" alt="" />
              </div>
              <div class="icons">
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-5 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
            <div class="instagram-posts">
              <div class="img1">
                <img src="/img/all-images/others/others-img13.png" alt="" />
              </div>
              <div class="icons">
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="instagram-posts">
              <div class="img1">
                <img src="/img/all-images/others/others-img4.png" alt="" />
              </div>
              <div class="icons">
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
            <div class="instagram-posts">
              <div class="img1">
                <img src="/img/all-images/service/service-img9.png" alt="" />
              </div>
              <div class="icons">
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-12" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="space18"></div>
            <div class="btn-area1 text-center">
              <a href="#" class="header-btn10"><i class="fa-brands fa-instagram"></i> Follow @hosue.property</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== OTHERS AREA ENDS ======= -->

    <!-- ===== FOOTER AREA STARTS ======= -->
    <div class="footer9-section-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="footer-menu-area">
              <div class="footer-elements">
                <div class="footer-logo">
                  <img src="/img/logo/footer-logo1.png" alt="" />
                </div>
                <div class="footer-menu">
                  <ul>
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
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
                      <a href="#">Pages</a>
                    </li>
                    <li>
                      <a href="{{ url('/pages/contact') }}">Contact</a>
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
                <div class="col-lg-5 m-auto">
                  <div class="footer-call-area text-center">
                    <a href="tel:+1234567890">+123 456 7890</a>
                    <div class="space36"></div>
                    <ul>
                      <li>
                        <a href="#"><span><i class="fa-solid fa-location-crosshairs"></i></span> <span>329 Quenberry Street, <br class="d-lg-block d-none" /> North California USA</span></a>
                      </li>
                      <li>
                        <a href="#"><span><i class="fa-regular fa-clock"></i></span> <span>Opening: 8:00 — 22:00</span></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="copyright-area">
                <p>© 2024 Hosue -Single Property Template.</p>
                <ul>
                  <li>
                    <a href="#">Privacy Policy</a>
                  </li>
                  <li>
                    <span>|</span>
                  </li>
                  <li>
                    <a href="#">Terms & Condition</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ===== FOOTER AREA ENDS ======= -->
  </div>
@endsection
