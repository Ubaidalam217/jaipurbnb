@extends('layouts.base', ['logo5' => true])

@section('title', 'The Royal Walled City Haveli - JaipurBnB')

@section('body_attribute')
  class="homepage5-body"
@endsection

@section('content')
  @include('layouts.partials.navbar')

  <!-- ===== HERO AREA STARTS ======= -->
  <div class="space80"></div>
  <div class="hero5-area">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="hero-header header-heading3">
            <h2 class="text-anime-style-3">A Heritage Haveli in the Heart of the Pink City.</h2>
            <div class="space20"></div>
            <p data-aos="fade-left" data-aos-duration="800">A restored heritage haveli in the heart of Jaipur's Walled City, minutes from Hawa Mahal, Johari Bazaar and the City Palace.</p>
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
            <h4>Approx Rs 2,500 / night</h4>
            <div class="space20"></div>
            <h3>The Royal Walled City Haveli</h3>
            <div class="space20"></div>
            <p>Walled City, Jaipur</p>
            <div class="space20"></div>
            <div class="box-lists">
              <ul>
                <li>
                  <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> 2 BR</a> <span>|</span>
                </li>
                <li>
                  <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> 2 BA</a> <span>|</span>
                </li>
                <li>
                  <a href="#"><img src="/img/icons/squre-icon1.svg" alt="" /> 1500 sq ft</a>
                </li>
              </ul>
              <a href="#" class="heart"><i class="fa-regular fa-heart"></i></a>
            </div>
            <div class="space24"></div>
            <div class="btn-area1">
              <a href="#" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#25D366;color:#0F3D2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;margin-right:12px;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><a href="#" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#B34D33;color:#fff;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;"><i class="fa-solid fa-phone"></i> Call</a>
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
                <a href="{{ url('/single/index5') }}">Rooftop Terrace</a>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon6.svg" alt="" />
              </div>
              <div class="content">
                <a href="{{ url('/single/index5') }}">Central Courtyard</a>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon7.svg" alt="" />
              </div>
              <div class="content">
                <a href="{{ url('/single/index5') }}">Airport Pickup</a>
              </div>
            </div>

            <div class="boxes">
              <div class="icons">
                <img src="/img/icons/others-icon8.svg" alt="" />
              </div>
              <div class="content">
                <a href="{{ url('/single/index5') }}">Home-Cooked Meals</a>
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
              <h2 class="text-anime-style-3">Authentic Heritage Experience at The Royal Walled City Haveli</h2>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="900">Set inside the old city walls, this restored haveli keeps its original jharokha windows, frescoed archways and open courtyard, with modern plumbing, air conditioning and fast Wi-Fi added throughout.</p>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="1000">The host lives on site and can arrange airport pickup, guided walks through the bazaars and home-cooked Rajasthani meals on request.</p>
              <div class="space32"></div>
              <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                <a href="#" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#25D366;color:#0F3D2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;margin-right:12px;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><a href="#" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#B34D33;color:#fff;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;"><i class="fa-solid fa-phone"></i> Call</a>
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
                <h5 data-aos="fade-left" data-aos-duration="800">Property amenities</h5>
                <div class="space20"></div>
                <h2 class="text-anime-style-3">Discover This Property's <br class="d-lg-block d-none" /> Amenities</h2>
              </div>
              <div class="author-box" data-aos="zoom-in-up" data-aos-duration="1000">
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
                    <p data-aos="fade-up" data-aos-duration="800">A traditional Rajasthani haveli arranged around a central courtyard, with a rooftop terrace looking out over the old city rooftops towards Nahargarh Fort.</p>
                    <div class="space24"></div>
                    <div class="others-area">
                      <div class="box1" data-aos="fade-up" data-aos-duration="900">
                        <h2>2X</h2>
                        <div class="space16"></div>
                        <p>Bedrooms</p>
                      </div>
                      <div class="box1" data-aos="fade-up" data-aos-duration="1000">
                        <h2>2X</h2>
                        <div class="space16"></div>
                        <p>Bathrooms</p>
                      </div>

                      <div class="box1" style="margin: 0;" data-aos="fade-up" data-aos-duration="1100">
                        <h2>1X</h2>
                        <div class="space16"></div>
                        <p>Courtyard</p>
                      </div>
                    </div>
                    <div class="space10"></div>
                    <div class="list-area" data-aos="fade-up" data-aos-duration="1000">
                      <ul>
                        <li>
                          <a href="#"><img src="/img/icons/check1.svg" alt="" /> Rooftop Terrace</a>
                        </li>
                        <li>
                          <a href="#"><img src="/img/icons/check1.svg" alt="" /> Traditional Courtyard</a>
                        </li>
                      </ul>
                      <ul>
                        <li>
                          <a href="#"><img src="/img/icons/check1.svg" alt="" /> Airport Pickup</a>
                        </li>
                        <li>
                          <a href="#"><img src="/img/icons/check1.svg" alt="" /> Home-Cooked Meals</a>
                        </li>
                      </ul>
                    </div>
                    <div class="space40"></div>
                    <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
                      <a href="#" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#25D366;color:#0F3D2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;margin-right:12px;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><a href="#" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#B34D33;color:#fff;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;"><i class="fa-solid fa-phone"></i> Call</a>
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
                  <a href="{{ url('/single/index5') }}">Bani Park Boutique Getaway</a>
                  <div class="space16"></div>
                  <p>Bani Park, Jaipur</p>
                  <div class="space24"></div>
                  <ul>
                    <li>
                      <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> 2 BR</a>
                    </li>
                    <li>
                      <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> 2 BA</a>
                    </li>
                    <li>
                      <a href="#" class="m-0"><img src="/img/icons/squre-icon1.svg" alt="" /> 1100 sq ft</a>
                    </li>
                  </ul>
                  <div class="space28"></div>
                  <div class="btn-area1">
                    <div class="single-btn">
                      <a href="#" class="header-btn6">Approx Rs 3,200 / night</a>
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
                  <a href="{{ url('/single/index5') }}">Cozy Amer Fort View Homestay</a>
                  <div class="space16"></div>
                  <p>Amer, Jaipur</p>
                  <div class="space24"></div>
                  <ul>
                    <li>
                      <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> 1 BR</a>
                    </li>
                    <li>
                      <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> 1 BA</a>
                    </li>
                    <li>
                      <a href="#" class="m-0"><img src="/img/icons/squre-icon1.svg" alt="" /> 900 sq ft</a>
                    </li>
                  </ul>
                  <div class="space28"></div>
                  <div class="btn-area1">
                    <div class="single-btn">
                      <a href="#" class="header-btn6">Approx Rs 1,800 / night</a>
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
                  <a href="{{ url('/single/index5') }}">Nahargarh Heritage Retreat</a>
                  <div class="space16"></div>
                  <p>Nahargarh, Jaipur</p>
                  <div class="space24"></div>
                  <ul>
                    <li>
                      <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> 3 BR</a>
                    </li>
                    <li>
                      <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> 3 BA</a>
                    </li>
                    <li>
                      <a href="#" class="m-0"><img src="/img/icons/squre-icon1.svg" alt="" /> 1800 sq ft</a>
                    </li>
                  </ul>
                  <div class="space28"></div>
                  <div class="btn-area1">
                    <div class="single-btn">
                      <a href="#" class="header-btn6">Approx Rs 5,500 / night</a>
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
                  <a href="{{ url('/single/index5') }}">Premium Terrace Studio near Central Cafes</a>
                  <div class="space16"></div>
                  <p>C-Scheme, Jaipur</p>
                  <div class="space24"></div>
                  <ul>
                    <li>
                      <a href="#"><img src="/img/icons/bed-icon1.svg" alt="" /> 1 BR</a>
                    </li>
                    <li>
                      <a href="#"><img src="/img/icons/bat-icon1.svg" alt="" /> 1 BA</a>
                    </li>
                    <li>
                      <a href="#" class="m-0"><img src="/img/icons/squre-icon1.svg" alt="" /> 800 sq ft</a>
                    </li>
                  </ul>
                  <div class="space28"></div>
                  <div class="btn-area1">
                    <div class="single-btn">
                      <a href="#" class="header-btn6">Approx Rs 3,800 / night</a>
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
              <h2 class="text-anime-style-3">The Royal Walled City Haveli Gallery</h2>
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
                  <a href="#"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>

              <div class="content-area">
                <div class="img1">
                  <img src="/img/all-images/gallery/gallery-img3.png" alt="" />
                </div>
                <div class="icons">
                  <a href="#"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>

              <div class="content-area">
                <div class="img1">
                  <img src="/img/all-images/gallery/gallery-img5.png" alt="" />
                </div>
                <div class="icons">
                  <a href="#"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>
              <div class="content-area">
                <div class="img1">
                  <img src="/img/all-images/gallery/gallery-img6.png" alt="" />
                </div>
                <div class="icons">
                  <a href="#"><i class="fa-solid fa-plus"></i></a>
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
                  <a href="#"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>

              <div class="content-area">
                <div class="img1">
                  <img src="/img/all-images/gallery/gallery-img8.png" alt="" />
                </div>
                <div class="icons">
                  <a href="#"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>

              <div class="content-area">
                <div class="img1">
                  <img src="/img/all-images/gallery/gallery-img9.png" alt="" />
                </div>
                <div class="icons">
                  <a href="#"><i class="fa-solid fa-plus"></i></a>
                </div>
              </div>
              <div class="content-area">
                <div class="img1">
                  <img src="/img/all-images/gallery/gallery-img7.png" alt="" />
                </div>
                <div class="icons">
                  <a href="#"><i class="fa-solid fa-plus"></i></a>
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
                    <a href="#">Ananya Verma</a>
                    <div class="space16"></div>
                    <p>Guest from Delhi</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Priya Sharma</a>
                    <div class="space16"></div>
                    <p>Guest from Mumbai</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Antonio Rudiger</a>
                    <div class="space16"></div>
                    <p>Guest from Delhi</p>
                  </div>
                </div>

                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img6.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Ananya Verma</a>
                    <div class="space16"></div>
                    <p>Guest from Delhi</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Priya Sharma</a>
                    <div class="space16"></div>
                    <p>Guest from Mumbai</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Antonio Rudiger</a>
                    <div class="space16"></div>
                    <p>Guest from Delhi</p>
                  </div>
                </div>

                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img6.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Ananya Verma</a>
                    <div class="space16"></div>
                    <p>Guest from Delhi</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img7.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Priya Sharma</a>
                    <div class="space16"></div>
                    <p>Guest from Mumbai</p>
                  </div>
                </div>
                <div class="slider-box">
                  <div class="img1">
                    <img src="/img/all-images/testimonial/testimonial-img8.png" alt="" />
                  </div>
                  <div class="content">
                    <a href="#">Antonio Rudiger</a>
                    <div class="space16"></div>
                    <p>Guest from Delhi</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
                      <a href="#">Priya Sharma</a>
                      <p>Happy Guest</p>
                    </div>
                  </div>
                  <div class="quito">
                    <img src="/img/icons/quoto-icon3.svg" alt="" />
                  </div>
                </div>
                <div class="space24"></div>
                <span>Highly recommend this Walled City haveli!</span>
                <div class="space16"></div>
                <p>“Booking was simple — I messaged the host on WhatsApp and had everything confirmed the same day. The haveli was exactly as listed.”</p>
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
              <h2 class="text-anime-style-3">Contact the Host Directly</h2>
              <div class="space16"></div>
              <p data-aos="fade-left" data-aos-duration="1000">Message the host on WhatsApp or call directly to check dates and agree a price. JaipurBnB takes no booking fee and no commission — you deal with the host, not us.</p>
              <div class="space32"></div>
              <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                <a href="#" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#25D366;color:#0F3D2E;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;margin-right:12px;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><a href="#" style="display:inline-flex;align-items:center;gap:8px;min-height:48px;padding:0 22px;border-radius:130px;background:#B34D33;color:#fff;font-family:'Poppins',sans-serif;font-size:16px;font-weight:600;text-decoration:none;"><i class="fa-solid fa-phone"></i> Call</a>
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

    <!-- ===== FOOTER AREA STARTS ======= -->
    <div class="footer5-bottom-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="footer-bottom-area">
              <div class="footer-menu-area">
                <div class="footer-logo">
                  <a href="{{ url('/') }}" style="color:#E07A5F;font-family:'Poppins',sans-serif;font-size:24px;font-weight:700;letter-spacing:-.02em;text-decoration:none;">JaipurBnB</a>
                </div>
                <div class="footer-menu">
                  <ul>
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="{{ url('/apartment/v4') }}">Browse Properties</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="#">Neighborhoods</a>
                    </li>
                  </ul>
                </div>
                <div class="footer-menu">
                  <ul>
                    <li>
                      <a href="#">List Your Property</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="#">How It Works</a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="#">Contact</a>
                    </li>
                  </ul>
                </div>
                <div class="footer-menu2">
                  <ul>
                    <li>
                      <a href="#"><span><i class="fa-solid fa-location-dot"></i></span> <span>Jaipur, Rajasthan <br /> India</span></a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="tel:+91XXXXXXXXXX"><span><i class="fa-solid fa-phone"></i></span> <span>+91 XXXXX XXXXX</span></a>
                    </li>
                    <li class="space24"></li>
                    <li>
                      <a href="mailto:hello@jaipurbnb.com" style="text-transform: none"><span><i class="fa-solid fa-envelope"></i></span> <span>hello@jaipurbnb.com</span></a>
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
                    <p>© 2026 JaipurBnB. All rights reserved.</p>
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
