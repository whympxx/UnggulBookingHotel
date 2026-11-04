@extends('layouts.app')

@section('content')
    <section class="section-sm">
        <div class="container" style="display:grid;grid-template-columns:260px 1fr;gap:1.5rem;align-items:start" id="accountLayout">
            <aside class="card reveal sticky" style="padding:1rem">
                @auth
                    <div style="text-align:center;padding:.5rem 0 1rem">
                        <img src="{{ auth()->user()->avatarUrl() }}" alt="" class="avatar avatar-lg" style="margin:auto">
                        <strong style="display:block;margin-top:.6rem">{{ auth()->user()->name }}</strong>
                        <span class="chip" style="margin-top:.3rem">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                @endauth
                <nav class="dash-nav" style="--x:0">
                    @foreach (array_filter([
                        auth()->check() ? ['settings', 'fa-gear', __('ui.settings')] : null,
                        auth()->check() ? ['profile.edit', 'fa-user-pen', __('ui.edit_profile')] : null,
                        auth()->check() ? ['account.security', 'fa-shield-halved', __('ui.account_security')] : null,
                        auth()->check() ? ['password.edit', 'fa-key', __('ui.change_password')] : null,
                        ['language', 'fa-language', __('ui.language')],
                    ]) as [$route, $icon, $label])
                        <a href="{{ route($route) }}" class="{{ request()->routeIs($route) ? 'active' : '' }}" style="color:{{ request()->routeIs($route) ? '#fff' : 'var(--text)' }}">
                            <i class="fas {{ $icon }}"></i> {{ $label }}
                        </a>
                    @endforeach
                </nav>
            </aside>
            <div class="reveal">
                @yield('account')
            </div>
        </div>
    </section>
    <style>@media (max-width: 860px) { #accountLayout { grid-template-columns: 1fr !important; } #accountLayout .sticky { position: static; } }</style>
@endsection
