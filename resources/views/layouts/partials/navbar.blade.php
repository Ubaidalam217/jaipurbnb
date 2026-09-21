{{--
  JaipurBnB primary site navigation.

  Self-contained by design: every rule below is scoped to .jb-nav / .jb-offcanvas
  and has ZERO dependency on the template SCSS. The only external requirement is
  Bootstrap 5's offcanvas JS, which is already bundled via resources/js/main.js.

  Contrast (against #FFFFFF):
    #2F3E46 nav links ......... 11.06:1  (AA + AAA)
    #B34D33 CTA bg / white text  5.21:1  (AA)
    #E07A5F wordmark .......... 2.95:1, permitted: WCAG 2.1 SC 1.4.3 exempts
                                          text that is part of a logo/brand name.
                                          Not used for any functional text.
--}}

@php
    $jbNavLinks = [
        ['label' => 'Home',              'href' => url('/'),             'active' => request()->is('/')],
        ['label' => 'Browse Properties', 'href' => route('properties.browse'), 'active' => request()->is('browse', 'property/*')],
        ['label' => 'Contact',           'href' => route('contact'),     'active' => request()->is('contact')],
    ];

    $jbUser = auth()->check() ? auth()->user() : null;
    $jbIsAdmin = $jbUser && $jbUser->isAdmin();
    $jbDashboard = $jbIsAdmin ? 'admin.dashboard' : 'host.dashboard';
    $jbCtaHref = $jbUser ? route($jbDashboard) : route('register');
    $jbCtaLabel = $jbUser ? ($jbIsAdmin ? 'Admin Panel' : 'Dashboard') : 'List Your Property';

    // Guest-facing primary CTA. Points at /browse, NOT at a checkout: there
    // is no on-platform booking - guests pick a listing and contact the host
    // over WhatsApp or by phone from the listing page. /browse is the first
    // step of that journey, so "Book Now" is the entry point to it.
    $jbBookHref = route('properties.browse');
@endphp

<style>
    .jb-nav,
    .jb-offcanvas {
        --jb-primary: #E07A5F;
        --jb-cta: #B34D33;
        --jb-cta-hover: #8F3D28;
        --jb-ink: #2F3E46;
        --jb-border: rgba(47, 62, 70, .12);
        --jb-tint: rgba(224, 122, 95, .09);
        font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    .jb-nav *,
    .jb-nav *::before,
    .jb-nav *::after,
    .jb-offcanvas *,
    .jb-offcanvas *::before,
    .jb-offcanvas *::after {
        box-sizing: border-box;
    }

    /* ---------- bar ---------- */
    .jb-nav {
        /* Bar height has to clear the logo. Was 104px to fit an 85px baked
           SVG lockup; the mark is now 46px with the wordmark set as text
           beside it, so 84px is the same breathing room around a much
           smaller element rather than a 104px bar with a hole in it.
           .jb-nav__inner sets height (not min-height), so anything taller
           than this spills out of the bar rather than growing it. */
        --jb-h: 84px;
        position: sticky;
        top: 0;
        z-index: 1030;
        width: 100%;
        background: #fff;
        border-bottom: 1px solid var(--jb-border);
    }

    .jb-nav__inner {
        display: flex;
        align-items: center;
        gap: 24px;
        height: var(--jb-h);
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ---------- wordmark ----------
       The logo is a mark + real HTML text, not one baked SVG. The old
       jaipurbnb-logo-compact.svg drew "Jaipur" and "bnb" as two <text>
       elements 155 units apart, in Georgia, in two different colours - it
       read as two words. It could not be fixed inside the SVG either: a file
       loaded through <img> is an isolated document and cannot reach the
       page's self-hosted Poppins, so any <text> in it falls back to a system
       serif. Splitting them gives one Poppins wordmark that matches the rest
       of the site, scales with the type ramp and is selectable text. */
    .jb-nav__brand {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-right: auto;
        text-decoration: none;
        white-space: nowrap;
        transition: opacity .2s ease;
    }

    .jb-nav__brand:hover,
    .jb-nav__brand:focus {
        opacity: .82;
        text-decoration: none;
    }

    .jb-nav__mark {
        display: block;
        width: auto;
        height: 46px;
        background: transparent !important;
    }

    /* One word, one family, one weight, one size - the two spans differ ONLY
       in colour. No space, no gap, no letter-spacing tweak between them:
       "JaipurBnB" has to read as a single word. */
    .jb-nav__word {
        font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        font-size: 24px;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -.015em;
    }

    /* Same charcoal as the hero copy and the nav links (11.06:1 on white). */
    .jb-nav__word-primary {
        color: var(--jb-ink);
    }

    /* #B34D33, not the #E07A5F brand primary: as text on white #E07A5F is
       only 2.95:1. A brand name is exempt from WCAG 1.4.3, but there is no
       reason to take the exemption when the deeper terracotta reads as the
       same hue at 5.21:1. */
    .jb-nav__word-accent {
        color: var(--jb-cta);
    }

    /* ---------- desktop menu ---------- */
    .jb-nav__desktop {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .jb-nav__menu {
        display: flex;
        align-items: center;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .jb-nav__link {
        position: relative;
        display: inline-flex;
        align-items: center;
        height: 40px;
        padding: 0 14px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 500;
        color: var(--jb-ink);
        text-decoration: none;
        white-space: nowrap;
        transition: color .2s ease, background-color .2s ease;
    }

    .jb-nav__link:hover {
        color: var(--jb-cta);
        background: var(--jb-tint);
        text-decoration: none;
    }

    .jb-nav__link.is-active {
        color: var(--jb-cta);
        font-weight: 600;
    }

    .jb-nav__link.is-active::after {
        content: "";
        position: absolute;
        right: 14px;
        bottom: 3px;
        left: 14px;
        height: 2px;
        border-radius: 2px;
        background: var(--jb-primary);
    }

    /* ---------- CTA ---------- */
    .jb-nav__cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 20px;
        border-radius: 10px;
        background: var(--jb-cta);
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color .2s ease, transform .12s ease;
    }

    .jb-nav__cta:hover,
    .jb-nav__cta:focus {
        background: var(--jb-cta-hover);
        color: #fff;
        text-decoration: none;
    }

    .jb-nav__cta:active {
        transform: translateY(1px);
    }

    /* ---------- CTA hierarchy ----------
       Two CTAs now sit side by side, aimed at two different audiences:
       "Book Now" at guests, "List Your Property" / "Dashboard" at hosts.
       Rendering both as filled terracotta buttons would give the bar two
       competing primaries and no visual answer to "what do I click?", so
       the host CTA is demoted to an outline and "Book Now" keeps the fill.

       Both use --jb-cta (#B34D33), not the #E07A5F brand primary: as text
       or as a border on white, #E07A5F only reaches 2.95:1 and fails WCAG
       AA for non-decorative UI. #B34D33 is 5.21:1 either way. */
    .jb-nav__cta--ghost {
        border: 1.5px solid var(--jb-cta);
        background: transparent;
        color: var(--jb-cta);
    }

    .jb-nav__cta--ghost:hover,
    .jb-nav__cta--ghost:focus {
        background: var(--jb-tint);
        color: var(--jb-cta-hover);
        border-color: var(--jb-cta-hover);
    }

    /* Mobile-only twin of the Book Now button. Lives directly in the bar
       next to the hamburger rather than inside the drawer - a CTA that
       needs two taps and a menu to reach is not a CTA. Hidden above the
       991.98px breakpoint where .jb-nav__desktop (and its own Book Now)
       comes back. */
    .jb-nav__book-mobile {
        display: none;
        align-items: center;
        justify-content: center;
        height: 40px;
        padding: 0 16px;
        border-radius: 10px;
        background: var(--jb-cta);
        color: #fff;
        font-size: 14.5px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color .2s ease;
    }

    .jb-nav__book-mobile:hover,
    .jb-nav__book-mobile:focus {
        background: var(--jb-cta-hover);
        color: #fff;
        text-decoration: none;
    }

    /* ---------- signed-in state ---------- */
    .jb-nav__who {
        max-width: 150px;
        overflow: hidden;
        font-size: 14.5px;
        font-weight: 500;
        color: var(--jb-ink);
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .jb-nav__logout {
        margin: 0;
    }

    .jb-nav__signout {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        padding: 0 14px;
        border: 1px solid var(--jb-border);
        border-radius: 10px;
        background: transparent;
        color: var(--jb-ink);
        font-family: inherit;
        font-size: 14.5px;
        font-weight: 500;
        cursor: pointer;
        white-space: nowrap;
        transition: background-color .2s ease;
    }

    .jb-nav__signout:hover {
        background: rgba(47, 62, 70, .06);
    }

    /* ---------- hamburger ---------- */
    .jb-nav__toggle {
        display: none;
        width: 44px;
        height: 44px;
        padding: 0;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--jb-border);
        border-radius: 10px;
        background: transparent;
        color: var(--jb-ink);
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .jb-nav__toggle:hover {
        background: rgba(47, 62, 70, .06);
    }

    /* ---------- focus ---------- */
    .jb-nav a:focus-visible,
    .jb-nav button:focus-visible,
    .jb-offcanvas a:focus-visible,
    .jb-offcanvas button:focus-visible {
        outline: 3px solid var(--jb-cta);
        outline-offset: 2px;
    }

    /* ---------- mobile drawer ---------- */
    .jb-offcanvas {
        width: 300px;
        max-width: 86vw;
        background: #fff;
    }

    .jb-offcanvas__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 60px;
        padding: 8px 16px;
        border-bottom: 1px solid var(--jb-border);
    }

    /* Same mark + wordmark lockup as the bar. Needs to be a flex row of its
       own - the drawer header is flex, but this anchor is one of its items,
       so the img and the wordmark inside it would otherwise stack. */
    .jb-offcanvas__brand {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .jb-offcanvas__close {
        display: inline-flex;
        width: 44px;
        height: 44px;
        padding: 0;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: var(--jb-ink);
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .jb-offcanvas__close:hover {
        background: rgba(47, 62, 70, .06);
    }

    .jb-offcanvas__body {
        display: flex;
        flex-direction: column;
        padding: 12px 16px 20px;
    }

    .jb-offcanvas__list {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin: 0 0 20px;
        padding: 0;
        list-style: none;
    }

    .jb-offcanvas__link {
        display: flex;
        align-items: center;
        min-height: 48px;
        padding: 0 12px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 500;
        color: var(--jb-ink);
        text-decoration: none;
        transition: color .2s ease, background-color .2s ease;
    }

    .jb-offcanvas__link:hover {
        color: var(--jb-cta);
        background: var(--jb-tint);
        text-decoration: none;
    }

    .jb-offcanvas__link.is-active {
        color: var(--jb-cta);
        font-weight: 600;
        background: var(--jb-tint);
    }

    .jb-offcanvas__cta {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 20px;
        border-radius: 10px;
        background: var(--jb-cta);
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color .2s ease;
    }

    .jb-offcanvas__cta:hover,
    .jb-offcanvas__cta:focus {
        background: var(--jb-cta-hover);
        color: #fff;
        text-decoration: none;
    }

    /* ---------- breakpoint ----------
       This is the hamburger layout: logo + Book Now + burger on one line.
       It was an 83px bar, which on a 390px phone spent over a tenth of the
       viewport on chrome before the guest saw a single property. 56px is a
       standard app-bar height and gets the whole header (56px + the 1px
       border = 57px) under 60px.

       The three numbers are locked to each other, so change them together:
         56px bar - 44px hamburger = 6px either side
         56px bar - 36px mark      = 10px either side
       The hamburger is the tallest child and is deliberately left at a full
       44x44 - it is the touch target, and shrinking it to buy header height
       would be trading the one thing a thumb has to hit. */
    @media (max-width: 991.98px) {
        .jb-nav {
            --jb-h: 56px;
        }

        .jb-nav__inner {
            gap: 10px;
            padding: 0 14px;
        }

        .jb-nav__mark {
            height: 36px;
        }

        .jb-nav__brand {
            gap: 8px;
        }

        .jb-nav__word {
            font-size: 19px;
        }

        .jb-nav__desktop {
            display: none;
        }

        /* 36px keeps the button clear of the 44px hamburger so the burger
           alone sets the bar height. It is a secondary target next to a
           full-size one, and still 36px tall by ~84px wide. */
        .jb-nav__book-mobile {
            display: inline-flex;
            height: 36px;
            padding: 0 14px;
            font-size: 14px;
        }

        .jb-nav__toggle {
            display: inline-flex;
        }
    }

    /* Narrow phones (iPhone SE and similar). The bar holds logo + Book Now +
       hamburger; trimming the button and wordmark keeps all three on one
       line with room to spare rather than wrapping the bar. Measured at
       360px: 14+40+8+99+10+80+10+44+14 = 319px used of 360px. */
    @media (max-width: 379.98px) {
        .jb-nav__book-mobile {
            padding: 0 11px;
            font-size: 13.5px;
        }

        .jb-nav__word {
            font-size: 18px;
        }

        .jb-nav__mark {
            height: 34px;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .jb-nav *,
        .jb-offcanvas * {
            transition: none !important;
        }
    }
</style>

<nav class="jb-nav" aria-label="Primary">
    <div class="jb-nav__inner">
        {{-- alt="" is correct: the mark is decorative now that the brand name
             is real text beside it. Giving it alt="JaipurBnB" would make a
             screen reader announce the link as "JaipurBnB JaipurBnB". --}}
        <a class="jb-nav__brand" href="{{ url('/') }}">
            <img src="{{ asset('img/jaipurbnb-mark.svg') }}" alt="" width="52" height="46" class="jb-nav__mark">
            <span class="jb-nav__word"><span class="jb-nav__word-primary">Jaipur</span><span class="jb-nav__word-accent">BnB</span></span>
        </a>

        <div class="jb-nav__desktop">
            <ul class="jb-nav__menu">
                @foreach ($jbNavLinks as $link)
                    <li>
                        <a class="jb-nav__link{{ $link['active'] ? ' is-active' : '' }}"
                           href="{{ $link['href'] }}"
                           @if ($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>
                    </li>
                @endforeach
            </ul>

            @if ($jbUser)
                <span class="jb-nav__who">{{ $jbUser->name }}</span>
            @endif

            {{-- Auth control sits BEFORE the two CTAs so the far right of the
                 bar - the most prominent slot - belongs to "Book Now". --}}
            @if ($jbUser)
                <form method="POST" action="{{ route('logout') }}" class="jb-nav__logout">
                    @csrf
                    <button class="jb-nav__signout" type="submit">Sign out</button>
                </form>
            @else
                <a class="jb-nav__link" href="{{ route('login') }}">Sign in</a>
            @endif

            <a class="jb-nav__cta jb-nav__cta--ghost" href="{{ $jbCtaHref }}">{{ $jbCtaLabel }}</a>

            <a class="jb-nav__cta" href="{{ $jbBookHref }}">Book Now</a>
        </div>

        {{-- Mobile-only. Deliberately outside .jb-nav__desktop (which is
             display:none under 992px) so the primary guest CTA stays in the
             top bar instead of disappearing into the hamburger. --}}
        <a class="jb-nav__book-mobile" href="{{ $jbBookHref }}">Book Now</a>

        <button class="jb-nav__toggle"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#jbMobileNav"
                aria-controls="jbMobileNav"
                aria-label="Open navigation menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false">
                <path d="M3 6h18M3 12h18M3 18h18" />
            </svg>
        </button>
    </div>

    <div class="offcanvas offcanvas-end jb-offcanvas"
         tabindex="-1"
         id="jbMobileNav"
         aria-labelledby="jbMobileNavLabel">
        <div class="jb-offcanvas__header">
            <a class="jb-offcanvas__brand" id="jbMobileNavLabel" href="{{ url('/') }}">
                <img src="{{ asset('img/jaipurbnb-mark.svg') }}" alt="" width="41" height="36" class="jb-nav__mark">
                <span class="jb-nav__word"><span class="jb-nav__word-primary">Jaipur</span><span class="jb-nav__word-accent">BnB</span></span>
            </a>
            <button class="jb-offcanvas__close"
                    type="button"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close navigation menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false">
                    <path d="M18 6 6 18M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="jb-offcanvas__body">
            <ul class="jb-offcanvas__list">
                @foreach ($jbNavLinks as $link)
                    <li>
                        <a class="jb-offcanvas__link{{ $link['active'] ? ' is-active' : '' }}"
                           href="{{ $link['href'] }}"
                           @if ($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>
                    </li>
                @endforeach
            </ul>

            <a class="jb-offcanvas__cta" href="{{ $jbCtaHref }}">{{ $jbCtaLabel }}</a>

            @if ($jbUser)
                <form method="POST" action="{{ route('logout') }}" style="margin-top:12px;">
                    @csrf
                    <button class="jb-offcanvas__link" type="submit"
                            style="width:100%;border:1px solid var(--jb-border);background:transparent;cursor:pointer;justify-content:center;">
                        Sign out
                    </button>
                </form>
            @else
                <a class="jb-offcanvas__link" href="{{ route('login') }}"
                   style="margin-top:12px;justify-content:center;border:1px solid var(--jb-border);">Sign in</a>
            @endif
        </div>
    </div>
</nav>
