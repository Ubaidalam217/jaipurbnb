@extends('layouts.base', ['logo5' => true])

@section('title', 'Forgot Password - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')

  <div class="jb-auth">
    <div class="jb-auth__card">
      <h1 class="jb-auth__title">Forgot your password?</h1>
      <p class="jb-auth__sub">Enter the email you signed up with and we will send you a reset link.</p>

      @if (session('error'))
        <div class="jb-auth__alert" role="alert">{{ session('error') }}</div>
      @endif

      @if (session('status'))
        <div class="jb-auth__alert jb-auth__alert--ok" role="status">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
        <div class="jb-auth__alert" role="alert">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" novalidate>
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

        <button class="jb-auth__btn" type="submit">Email me a reset link</button>
      </form>

      <p class="jb-auth__alt">
        Remembered it? <a class="jb-auth__link" href="{{ route('login') }}">Back to sign in</a>
      </p>
    </div>
  </div>

  @include('layouts.partials.footer')
@endsection
