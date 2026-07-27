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
            <h2>Contact Us</h2>
            <div class="space24"></div>
            <p>
              <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/blogs/blog') }}"'">Contact Us</a>
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

  <!-- ===== CONTACT AREA STARTS ======= -->
  <div class="contact-inner-area sp6">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="contact-inner-boxarea">
            <div class="row align-items-center">
              <div class="col-lg-8">
                <div class="contact-input-section">
                  <h3>Send us a Message</h3>
                  <div class="space16"></div>
                  <p>
                    Contact us today and let's start your journey to urban living excellence. <br /> Our team at Hosue is here answer your questions, schedule viewings.
                  </p>
                  <div class="space12"></div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="space20"></div>
                      <div class="input-area">
                        <input type="text" placeholder="First Name" />
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="space20"></div>
                      <div class="input-area">
                        <input type="email" placeholder="Email" />
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="space20"></div>
                      <div class="input-area">
                        <input type="number" placeholder="Phone" />
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="space20"></div>
                      <div class="input-area">
                        <select name="country" class="nice-select">
                          <option value="1" data-display="Subject*">Subject*</option>
                          <option value="">Option 01</option>
                          <option value="">Option 02</option>
                          <option value="">Option 03</option>
                          <option value="">Option 04</option>
                          <option value="">Option 05</option>
                          <option value="">Option 06</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="space20"></div>
                      <div class="input-area">
                        <textarea placeholder="Your Message*"></textarea>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="space32"></div>
                      <div class="input-area text-end">
                        <button type="submit" class="header-btn4">Send Message</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="contact-box">
                  <div class="icons">
                    <img src="/img/icons/contact-icon1.svg" alt="" />
                  </div>
                  <div class="content">
                    <p>Call</p>
                    <a href="tel:+1234567890">+123 456 7890</a>
                  </div>
                </div>
                <div class="space20"></div>
                <div class="contact-box">
                  <div class="icons">
                    <img src="/img/icons/contact-icon2.svg" alt="" />
                  </div>
                  <div class="content">
                    <p>Email</p>
                    <a href="mailto:info@hosuevilla.com">info@hosuevilla.com</a>
                  </div>
                </div>
                <div class="space20"></div>
                <div class="contact-box">
                  <div class="icons">
                    <img src="/img/icons/contact-icon3.svg" alt="" />
                  </div>
                  <div class="content">
                    <p>Schedule Time</p>
                    <a href="#">24/7 Anytime All Support</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="space80"></div>

      <div class="row">
        <div class="col-lg-4">
          <div class="contact-author-box">
            <div class="img1">
              <img src="/img/all-images/testimonial/testimonial-img2.png" alt="" />
            </div>
            <div class="space24"></div>
            <p>My Name is Alexy Roy, Agent of Hosue Apartment and Villa. I will answer all your question.</p>
            <div class="space32"></div>
            <div class="btn-area1">
              <a href="#"><img src="/img/icons/whatsapp.svg" alt="" /> Ask Question On WhatsApp</a>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="maps-area">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4506257.120552435!2d88.67021924228865!3d21.954385721237916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1704088968016!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== CONTACT AREA ENDS ======= -->
@endsection
