@extends('layouts.plain')

@section('title', 'Maintenance')

@section('content')
    <section class="hero" style="margin-top:0;padding-top:0;min-height:100vh;text-align:center">
        <div class="container" style="position:relative;z-index:2">
            <div style="perspective:600px;display:flex;justify-content:center;margin-bottom:2rem">
                <div class="cube">
                    <div class="f1"><i class="fas fa-screwdriver-wrench"></i></div><div class="f2"><i class="fas fa-hotel"></i></div>
                    <div class="f3"><i class="fas fa-gear"></i></div><div class="f4"><i class="fas fa-hammer"></i></div>
                    <div class="f5"><i class="fas fa-star"></i></div><div class="f6"><i class="fas fa-key"></i></div>
                </div>
            </div>
            <h1>{{ $site['site_title'] }} sedang dalam perawatan</h1>
            <p class="lead" style="margin:auto">Silakan kembali beberapa saat lagi. Hubungi kami di {{ $site['email'] }} / {{ $site['phone'] }}.</p>
        </div>
    </section>
@endsection
