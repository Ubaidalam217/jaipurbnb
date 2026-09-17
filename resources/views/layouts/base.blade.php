<!DOCTYPE html>
<html lang="en" @yield('html_attribute')>

<head>

    {{-- Pushed by pages with an LCP image (e.g. the homepage hero) - kept
         first in <head> so the browser's preload scanner sees it before
         anything else while it is still parsing the raw HTML. --}}
    @stack('preload')

    @include('layouts.partials.title-meta')

    <!--===== CSS LINK =======-->
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