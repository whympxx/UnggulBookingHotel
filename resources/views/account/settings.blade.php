@extends('layouts.account')

@section('title', __('ui.settings'))
@section('page-title', __('ui.settings'))

@section('account')
    <div class="grid grid-2">
        @foreach ([
            ['profile.edit', 'fa-user-pen', __('ui.edit_profile'), 'Ubah nama, email, nomor telepon, dan foto profil.'],
            ['account.security', 'fa-shield-halved', __('ui.account_security'), 'Lihat ringkasan data akun Anda.'],
            ['password.edit', 'fa-key', __('ui.change_password'), 'Perbarui password secara berkala agar akun aman.'],
            ['language', 'fa-language', __('ui.language'), 'Pilih bahasa tampilan: Indonesia, English, 日本語, 中文.'],
        ] as [$route, $icon, $title, $text])
            <a href="{{ route($route) }}" class="feature" data-tilt="8" style="color:inherit">
                <div class="ico"><i class="fas {{ $icon }}"></i></div>
                <h3>{{ $title }}</h3>
                <p>{{ $text }}</p>
            </a>
        @endforeach
        <div class="feature" style="display:flex;flex-direction:column;gap:.6rem;justify-content:center">
            <h3 style="margin:0">Mode tampilan</h3>
            <button type="button" class="btn btn-outline" onclick="toggleTheme()"><i class="fas fa-moon" data-theme-icon></i> Ganti terang / gelap</button>
        </div>
        <div class="feature" style="display:flex;flex-direction:column;gap:.6rem;justify-content:center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <input type="hidden" name="switch" value="1">
                <button type="submit" class="btn btn-outline btn-block"><i class="fas fa-repeat"></i> {{ __('ui.switch_account') }}</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-arrow-right-from-bracket"></i> {{ __('ui.logout') }}</button>
            </form>
        </div>
    </div>
@endsection
