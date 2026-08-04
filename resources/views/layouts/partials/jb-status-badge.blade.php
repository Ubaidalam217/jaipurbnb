{{-- Usage: @include('layouts.partials.jb-status-badge', ['property' => $property]) --}}
@php
    $map = [
        \App\Models\Property::STATUS_PENDING  => ['pending',  'Pending review'],
        \App\Models\Property::STATUS_APPROVED => ['approved', 'Approved'],
        \App\Models\Property::STATUS_REJECTED => ['rejected', 'Rejected'],
    ];
    [$tone, $label] = $map[$property->listing_status] ?? ['neutral', ucfirst($property->listing_status)];
@endphp

<span class="jb-badge jb-badge--{{ $tone }}"><span class="jb-badge__dot"></span>{{ $label }}</span>

@if ($property->is_visible)
    <span class="jb-badge jb-badge--approved"><span class="jb-badge__dot"></span>Live on site</span>
@else
    <span class="jb-badge jb-badge--neutral"><span class="jb-badge__dot"></span>Not published</span>
@endif
