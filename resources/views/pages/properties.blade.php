@extends('layouts.app')

@section('title', 'Properties')
@section('page-title', 'Properties')
@section('page-subtitle', 'Koleksi lengkap properti hotel yang dikelola agent profesional kami.')

@section('content')
    <section class="section-sm">
        <div class="container">
            <div class="section-head reveal">
                <div><span class="kicker">Pilihan editor</span><h2>Recommended Hotel</h2></div>
            </div>
            <div class="grid grid-3">
                @foreach ($featured as $hotel)
                    @include('partials.hotel-card')
                @endforeach
            </div>
        </div>
    </section>
    <section class="section-sm">
        <div class="container">
            <div class="section-head reveal">
                <div><span class="kicker">Semua properti</span><h2>All Hotels</h2></div>
                <a href="{{ route('services') }}" class="btn btn-outline"><i class="fas fa-filter"></i> Filter &amp; urutkan</a>
            </div>
            <div class="grid grid-auto">
                @foreach ($hotels as $hotel)
                    @include('partials.hotel-card')
                @endforeach
            </div>
        </div>
    </section>
@endsection
