@extends('layouts.base', ['logo5' => true])

@section('title', 'Add a Property - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')
  @include('layouts.partials.jb-prop-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      <p class="jb-dash__eyebrow">Host dashboard</p>
      <h1 class="jb-dash__title">Add a new property</h1>
      <p class="jb-dash__sub">Tell guests about your Jaipur stay. You can edit any of this later.</p>

      @if ($errors->any())
        <div class="jb-auth__alert" role="alert">
          Please correct {{ $errors->count() }} {{ Str::plural('problem', $errors->count()) }} below.
        </div>
      @endif

      <form class="jb-form" method="POST" action="{{ route('host.properties.store') }}"
            enctype="multipart/form-data" novalidate>
        @csrf

        {{-- 1. Basic info --}}
        <section class="jb-form__section">
          <h2 class="jb-form__legend">1. Basic information</h2>
          <p class="jb-form__hint">What is this place called, and what makes it special?</p>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="title">Listing title <span class="jb-auth__req">*</span></label>
            <input class="jb-auth__input @error('title') is-invalid @enderror" type="text"
                   id="title" name="title" value="{{ old('title') }}" maxlength="150" required
                   placeholder="e.g. The Royal Walled City Haveli">
            @error('title')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          </div>

          <div class="jb-auth__field" style="margin-bottom:0;">
            <label class="jb-auth__label" for="description">Description <span class="jb-auth__req">*</span></label>
            <textarea class="jb-auth__input @error('description') is-invalid @enderror"
                      id="description" name="description" maxlength="5000" required
                      placeholder="Describe the rooms, the location, and what guests will love.">{{ old('description') }}</textarea>
            <span class="jb-auth__hint">Minimum 20 characters.</span>
            @error('description')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          </div>
        </section>

        {{-- 2. Location & type --}}
        <section class="jb-form__section">
          <h2 class="jb-form__legend">2. Location &amp; type</h2>
          <p class="jb-form__hint">Guests filter by these, so pick the closest match.</p>

          <div class="jb-form__grid">
            <div class="jb-auth__field">
              <label class="jb-auth__label" for="neighborhood">Neighborhood <span class="jb-auth__req">*</span></label>
              <select class="jb-auth__input jb-native-select @error('neighborhood') is-invalid @enderror"
                      id="neighborhood" name="neighborhood" required>
                <option value="">Choose a neighborhood</option>
                @foreach (\App\Models\Property::NEIGHBORHOODS as $hood)
                  <option value="{{ $hood }}" @selected(old('neighborhood') === $hood)>{{ $hood }}</option>
                @endforeach
              </select>
              @error('neighborhood')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="stay_type">Stay type <span class="jb-auth__req">*</span></label>
              <select class="jb-auth__input jb-native-select @error('stay_type') is-invalid @enderror"
                      id="stay_type" name="stay_type" required>
                <option value="">Choose a stay type</option>
                @foreach (\App\Models\Property::STAY_TYPES as $type)
                  <option value="{{ $type }}" @selected(old('stay_type') === $type)>{{ $type }}</option>
                @endforeach
              </select>
              @error('stay_type')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="approx_price">Approx price per night (Rs) <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('approx_price') is-invalid @enderror" type="number"
                     id="approx_price" name="approx_price" value="{{ old('approx_price') }}"
                     min="100" max="1000000" step="1" inputmode="numeric" required placeholder="2500">
              <span class="jb-auth__hint">Guests see this as a guide, not a fixed rate.</span>
              @error('approx_price')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>
          </div>
        </section>

        {{-- 3. Photos --}}
        <section class="jb-form__section">
          <h2 class="jb-form__legend">3. Photos</h2>
          <p class="jb-form__hint">Up to 15 photos, 5 MB each (JPG, PNG or WebP). Pick one as the cover guests see first.</p>

          <label class="jb-btn-sm jb-photo__drop" for="photos">Choose photos&hellip;</label>
          <input id="photos" name="photos[]" type="file" multiple
                 accept="image/jpeg,image/png,image/webp" class="visually-hidden"
                 style="position:absolute;width:1px;height:1px;opacity:0;">

          @error('photos')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          @error('photos.*')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          @error('cover_index')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror

          <div class="jb-photos" id="jb-previews"></div>
          <p class="jb-auth__hint" id="jb-photo-count">No photos selected yet.</p>
        </section>

        {{-- 4. External calendar --}}
        <section class="jb-form__section">
          <h2 class="jb-form__legend">4. External calendar <span style="font-weight:500;color:var(--jb-muted);">(optional)</span></h2>
          <p class="jb-form__hint">Paste your Airbnb .ics link and we will block those dates automatically once calendar sync goes live.</p>

          <div class="jb-auth__field" style="margin-bottom:0;">
            <label class="jb-auth__label" for="ical_feed_url">Airbnb iCal URL</label>
            <input class="jb-auth__input @error('ical_feed_url') is-invalid @enderror" type="url"
                   id="ical_feed_url" name="ical_feed_url" value="{{ old('ical_feed_url') }}"
                   maxlength="255" placeholder="https://www.airbnb.com/calendar/ical/...">
            @error('ical_feed_url')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          </div>
        </section>

        <div class="jb-form__note" style="margin-bottom:20px;">
          <span>Your listing will be reviewed by our team within 48 hours. It stays private until it is approved and a subscription is active.</span>
        </div>

        <div class="jb-form__actions">
          <button class="jb-dash__cta" type="submit">Submit for Review</button>
          <a class="jb-dash__ghost" href="{{ route('host.properties.index') }}">Cancel</a>
        </div>
      </form>

    </div>
  </div>

  @include('layouts.partials.jb-photo-picker')
@endsection
