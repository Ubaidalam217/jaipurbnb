<!--===== FOOTER AREA STARTS =======-->
{{--
  Consent checkbox styling. Inline for the same reason as the alerts below:
  Hostinger has no Node and public/build is gitignored, so an SCSS change
  would cost a local rebuild plus a manual bundle upload.

  Colours are for the dark footer specifically - the /contact copy of this
  control sits on white and is styled separately in jb-auth-styles.
--}}
<style>
    .jb-footer-consent {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin: 0;
        color: rgba(255, 255, 255, .82);
        font-family: 'Poppins', sans-serif;
        font-size: 13.5px;
        line-height: 1.5;
        cursor: pointer;
    }

    /* accent-color tints the native control instead of replacing it, so the
       checkbox keeps its built-in keyboard focus ring and screen-reader
       semantics. margin-top nudges the box onto the first text baseline. */
    .jb-footer-consent input[type="checkbox"] {
        flex: 0 0 auto;
        width: 17px;
        height: 17px;
        margin-top: 2px;
        accent-color: #E07A5F;
        cursor: pointer;
    }

    .jb-footer-consent a {
        color: #E07A5F;
        text-decoration: underline;
    }
</style>
<div class="footer3-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-instagram-area">
                    <div class="row">
                        <div class="col-lg-6">
                            {{--
                                Posts to ContactController@send, the same endpoint as the
                                form on /contact. Both render on /contact at once, so the
                                hidden source=footer tells the controller which one to
                                flash back to; $fromFooter below gates every message and
                                every old() call so the two never show each other's state.

                                Alerts and errors are styled inline rather than in SCSS,
                                for the reason given on the Legal column below: Hostinger
                                has no Node and public/build is gitignored, so a SCSS
                                change would mean a local rebuild plus a manual bundle
                                upload. The colours are picked for the dark footer, where
                                the light-background .jb-auth__alert styles are unreadable
                                (and not loaded on most pages anyway).
                            --}}
                            @php($fromFooter = session('contact_source') === 'footer')

                            <div class="footer-contact-box" id="footer-contact" data-aos="zoom-in-up" data-aos-duration="1000">
                                <h3>Send Us A Message</h3>
                                <div class="space16"></div>

                                @if ($fromFooter && session('contact_success'))
                                    <div role="status" data-contact-alert="footer" style="margin-bottom:16px;padding:12px 14px;border-radius:10px;border-left:3px solid #4ADE80;background:rgba(74,222,128,.12);color:#BBF7D0;font-family:'Poppins',sans-serif;font-size:14.5px;line-height:1.5;">
                                        {{ session('contact_success') }}
                                    </div>
                                @endif

                                @if ($fromFooter && session('contact_error'))
                                    <div role="alert" data-contact-alert="footer" style="margin-bottom:16px;padding:12px 14px;border-radius:10px;border-left:3px solid #F87171;background:rgba(248,113,113,.12);color:#FECACA;font-family:'Poppins',sans-serif;font-size:14.5px;line-height:1.5;">
                                        {{ session('contact_error') }}
                                    </div>
                                @endif

                                @if ($fromFooter && $errors->any())
                                    <div role="alert" data-contact-alert="footer" style="margin-bottom:16px;padding:12px 14px;border-radius:10px;border-left:3px solid #F87171;background:rgba(248,113,113,.12);color:#FECACA;font-family:'Poppins',sans-serif;font-size:14.5px;line-height:1.5;">
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('contact.send') }}" novalidate>
                                    @csrf
                                    <input type="hidden" name="source" value="footer">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="space16"></div>
                                            <div class="input-area">
                                                <input type="text" name="name" id="footer-contact-name"
                                                       placeholder="Your Name*" aria-label="Your name"
                                                       maxlength="100" required
                                                       value="{{ $fromFooter ? old('name') : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="space16"></div>
                                            <div class="input-area">
                                                {{-- type="tel", not the template's type="number": a number
                                                     spinner mangles leading zeros, +91 prefixes and spaces. --}}
                                                <input type="tel" name="phone" id="footer-contact-phone"
                                                       placeholder="Mobile Number*" aria-label="Mobile number"
                                                       maxlength="20" required
                                                       value="{{ $fromFooter ? old('phone') : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="space16"></div>
                                            <div class="input-area">
                                                <input type="email" name="email" id="footer-contact-email"
                                                       placeholder="Email Address*" aria-label="Email address"
                                                       maxlength="255" required
                                                       autocomplete="email" inputmode="email"
                                                       value="{{ $fromFooter ? old('email') : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="space16"></div>
                                            <div class="input-area">
                                                <textarea name="message" id="footer-contact-message"
                                                          placeholder="Your Message*" aria-label="Your message"
                                                          maxlength="2000" required>{{ $fromFooter ? old('message') : '' }}</textarea>
                                            </div>
                                        </div>
                                        {{-- Never repopulated from old(): consent has to be given on the
                                             attempt that actually sends, not inherited from a failed one. --}}
                                        <div class="col-lg-12">
                                            <div class="space16"></div>
                                            <label class="jb-footer-consent" for="footer-contact-consent">
                                                <input type="checkbox" name="consent" id="footer-contact-consent" value="1" required>
                                                <span>I agree to the <a href="{{ route('legal.privacy') }}" target="_blank" rel="noopener">privacy policy</a>.</span>
                                            </label>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="space32"></div>
                                            <div class="input-area text-end">
                                                <button type="submit" class="header-btn4">Send Message</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="instagram-images">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="instagram-posts" data-aos="zoom-in-up" data-aos-duration="800">
                                            <div class="img1">
                                                <img src="/img/all-images/gallery/gallery-img2.webp" alt="Jaipur haveli" width="1024" height="733">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="/img/all-images/gallery/gallery-img3.webp" alt="Jaipur pool villa" width="1200" height="800">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-7 col-md-6" data-aos="zoom-in-up" data-aos-duration="1100">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="/img/all-images/gallery/gallery-img4.webp" alt="Jaipur property interior" width="396" height="316">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="/img/all-images/gallery/gallery-img5.webp" alt="Jaipur garden courtyard" width="1200" height="922">
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
                                    <img src="{{ asset('img/jaipurbnb-logo-compact.svg') }}" alt="JaipurBnB" width="76" height="70" style="height:70px;width:auto;display:block;">
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
                                    <li><a href="mailto:{{ config('contact.email') }}" style="text-transform: none"><span><i class="fa-solid fa-envelope"></i></span> <span>{{ config('contact.email') }}</span></a></li>
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