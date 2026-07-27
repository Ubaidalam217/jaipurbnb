<!DOCTYPE html>
<html lang="en" @yield('html_attribute')>

<head>

    @include('layouts.partials.title-meta')

    <!--===== CSS LINK =======-->
    @vite(['resources/scss/main.scss'])

    @yield('css')

</head>

<body @yield('body_attribute')>

    @include('layouts.partials.loader')


    @yield('content')


    @yield('scripts')

    @vite(['resources/js/main.js'])

</body>

</html>