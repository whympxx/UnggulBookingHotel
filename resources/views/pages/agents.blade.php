@extends('layouts.app')

@section('title', 'Agent')
@section('page-title', 'Agent Kami')
@section('page-subtitle', 'Kenali agent profesional yang mengelola setiap properti.')

@section('content')
    <section class="section-sm">
        <div class="container">
            @forelse ($agents as $agent)
                <div class="card reveal" style="margin-bottom:2rem" id="agent-{{ $agent->id }}">
                    <div style="display:flex;gap:1.5rem;flex-wrap:wrap;align-items:center;margin-bottom:1.5rem">
                        <div data-tilt="15" style="border-radius:50%">
                            <img src="{{ $agent->avatarUrl() }}" alt="{{ $agent->name }}" class="avatar avatar-lg" style="border-width:3px">
                        </div>
                        <div style="flex:1;min-width:240px">
                            <h2 style="margin:0">{{ $agent->name }}</h2>
                            @if ($agent->agency)<span class="chip"><i class="fas fa-building"></i> {{ $agent->agency }}</span>@endif
                            <p class="muted" style="margin:.6rem 0 0">{{ $agent->bio }}</p>
                        </div>
                        <div class="chips" style="flex-direction:column;align-items:flex-start">
                            @if ($agent->location)<span class="meta"><i class="fas fa-location-dot"></i> {{ \Illuminate\Support\Str::limit($agent->location, 50) }}</span>@endif
                            @if ($agent->phone)<a class="meta" href="tel:{{ $agent->phone }}"><i class="fas fa-phone"></i> {{ $agent->phone }}</a>@endif
                            <a class="meta" href="mailto:{{ $agent->email }}"><i class="fas fa-envelope"></i> {{ $agent->email }}</a>
                            <div class="socials" style="margin-top:.3rem">
                                @foreach (['facebook' => 'fab fa-facebook-f', 'instagram' => 'fab fa-instagram', 'x' => 'fab fa-x-twitter'] as $platform => $icon)
                                    @if (($agent->social[$platform] ?? '#') !== '#' && filled($agent->social[$platform] ?? null))
                                        <a class="btn btn-ghost btn-icon" href="{{ $agent->social[$platform] }}" target="_blank" rel="noopener"><i class="{{ $icon }}"></i></a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <h3 style="font-size:1rem" class="muted">{{ $agent->hotels->count() }} properti oleh {{ $agent->name }}</h3>
                    @if ($agent->hotels->isEmpty())
                        <p class="muted">Belum ada properti.</p>
                    @else
                        <div class="grid grid-auto">
                            @foreach ($agent->hotels as $hotel)
                                @php $hotel->setRelation('agent', $agent); @endphp
                                @include('partials.hotel-card', ['wishlistIds' => []])
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty card"><i class="fas fa-user-tie"></i>Belum ada agent.</div>
            @endforelse
        </div>
    </section>
@endsection
