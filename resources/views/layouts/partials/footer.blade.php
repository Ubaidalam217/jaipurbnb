<!--===== FOOTER AREA STARTS =======-->
<div class="footer3-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-instagram-area">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="footer-contact-box" data-aos="zoom-in-up" data-aos-duration="1000">
                                <h3>Send Us A Message</h3>
                                <div class="space16"></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="space16"></div>
                                        <div class="input-area">
                                            <input type="text" placeholder="Your Name*">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="space16"></div>
                                        <div class="input-area">
                                            <input type="number" placeholder="Mobile Number*">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="space16"></div>
                                        <div class="input-area">
                                            <textarea name="#" id="#" placeholder="Your Message*"></textarea>
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
                        <div class="col-lg-6">
                            <div class="instagram-images">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="instagram-posts" data-aos="zoom-in-up" data-aos-duration="800">
                                            <div class="img1">
                                                <img src="/img/all-images/others/others-img7.png" alt="">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="/img/all-images/others/others-img8.png" alt="">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-7 col-md-6" data-aos="zoom-in-up" data-aos-duration="1100">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="/img/all-images/others/others-img9.png" alt="">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="/img/all-images/others/others-img10.png" alt="">
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
    <div class="footer3-bottom-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-bottom-area">
                        <div class="footer-menu-area">
                            <div class="footer-logo">
                                {{-- Logo ink is dark (navy/brown) and the footer is dark charcoal,
                                     so the transparent SVG sits on a light chip to stay legible. --}}
                                <a href="{{ url('/') }}" style="display:inline-block;background:#FFFDF7;padding:8px 12px;border-radius:8px;line-height:0;text-decoration:none;">
                                    {{-- Compact variant (no tagline): even at 70px the tagline in
                                         the master lockup would render under 3px tall. See the
                                         header comment in jaipurbnb-logo-compact.svg.
                                         The inline height also has to beat _footer-1.scss, which
                                         pins .footer-logo img to 150x48 with object-fit:contain. --}}
                                    <img src="{{ asset('img/jaipurbnb-logo-compact.svg') }}" alt="JaipurBnB" style="height:70px;width:auto;display:block;">
                                </a>
                            </div>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li class="space24"></li>
                                    <li><a href="{{ route('properties.browse') }}">Browse Properties</a></li>
                                    <li class="space24"></li>
                                    {{-- No dedicated neighbourhoods page; /browse filters by neighbourhood. --}}
                                    <li><a href="{{ route('properties.browse') }}">Neighborhoods</a></li>
                                </ul>
                            </div>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="{{ route('register') }}">List Your Property</a></li>
                                    <li class="space24"></li>
                                    <li><a href="{{ url('/#how-it-works') }}">How It Works</a></li>
                                    <li class="space24"></li>
                                    <li><a href="{{ route('contact') }}">Contact</a></li>
                                </ul>
                            </div>
                            {{-- Legal column. Labelled because "Terms", "Privacy" etc. are
                                 not self-evidently a group the way the nav columns are, and
                                 payment gateways expect these links to be findable. Styled
                                 inline rather than in SCSS: Hostinger has no Node and
                                 public/build is gitignored, so a SCSS change would mean a
                                 local rebuild plus a manual bundle upload. --}}
                            <div class="footer-menu">
                                <span style="display:block;margin-bottom:16px;color:rgba(255,255,255,.55);font-family:'Poppins',sans-serif;font-size:13px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;">Legal</span>
                                <ul>
                                    <li><a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a></li>
                                    <li class="space24"></li>
                                    <li><a href="{{ route('legal.privacy') }}">Privacy Policy</a></li>
                                    <li class="space24"></li>
                                    <li><a href="{{ route('legal.refund') }}">Refund Policy</a></li>
                                    <li class="space24"></li>
                                    <li><a href="{{ route('legal.host-terms') }}">Host Terms</a></li>
                                </ul>
                            </div>
                            <div class="footer-menu2">
                                <ul>
                                    <li><span> <span><i class="fa-solid fa-location-dot"></i></span> <span>Jaipur, Rajasthan <br> India </span></span></li>
                                    <li class="space24"></li>
                                    {{-- Number comes from CONTACT_PHONE in .env (config/contact.php).
                                         Defaults to a +91 00000 00000 placeholder until the client
                                         supplies the real line. --}}
                                    <li><a href="tel:{{ config('contact.phone_tel') }}"><span><i class="fa-solid fa-phone"></i></span> <span>{{ config('contact.phone') }}</span></a></li>
                                    <li class="space24"></li>
                                    <li><a href="mailto:hello@jaipurbnb.com" style="text-transform: none"><span><i class="fa-solid fa-envelope"></i></span> <span>hello@jaipurbnb.com</span></a></li>
                                </ul>
                            </div>
                            {{-- Social icons removed: all four pointed at "#" and JaipurBnB has no
                                 social profiles yet. Restore with real URLs when the client has them. --}}
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
</div>
<!--===== FOOTER AREA ENDS =======-->