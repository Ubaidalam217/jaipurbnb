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
        <a class="jb-dash__card" style="text-decoration:none;"
           href="{{ route('admin.properties.index', ['status' => 'pending']) }}">
          <span class="jb-dash__stat">{{ $pendingCount }}</span>
          <span class="jb-dash__label">Pending Approvals</span>
        </a>
        <a class="jb-dash__card" style="text-decoration:none;"
           href="{{ route('admin.properties.index', ['status' => 'approved']) }}">
          <span class="jb-dash__stat">{{ $approvedCount }}</span>
          <span class="jb-dash__label">Approved Properties</span>
        </a>
        <a class="jb-dash__card" style="text-decoration:none;"
           href="{{ route('admin.properties.index', ['status' => 'rejected']) }}">
          <span class="jb-dash__stat">{{ $rejectedCount }}</span>
          <span class="jb-dash__label">Rejected</span>
        </a>
      </div>

      <div class="jb-dash__actions">
        <a class="jb-dash__cta" href="{{ route('admin.properties.index') }}">Open Moderation Queue</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="jb-dash__ghost" type="submit">Sign out</button>
        </form>
      </div>

    </div>
  </div>
@endsection
