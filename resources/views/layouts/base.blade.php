<!DOCTYPE html>
<html lang="en" @yield('html_attribute')>

<head>

    {{--
      Critical CSS, inlined. Covers the CSS reset + grid system the rest of
      the page is built on - see resources/scss/critical.scss for what it
      does and doesn't include and why. Kept before everything else in
      <head>, including the preload stack below, so the browser has enough
      to render a structurally-correct page the instant body parsing
      starts, without waiting on the external stylesheet below.
    --}}
    <style>{!! \Illuminate\Support\Facades\Vite::content('resources/scss/critical.scss') !!}</style>

    {{-- Pushed by pages with an LCP image (e.g. the homepage hero) - kept
         first in <head> so the browser's preload scanner sees it before
         anything else while it is still parsing the raw HTML. --}}
    @stack('preload')

    @include('layouts.partials.title-meta')

    {{--
      Main stylesheet - loaded synchronously, NOT via the async preload+
      onload swap. That was tried and deliberately reverted: this template
      has several hundred fixed-height rules (property/gallery/service
      sections, card image boxes) that only exist in this bundle, not in
      the critical CSS above, and every one of them is a live CLS
      protection - see resources/scss/critical.scss's own comment. Loading
      it async would let those sections render at their unstyled auto
      height first and then snap to their real fixed height the moment
      this arrives, which is a bigger layout shift than the ~1 round-trip
      of render-blocking time saved by not doing this. CLS is the metric
      actually in trouble here; Speed Index is not worth regressing it
      for. @vite() already emits its own <link rel=preload as=style> ahead
      of the stylesheet link, so this is not literally un-optimized either.
    --}}
    @vite(['resources/scss/main.scss'])

    @yield('css')

    {{-- JSON-LD structured data, pushed by the pages that have any. --}}
    @stack('jsonld')

</head>

<body @yield('body_attribute')>

    @include('layouts.partials.loader')


    @yield('content')


    @yield('scripts')

    @vite(['resources/js/main.js'])

</body>

</html>