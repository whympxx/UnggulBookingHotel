@extends('layouts.app')

@section('title', 'Jelajahi Hotel')
@section('page-title', 'Jelajahi Hotel')
@section('page-subtitle', 'Filter berdasarkan lokasi, harga, dan rating untuk menemukan hotel yang paling pas.')

@section('content')
    <section class="section-sm">
        <div class="container">
            <form method="GET" action="{{ route('services') }}" class="card glass reveal" style="margin-bottom:2rem">
                <div class="form-grid" style="grid-template-columns:repeat(auto-fit,minmax(170px,1fr));align-items:end">
                    <div class="field" style="grid-column:span 2">
                        <label for="f-search">Kata kunci</label>
                        <div class="input-icon"><i class="fas fa-magnifying-glass"></i>
                            <input id="f-search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama hotel / kota"></div>
                    </div>
                    <div class="field">
                        <label for="f-location">Lokasi</label>
                        <select id="f-location" name="location">
                            <option value="">Semua</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location }}" @selected(($filters['location'] ?? '') === $location)>{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="f-min">Harga min</label>
                        <input id="f-min" type="number" name="min_price" min="0" step="50000" value="{{ $filters['min_price'] ?? '' }}" placeholder="{{ number_format($priceRange[0], 0, ',', '.') }}">
                    </div>
                    <div class="field">
                        <label for="f-max">Harga maks</label>
                        <input id="f-max" type="number" name="max_price" min="0" step="50000" value="{{ $filters['max_price'] ?? '' }}" placeholder="{{ number_format($priceRange[1], 0, ',', '.') }}">
                    </div>
                    <div class="field">
                        <label for="f-rating">Rating min</label>
                        <select id="f-rating" name="min_rating">
                            <option value="">Semua</option>
                            @foreach ([4.5, 4, 3.5, 3] as $r)
                                <option value="{{ $r }}" @selected(($filters['min_rating'] ?? '') == $r)>{{ $r }}+ ★</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="f-sort">Urutkan</label>
                        <select id="f-sort" name="sort" onchange="this.form.submit()">
                            @foreach (['rating' => 'Rating tertinggi', 'price_asc' => 'Harga termurah', 'price_desc' => 'Harga termahal', 'name' => 'Nama A-Z'] as $value => $label)
                                <option value="{{ $value }}" @selected(($filters['sort'] ?? 'rating') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:flex;gap:.5rem">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Terapkan</button>
                        <a href="{{ route('services') }}" class="btn btn-outline" title="Reset filter"><i class="fas fa-rotate-left"></i></a>
                    </div>
                </div>
            </form>

            <p class="muted reveal">Menampilkan <strong>{{ $hotels->count() }}</strong> hotel</p>

            @if ($hotels->isEmpty())
                <div class="empty card"><i class="fas fa-magnifying-glass-location"></i>Tidak ada hotel yang cocok dengan filter. <a href="{{ route('services') }}">Reset filter</a></div>
            @else
                <div class="grid grid-auto">
                    @foreach ($hotels as $hotel)
                        @include('partials.hotel-card')
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
