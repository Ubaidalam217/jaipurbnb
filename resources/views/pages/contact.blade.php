@extends('layouts.base', ['logo5' => true])

@section('title', 'Contact JaipurBnB - Get in Touch for Jaipur Stay Enquiries')

@section('meta_description', 'Reach out to JaipurBnB for authentic Jaipur boutique stay recommendations, host contact, or partnership enquiries.')

@section('content')
  @include('layouts.partials.navbar')

  {{--
    The form below reaches JaipurBnB itself (ContactController::send emails it
    to config('contact.email')). Guest to host contact stays off-platform on
    the WhatsApp/Call buttons of each listing - that is the product - so the
    hero still pushes people to /browse first, and this form is for platform
    enquiries: billing, subscriptions, "how do I list".

    The footer partial's "Send Us A Message" card posts to the SAME endpoint,
    and the footer renders on this page too, so both forms are live here at
    once. They are told apart by a hidden source input; see $fromPage below
    and the comment in layouts/partials/footer.blade.php.
  --}}
  @include('layouts.partials.jb-auth-styles')

  <style>
    /*
      The .jb-auth__* rules in the partial above are plain top-level class
      selectors that only need the design-token custom properties in scope.
      .jb-contact republishes them for this mid-page section, because
      .jb-auth itself is a full-height centred page shell and would blow the
      layout apart if used here.
    */
    .jb-contact {
        --jb-primary: #E07A5F;
        --jb-cta: #B34D33;
        --jb-cta-hover: #8F3D28;
        --jb-ink: #2F3E46;
        --jb-muted: #6C7A80;
        --jb-border: rgba(47, 62, 70, .18);
        --jb-error: #B3261E;
        font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        color: var(--jb-ink);
        padding: 40px;
        border: 1px solid var(--jb-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 24px rgba(47, 62, 70, .06);
    }

    .jb-contact *,
    .jb-contact *::before,
    .jb-contact *::after {
        box-sizing: border-box;
    }

    .jb-contact__title {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -.02em;
        color: var(--jb-ink);
    }

    .jb-contact__sub {
        margin: 8px 0 28px;
        font-size: 15px;
        line-height: 1.5;
        color: var(--jb-muted);
    }

    /* textarea needs a sensible height; the shared input rule only sets min-height */
    textarea.jb-auth__input {
        min-height: 150px;
        resize: vertical;
    }

    @media (max-width: 575.98px) {
        .jb-contact {
            padding: 24px;
        }
    }
  </style>

  <div class="inner-page-header-area" style="padding:120px 0 60px;background:#2F3E46;">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 m-auto text-center">
          <h1 style="color:#fff;font-family:'Poppins',sans-serif;font-size:40px;font-weight:700;line-height:1.2;">Contact JaipurBnB</h1>
          <div class="space16"></div>
          <p style="color:rgba(255,255,255,.82);font-family:'Poppins',sans-serif;font-size:16px;line-height:1.7;">
            Booking a stay? Contact the host directly from any listing. That is
            how JaipurBnB works, and it gets you an answer fastest.
          </p>
          <div class="space24"></div>
          <a href="{{ route('properties.browse') }}" class="header-btn4">Browse Properties</a>
        </div>
      </div>
    </div>
  </div>

  <div class="sp1">
    <div class="container">
      <div class="row">

        <div class="col-lg-4 col-md-6">
          <div style="padding:32px;border:1px solid rgba(47,62,70,.12);border-radius:16px;height:100%;">
            <h3 style="color:#2F3E46;font-family:'Poppins',sans-serif;font-size:20px;font-weight:700;">Email us</h3>
            <div class="space12"></div>
            <p style="font-family:'Poppins',sans-serif;font-size:16px;line-height:1.7;">
              For listing enquiries, billing questions or anything about your
              subscription.
            </p>
            <div class="space12"></div>
            <a href="mailto:{{ config('contact.email') }}" style="color:#B34D33;font-family:'Poppins',sans-serif;font-weight:600;text-transform:none;">{{ config('contact.email') }}</a>
          </div>
          <div class="space30 d-lg-none d-block"></div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div style="padding:32px;border:1px solid rgba(47,62,70,.12);border-radius:16px;height:100%;">
            <h3 style="color:#2F3E46;font-family:'Poppins',sans-serif;font-size:20px;font-weight:700;">Call us</h3>
            <div class="space12"></div>
            <p style="font-family:'Poppins',sans-serif;font-size:16px;line-height:1.7;">
              Monday to Saturday, 10am to 7pm IST.
            </p>
            <div class="space12"></div>
            {{-- CONTACT_PHONE in .env (config/contact.php). --}}
            <a href="tel:{{ config('contact.phone_tel') }}" style="color:#B34D33;font-family:'Poppins',sans-serif;font-weight:600;">{{ config('contact.phone') }}</a>
          </div>
          <div class="space30 d-lg-none d-block"></div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div style="padding:32px;border:1px solid rgba(47,62,70,.12);border-radius:16px;height:100%;">
            <h3 style="color:#2F3E46;font-family:'Poppins',sans-serif;font-size:20px;font-weight:700;">Where we are</h3>
            <div class="space12"></div>
            <p style="font-family:'Poppins',sans-serif;font-size:16px;line-height:1.7;">
              Jaipur, Rajasthan<br>India
            </p>
            <div class="space12"></div>
            <a href="{{ route('register') }}" style="color:#B34D33;font-family:'Poppins',sans-serif;font-weight:600;">List your property →</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- id="contact-form" is the fragment ContactController redirects back to,
       so the flash message lands in view instead of at the top of the page.

       $fromPage gates every message and every old() call. The footer card
       posts to the same endpoint and also renders on this page, so without
       the gate a footer submission would light this form up too and
       repopulate it with the footer's input. --}}
  @php($fromPage = session('contact_source') === 'page')

  <div id="contact-form" style="padding:0 0 90px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 m-auto">
          <div class="jb-contact">

            <h2 class="jb-contact__title">Send us a message</h2>
            <p class="jb-contact__sub">
              For anything about listings, billing or your subscription. We
              usually reply within one working day. Booking a stay? Contact the
              host directly from their listing instead - it is faster.
            </p>

            @if ($fromPage && session('contact_success'))
              <div class="jb-auth__alert jb-auth__alert--ok" role="status" data-contact-alert="page">{{ session('contact_success') }}</div>
            @endif

            @if ($fromPage && session('contact_error'))
              <div class="jb-auth__alert" role="alert" data-contact-alert="page">{{ session('contact_error') }}</div>
            @endif

            @if ($fromPage && $errors->any())
              <div class="jb-auth__alert" role="alert" data-contact-alert="page">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('contact.send') }}" novalidate>
              @csrf
              <input type="hidden" name="source" value="page">

              {{-- @error() cannot be used here: it reads the shared error bag
                   and would fire on this form for a footer submission too.
                   Resolve each message through $fromPage instead. --}}
              @php($nameError = $fromPage ? $errors->first('name') : '')
              @php($phoneError = $fromPage ? $errors->first('phone') : '')
              @php($emailError = $fromPage ? $errors->first('email') : '')
              @php($messageError = $fromPage ? $errors->first('message') : '')
              @php($consentError = $fromPage ? $errors->first('consent') : '')

              <div class="jb-auth__field">
                <label class="jb-auth__label" for="contact-name">Your name <span class="jb-auth__req">*</span></label>
                <input class="jb-auth__input @if ($nameError) is-invalid @endif"
                       type="text" id="contact-name" name="name"
                       value="{{ $fromPage ? old('name') : '' }}" maxlength="100" required
                       autocomplete="name"
                       @if ($nameError) aria-invalid="true" aria-describedby="contact-name-error" @endif>
                @if ($nameError)
                  <span class="jb-auth__error" id="contact-name-error" role="alert">{{ $nameError }}</span>
                @endif
              </div>

              <div class="jb-auth__field">
                <label class="jb-auth__label" for="contact-phone">Phone number <span class="jb-auth__req">*</span></label>
                {{-- type="tel", not type="number": a number spinner mangles
                     leading zeros, +91 prefixes and spaces. --}}
                <input class="jb-auth__input @if ($phoneError) is-invalid @endif"
                       type="tel" id="contact-phone" name="phone"
                       value="{{ $fromPage ? old('phone') : '' }}" maxlength="20" required
                       autocomplete="tel"
                       @if ($phoneError) aria-invalid="true" aria-describedby="contact-phone-error" @endif>
                @if ($phoneError)
                  <span class="jb-auth__error" id="contact-phone-error" role="alert">{{ $phoneError }}</span>
                @endif
              </div>

              <div class="jb-auth__field">
                <label class="jb-auth__label" for="contact-email">Email address <span class="jb-auth__req">*</span></label>
                <input class="jb-auth__input @if ($emailError) is-invalid @endif"
                       type="email" id="contact-email" name="email"
                       value="{{ $fromPage ? old('email') : '' }}" maxlength="255" required
                       autocomplete="email" inputmode="email"
                       @if ($emailError) aria-invalid="true" aria-describedby="contact-email-error" @endif>
                @if ($emailError)
                  <span class="jb-auth__error" id="contact-email-error" role="alert">{{ $emailError }}</span>
                @endif
              </div>

              <div class="jb-auth__field">
                <label class="jb-auth__label" for="contact-message">Your message <span class="jb-auth__req">*</span></label>
                <textarea class="jb-auth__input @if ($messageError) is-invalid @endif"
                          id="contact-message" name="message"
                          maxlength="2000" required
                          @if ($messageError) aria-invalid="true" aria-describedby="contact-message-error" @endif>{{ $fromPage ? old('message') : '' }}</textarea>
                @if ($messageError)
                  <span class="jb-auth__error" id="contact-message-error" role="alert">{{ $messageError }}</span>
                @endif
              </div>

              {{-- Consent is unticked by default and has no old() repopulation:
                   a consent box that survives a failed submission has not been
                   actively agreed to on THIS attempt. --}}
              <div class="jb-auth__field jb-consent">
                <label class="jb-consent__label" for="contact-consent">
                  <input type="checkbox" id="contact-consent" name="consent" value="1" required
                         @if ($consentError) aria-invalid="true" aria-describedby="contact-consent-error" @endif>
                  <span>
                    I agree to the <a href="{{ route('legal.privacy') }}" target="_blank" rel="noopener">privacy policy</a>
                    and consent to JaipurBnB using these details to reply to my enquiry.
                    <span class="jb-auth__req">*</span>
                  </span>
                </label>
                @if ($consentError)
                  <span class="jb-auth__error" id="contact-consent-error" role="alert">{{ $consentError }}</span>
                @endif
              </div>

              <button type="submit" class="jb-auth__btn">Send message</button>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  @include('layouts.partials.footer')
@endsection
