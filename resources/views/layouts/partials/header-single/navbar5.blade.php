<!--=====HEADER START=======-->
<header>
    <div class="header-area homepage5 header header-sticky d-none d-lg-block " id="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-top-area">
                        <p>Are you Visit in Diamond Property? <a href="{{ url('/pages/contact') }}"> Contact Us</a></p>
                        <ul>
                            <li><a href="mailto:info@realesate.com"><i class="fa-solid fa-envelope"></i> info@realesate.com</a></li>
                            <li><a href="tel:(555)123-4567"><i class="fa-solid fa-phone-volume"></i> (555) 123-4567</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <nav id="navbar-example2" class="navbar">
                        <div class="header-elements">
                            <div class="site-logo">
                                <a href="{{ url('/') }}"><img src="/img/logo/logo5.png" alt=""></a>
                            </div>
                            <div class="main-menu">
                                <ul>
                                    <li class="nav-item"><a href="#property" class="nav-link active"><span>Property</span></a></li>
                                    <li class="nav-item"><a href="#amenities" class="nav-link"><span>Amenities</span></a></li>
                                    <li class="nav-item"><a href="#apartment" class="nav-link"><span>Apartment</span></a></li>
                                    <li class="nav-item"><a href="#gallery" class="nav-link"><span>Gallery</span></a></li>
                                    <li class="nav-item"><a href="#testimonials" class="nav-link"><span>Testimonials</span></a></li>
                                    <li class="nav-item"><a href="#blogs" class="nav-link"><span>Blogs</span></a></li>
                                </ul>
                            </div>
                            <div class="btn-area">
                                <div class="search-icon header__search header-search-btn">
                                    <a href="#"><img src="/img/icons/search-icon1.svg" alt=""> <span></span></a>
                                </div>
                                <a href="{{ url('/pages/contact') }}" class="header-btn6">Schedule A Visit <i class="fa-solid fa-arrow-right"></i></a>
                            </div>

                            <div class="header-search-form-wrapper">
                                <div class="tx-search-close tx-close"><i class="fa-solid fa-xmark"></i></div>
                                <div class="header-search-container">
                                    <form role="search" class="search-form">
                                        @csrf
                                        <input type="search" class="search-field" placeholder="Search …" value="" name="s">
                                        <button type="submit" class="search-submit"><img src="/img/icons/search-icon1.svg" alt=""></button>
                                    </form>
                                </div>
                            </div>
                            <div class="body-overlay"></div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!--=====HEADER END =======-->

<!--===== MOBILE HEADER STARTS =======-->
<div class="mobile-header mobile-haeder5 d-block d-lg-none">
    <div class="container-fluid">
        <div class="col-12">
            <div class="mobile-header-elements">
                <div class="mobile-logo">
                    <a href="{{ url('/') }}"><img src="/img/logo/logo5.png" alt=""></a>
                </div>
                <div class="mobile-nav-icon dots-menu">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-sidebar mobile-sidebar5">
    <div class="logosicon-area">
        <div class="logos">
            <img src="/img/logo/logo5.png" alt="">
        </div>
        <div class="menu-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div class="mobile-nav mobile-nav1">
        <ul class="mobile-nav-list nav-list1">
            <li><a href="#">Home </a>
                <ul class="sub-menu">
                    <li>
                        <a href="#">Multiple Page</a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('/') }}">Home One</a></li>
                            <li><a href="{{ url('/demo/index2') }}">Home Two</a></li>
                            <li><a href="{{ url('/demo/index3') }}">Home Three</a></li>
                            <li><a href="{{ url('/demo/index4') }}">Home Four</a></li>
                            <li><a href="{{ url('/demo/index5') }}">Home Five</a></li>
                            <li><a href="{{ url('/demo/index6') }}">Home Six</a></li>
                            <li><a href="{{ url('/demo/index7') }}">Home Seven</a></li>
                            <li><a href="{{ url('/demo/index8') }}">Home Eight</a></li>
                            <li><a href="{{ url('/demo/index9') }}">Home Nine</a></li>
                            <li><a href="{{ url('/demo/index10') }}">Home Ten</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Landing Page</a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('/single/index1') }}" target="_blank">Home One</a></li>
                            <li><a href="{{ url('/single/index2') }}" target="_blank">Home Two</a></li>
                            <li><a href="{{ url('/single/index3') }}" target="_blank">Home Three</a></li>
                            <li><a href="{{ url('/single/index4') }}" target="_blank">Home Four</a></li>
                            <li><a href="{{ url('/single/index5') }}" target="_blank">Home Five</a></li>
                            <li><a href="{{ url('/single/index6') }}" target="_blank">Home Six</a></li>
                            <li><a href="{{ url('/single/index7') }}" target="_blank">Home Seven</a></li>
                            <li><a href="{{ url('/single/index8') }}" target="_blank">Home Eight</a></li>
                            <li><a href="{{ url('/single/index9') }}" target="_blank">Home Nine</a></li>
                            <li><a href="{{ url('/single/index10') }}" target="_blank">Home Ten</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item"><a href="#property" class="nav-link active"><span>Property</span></a></li>
            <li class="nav-item"><a href="#amenities" class="nav-link"><span>Amenities</span></a></li>
            <li class="nav-item"><a href="#apartment" class="nav-link"><span>Apartment</span></a></li>
            <li class="nav-item"><a href="#gallery" class="nav-link"><span>Gallery</span></a></li>
            <li class="nav-item"><a href="#testimonials" class="nav-link"><span>Testimonials</span></a></li>
            <li class="nav-item"><a href="#blogs" class="nav-link"><span>Blogs</span></a></li>
        </ul>

        <div class="allmobilesection">
            <a href="{{ url('/pages/contact') }}" class="header-btn6">Get Started <span><i class="fa-solid fa-arrow-right"></i></span></a>
            <div class="single-footer">
                <h3>Contact Info</h3>
                <div class="footer1-contact-info">
                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="contact-info-text">
                            <a href="tel:+3(924)4596512">+3(924)4596512</a>
                        </div>
                    </div>

                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="contact-info-text">
                            <a href="mailto:info@example.com">info@example.com</a>
                        </div>
                    </div>

                    <div class="single-footer">
                        <h3>Our Location</h3>

                        <div class="contact-info-single">
                            <div class="contact-info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="contact-info-text">
                                <a href="mailto:info@example.com">55 East Birchwood Ave.Brooklyn, <br> New York 11201,United States</a>
                            </div>
                        </div>

                    </div>
                    <div class="single-footer">
                        <h3>Social Links</h3>

                        <div class="social-links-mobile-menu">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== MOBILE HEADER STARTS =======-->