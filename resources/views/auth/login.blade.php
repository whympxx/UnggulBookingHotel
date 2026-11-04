@extends('layouts.auth')

@section('title', $title)
@section('visual-title', ['user' => 'Selamat datang kembali!', 'agent' => 'Kelola properti Anda.', 'admin' => 'Panel administrator.'][$role])

@php $prefix = $role === 'user' ? '' : $role.'.'; @endphp

@section('content')
    @include('partials.role-tabs', ['mode' => 'login'])

    <h1 style="margin-top:1.5rem">{{ $title }}</h1>
    <p class="muted">Masuk untuk melanjutkan.</p>

    @include('partials.flash', ['showErrors' => false])

    <form method="POST" action="{{ route($prefix.'login') }}" novalidate>
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <div class="input-icon"><i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@email.com"></div>
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label for="password">Password</label>
            <div class="input-icon"><i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                <button type="button" class="toggle-pass" aria-label="Lihat password"><i class="fas fa-eye"></i></button></div>
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center">
            <label class="check"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
            <a href="{{ route('password.request') }}" class="small">Lupa password?</a>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Masuk <i class="fas fa-arrow-right"></i></button>
    </form>

    @if ($role !== 'admin' || filled(config('app.admin_registration_code')))
        <p class="muted" style="text-align:center;margin-top:1.5rem">Belum punya akun? <a href="{{ route($prefix.'register') }}">Daftar sekarang</a></p>
    @endif
@endsection
