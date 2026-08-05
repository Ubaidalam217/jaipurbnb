@extends('layouts.base', ['logo5' => true])

@section('title', $property->title.' - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')
  @include('layouts.partials.jb-prop-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      <div class="jb-prop__bar">
        <div>
          <p class="jb-dash__eyebrow">Listing preview</p>
          <h1 class="jb-dash__title">{{ $property->title }}</h1>
          <p class="jb-dash__sub" style="margin:0;">
            {{ $property->neighborhood }} &middot; {{ $property->stay_type }} &middot;
            Approx Rs {{ number_format($property->approx_price) }} / night
          </p>
        </div>
        <div class="jb-row__actions">
          <a class="jb-btn-sm" href="{{ route('host.properties.index') }}">Back</a>
          <a class="jb-btn-sm" href="{{ route('host.properties.availability', $property) }}">Manage Availability</a>
          <a class="jb-btn-sm jb-btn-sm--primary" href="{{ route('host.properties.edit', $property) }}">Edit</a>
        </div>
      </div>

      <div class="jb-split">
        <div>
          <div class="jb-panel">
            <h2>Photos ({{ $property->images->count() }})</h2>
            @if ($property->images->isEmpty())
              <p style="margin:0;color:var(--jb-muted);">No photos uploaded.</p>
            @else
              <div class="jb-gallery">
                @foreach ($property->images as $image)
                  <div style="position:relative;">
                    <img src="{{ Storage::url($image->image_url) }}" alt="">
                    @if ($image->is_cover)<span class="jb-photo__flag">Cover</span>@endif
                  </div>
                @endforeach
              </div>
            @endif
          </div>

          <div class="jb-panel">
            <h2>Description</h2>
            <p style="margin:0;white-space:pre-line;line-height:1.65;">{{ $property->description }}</p>
          </div>
        </div>

        <div>
          <div class="jb-panel">
            <h2>Status</h2>
            <div class="jb-row__badges" style="margin:0 0 18px;">
              @include('layouts.partials.jb-status-badge', ['property' => $property])
            </div>

            @if ($property->listing_status === \App\Models\Property::STATUS_REJECTED && $property->rejection_reason)
              <div class="jb-auth__alert" role="alert" style="margin-bottom:18px;">
                <strong>Reason:</strong> {{ $property->rejection_reason }}
              </div>
            @endif

            <dl class="jb-defs" style="grid-template-columns:1fr;">
              <div>
                <dt>Verified</dt>
                <dd>{{ $property->is_verified ? 'Yes' : 'Not yet' }}</dd>
              </div>
              <div>
                <dt>Subscription</dt>
                <dd>{{ $property->subscription_expiry ? 'Until '.$property->subscription_expiry->format('d M Y') : 'None active' }}</dd>
              </div>
              <div>
                <dt>Submitted</dt>
                <dd>{{ $property->created_at->format('d M Y') }}</dd>
              </div>
              <div>
                <dt>Calendar sync</dt>
                <dd style="word-break:break-all;">{{ $property->ical_feed_url ?: 'Not connected' }}</dd>
              </div>
            </dl>
          </div>

          <div class="jb-form__note">
            <span>A listing goes live only once it is approved <em>and</em> has an active subscription.</span>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
