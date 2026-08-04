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
          </div>
        </section>

        <section class="jb-form__section">
          <h2 class="jb-form__legend">3. Photos</h2>
          <p class="jb-form__hint">Untick a photo to delete it. Add new ones below. Up to 15 in total, and one must be the cover.</p>

          @error('photos')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          @error('photos.*')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror
          @error('cover_index')<span class="jb-auth__error" role="alert">{{ $message }}</span>@enderror

          @if ($property->images->isNotEmpty())
            <h3 style="margin:18px 0 0;font-size:14px;font-weight:600;">Current photos</h3>
            <div class="jb-photos">
              @foreach ($property->images as $image)
                <div class="jb-photo {{ $image->is_cover ? 'is-cover' : '' }}">
                  <img class="jb-photo__img" src="{{ Storage::url($image->image_url) }}" alt="">
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
          <h2 class="jb-form__legend">4. External calendar <span style="font-weight:500;color:var(--jb-muted);">(optional)</span></h2>
          <p class="jb-form__hint">Paste your Airbnb .ics link and we will block those dates automatically once calendar sync goes live.</p>

          <div class="jb-auth__field" style="margin-bottom:0;">
            <label class="jb-auth__label" for="ical_feed_url">Airbnb iCal URL</label>
            <input class="jb-auth__input @error('ical_feed_url') is-invalid @enderror" type="url"
                   id="ical_feed_url" name="ical_feed_url"
                   value="{{ old('ical_feed_url', $property->ical_feed_url) }}" maxlength="255">
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
