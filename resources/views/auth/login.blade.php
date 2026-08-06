@extends('layouts.base', ['logo5' => true])

@section('title', 'Sign In - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')

  <div class="jb-auth">
    <div class="jb-auth__card">
      <h1 class="jb-auth__title">Sign in</h1>
      <p class="jb-auth__sub">Access your JaipurBnB host dashboard.</p>

      @if (session('error'))
        <div class="jb-auth__alert" role="alert">{{ session('error') }}</div>
      @endif

      @if (session('status'))
        <div class="jb-auth__alert jb-auth__alert--ok" role="status">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
        <div class="jb-auth__alert" role="alert">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="email">Email address</label>
          <input class="jb-auth__input @error('email') is-invalid @enderror"
                 type="email" id="email" name="email"
                 value="{{ old('email') }}" required autofocus
                 autocomplete="email"
                 @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
          @error('email')
            <span class="jb-auth__error" id="email-error" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <div class="jb-auth__field">
          <label class="jb-auth__label" for="password">Password</label>
          <div class="jb-auth__pw">
            <input class="jb-auth__input @error('password') is-invalid @enderror"
                   type="password" id="password" name="password" required
                   autocomplete="current-password"
                   @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            <button class="jb-auth__toggle" type="button"
                    data-jb-toggle="password" aria-label="Show password">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false">
                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
            </button>
          </div>
          @error('password')
            <span class="jb-auth__error" id="password-error" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <div class="jb-auth__row">
          {{-- value="1" is required: a bare checkbox submits "on", which fails the 'boolean' rule --}}
          <label class="jb-auth__check" for="remember">
            <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
            Remember me
          </label>
          {{-- "Forgot password?" removed: no password-reset flow is built, so the
               link went nowhere. Restore it when the reset routes exist. --}}
        </div>

        <button class="jb-auth__btn" type="submit">Sign in</button>
      </form>

      <p class="jb-auth__alt">
        New to JaipurBnB?
        <a class="jb-auth__link" href="{{ route('register') }}">Create a host account</a>
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
