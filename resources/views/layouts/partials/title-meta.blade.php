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

  $jbTitle = $jbSection('og_title', trim($__env->yieldContent('title')) ?: 'JaipurBnB - Authentic Jaipur Stays');
  $jbImage = $jbSection('og_image', asset('img/jaipurbnb-logo.svg'));
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

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{!! $jbTitle !!}">
<meta name="twitter:description" content="{!! $jbDescription !!}">
<meta name="twitter:image" content="{!! $jbImage !!}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!--=====FAB ICON=======-->
<link rel="icon" href="{{ asset('img/jaipurbnb-logo.svg') }}" type="image/svg+xml">

