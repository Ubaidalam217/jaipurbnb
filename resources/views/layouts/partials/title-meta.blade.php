<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'JaipurBnB - Authentic Jaipur Stays')</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!--=====FAB ICON=======-->
@if(isset($logo2))
    <link rel="shortcut icon" href="/img/logo/fav-logo2.png" type="image/x-icon">
@elseif(isset($logo1))
    <link rel="shortcut icon" href="/img/logo/fav-logo1.png" type="image/x-icon">
@elseif(isset($logo4))
    <link rel="shortcut icon" href="/img/logo/fav-logo4.png" type="image/x-icon">
@elseif(isset($logo5))
    <link rel="shortcut icon" href="/img/logo/fav-logo5.png" type="image/x-icon">
@elseif(isset($logo6))
    <link rel="shortcut icon" href="/img/logo/fav-logo6.png" type="image/x-icon">
@elseif(isset($logo7))
    <link rel="shortcut icon" href="/img/logo/fav-logo7.png" type="image/x-icon">
@elseif(isset($logo8))
    <link rel="shortcut icon" href="/img/logo/fav-logo8.png" type="image/x-icon">
@elseif(isset($logo9))
    <link rel="shortcut icon" href="/img/logo/fav-logo9.png" type="image/x-icon">
@elseif(isset($logo10))
    <link rel="shortcut icon" href="/img/logo/fav-logo10.png" type="image/x-icon">
@else
    <link rel="shortcut icon" href="/img/logo/fav-logo3.png" type="image/x-icon">
@endif

