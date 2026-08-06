{{--
  JaipurBnB — primary site navigation.

  Self-contained by design: every rule below is scoped to .jb-nav / .jb-offcanvas
  and has ZERO dependency on the template SCSS. The only external requirement is
  Bootstrap 5's offcanvas JS, which is already bundled via resources/js/main.js.

  Contrast (against #FFFFFF):
    #2F3E46 nav links ......... 11.06:1  (AA + AAA)
    #B34D33 CTA bg / white text  5.21:1  (AA)
    #E07A5F wordmark .......... 2.95:1  — permitted: WCAG 2.1 SC 1.4.3 exempts
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
        --jb-h: 72px;
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
            --jb-h: 60px;
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

        .jb-nav__toggle {
            display: inline-flex;
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
        <a class="jb-nav__brand" href="{{ url('/') }}">JaipurBnB</a>

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

            <a class="jb-nav__cta" href="{{ $jbCtaHref }}">{{ $jbCtaLabel }}</a>

            @if ($jbUser)
                <form method="POST" action="{{ route('logout') }}" class="jb-nav__logout">
                    @csrf
                    <button class="jb-nav__signout" type="submit">Sign out</button>
                </form>
            @else
                <a class="jb-nav__link" href="{{ route('login') }}">Sign in</a>
            @endif
        </div>

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
            <a class="jb-offcanvas__brand" id="jbMobileNavLabel" href="{{ url('/') }}">JaipurBnB</a>
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
