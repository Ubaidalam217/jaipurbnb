{{--
  Shared shell for the four legal pages under resources/views/pages/legal/.

  Styling is an inline <style> block rather than SCSS on purpose: Hostinger
  has no Node, public/build is gitignored, and a rebuilt bundle has to be
  uploaded by hand. Keeping legal-page CSS in Blade means these pages deploy
  as plain file copies. Same reasoning as the inline styles on
  pages/contact.blade.php and host/properties/plans.blade.php.

  Child pages set: $pageTitle, $pageIntro, $activeLegal (route name suffix).
--}}
@extends('layouts.base', ['logo5' => true])

@section('title', $pageTitle . ' - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')

  <style>
    .jb-legal {
      --jb-primary: #E07A5F;
      --jb-cta: #B34D33;
      --jb-ink: #2F3E46;
      --jb-muted: #6B7A82;
      --jb-border: rgba(47, 62, 70, .14);
      font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    .jb-legal__hero {
      background: var(--jb-ink);
      padding: 120px 0 56px;
      text-align: center;
    }

    .jb-legal__eyebrow {
      display: inline-block;
      padding: 6px 14px;
      border-radius: 999px;
      background: rgba(224, 122, 95, .18);
      color: #F0B49F;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .jb-legal__title {
      margin: 16px 0 10px;
      color: #fff;
      font-size: 40px;
      font-weight: 700;
      line-height: 1.2;
    }

    .jb-legal__intro {
      max-width: 720px;
      margin: 0 auto;
      color: rgba(255, 255, 255, .82);
      font-size: 16px;
      line-height: 1.7;
    }

    .jb-legal__updated {
      margin-top: 18px;
      color: rgba(255, 255, 255, .6);
      font-size: 14px;
    }

    .jb-legal__wrap {
      display: grid;
      grid-template-columns: 260px minmax(0, 1fr);
      gap: 48px;
      max-width: 1120px;
      margin: 0 auto;
      padding: 56px 20px 80px;
    }

    .jb-legal__nav { position: sticky; top: 24px; align-self: start; }

    .jb-legal__nav h2 {
      margin: 0 0 14px;
      color: var(--jb-muted);
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .06em;
      text-transform: uppercase;
    }

    .jb-legal__nav ul { margin: 0; padding: 0; list-style: none; }

    .jb-legal__nav a {
      display: block;
      padding: 11px 14px;
      border-left: 2px solid var(--jb-border);
      color: var(--jb-ink);
      font-size: 15px;
      line-height: 1.4;
      text-decoration: none;
      transition: all .2s ease;
    }

    .jb-legal__nav a:hover {
      border-left-color: var(--jb-primary);
      background: rgba(224, 122, 95, .07);
      color: var(--jb-cta);
    }

    .jb-legal__nav a[aria-current="page"] {
      border-left-color: var(--jb-cta);
      background: rgba(224, 122, 95, .1);
      color: var(--jb-cta);
      font-weight: 600;
    }

    .jb-legal__body { max-width: 760px; color: var(--jb-ink); }

    .jb-legal__body h2 {
      margin: 44px 0 14px;
      padding-top: 4px;
      color: var(--jb-ink);
      font-size: 23px;
      font-weight: 700;
      line-height: 1.3;
    }

    .jb-legal__body h2:first-child { margin-top: 0; }

    .jb-legal__body h3 {
      margin: 26px 0 10px;
      color: var(--jb-ink);
      font-size: 17px;
      font-weight: 600;
      line-height: 1.4;
    }

    .jb-legal__body p,
    .jb-legal__body li {
      color: #46565E;
      font-size: 15.5px;
      line-height: 1.8;
    }

    .jb-legal__body p { margin: 0 0 14px; }
    .jb-legal__body ul, .jb-legal__body ol { margin: 0 0 18px; padding-left: 22px; }
    .jb-legal__body li { margin-bottom: 9px; }
    .jb-legal__body strong { color: var(--jb-ink); font-weight: 600; }

    .jb-legal__body a {
      color: var(--jb-cta);
      font-weight: 500;
      text-decoration: underline;
      text-underline-offset: 2px;
    }

    .jb-legal__body a:hover { color: #8F3D28; }

    /* Pull-quote box for the clauses that carry money or liability. */
    .jb-legal__callout {
      margin: 22px 0;
      padding: 20px 24px;
      border: 1px solid rgba(224, 122, 95, .34);
      border-left: 4px solid var(--jb-primary);
      border-radius: 10px;
      background: rgba(224, 122, 95, .08);
    }

    .jb-legal__callout p:last-child { margin-bottom: 0; }

    .jb-legal__contact {
      margin-top: 40px;
      padding: 24px 26px;
      border: 1px solid var(--jb-border);
      border-radius: 14px;
      background: #FBFAF8;
    }

    .jb-legal__contact h2 { margin-top: 0; font-size: 19px; }
    .jb-legal__contact p:last-child { margin-bottom: 0; }

    .jb-legal__toc {
      margin: 0 0 8px;
      padding: 20px 24px;
      border: 1px solid var(--jb-border);
      border-radius: 12px;
      background: #FBFAF8;
    }

    .jb-legal__toc h2 { margin: 0 0 12px; font-size: 15px; text-transform: uppercase; letter-spacing: .05em; color: var(--jb-muted); }
    .jb-legal__toc ol { margin: 0; padding-left: 20px; }
    .jb-legal__toc li { margin-bottom: 6px; font-size: 14.5px; }

    @media (max-width: 991.98px) {
      .jb-legal__hero { padding: 100px 0 44px; }
      .jb-legal__title { font-size: 29px; }
      .jb-legal__wrap { grid-template-columns: 1fr; gap: 32px; padding: 36px 16px 60px; }
      .jb-legal__nav { position: static; }
      .jb-legal__body h2 { font-size: 20px; }
    }
  </style>

  <div class="jb-legal">
    <div class="jb-legal__hero">
      <div class="container">
        <span class="jb-legal__eyebrow">Legal</span>
        <h1 class="jb-legal__title">{{ $pageTitle }}</h1>
        <p class="jb-legal__intro">{{ $pageIntro }}</p>
        <p class="jb-legal__updated">Last updated: 5 September 2026</p>
      </div>
    </div>

    <div class="jb-legal__wrap">
      <nav class="jb-legal__nav" aria-label="Legal documents">
        <h2>Policies</h2>
        <ul>
          @foreach ([
            'legal.terms'      => 'Terms &amp; Conditions',
            'legal.privacy'    => 'Privacy Policy',
            'legal.refund'     => 'Refund &amp; Cancellation',
            'legal.host-terms' => 'Host Listing Terms',
          ] as $routeName => $label)
            <li>
              <a href="{{ route($routeName) }}"
                 @if (request()->routeIs($routeName)) aria-current="page" @endif>{!! $label !!}</a>
            </li>
          @endforeach
        </ul>
      </nav>

      <article class="jb-legal__body">
        @yield('legal_body')

        <div class="jb-legal__contact">
          <h2>Questions about this policy?</h2>
          <p>
            Write to us at
            <a href="mailto:hello@jaipurbnb.com" style="text-transform:none;">hello@jaipurbnb.com</a>
            or call <a href="tel:{{ config('contact.phone_tel') }}">{{ config('contact.phone') }}</a>
            (Monday to Saturday, 10am to 7pm IST). JaipurBnB operates from Jaipur, Rajasthan, India.
          </p>
        </div>
      </article>
    </div>
  </div>

  @include('layouts.partials.footer')
@endsection
