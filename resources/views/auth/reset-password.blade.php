@extends('layouts.base', ['logo5' => true])

@section('title', 'Reset Password - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')

  <div class="jb-auth">
    <div class="jb-auth__card">
      <h1 class="jb-auth__title">Choose a new password</h1>
      <p class="jb-auth__sub">At least 8 characters. You will use this to sign in from now on.</p>

      @if ($errors->any())
        <div class="jb-auth__alert" role="alert">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('password.update') }}" novalidate>
        @csrf

        {{-- The token comes from the emailed link, not from the guest. --}}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="email">Email address</label>
          <input class="jb-auth__input @error('email') is-invalid @enderror"
                 type="email" id="email" name="email"
                 value="{{ old('email', $email) }}" required
                 autocomplete="email"
                 @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
          @error('email')
            <span class="jb-auth__error" id="email-error" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="password">New password</label>
          <div class="jb-auth__pw">
            <input class="jb-auth__input @error('password') is-invalid @enderror"
                   type="password" id="password" name="password" required autofocus
                   autocomplete="new-password"
                   @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            <button class="jb-auth__toggle" type="button"
                    data-jb-toggle="password" aria-label="Show password">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" aria-hidden="true" focusable="false">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
            </button>
          </div>
          @error('password')
            <span class="jb-auth__error" id="password-error" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="password_confirmation">Confirm new password</label>
          <input class="jb-auth__input" type="password"
                 id="password_confirmation" name="password_confirmation" required
                 autocomplete="new-password">
        </div>

        <button class="jb-auth__btn" type="submit">Reset password</button>
      </form>

      <p class="jb-auth__alt">
        <a class="jb-auth__link" href="{{ route('login') }}">Back to sign in</a>
      </p>
    </div>
  </div>

  @include('layouts.partials.footer')
@endsection
