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
        /* Bar height has to clear the logo: 85px logo + 2x10px breathing room.
           .jb-nav__inner sets height (not min-height), so a logo taller than
           this would spill out of the bar rather than grow it. */
        --jb-h: 104px;
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

    /* ---------- wordmark ---------- */
    .jb-nav__brand {
        display: inline-flex;
        align-items: center;
        margin-right: auto;
        font-size: 24px;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -.02em;
        color: var(--jb-primary);
        text-decoration: none;
        white-space: nowrap;
        transition: color .2s ease;
    }

    .jb-nav__brand:hover,
    .jb-nav__brand:focus {
        color: var(--jb-cta);
        text-decoration: none;
    }

    /* Client SVG logo replaces the wordmark; shrink it on small screens. */
    .navbar-logo {
        display: block;
        background: transparent !important;
    }

    /* Breakpoint matches the --jb-h switch at 991.98px below. It used to be
       768px, which left 768-992px rendering the full-size logo inside the
       already-shortened bar. */
    @media (max-width: 991.98px) {
        .navbar-logo {
            /* !important is required: the <img> carries an inline height:85px,
               which would otherwise outrank this class selector. */
            height: 65px !important;
        }
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

    .jb-offcanvas__brand {
        font-size: 20px;
        font-weight: 700;
        letter-spacing: -.02em;
        color: var(--jb-primary);
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

    /* ---------- breakpoint ---------- */
    @media (max-width: 991.98px) {
        .jb-nav {
            /* 65px logo + 2x9px. Was 60px, which the 65px logo overflowed. */
            --jb-h: 83px;
        }

        .jb-nav__inner {
            gap: 12px;
            padding: 0 16px;
        }

        .jb-nav__brand {
            font-size: 20px;
        }

        .jb-nav__desktop {
            display: none;
        }

        .jb-nav__book-mobile {
            display: inline-flex;
        }

        .jb-nav__toggle {
            display: inline-flex;
        }
    }

    /* Narrow phones (iPhone SE and similar). The bar holds logo + Book Now +
       hamburger; trimming the button's padding keeps all three on one line
       with room to spare rather than wrapping the bar. */
    @media (max-width: 379.98px) {
        .jb-nav__book-mobile {
            padding: 0 12px;
            font-size: 13.5px;
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
        <a class="jb-nav__brand" href="{{ url('/') }}"><img src="{{ asset('img/jaipurbnb-logo-compact.svg') }}" alt="JaipurBnB" width="93" height="85" style="height: 85px; width: auto; background: transparent;" class="navbar-logo"></a>

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
            <a class="jb-offcanvas__brand" id="jbMobileNavLabel" href="{{ url('/') }}"><img src="{{ asset('img/jaipurbnb-logo-compact.svg') }}" alt="JaipurBnB" width="93" height="85" style="height: 85px; width: auto; background: transparent;" class="navbar-logo"></a>
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
