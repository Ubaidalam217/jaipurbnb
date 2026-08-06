@extends('layouts.base', ['logo5' => true])

@section('title', 'My Properties - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')
  @include('layouts.partials.jb-prop-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      @if (session('status'))
        <div class="jb-auth__alert jb-auth__alert--ok" role="status">{{ session('status') }}</div>
      @endif

      @if (session('error'))
        <div class="jb-auth__alert" role="alert">{{ session('error') }}</div>
      @endif

      <style>
        /* Subscription call-to-action on each listing row. */
        .jb-sub-cta {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          min-height: 38px;
          padding: 0 16px;
          border-radius: 8px;
          background: #B34D33;
          color: #fff;
          font-family: 'Poppins', sans-serif;
          font-size: 14px;
          font-weight: 600;
          text-decoration: none;
          white-space: nowrap;
          transition: background-color .2s ease;
        }
        .jb-sub-cta:hover { background: #8F3D28; color: #fff; text-decoration: none; }
        .jb-sub-cta--renew { background: #2F3E46; }
        .jb-sub-cta--renew:hover { background: #1F2A30; }
        .jb-live-badge {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          padding: 5px 12px;
          border-radius: 999px;
          background: rgba(28, 138, 74, .12);
          color: #1C8A4A;
          font-family: 'Poppins', sans-serif;
          font-size: 13px;
          font-weight: 600;
          white-space: nowrap;
        }
        .jb-live-badge::before {
          content: "";
          width: 8px;
          height: 8px;
          border-radius: 50%;
          background: #1C8A4A;
        }
      </style>

      <div class="jb-prop__bar">
        <div>
          <p class="jb-dash__eyebrow">Host dashboard</p>
          <h1 class="jb-dash__title">My Properties</h1>
          <p class="jb-dash__sub" style="margin:0;">{{ $properties->count() }} {{ Str::plural('listing', $properties->count()) }}</p>
        </div>
        <a class="jb-dash__cta" href="{{ route('host.properties.create') }}">Add New Property</a>
      </div>

      @if ($properties->isEmpty())
        <div class="jb-empty">
          <h3>No listings yet</h3>
          <p>Add your first Jaipur property and our team will review it within 48 hours.</p>
          <a class="jb-dash__cta" href="{{ route('host.properties.create') }}">Add New Property</a>
        </div>
      @else
        <div class="jb-list">
          @foreach ($properties as $property)
            <div class="jb-row">
              <div class="jb-row__thumb">
                @if ($property->coverImage)
                  <img src="{{ $property->coverImage->display_url }}" alt="{{ $property->title }}">
                @endif
              </div>

              <div class="jb-row__main">
                <h2 class="jb-row__title">{{ $property->title }}</h2>
                <p class="jb-row__meta">
                  {{ $property->neighborhood }} &middot; {{ $property->stay_type }} &middot;
                  Approx Rs {{ number_format($property->approx_price) }} / night
                </p>
                <p class="jb-row__meta">
                  @if ($property->subscription_expiry)
                    Subscription until {{ $property->subscription_expiry->format('d M Y') }}
                  @else
                    No active subscription
                  @endif
                </p>
                <div class="jb-row__badges">
                  @include('layouts.partials.jb-status-badge', ['property' => $property])
                  @if ($property->is_visible)
                    <span class="jb-live-badge">Live</span>
                  @endif
                </div>

                @if ($property->listing_status === \App\Models\Property::STATUS_REJECTED && $property->rejection_reason)
                  <div class="jb-auth__alert" role="alert" style="margin:12px 0 0;">
                    <strong>Reason:</strong> {{ $property->rejection_reason }}
                  </div>
                @endif
              </div>

              <div class="jb-row__actions">
                {{-- Only an approved listing is billable: pending and rejected
                     ones have nothing to publish yet. An expired subscription
                     and a never-paid one land on the same plans page, but the
                     wording differs so the host knows which they are in. --}}
                @if ($property->awaitingSubscription())
                  @if ($property->subscriptionHasExpired())
                    <a class="jb-sub-cta jb-sub-cta--renew" href="{{ route('host.properties.plans', $property) }}">
                      Subscription Expired &mdash; Renew
                    </a>
                  @else
                    <a class="jb-sub-cta" href="{{ route('host.properties.plans', $property) }}">
                      Subscribe to Publish
                    </a>
                  @endif
                @endif

                <a class="jb-btn-sm" href="{{ route('host.properties.show', $property) }}">View</a>
                <a class="jb-btn-sm" href="{{ route('host.properties.edit', $property) }}">Edit</a>
                <a class="jb-btn-sm" href="{{ route('host.properties.availability', $property) }}">Manage Calendar</a>
                <form method="POST" action="{{ route('host.properties.destroy', $property) }}"
                      onsubmit="return confirm('Delete “{{ $property->title }}” and all its photos? This cannot be undone.');">
                  @csrf
                  @method('DELETE')
                  <button class="jb-btn-sm jb-btn-sm--danger" type="submit">Delete</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @endif

    </div>
  </div>
@endsection
