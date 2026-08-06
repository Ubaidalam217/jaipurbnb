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
                </div>

                @if ($property->listing_status === \App\Models\Property::STATUS_REJECTED && $property->rejection_reason)
                  <div class="jb-auth__alert" role="alert" style="margin:12px 0 0;">
                    <strong>Reason:</strong> {{ $property->rejection_reason }}
                  </div>
                @endif
              </div>

              <div class="jb-row__actions">
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
