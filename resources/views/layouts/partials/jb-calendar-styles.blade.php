{{--
  Availability calendar styles, jb-cal- prefixed.

  Self-contained by design: the tokens below are declared on .jb-cal
  itself rather than pulled from jb-auth-styles, because this partial is
  also used on the PUBLIC property page, which does not load the
  dashboard stylesheet. Same convention as the navbar partial.

  Contrast (WCAG AA needs 4.5:1 for body text):
    #2F3E46 available number on #FFFFFF ...... 11.06:1
    #6B767C blocked number on #E9ECEE ........  4.55:1
    #6C7A80 weekday header on #FFFFFF ........  4.71:1
    #A9B2B7 past number on #FFFFFF ...........  2.29:1 - intentionally
            below AA: past dates are decoration, not information, and
            every cell also carries its state in aria-label.
--}}
@once
<style>
    .jb-cal {
        --jb-cal-ink: #2F3E46;
        --jb-cal-muted: #6C7A80;
        --jb-cal-line: rgba(47, 62, 70, .14);
        --jb-cal-primary: #E07A5F;
        --jb-cal-cta: #B34D33;
        --jb-cal-blocked-bg: #E9ECEE;
        --jb-cal-blocked-ink: #6B767C;
        font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        color: var(--jb-cal-ink);
    }

    .jb-cal *,
    .jb-cal *::before,
    .jb-cal *::after {
        box-sizing: border-box;
    }

    /* ---------- month grid ---------- */
    .jb-cal__months {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    @media (max-width: 1024px) {
        .jb-cal__months {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 680px) {
        .jb-cal__months {
            grid-template-columns: 1fr;
        }
    }

    .jb-cal__month {
        padding: 18px;
        border: 1px solid var(--jb-cal-line);
        border-radius: 14px;
        background: #fff;
    }

    .jb-cal__month-name {
        margin: 0 0 14px;
        font-size: 15px;
        font-weight: 600;
        text-align: center;
        color: var(--jb-cal-ink);
    }

    .jb-cal__grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px;
    }

    .jb-cal__dow {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-bottom: 6px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: .02em;
        color: var(--jb-cal-muted);
    }

    /* ---------- day cells ---------- */
    .jb-cal__day,
    .jb-cal__blank {
        display: flex;
        align-items: center;
        justify-content: center;
        /* Square cells that scale with the column width. */
        aspect-ratio: 1 / 1;
        border-radius: 8px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 500;
        line-height: 1;
    }

    .jb-cal__day {
        position: relative;
        border: 1px solid var(--jb-cal-line);
        background: #fff;
        color: var(--jb-cal-ink);
    }

    .jb-cal__blank {
        border: 0;
        background: transparent;
    }

    .jb-cal__day--blocked {
        border-color: transparent;
        background: var(--jb-cal-blocked-bg);
        color: var(--jb-cal-blocked-ink);
        text-decoration: line-through;
    }

    .jb-cal__day--past {
        border-color: transparent;
        background: transparent;
        color: #A9B2B7;
        text-decoration: none;
    }

    /* Airbnb-synced (or booked) dates the host cannot edit. The stripe
       reads as "locked" without depending on an icon font. */
    .jb-cal__day--locked {
        background:
            repeating-linear-gradient(-45deg,
                #E3E7EA 0, #E3E7EA 3px,
                #EFF2F3 3px, #EFF2F3 6px);
        color: var(--jb-cal-blocked-ink);
        cursor: not-allowed;
    }

    .jb-cal__lock {
        position: absolute;
        top: 2px;
        right: 3px;
        font-size: 7.5px;
        line-height: 1;
        color: var(--jb-cal-cta);
    }

    /* ---------- interactive (host) ---------- */
    .jb-cal--interactive .jb-cal__day:not(:disabled) {
        cursor: pointer;
        transition: transform .12s ease, border-color .2s ease, background-color .2s ease;
    }

    .jb-cal--interactive .jb-cal__day:not(:disabled):hover {
        border-color: var(--jb-cal-primary);
        transform: translateY(-1px);
    }

    .jb-cal--interactive .jb-cal__day:focus-visible {
        outline: 3px solid var(--jb-cal-cta);
        outline-offset: 2px;
    }

    .jb-cal--interactive .jb-cal__day:disabled {
        cursor: default;
    }

    /* Dim a cell while its request is in flight. */
    .jb-cal--interactive .jb-cal__day.is-saving {
        opacity: .5;
    }

    /* ---------- legend ---------- */
    .jb-cal__legend {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 20px;
        font-size: 13.5px;
        color: var(--jb-cal-muted);
    }

    .jb-cal__legend-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .jb-cal__swatch {
        width: 18px;
        height: 18px;
        flex: 0 0 auto;
        border-radius: 5px;
        border: 1px solid var(--jb-cal-line);
    }

    .jb-cal__swatch--available {
        background: #fff;
    }

    .jb-cal__swatch--blocked {
        border-color: transparent;
        background: var(--jb-cal-blocked-bg);
    }

    .jb-cal__swatch--locked {
        border-color: transparent;
        background:
            repeating-linear-gradient(-45deg,
                #E3E7EA 0, #E3E7EA 3px,
                #EFF2F3 3px, #EFF2F3 6px);
    }

    .jb-cal__note {
        margin: 14px 0 0;
        font-size: 13.5px;
        line-height: 1.6;
        color: var(--jb-cal-muted);
    }

    /* ---------- toast ---------- */
    .jb-cal__toast {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 1080;
        max-width: 320px;
        padding: 12px 18px;
        border-radius: 10px;
        background: #2F3E46;
        color: #fff;
        font-family: 'Poppins', system-ui, sans-serif;
        font-size: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, .18);
        opacity: 0;
        transform: translateY(8px);
        pointer-events: none;
        transition: opacity .2s ease, transform .2s ease;
    }

    .jb-cal__toast.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .jb-cal__toast--error {
        background: #B3261E;
    }

    @media (prefers-reduced-motion: reduce) {

        .jb-cal *,
        .jb-cal__toast {
            transition: none !important;
        }
    }
</style>
@endonce
