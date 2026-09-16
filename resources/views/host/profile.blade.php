@extends('layouts.base', ['logo5' => true])

@section('title', 'My Profile - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      @if (session('status'))
        <div class="jb-auth__alert jb-auth__alert--ok" role="status">{{ session('status') }}</div>
      @endif

      <p class="jb-dash__eyebrow">Host account</p>
      <h1 class="jb-dash__title">My profile</h1>
      <p class="jb-dash__sub">
        Guests reach you on the numbers below &mdash; they are what the Call and
        WhatsApp buttons on your listings use, so keep them current.
      </p>

      <div class="jb-dash__card" style="padding:28px;">
        <form method="POST" action="{{ route('host.profile.update') }}" novalidate>
          @csrf
          {{-- PATCH, not POST: the route is registered as PATCH because this
               updates an existing record rather than creating one. --}}
          @method('PATCH')

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="full_name">Full name <span class="jb-auth__req">*</span></label>
            <input class="jb-auth__input @error('full_name') is-invalid @enderror"
                   type="text" id="full_name" name="full_name"
                   value="{{ old('full_name', $user->name) }}" required
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
                   value="{{ old('email', $user->email) }}" required
                   autocomplete="email" maxlength="100"
                   @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
            <span class="jb-auth__hint">This is also your login. Changing it changes how you sign in.</span>
            @error('email')
              <span class="jb-auth__error" id="email-error" role="alert">{{ $message }}</span>
            @enderror
          </div>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="phone_number">Phone number <span class="jb-auth__req">*</span></label>
            <input class="jb-auth__input @error('phone_number') is-invalid @enderror"
                   type="tel" id="phone_number" name="phone_number"
                   value="{{ old('phone_number', $user->phone_number) }}" required
                   autocomplete="tel" inputmode="tel" maxlength="20"
                   @error('phone_number') aria-invalid="true" aria-describedby="phone_number-error" @enderror>
            <span class="jb-auth__hint">Used by the &ldquo;Call&rdquo; button on every listing you own.</span>
            @error('phone_number')
              <span class="jb-auth__error" id="phone_number-error" role="alert">{{ $message }}</span>
            @enderror
          </div>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="whatsapp_number">WhatsApp number <span style="font-weight:500;color:#6C7A80;">(optional)</span></label>
            <input class="jb-auth__input @error('whatsapp_number') is-invalid @enderror"
                   type="tel" id="whatsapp_number" name="whatsapp_number"
                   value="{{ old('whatsapp_number', $user->whatsapp_number) }}"
                   autocomplete="tel" inputmode="tel" maxlength="20"
                   placeholder="Only if different from your phone number"
                   @error('whatsapp_number') aria-invalid="true" aria-describedby="whatsapp_number-error" @enderror>
            <span class="jb-auth__hint">Leave blank and WhatsApp messages go to your phone number above.</span>
            @error('whatsapp_number')
              <span class="jb-auth__error" id="whatsapp_number-error" role="alert">{{ $message }}</span>
            @enderror
          </div>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="host_address">Address <span style="font-weight:500;color:#6C7A80;">(optional)</span></label>
            <textarea class="jb-auth__input @error('host_address') is-invalid @enderror"
                      id="host_address" name="host_address" maxlength="2000"
                      style="min-height:90px;resize:vertical;"
                      placeholder="House / street, area">{{ old('host_address', $user->host_address) }}</textarea>
            <span class="jb-auth__hint">Your own address for our records. It is never shown to guests.</span>
            @error('host_address')
              <span class="jb-auth__error" role="alert">{{ $message }}</span>
            @enderror
          </div>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="host_city">City</label>
            <input class="jb-auth__input @error('host_city') is-invalid @enderror"
                   type="text" id="host_city" name="host_city"
                   value="{{ old('host_city', $user->host_city) }}" maxlength="100">
            @error('host_city')
              <span class="jb-auth__error" role="alert">{{ $message }}</span>
            @enderror
          </div>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="host_state">State</label>
            <input class="jb-auth__input @error('host_state') is-invalid @enderror"
                   type="text" id="host_state" name="host_state"
                   value="{{ old('host_state', $user->host_state) }}" maxlength="100">
            @error('host_state')
              <span class="jb-auth__error" role="alert">{{ $message }}</span>
            @enderror
          </div>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="host_pincode">Pincode</label>
            <input class="jb-auth__input @error('host_pincode') is-invalid @enderror"
                   type="text" id="host_pincode" name="host_pincode"
                   value="{{ old('host_pincode', $user->host_pincode) }}" maxlength="10"
                   inputmode="numeric">
            @error('host_pincode')
              <span class="jb-auth__error" role="alert">{{ $message }}</span>
            @enderror
          </div>

          <button type="submit" class="jb-auth__btn">Save changes</button>
        </form>
      </div>

      <div class="space24"></div>
      <a href="{{ route('host.dashboard') }}" class="jb-dash__ghost">&larr; Back to dashboard</a>

    </div>
  </div>

  @include('layouts.partials.footer')
@endsection
