@extends('layouts.app')

@section('title', 'Wishlist')
@section('page-title', 'Wishlist Saya')
@section('page-subtitle', 'Hotel yang Anda simpan untuk dipesan nanti.')

@section('content')
    <section class="section-sm">
        <div class="container">
            @if ($hotels->isEmpty())
                <div class="empty card reveal">
                    <i class="far fa-heart"></i>
                    <h3>Wishlist masih kosong</h3>
                    <p>Tekan ikon hati pada kartu hotel untuk menyimpannya di sini.</p>
                    <a href="{{ route('services') }}" class="btn btn-primary">Jelajahi hotel</a>
                </div>
            @else
                <div class="grid grid-auto">
                    @foreach ($hotels as $hotel)
                        @include('partials.hotel-card', ['wishlistIds' => $hotels->pluck('id')->all()])
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
