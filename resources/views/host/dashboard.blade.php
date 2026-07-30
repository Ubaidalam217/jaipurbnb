@extends('layouts.base', ['logo5' => true])

@section('title', 'Host Dashboard - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      @if (session('status'))
        <div class="jb-auth__alert jb-auth__alert--ok" role="status">{{ session('status') }}</div>
      @endif

      <p class="jb-dash__eyebrow">Host dashboard</p>
      <h1 class="jb-dash__title">Welcome, {{ auth()->user()->name }}!</h1>
      <p class="jb-dash__sub">Manage your Jaipur listings and track guest enquiries.</p>

      <div class="jb-dash__grid">
        <div class="jb-dash__card">
          <span class="jb-dash__stat">0</span>
          <span class="jb-dash__label">My Properties</span>
        </div>
        <div class="jb-dash__card">
          <span class="jb-dash__stat">0</span>
          <span class="jb-dash__label">Active Listings</span>
        </div>
        <div class="jb-dash__card">
          <span class="jb-dash__stat">0</span>
          <span class="jb-dash__label">Total Leads</span>
        </div>
      </div>

      <div class="jb-dash__actions">
        {{-- TODO: point at the property-create route once it exists --}}
        <a class="jb-dash__cta" href="#">Add New Property</a>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="jb-dash__ghost" type="submit">Sign out</button>
        </form>
      </div>

    </div>
  </div>
@endsection
