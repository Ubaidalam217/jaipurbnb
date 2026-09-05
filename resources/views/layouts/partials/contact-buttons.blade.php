{{--
  WhatsApp + Call buttons for a single $property.

  Usage: @include('layouts.partials.contact-buttons', ['property' => $property])
  Pass ['property' => $property, 'size' => 'sm'] for the compact browse-card variant,
  or add 'fullWidth' => true to split the two buttons 50/50 across the
  full width of their container (used on /browse cards).

  Click tracking: main.js delegates a click listener on [data-lead-type]
  and fires navigator.sendBeacon('/api/analytics/log', ...) - nothing
  here talks to the network directly, so these links work even with JS
  disabled (WhatsApp/tel: still open; only the lead never gets logged).

  @once guards the <style> block so including this partial many times
  on one page (every card in the /browse grid) only emits the CSS once.
--}}
@once
<style>
    /*
      SPECIFICITY NOTE - why every rule below is scoped under
      .jb-contact-row rather than styling .jb-contact-btn on its own:

      The template SCSS styles bare <a> descendants of its layout
      containers, e.g.

        .apartment-inner2-section-area .apartment-boxarea .content-area a
            { display: inline-block; font-size: 20px; font-weight: bold; ... }

      That selector scores (0,3,1). A lone `.jb-contact-btn` scores
      (0,1,0) and loses, so `display: inline-flex` was being replaced by
      `inline-block` - which silently disables align-items /
      justify-content / gap and leaves the icon+label sitting at the
      left edge of a stretched button. Two classes is enough for every
      container these buttons are actually used in today; the browse
      card additionally renders them OUTSIDE .content-area so no
      template rule targets them at all.
    */
    .jb-contact-row {
        display: flex;
        flex-wrap: wrap;
        /* stretch keeps both buttons exactly the same height even if one
           ever wraps to two lines. */
        align-items: stretch;
        gap: 12px;
    }

    /* Shared button box - the fallback <span> gets the same geometry so
       it lines up identically when a host has no phone on file. */
    .jb-contact-row .jb-contact-btn,
    .jb-contact-row .jb-contact-btn--disabled {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-sizing: border-box;
        min-height: 52px;
        padding: 14px 26px;
        border: 0;
        /* Pill, deliberately - kept as the exception to the 8px button rule
           because these are the primary conversion control on every card and
           the rounded shape is what distinguishes them from template buttons. */
        border-radius: 999px;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 600;
        transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease;
        /* line-height:1 makes the text box exactly the glyph height, so
           align-items:center has a predictable box to centre. The
           template's inherited line-height (24px) against a 48px min-height
           was part of why the label looked top-heavy. */
        line-height: 1;
        text-align: center;
        text-decoration: none;
        white-space: nowrap;
    }

    /* Keep the icon on the same optical baseline as the label so the pair
       centres as one unit rather than the icon riding high. */
    .jb-contact-row .jb-contact-btn i {
        font-size: 1em;
        line-height: 1;
    }

    /* WhatsApp's own brand green. Deliberately NOT replaced with a JaipurBnB
       colour: the green is the affordance - people recognise the button
       before they read it. Label is near-black green rather than white
       because white on #25D366 is only 2.1:1. */
    .jb-contact-row .jb-contact-btn--whatsapp,
    .jb-contact-row .jb-contact-btn--whatsapp:focus {
        background: #25D366;
        color: #0F3D2E;
        box-shadow: 0 4px 14px rgba(37, 211, 102, .34);
    }

    .jb-contact-row .jb-contact-btn--whatsapp:hover {
        background: #1FBE5A;
        color: #0F3D2E;
        box-shadow: 0 8px 22px rgba(37, 211, 102, .46);
    }

    .jb-contact-row .jb-contact-btn--call,
    .jb-contact-row .jb-contact-btn--call:focus {
        background: #B34D33;
        color: #fff;
        box-shadow: 0 4px 14px rgba(179, 77, 51, .30);
    }

    .jb-contact-row .jb-contact-btn--call:hover {
        background: #8F3D28;
        color: #fff;
        box-shadow: 0 8px 22px rgba(179, 77, 51, .42);
    }

    /* Lift instead of the old opacity fade - fading a button on hover reads
       as "disabling" it, which is the wrong signal on a CTA. */
    .jb-contact-row .jb-contact-btn:hover {
        text-decoration: none;
        transform: translateY(-2px);
    }

    .jb-contact-row .jb-contact-btn:active {
        transform: translateY(0);
    }

    @media (prefers-reduced-motion: reduce) {
        .jb-contact-row .jb-contact-btn {
            transition: none;
        }
        .jb-contact-row .jb-contact-btn:hover {
            transform: none;
        }
    }

    .jb-contact-row .jb-contact-btn--disabled {
        background: rgba(47, 62, 70, .08);
        color: #2F3E46;
        font-size: 14px;
        font-weight: 500;
    }

    /* Compact variant, used on the browse cards. Bumped alongside the full
       size so the WhatsApp CTA stays prominent in the grid. */
    .jb-contact-row--sm .jb-contact-btn,
    .jb-contact-row--sm .jb-contact-btn--disabled {
        min-height: 44px;
        padding: 11px 18px;
        font-size: 13.5px;
        gap: 7px;
    }

    /* The icon carries the recognition at card size, so let it run slightly
       ahead of the label rather than matching it 1:1. */
    .jb-contact-row--sm .jb-contact-btn i {
        font-size: 1.15em;
    }

    /* Two buttons split 50/50 across the full width of their container.
       flex-basis: 0 (not 50%) is deliberate - combined with equal
       flex-grow on both buttons it guarantees an exact even split
       regardless of "WhatsApp" vs "Call" being different text lengths. */
    .jb-contact-row--full {
        flex-wrap: nowrap;
        width: 100%;
    }

    .jb-contact-row--full .jb-contact-btn,
    .jb-contact-row--full .jb-contact-btn--disabled {
        flex: 1 1 0;
        /* min-width:0 lets a flex item shrink below its content width, so
           a long label cannot force the pair off 50/50 on narrow cards. */
        min-width: 0;
        padding-left: 8px;
        padding-right: 8px;
    }
