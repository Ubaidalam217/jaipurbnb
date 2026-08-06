@extends('layouts.base', ['logo5' => true])

@section('title', 'Moderation Queue - JaipurBnB Admin')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')
  @include('layouts.partials.jb-prop-styles')

  @php
    $tabs = [
      \App\Models\Property::STATUS_PENDING  => 'Pending',
      \App\Models\Property::STATUS_APPROVED => 'Approved',
      \App\Models\Property::STATUS_REJECTED => 'Rejected',
      'all'                                 => 'All',
    ];
  @endphp

  <div class="jb-dash">
    <div class="jb-dash__inner">

      @if (session('status'))
        <div class="jb-auth__alert jb-auth__alert--ok" role="status">{{ session('status') }}</div>
      @endif

      <p class="jb-dash__eyebrow">Administration</p>
      <h1 class="jb-dash__title">Moderation queue</h1>
      <p class="jb-dash__sub">Review host submissions and decide what goes live.</p>

      <div class="jb-tabs">
        @foreach ($tabs as $key => $label)
          <a class="jb-tab {{ $filter === $key ? 'is-active' : '' }}"
             href="{{ route('admin.properties.index', ['status' => $key]) }}"
             @if ($filter === $key) aria-current="page" @endif>
            {{ $label }} <span class="jb-tab__n">{{ $counts[$key] ?? 0 }}</span>
          </a>
        @endforeach
      </div>

      @if ($properties->isEmpty())
        <div class="jb-empty">
          <h3>Nothing here</h3>
          <p>There are no {{ $filter === 'all' ? '' : $filter }} listings right now.</p>
        </div>
      @else
        <div class="jb-list">
          @foreach ($properties as $property)
            <div class="jb-row">
              <div class="jb-row__thumb">
                @if ($property->coverImage)
                  <img src="{{ $property->coverImage->display_url }}" alt="">
                @endif
              </div>

              <div class="jb-row__main">
                <h2 class="jb-row__title">{{ $property->title }}</h2>
                <p class="jb-row__meta">
                  {{ $property->neighborhood }} &middot; {{ $property->stay_type }} &middot;
                  Approx Rs {{ number_format($property->approx_price) }} / night
                </p>
                <p class="jb-row__meta">
                  Host: <strong>{{ $property->host->name }}</strong> &middot;
                  {{ $property->host->email }} &middot; {{ $property->host->phone_number ?? 'no phone' }}
                </p>
                <p class="jb-row__meta">Submitted {{ $property->created_at->format('d M Y, H:i') }}</p>
                <div class="jb-row__badges">
                  @include('layouts.partials.jb-status-badge', ['property' => $property])
                </div>
              </div>

              <div class="jb-row__actions">
                <a class="jb-btn-sm jb-btn-sm--primary" href="{{ route('admin.properties.show', $property) }}">Review</a>

                @if ($property->listing_status !== \App\Models\Property::STATUS_APPROVED)
                  <form method="POST" action="{{ route('admin.properties.approve', $property) }}">
                    @csrf
                    <button class="jb-btn-sm" type="submit">Approve</button>
                  </form>
                @endif

                @if ($property->listing_status !== \App\Models\Property::STATUS_REJECTED)
                  <button class="jb-btn-sm jb-btn-sm--danger" type="button"
                          data-jb-reject="{{ route('admin.properties.reject', $property) }}"
                          data-jb-title="{{ $property->title }}">Reject</button>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif

    </div>
  </div>

  @include('layouts.partials.jb-reject-modal')
@endsection
