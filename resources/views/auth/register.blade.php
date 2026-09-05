@extends('layouts.base', ['logo5' => true])

@section('title', 'List Your Property - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')

  <div class="jb-auth">
    <div class="jb-auth__card">
      <h1 class="jb-auth__title">List your property</h1>
      <p class="jb-auth__sub">Create a host account to publish your Jaipur stay and start receiving guest enquiries on WhatsApp.</p>

      <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="full_name">Full name <span class="jb-auth__req">*</span></label>
          <input class="jb-auth__input @error('full_name') is-invalid @enderror"
                 type="text" id="full_name" name="full_name"
                 value="{{ old('full_name') }}" required autofocus
                 autocomplete="name" maxlength="100"
                 @error('full_name') aria-invalid="true" aria-describedby="full_name-error" @enderror>
          @error('full_name')
            <span class="jb-auth__error" id="full_name-error" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="email">Email address <span class="jb-auth__req">*</span></label>
          <input class="jb-auth__input @error('email') is-invalid @enderror"
                 type="email" id="email" name="email"
                 value="{{ old('email') }}" required
                 autocomplete="email" maxlength="100"
                 @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
          @error('email')
            <span class="jb-auth__error" id="email-error" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="phone_number">Phone number <span class="jb-auth__req">*</span></label>
          <input class="jb-auth__input @error('phone_number') is-invalid @enderror"
                 type="tel" id="phone_number" name="phone_number"
                 value="{{ old('phone_number') }}" required
                 autocomplete="tel" inputmode="tel" maxlength="20"
                 {{-- Format hint only. Uses CONTACT_PHONE (config/contact.php) so no
                      real-looking number is hardcoded in the markup. --}}
                 placeholder="{{ config('contact.phone') }}"
                 aria-describedby="phone_number-hint @error('phone_number') phone_number-error @enderror"
                 @error('phone_number') aria-invalid="true" @enderror>
          <span class="jb-auth__hint" id="phone_number-hint">Guests will contact you on this number via WhatsApp and call.</span>
          @error('phone_number')
            <span class="jb-auth__error" id="phone_number-error" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="password">Password <span class="jb-auth__req">*</span></label>
          <div class="jb-auth__pw">
            <input class="jb-auth__input @error('password') is-invalid @enderror"
                   type="password" id="password" name="password" required
                   autocomplete="new-password" minlength="8"
                   aria-describedby="password-hint @error('password') password-error @enderror"
                   @error('password') aria-invalid="true" @enderror>
            <button class="jb-auth__toggle" type="button"
                    data-jb-toggle="password" aria-label="Show password">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false">
                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
            </button>
          </div>
          <span class="jb-auth__hint" id="password-hint">At least 8 characters.</span>
          @error('password')
            <span class="jb-auth__error" id="password-error" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="password_confirmation">Confirm password <span class="jb-auth__req">*</span></label>
          <input class="jb-auth__input" type="password"
                 id="password_confirmation" name="password_confirmation"
                 required autocomplete="new-password" minlength="8">
        </div>

        {{-- Consent notice rather than a tick-box: account creation is the
             affirmative act, and a required checkbox here would add a
             validation branch to RegisterController for no legal gain. --}}
        <p style="margin:0 0 18px;color:#6B7A82;font-family:'Poppins',sans-serif;font-size:13.5px;line-height:1.6;">
          By continuing, you agree to our
          <a class="jb-auth__link" href="{{ route('legal.terms') }}" target="_blank" rel="noopener">Terms</a>,
          <a class="jb-auth__link" href="{{ route('legal.host-terms') }}" target="_blank" rel="noopener">Host Terms</a>
          and <a class="jb-auth__link" href="{{ route('legal.privacy') }}" target="_blank" rel="noopener">Privacy Policy</a>.
        </p>

        <button class="jb-auth__btn" type="submit">Create host account</button>
      </form>

      <p class="jb-auth__alt">
        Already have an account?
        <a class="jb-auth__link" href="{{ route('login') }}">Sign in</a>
      </p>
    </div>
  </div>

  <script>
    document.querySelectorAll('[data-jb-toggle]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.getAttribute('data-jb-toggle'));
        if (!input) return;
        var showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
      });
    });
  </script>
@endsection
