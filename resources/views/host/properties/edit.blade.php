@extends('layouts.base', ['logo5' => true])

@section('title', 'Edit '.$property->title.' - JaipurBnB')

{{-- Flags the shared photo picker into "edit" mode (unified cover radio group). --}}
@section('body_attribute')
  data-jb-edit
@endsection

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')
  @include('layouts.partials.jb-prop-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      <p class="jb-dash__eyebrow">Host dashboard</p>
      <h1 class="jb-dash__title">Edit listing</h1>
      <p class="jb-dash__sub">{{ $property->title }}</p>

      @if ($errors->any())
        <div class="jb-auth__alert" role="alert">
          Please correct {{ $errors->count() }} {{ Str::plural('problem', $errors->count()) }} below.
        </div>
      @endif

      @if ($property->listing_status === \App\Models\Property::STATUS_REJECTED)
        <div class="jb-auth__alert" role="alert">
          <strong>This listing was rejected.</strong>
          @if ($property->rejection_reason) {{ $property->rejection_reason }} @endif
          Saving your changes will send it back for review.
        </div>
      @endif

      <form class="jb-form" method="POST" action="{{ route('host.properties.update', $property) }}"
            enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        {{-- Filled by the photo picker on submit --}}
        <input type="hidden" name="cover_image_id" value="{{ optional($property->images->firstWhere('is_cover', true))->id }}">
        <input type="hidden" name="cover_index" value="">

        <section class="jb-form__section">
          <h2 class="jb-form__legend">1. Basic information</h2>
          <p class="jb-form__hint">What is this place called, and what makes it special?</p>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="title">Listing title <span class="jb-auth__req">*</span></label>
            <input class="jb-auth__input @error('title') is-invalid @enderror" type="text"
                   id="title" name="title" value="{{ old('title', $property->title) }}" maxlength="150" required>
            @error('title')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          </div>

          <div class="jb-auth__field" style="margin-bottom:0;">
            <label class="jb-auth__label" for="description">Description <span class="jb-auth__req">*</span></label>
            <textarea class="jb-auth__input @error('description') is-invalid @enderror"
                      id="description" name="description" maxlength="5000" required>{{ old('description', $property->description) }}</textarea>
            @error('description')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          </div>
        </section>

        <section class="jb-form__section">
          <h2 class="jb-form__legend">2. Location &amp; type</h2>
          <p class="jb-form__hint">Guests filter by these, so pick the closest match.</p>

          <div class="jb-form__grid">
            <div class="jb-auth__field">
              <label class="jb-auth__label" for="neighborhood">Neighborhood <span class="jb-auth__req">*</span></label>
              <select class="jb-auth__input jb-native-select @error('neighborhood') is-invalid @enderror"
                      id="neighborhood" name="neighborhood" required>
                @foreach (\App\Models\Property::NEIGHBORHOODS as $hood)
                  <option value="{{ $hood }}" @selected(old('neighborhood', $property->neighborhood) === $hood)>{{ $hood }}</option>
                @endforeach
              </select>
              @error('neighborhood')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="stay_type">Stay type <span class="jb-auth__req">*</span></label>
              <select class="jb-auth__input jb-native-select @error('stay_type') is-invalid @enderror"
                      id="stay_type" name="stay_type" required>
                @foreach (\App\Models\Property::STAY_TYPES as $type)
                  <option value="{{ $type }}" @selected(old('stay_type', $property->stay_type) === $type)>{{ $type }}</option>
                @endforeach
              </select>
              @error('stay_type')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="approx_price">Approx price per night (Rs) <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('approx_price') is-invalid @enderror" type="number"
                     id="approx_price" name="approx_price" value="{{ old('approx_price', $property->approx_price) }}"
                     min="100" max="1000000" step="1" inputmode="numeric" required>
              @error('approx_price')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="max_adults">Adults <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('max_adults') is-invalid @enderror" type="number"
                     id="max_adults" name="max_adults" value="{{ old('max_adults', $property->max_adults) }}"
                     min="1" max="16" step="1" inputmode="numeric" required>
              <span class="jb-auth__hint">Adults + children set the guest count guests filter by on the browse page.</span>
              @error('max_adults')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="max_children">Children</label>
              <input class="jb-auth__input @error('max_children') is-invalid @enderror" type="number"
                     id="max_children" name="max_children" value="{{ old('max_children', $property->max_children) }}"
                     min="0" max="10" step="1" inputmode="numeric" required>
              @error('max_children')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="max_infants">Infants</label>
              <input class="jb-auth__input @error('max_infants') is-invalid @enderror" type="number"
                     id="max_infants" name="max_infants" value="{{ old('max_infants', $property->max_infants) }}"
                     min="0" max="10" step="1" inputmode="numeric" required>
              <span class="jb-auth__hint">Infants don't count toward the guest total.</span>
              @error('max_infants')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="bedrooms">Bedrooms <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('bedrooms') is-invalid @enderror" type="number"
                     id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}"
                     min="1" max="10" step="1" inputmode="numeric" required>
              @error('bedrooms')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="bathrooms">Bathrooms <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('bathrooms') is-invalid @enderror" type="number"
                     id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}"
                     min="1" max="10" step="1" inputmode="numeric" required>
              @error('bathrooms')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="jb-auth__field" style="margin:18px 0 0;">
            <label class="jb-auth__label" style="display:flex;align-items:center;gap:10px;cursor:pointer;">
              <input type="checkbox" name="is_pet_friendly" value="1" style="width:18px;height:18px;"
                     @checked(old('is_pet_friendly', $property->is_pet_friendly))>
              This property is pet-friendly
            </label>
          </div>
        </section>

        <section class="jb-form__section">
          <h2 class="jb-form__legend">3. Address &amp; location</h2>
          <p class="jb-form__hint">Guests see the full address only after you approve their enquiry - this powers the map on your listing.</p>

          <div class="jb-auth__field">
            <label class="jb-auth__label" for="full_address">Full address <span class="jb-auth__req">*</span></label>
            <textarea class="jb-auth__input @error('full_address') is-invalid @enderror"
                      id="full_address" name="full_address" maxlength="2000" required
                      placeholder="House / street, landmark, area">{{ old('full_address', $property->full_address) }}</textarea>
            @error('full_address')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          </div>

          <div class="jb-form__grid">
            <div class="jb-auth__field">
              <label class="jb-auth__label" for="city">City <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('city') is-invalid @enderror" type="text"
                     id="city" name="city" value="{{ old('city', $property->city) }}" maxlength="100" required>
              @error('city')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="state">State <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('state') is-invalid @enderror" type="text"
                     id="state" name="state" value="{{ old('state', $property->state) }}" maxlength="100" required>
              @error('state')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="pincode">Pincode <span class="jb-auth__req">*</span></label>
              <input class="jb-auth__input @error('pincode') is-invalid @enderror" type="text"
                     id="pincode" name="pincode" value="{{ old('pincode', $property->pincode) }}" maxlength="10" required
                     placeholder="302001">
              @error('pincode')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="latitude">Latitude <span style="font-weight:500;color:var(--jb-muted);">(optional)</span></label>
              <input class="jb-auth__input @error('latitude') is-invalid @enderror" type="text"
                     id="latitude" name="latitude" value="{{ old('latitude', $property->latitude) }}"
                     inputmode="decimal" placeholder="26.9124">
              @error('latitude')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>

            <div class="jb-auth__field">
              <label class="jb-auth__label" for="longitude">Longitude <span style="font-weight:500;color:var(--jb-muted);">(optional)</span></label>
              <input class="jb-auth__input @error('longitude') is-invalid @enderror" type="text"
                     id="longitude" name="longitude" value="{{ old('longitude', $property->longitude) }}"
                     inputmode="decimal" placeholder="75.7873">
              <span class="jb-auth__hint">Right-click the spot on Google Maps and copy the two numbers it shows.</span>
              @error('longitude')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
            </div>
          </div>
        </section>

        <section class="jb-form__section">
          <h2 class="jb-form__legend">4. Amenities</h2>
          <p class="jb-form__hint">Tick everything guests will find at this property.</p>

          @php $jbSelectedAmenities = old('amenities', $property->amenities->pluck('id')->all()); @endphp
          @foreach ($amenitiesByCategory as $category => $categoryAmenities)
            <h3 style="margin:0 0 10px;font-size:14px;font-weight:600;text-transform:capitalize;">{{ $category }}</h3>
            <div class="jb-form__grid" style="margin-bottom:20px;">
              @foreach ($categoryAmenities as $amenity)
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14.5px;">
                  <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" style="width:17px;height:17px;"
                         @checked(collect($jbSelectedAmenities)->contains($amenity->id))>
                  @if ($amenity->icon)<i class="{{ $amenity->icon }}" aria-hidden="true"></i>@endif
                  {{ $amenity->name }}
                </label>
              @endforeach
            </div>
          @endforeach
        </section>

        <section class="jb-form__section">
          <h2 class="jb-form__legend">5. Photos</h2>
          <p class="jb-form__hint">Untick a photo to delete it. Add new ones below. Up to 15 in total, and one must be the cover.</p>

          @error('photos')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          @error('photos.*')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          @error('cover_index')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror

          @if ($property->images->isNotEmpty())
            <h3 style="margin:18px 0 0;font-size:14px;font-weight:600;">Current photos</h3>
            <div class="jb-photos">
              @foreach ($property->images as $image)
                <div class="jb-photo {{ $image->is_cover ? 'is-cover' : '' }}">
                  <img class="jb-photo__img" src="{{ $image->display_url }}" alt="">
                  @if ($image->is_cover)<span class="jb-photo__flag">Cover</span>@endif
                  <div class="jb-photo__foot">
                    <label class="jb-photo__pick">
                      <input type="checkbox" name="existing_image_ids[]" value="{{ $image->id }}" checked>
                      Keep
                    </label>
                    <label class="jb-photo__pick">
                      <input type="radio" name="cover_choice" value="existing:{{ $image->id }}" @checked($image->is_cover)>
                      Cover
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
          @endif

          <h3 style="margin:24px 0 10px;font-size:14px;font-weight:600;">Add more photos</h3>
          <label class="jb-btn-sm jb-photo__drop" for="photos">Choose photos&hellip;</label>
          <input id="photos" name="photos[]" type="file" multiple
                 accept="image/jpeg,image/png,image/webp"
                 style="position:absolute;width:1px;height:1px;opacity:0;">

          <div class="jb-photos" id="jb-previews"></div>
          <p class="jb-auth__hint" id="jb-photo-count"></p>
        </section>

        <section class="jb-form__section">
          <h2 class="jb-form__legend">6. External calendar <span style="font-weight:500;color:var(--jb-muted);">(optional)</span></h2>
          <p class="jb-form__hint">Paste the .ics export URL from whichever calendar you already use. Dates booked there will automatically be blocked on JaipurBnB.</p>

          <div class="jb-auth__field" style="margin-bottom:0;">
            <label class="jb-auth__label" for="ical_feed_url">External Calendar / iCal URL (optional)</label>
            <input class="jb-auth__input @error('ical_feed_url') is-invalid @enderror" type="url"
                   id="ical_feed_url" name="ical_feed_url"
                   value="{{ old('ical_feed_url', $property->ical_feed_url) }}" maxlength="255"
                   placeholder="https://example.com/calendar/ical/....ics">
            <span class="jb-auth__hint">
              Any standard .ics feed works &mdash; on Airbnb it is under Calendar &rarr; Availability
              &rarr; Connect to another website &rarr; Export calendar. We check it every 30 minutes.
              Sync is one-way &mdash; we never change anything on the other calendar. Clearing this
              field stops the sync; dates it already blocked are released on the next run.
            </span>
            @error('ical_feed_url')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          </div>
        </section>

        <div class="jb-form__actions">
          <button class="jb-dash__cta" type="submit">Save changes</button>
          <a class="jb-dash__ghost" href="{{ route('host.properties.index') }}">Cancel</a>
        </div>
      </form>

    </div>
  </div>

  @include('layouts.partials.jb-photo-picker')
@endsection