</style>
@endonce
@php
    $jbWhatsappUrl = $property->whatsappUrl();
    $jbCallUrl = $property->callUrl();
    $jbSm = ($size ?? 'lg') === 'sm';
    $jbFull = ($fullWidth ?? false) === true;
    $jbRowClass = 'jb-contact-row'
        .($jbSm ? ' jb-contact-row--sm' : '')
        .($jbFull ? ' jb-contact-row--full' : '');
@endphp
<div class="{{ $jbRowClass }}">
    @if ($jbWhatsappUrl && $jbCallUrl)
        <a href="{{ $jbWhatsappUrl }}"
           class="jb-contact-btn jb-contact-btn--whatsapp"
           target="_blank"
           rel="noopener noreferrer"
           data-lead-type="whatsapp_click"
           data-property-id="{{ $property->id }}">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp
        </a>
        {{--
          No target="_blank" on the Call button: a tel: URL is handed to
          the OS, not loaded as a document, so target="_blank" makes a
          desktop browser open (and strand) an empty tab. Mobile intercepts
          tel: and opens the dialer regardless of target.
        --}}
        <a href="{{ $jbCallUrl }}"
           class="jb-contact-btn jb-contact-btn--call"
           data-lead-type="call_click"
           data-property-id="{{ $property->id }}">
            <i class="fa-solid fa-phone"></i> Call
        </a>
    @else
        {{-- Only reachable if a host account predates the required phone_number field. --}}
        <span class="jb-contact-btn--disabled">Contact info unavailable</span>
    @endif
</div>
