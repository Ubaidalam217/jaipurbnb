<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'JaipurBnB - Authentic Jaipur Stays')</title>

{{--
  SEO metadata.

  Every URL here comes from Laravel's URL generator rather than a hardcoded
  domain, so it follows APP_URL. The app is currently served from the /app
  subfolder while WordPress holds the domain root; when the document root is
  repointed at laravel_app/public and APP_URL drops the /app suffix, every
  canonical, og:url and sitemap entry becomes a root-domain URL on its own.
  Nothing here needs editing at that cutover.
--}}
@php
  // Private areas: host dashboard, admin panel and the auth screens. Derived
  // from the request path rather than a @section in each view - there are
  // dozens of those views, and one forgotten @section silently puts a host's
  // dashboard in the index. A view can still override with @section('robots').
  $jbPrivate = request()->is(
      'host', 'host/*',
      'admin', 'admin/*',
      'login', 'register',
      'password', 'password/*',
      'dashboard', 'dashboard/*',
  );

  // Sections are read back through this helper, never interpolated directly.
  //
  // Blade's inline form, @section('meta_description', $value), escapes the
  // value with e() as it stores it - the block form, @section(...)@endsection,
  // does not. Echoing the result with {{ }} would therefore escape the inline
  // ones a second time, and a listing whose description contains an
  // apostrophe would publish a meta description reading "Jaipur&#039;s".
  // Decode first, escape exactly once, then emit raw.
  $jbSection = function (string $name, string $fallback) use ($__env) {
      $value = trim($__env->yieldContent($name)) ?: $fallback;

      return e(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
  };

  $jbDescription = $jbSection(
      'meta_description',
      'Browse verified homestays, heritage havelis, boutique apartments and luxury villas across Jaipur. Contact hosts directly on WhatsApp or by phone - no booking fees, no middleman.'
  );

  $jbTitle = $jbSection('og_title', trim($__env->yieldContent('title')) ?: 'JaipurBnB - Authentic Jaipur Stays, Boutique Havelis & Heritage Homes');

  // Social preview image.
  //
  // Default is the homepage hero photo, NOT the logo SVG that used to be
  // here. Facebook, WhatsApp, LinkedIn and X all refuse image/svg+xml, so
  // every share of every page was rendering with no thumbnail at all. The
  // 1200w variant is used because 1200x630-ish is what summary_large_image
  // and og both want; the 400w/800w srcset variants are too small and get
  // dropped by Twitter's validator.
  //
  // Pages override it with @section('og_image') - listing pages pass their
  // own cover photo. Those arrive as ROOT-RELATIVE paths ("/storage/...")
  // because that is what ImageModel::display_url returns, and og:image must
  // be absolute or crawlers discard it, so anything without a scheme is
  // promoted through url() here rather than in each calling view.
  $jbImageRaw = trim($__env->yieldContent('og_image')) ?: asset('img/all-images/hero/hero-img6-1200w.webp');
  $jbImageRaw = html_entity_decode($jbImageRaw, ENT_QUOTES, 'UTF-8');
  $jbImage = e(\Illuminate\Support\Str::startsWith($jbImageRaw, ['http://', 'https://'])
      ? $jbImageRaw
      : url($jbImageRaw));

  $jbUrl = e(url()->current());
@endphp

<meta name="description" content="{!! $jbDescription !!}">
<meta name="robots" content="@yield('robots', $jbPrivate ? 'noindex,nofollow' : 'index,follow')">
<link rel="canonical" href="{!! $jbUrl !!}">

<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:site_name" content="JaipurBnB">
<meta property="og:locale" content="en_IN">
<meta property="og:title" content="{!! $jbTitle !!}">
<meta property="og:description" content="{!! $jbDescription !!}">
<meta property="og:url" content="{!! $jbUrl !!}">
<meta property="og:image" content="{!! $jbImage !!}">
<meta property="og:image:alt" content="{!! $jbTitle !!}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{!! $jbTitle !!}">
<meta name="twitter:description" content="{!! $jbDescription !!}">
<meta name="twitter:image" content="{!! $jbImage !!}">
<meta name="twitter:image:alt" content="{!! $jbTitle !!}">

{{--
  Poppins is SELF-HOSTED - there is deliberately no <link> to
  fonts.googleapis.com here, and no preconnect to it either.

  The @font-face rules ship inside the inlined critical CSS (see
  resources/scss/critical.scss), so the browser can start fetching the font
  straight from the HTML with no blocking stylesheet request first. The old
  setup cost two serial third-party round trips before any text could paint:
  a render-blocking CSS request to fonts.googleapis.com, which then pointed
  at font files on a second origin, fonts.gstatic.com.

  If a Google-hosted font is ever reintroduced, put the preconnects back with
  it - without them it is even slower than what was removed here.
--}}

<!--=====FAB ICON=======-->
<link rel="icon" href="{{ asset('img/jaipurbnb-logo.svg') }}" type="image/svg+xml">

