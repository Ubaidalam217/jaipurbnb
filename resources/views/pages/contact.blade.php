@extends('layouts.base', ['logo5' => true])

@section('title', 'Contact JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')

  {{--
    The form below is the ONE form on the site that reaches JaipurBnB itself
    (ContactController::send emails it to config('contact.email')). Guest to
    host contact stays off-platform on the WhatsApp/Call buttons of each
    listing - that is the product - so the hero still pushes people to /browse
    first, and this form is for platform enquiries: billing, subscriptions,
    "how do I list".

    NOTE: the footer partial still carries the template's decorative
    "Send Us A Message" block, which posts nowhere. It is unrelated to this
    form and should either be wired to contact.send or removed.
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
            <a href="mailto:hello@jaipurbnb.com" style="color:#B34D33;font-family:'Poppins',sans-serif;font-weight:600;text-transform:none;">hello@jaipurbnb.com</a>
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
       so the flash message lands in view instead of at the top of the page. --}}
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

            @if (session('contact_success'))
              <div class="jb-auth__alert jb-auth__alert--ok" role="status">{{ session('contact_success') }}</div>
            @endif

            @if (session('contact_error'))
              <div class="jb-auth__alert" role="alert">{{ session('contact_error') }}</div>
            @endif

            @if ($errors->any())
              <div class="jb-auth__alert" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('contact.send') }}" novalidate>
              @csrf

              <div class="jb-auth__field">
                <label class="jb-auth__label" for="contact-name">Your name <span class="jb-auth__req">*</span></label>
                <input class="jb-auth__input @error('name') is-invalid @enderror"
                       type="text" id="contact-name" name="name"
                       value="{{ old('name') }}" maxlength="100" required
                       autocomplete="name"
                       @error('name') aria-invalid="true" aria-describedby="contact-name-error" @enderror>
                @error('name')
                  <span class="jb-auth__error" id="contact-name-error" role="alert">{{ $message }}</span>
                @enderror
              </div>

              <div class="jb-auth__field">
                <label class="jb-auth__label" for="contact-phone">Phone number <span class="jb-auth__req">*</span></label>
                {{-- type="tel", not type="number": a number spinner mangles
                     leading zeros, +91 prefixes and spaces. --}}
                <input class="jb-auth__input @error('phone') is-invalid @enderror"
                       type="tel" id="contact-phone" name="phone"
                       value="{{ old('phone') }}" maxlength="20" required
                       autocomplete="tel"
                       @error('phone') aria-invalid="true" aria-describedby="contact-phone-error" @enderror>
                @error('phone')
                  <span class="jb-auth__error" id="contact-phone-error" role="alert">{{ $message }}</span>
                @enderror
              </div>

              <div class="jb-auth__field">
                <label class="jb-auth__label" for="contact-message">Your message <span class="jb-auth__req">*</span></label>
                <textarea class="jb-auth__input @error('message') is-invalid @enderror"
                          id="contact-message" name="message"
                          maxlength="2000" required
                          @error('message') aria-invalid="true" aria-describedby="contact-message-error" @enderror>{{ old('message') }}</textarea>
                @error('message')
                  <span class="jb-auth__error" id="contact-message-error" role="alert">{{ $message }}</span>
                @enderror
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
