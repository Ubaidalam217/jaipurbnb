@extends('layouts.base', ['logo5' => true])

@section('title', 'Review: '.$property->title.' - JaipurBnB Admin')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')
  @include('layouts.partials.jb-prop-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      <div class="jb-prop__bar">
        <div>
          <p class="jb-dash__eyebrow">Reviewing submission</p>
          <h1 class="jb-dash__title">{{ $property->title }}</h1>
          <p class="jb-dash__sub" style="margin:0;">
            {{ $property->neighborhood }} &middot; {{ $property->stay_type }} &middot;
            Approx Rs {{ number_format($property->approx_price) }} / night
          </p>
        </div>
        <a class="jb-btn-sm" href="{{ route('admin.properties.index') }}">Back to queue</a>
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
            <h2>Decision</h2>
            <div class="jb-row__badges" style="margin:0 0 18px;">
              @include('layouts.partials.jb-status-badge', ['property' => $property])
            </div>

            @if ($property->rejection_reason)
              <div class="jb-auth__alert" role="alert" style="margin-bottom:18px;">
                <strong>Previous reason:</strong> {{ $property->rejection_reason }}
              </div>
            @endif

            <div class="jb-form__actions">
              @if ($property->listing_status !== \App\Models\Property::STATUS_APPROVED)
                <form method="POST" action="{{ route('admin.properties.approve', $property) }}">
                  @csrf
                  <button class="jb-dash__cta" type="submit">Approve listing</button>
                </form>
              @endif

              @if ($property->listing_status !== \App\Models\Property::STATUS_REJECTED)
                <button class="jb-dash__ghost" type="button"
                        data-jb-reject="{{ route('admin.properties.reject', $property) }}"
                        data-jb-title="{{ $property->title }}"
                        style="color:#B3261E;border-color:rgba(179,38,30,.35);">Reject</button>
              @endif
            </div>

            <p class="jb-auth__hint" style="margin-top:16px;">
              Approving marks the listing verified. It still needs an active
              subscription before it appears publicly.
            </p>
          </div>

          <div class="jb-panel">
            <h2>Host</h2>
            <dl class="jb-defs" style="grid-template-columns:1fr;">
              <div>
                <dt>Name</dt>
                <dd>{{ $property->host->name }}</dd>
              </div>
              <div>
                <dt>Email</dt>
                <dd style="word-break:break-all;text-transform:none;">{{ $property->host->email }}</dd>
              </div>
              <div>
                <dt>Phone</dt>
                <dd>{{ $property->host->phone_number ?? '-' }}</dd>
              </div>
              <div>
                <dt>Submitted</dt>
                <dd>{{ $property->created_at->format('d M Y, H:i') }}</dd>
              </div>
              <div>
                <dt>Calendar feed</dt>
                <dd style="word-break:break-all;">{{ $property->ical_feed_url ?: 'Not connected' }}</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>

    </div>
  </div>

  @include('layouts.partials.jb-reject-modal')
@endsection
