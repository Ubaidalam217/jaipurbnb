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

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="max_adults">Adults <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('max_adults') is-invalid @enderror" type="number"
                     id="max_adults" name="max_adults" value="{{ old('max_adults', 2) }}"
                     min="1" max="16" step="1" inputmode="numeric" required>
              <span class="jb-auth__hint">Adults + children set the guest count guests filter by on the browse page.</span>
              @error('max_adults')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="max_children">Children</label>
              <input class="jb-auth__input @error('max_children') is-invalid @enderror" type="number"
                     id="max_children" name="max_children" value="{{ old('max_children', 0) }}"
                     min="0" max="10" step="1" inputmode="numeric" required>
              @error('max_children')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="max_infants">Infants</label>
              <input class="jb-auth__input @error('max_infants') is-invalid @enderror" type="number"
                     id="max_infants" name="max_infants" value="{{ old('max_infants', 0) }}"
                     min="0" max="10" step="1" inputmode="numeric" required>
              <span class="jb-auth__hint">Infants don't count toward the guest total.</span>
              @error('max_infants')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="bedrooms">Bedrooms <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('bedrooms') is-invalid @enderror" type="number"
                     id="bedrooms" name="bedrooms" value="{{ old('bedrooms', 1) }}"
                     min="1" max="10" step="1" inputmode="numeric" required>
              @error('bedrooms')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="bathrooms">Bathrooms <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('bathrooms') is-invalid @enderror" type="number"
                     id="bathrooms" name="bathrooms" value="{{ old('bathrooms', 1) }}"
                     min="1" max="10" step="1" inputmode="numeric" required>
              @error('bathrooms')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="jb-auth__field" style="margin:18px 0 0;">
            <label class="jb-auth__label" style="display:flex;align-items:center;gap:10px;cursor:pointer;">
              <input type="checkbox" name="is_pet_friendly" value="1" style="width:18px;height:18px;"
                     @checked(old('is_pet_friendly'))>
              This property is pet-friendly
            </label>
          </div>
        </section>

        {{-- 3. Address & location --}}
        <section class="jb-form__section">
          <h2 class="jb-form__legend">3. Address &amp; location</h2>
          <p class="jb-form__hint">Guests see the full address only after you approve their enquiry - this powers the map on your listing.</p>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="full_address">Full address <span class="jb-auth__req">*</span></label>
            <textarea class="jb-auth__input @error('full_address') is-invalid @enderror"
                      id="full_address" name="full_address" maxlength="2000" required
                      placeholder="House / street, landmark, area">{{ old('full_address') }}</textarea>
            @error('full_address')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          </div>

          <div class="jb-form__grid">
            <div class="jb-auth__field">
              <label class="jb-auth__label" for="city">City <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('city') is-invalid @enderror" type="text"
                     id="city" name="city" value="{{ old('city', 'Jaipur') }}" maxlength="100" required>
              @error('city')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="state">State <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('state') is-invalid @enderror" type="text"
                     id="state" name="state" value="{{ old('state', 'Rajasthan') }}" maxlength="100" required>
              @error('state')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="pincode">Pincode <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('pincode') is-invalid @enderror" type="text"
                     id="pincode" name="pincode" value="{{ old('pincode') }}" maxlength="10" required
                     placeholder="302001">
              @error('pincode')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="latitude">Latitude <span style="font-weight:500;color:var(--jb-muted);">(optional)</span></label>
              <input class="jb-auth__input @error('latitude') is-invalid @enderror" type="text"
                     id="latitude" name="latitude" value="{{ old('latitude') }}"
                     inputmode="decimal" placeholder="26.9124">
              @error('latitude')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="longitude">Longitude <span style="font-weight:500;color:var(--jb-muted);">(optional)</span></label>
              <input class="jb-auth__input @error('longitude') is-invalid @enderror" type="text"
                     id="longitude" name="longitude" value="{{ old('longitude') }}"
                     inputmode="decimal" placeholder="75.7873">
              <span class="jb-auth__hint">Right-click the spot on Google Maps and copy the two numbers it shows.</span>
              @error('longitude')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>
          </div>
        </section>

        {{-- 4. Amenities --}}
        <section class="jb-form__section">
          <h2 class="jb-form__legend">4. Amenities</h2>
          <p class="jb-form__hint">Tick everything guests will find at this property.</p>

          @foreach ($amenitiesByCategory as $category => $categoryAmenities)
            <h3 style="margin:0 0 10px;font-size:14px;font-weight:600;text-transform:capitalize;">{{ $category }}</h3>
            <div class="jb-form__grid" style="margin-bottom:20px;">
              @foreach ($categoryAmenities as $amenity)
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14.5px;">
                  <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" style="width:17px;height:17px;"
                         @checked(collect(old('amenities', []))->contains($amenity->id))>
                  @if ($amenity->icon)<i class="{{ $amenity->icon }}" aria-hidden="true"></i>@endif
                  {{ $amenity->name }}
                </label>
              @endforeach
            </div>
          @endforeach
        </section>

        {{-- 5. Photos --}}
        <section class="jb-form__section">
          <h2 class="jb-form__legend">5. Photos</h2>
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

        {{-- 6. External calendar --}}
        <section class="jb-form__section">
          <h2 class="jb-form__legend">6. External calendar <span style="font-weight:500;color:var(--jb-muted);">(optional)</span></h2>
          <p class="jb-form__hint">Paste the .ics export URL from whichever calendar you already use. Dates booked there will automatically be blocked on JaipurBnB.</p>

          <div class="jb-auth__field" style="margin-bottom:0;">
            <label class="jb-auth__label" for="ical_feed_url">External Calendar / iCal URL (optional)</label>
            <input class="jb-auth__input @error('ical_feed_url') is-invalid @enderror" type="url"
                   id="ical_feed_url" name="ical_feed_url" value="{{ old('ical_feed_url') }}"
                   maxlength="255" placeholder="https://example.com/calendar/ical/....ics">
            <span class="jb-auth__hint">
              Any standard .ics feed works &mdash; on Airbnb it is under Calendar &rarr; Availability
              &rarr; Connect to another website &rarr; Export calendar. We check it every 30 minutes.
              Sync is one-way &mdash; we never change anything on the other calendar.
            </span>
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
