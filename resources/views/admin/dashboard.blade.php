@extends('layouts.base', ['logo5' => true])

@section('title', 'Admin Panel - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      <p class="jb-dash__eyebrow">Administration</p>
      <h1 class="jb-dash__title">Admin Panel</h1>
      <p class="jb-dash__sub">Review submitted listings and manage approvals.</p>

      <div class="jb-dash__grid">
        <div class="jb-dash__card">
          <span class="jb-dash__stat">0</span>
          <span class="jb-dash__label">Pending Approvals</span>
        </div>
        <div class="jb-dash__card">
          <span class="jb-dash__stat">0</span>
          <span class="jb-dash__label">Approved Properties</span>
        </div>
        <div class="jb-dash__card">
          <span class="jb-dash__stat">0</span>
          <span class="jb-dash__label">Rejected</span>
        </div>
      </div>

      <div class="jb-dash__actions">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="jb-dash__ghost" type="submit">Sign out</button>
        </form>
      </div>

    </div>
  </div>
@endsection
