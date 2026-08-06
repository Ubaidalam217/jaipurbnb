{{--
  Three-month availability grid.

  Required: $calendar  (from App\Support\AvailabilityCalendar::build())
  Optional: $interactive (bool, default false) - renders clickable
            <button> cells and the Airbnb lock legend. The host page
            supplies the fetch() wiring; this partial stays markup-only.
            $toggleUrl (string) - required when $interactive is true.

  Read-only cells are <span>, not disabled <button>, so a guest's
  keyboard tab order is not filled with ~90 inert stops.
--}}
@include('layouts.partials.jb-calendar-styles')

@php
    $jbInteractive = ($interactive ?? false) === true;
    $jbWeekdays = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
@endphp

<div class="jb-cal{{ $jbInteractive ? ' jb-cal--interactive' : '' }}"
     @if ($jbInteractive) data-toggle-url="{{ $toggleUrl }}" @endif>
    <div class="jb-cal__months">
        @foreach ($calendar as $month)
            <div class="jb-cal__month">
                <p class="jb-cal__month-name">{{ $month['label'] }}</p>

                <div class="jb-cal__grid">
                    @foreach ($jbWeekdays as $weekday)
                        <span class="jb-cal__dow" aria-hidden="true">{{ $weekday }}</span>
                    @endforeach

                    @for ($blank = 0; $blank < $month['leading']; $blank++)
                        <span class="jb-cal__blank" aria-hidden="true"></span>
                    @endfor

                    @foreach ($month['days'] as $day)
                        @php
                            $jbClasses = ['jb-cal__day'];

                            if ($day['is_past']) {
                                $jbClasses[] = 'jb-cal__day--past';
                                $jbState = 'past';
                            } elseif ($day['is_locked']) {
                                $jbClasses[] = 'jb-cal__day--locked';
                                // Only the host is told WHY a date is locked. A guest
                                // seeing "blocked by Airbnb sync" would learn the host
                                // also lists on a competing marketplace - that is the
                                // host's business, not a browsing guest's.
                                $jbState = ! $jbInteractive
                                    ? 'unavailable'
                                    : ($day['source'] === \App\Models\PropertyAvailability::SOURCE_AIRBNB
                                        ? 'blocked by Airbnb sync'
                                        : 'booked');
                            } elseif ($day['is_available']) {
                                $jbClasses[] = 'jb-cal__day--available';
                                $jbState = 'available';
                            } else {
                                $jbClasses[] = 'jb-cal__day--blocked';
                                $jbState = 'blocked';
                            }

                            // Only future, host-owned dates are clickable.
                            $jbClickable = $jbInteractive && ! $day['is_past'] && ! $day['is_locked'];
                        @endphp

                        @if ($jbClickable)
                            <button type="button"
                                    class="{{ implode(' ', $jbClasses) }}"
                                    data-date="{{ $day['date'] }}"
                                    aria-pressed="{{ $day['is_available'] ? 'false' : 'true' }}"
                                    aria-label="{{ $day['label'] }} — {{ $jbState }}. Select to {{ $day['is_available'] ? 'block' : 'unblock' }}.">{{ $day['day'] }}</button>
                        @else
                            <span class="{{ implode(' ', $jbClasses) }}"
                                  aria-label="{{ $day['label'] }} — {{ $jbState }}"
                                  @if ($day['is_locked'] && ! $day['is_past']) title="{{ ucfirst($jbState) }} — not editable here" @endif>{{ $day['day'] }}@if ($jbInteractive && $day['is_locked'] && ! $day['is_past'])<i class="fa-solid fa-lock jb-cal__lock" aria-hidden="true"></i>@endif</span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="jb-cal__legend">
        <span class="jb-cal__legend-item">
            <span class="jb-cal__swatch jb-cal__swatch--available" aria-hidden="true"></span> Available
        </span>
        <span class="jb-cal__legend-item">
            <span class="jb-cal__swatch jb-cal__swatch--blocked" aria-hidden="true"></span> Blocked
        </span>
        @if ($jbInteractive)
            <span class="jb-cal__legend-item">
                <span class="jb-cal__swatch jb-cal__swatch--locked" aria-hidden="true"></span> Airbnb-synced (locked)
            </span>
        @endif
    </div>
</div>
