<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('partials.head')
    <title>@yield('title') - {{ $site['site_title'] }}</title>
    @stack('styles')
</head>
<body class="@yield('body-class')">
    @yield('content')
    @stack('scripts')
</body>
</html>
