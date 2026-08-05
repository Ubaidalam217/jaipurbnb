@extends('layouts.base', ['logo5' => true])

@section('title', 'Availability - '.$property->title.' - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  @include('layouts.partials.jb-auth-styles')
  @include('layouts.partials.jb-prop-styles')

  <div class="jb-dash">
    <div class="jb-dash__inner">

      <div class="jb-prop__bar">
        <div>
          <p class="jb-dash__eyebrow">Availability calendar</p>
          <h1 class="jb-dash__title">{{ $property->title }}</h1>
          <p class="jb-dash__sub" style="margin:0;">
            {{ $property->neighborhood }} &middot; {{ $property->stay_type }}
          </p>
        </div>
        <div class="jb-row__actions">
          <a class="jb-btn-sm" href="{{ route('host.properties.index') }}">Back</a>
          <a class="jb-btn-sm" href="{{ route('host.properties.show', $property) }}">View listing</a>
        </div>
      </div>

      <div class="jb-panel">
        <h2>Next three months</h2>
        <p class="jb-cal__note" style="margin-top:0;margin-bottom:20px;">
          Select any future date to block it, and select it again to open it back up.
          Blocked dates still appear on your public listing, marked as unavailable.
        </p>

        @include('layouts.partials.jb-calendar', [
            'calendar'    => $calendar,
            'interactive' => true,
            'toggleUrl'   => route('host.properties.availability.toggle', $property),
        ])

        @if ($property->ical_feed_url)
          <p class="jb-cal__note">
            Dates pulled from your Airbnb calendar are locked here — clear them in Airbnb and they
            will disappear on the next sync.
          </p>
        @endif
      </div>

    </div>
  </div>

  <div class="jb-cal__toast" id="jbCalToast" role="status" aria-live="polite"></div>
@endsection

@section('scripts')
<script>
  (function () {
    var calendar = document.querySelector('.jb-cal--interactive');
    if (!calendar) return;

    var toggleUrl = calendar.dataset.toggleUrl;
    var csrfToken = @json(csrf_token());
    var toast = document.getElementById('jbCalToast');
    var toastTimer;

    function announce(message, isError) {
      toast.textContent = message;
      toast.className = 'jb-cal__toast is-visible' + (isError ? ' jb-cal__toast--error' : '');
      clearTimeout(toastTimer);
      toastTimer = setTimeout(function () {
        toast.className = 'jb-cal__toast';
      }, 3200);
    }

    // Pull the first validation message out of Laravel's 422 shape so a
    // rejected date says why instead of a generic failure.
    function messageFrom(payload) {
      if (payload && payload.message) return payload.message;
      if (payload && payload.errors) {
        var first = Object.keys(payload.errors)[0];
        if (first) return payload.errors[first][0];
      }
      return 'Could not update that date. Please try again.';
    }

    function paint(cell, blocked) {
      cell.classList.toggle('jb-cal__day--blocked', blocked);
      cell.classList.toggle('jb-cal__day--available', !blocked);
      cell.setAttribute('aria-pressed', blocked ? 'true' : 'false');

      var label = cell.getAttribute('aria-label').split(' — ')[0];
      cell.setAttribute(
        'aria-label',
        label + ' — ' + (blocked ? 'blocked' : 'available') +
        '. Select to ' + (blocked ? 'unblock' : 'block') + '.'
      );
    }

    // Delegated: one listener for ~90 cells across three months.
    calendar.addEventListener('click', function (event) {
      var cell = event.target.closest('button.jb-cal__day');
      if (!cell || cell.disabled) return;

      // Guard against a double-click firing two toggles that cancel out.
      cell.disabled = true;
      cell.classList.add('is-saving');

      fetch(toggleUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ date: cell.dataset.date })
      })
        .then(function (response) {
          return response.json()
            .catch(function () { return {}; })
            .then(function (payload) { return { ok: response.ok, payload: payload }; });
        })
        .then(function (result) {
          if (!result.ok) {
            announce(messageFrom(result.payload), true);
            return;
          }
          paint(cell, result.payload.blocked);
          announce(result.payload.blocked ? 'Date blocked.' : 'Date opened up.');
        })
        .catch(function () {
          announce('Network error — the date was not saved.', true);
        })
        .finally(function () {
          cell.disabled = false;
          cell.classList.remove('is-saving');
        });
    });
  })();
</script>
@endsection
