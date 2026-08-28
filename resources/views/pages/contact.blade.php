@extends('layouts.base', ['logo5' => true])

@section('title', 'Contact JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')

  {{--
    Deliberately NOT a message form. The footer already carries a decorative
    "Send Us A Message" form that posts nowhere, and adding a second dead form
    would repeat that. Guests reach hosts per listing over WhatsApp/phone -
    that is the product - so this page routes people to the right channel
    instead of pretending to collect messages.
  --}}
  <div class="inner-page-header-area" style="padding:120px 0 60px;background:#2F3E46;">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 m-auto text-center">
          <h1 style="color:#fff;font-family:'Poppins',sans-serif;font-size:40px;font-weight:700;line-height:1.2;">Contact JaipurBnB</h1>
          <div class="space16"></div>
          <p style="color:rgba(255,255,255,.82);font-family:'Poppins',sans-serif;font-size:16px;line-height:1.7;">
            Booking a stay? Contact the host directly from any listing — that is
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
              Monday to Saturday, 10am – 7pm IST.
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

  @include('layouts.partials.footer')
@endsection
