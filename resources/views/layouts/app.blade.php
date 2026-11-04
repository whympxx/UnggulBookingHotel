<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('partials.head')
    <title>@yield('title', 'Beranda') - {{ $site['site_title'] }}</title>
    @stack('styles')
</head>
<body>
    <div class="page-loader" aria-hidden="true"><div class="loader-cube"><span></span><span></span><span></span></div></div>

    @include('partials.navbar', ['transparent' => View::hasSection('transparent-nav')])

    @yield('hero')

    <main>
        @hasSection('page-title')
            <section class="page-header">
                <span class="orb" style="width:120px;height:120px;right:10%;top:20%;background:radial-gradient(circle at 30% 30%,#fde68a,#f59e0b)"></span>
                <span class="orb" style="width:60px;height:60px;right:28%;bottom:10%;background:radial-gradient(circle at 30% 30%,#c4b5fd,#7c3aed);animation-delay:-3s"></span>
                <div class="container">
                    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a> / @yield('page-title')</div>
                    <h1>@yield('page-title')</h1>
                    @hasSection('page-subtitle')<p>@yield('page-subtitle')</p>@endif
                </div>
            </section>
        @endif

        <div class="container">
            @include('partials.flash')
        </div>

        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
