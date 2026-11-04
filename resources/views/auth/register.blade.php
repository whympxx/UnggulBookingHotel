@extends('layouts.auth')

@php
    $prefix = $role === 'user' ? '' : $role.'.';
    $title = ['user' => 'Buat akun', 'agent' => 'Daftar sebagai Agent', 'admin' => 'Registrasi Admin'][$role];
    $fields = [
        ['name', 'Nama lengkap', 'text', 'fa-user', 'name'],
        ['email', 'Email', 'email', 'fa-envelope', 'email'],
    ];
    if ($role === 'agent') {
        $fields[] = ['agency', 'Nama agensi', 'text', 'fa-building', 'organization'];
    }
    if ($role === 'admin') {
        $fields[] = ['admin_code', 'Kode registrasi admin', 'password', 'fa-user-shield', 'off'];
    }
    $fields[] = ['password', 'Password (min. 8 karakter)', 'password', 'fa-lock', 'new-password'];
    $fields[] = ['password_confirmation', 'Konfirmasi password', 'password', 'fa-lock', 'new-password'];
@endphp

@section('title', $title)
@section('visual-title', $role === 'agent' ? 'Kembangkan bisnis hotel Anda bersama kami.' : 'Bergabung dan nikmati promo eksklusif.')

@section('content')
    @include('partials.role-tabs', ['mode' => 'register'])

    <h1 style="margin-top:1.5rem">{{ $title }}</h1>
    <p class="muted">Hanya butuh satu menit.</p>

    <form method="POST" action="{{ route($prefix.'register') }}" novalidate>
        @csrf
        @foreach ($fields as [$field, $label, $type, $icon, $auto])
            <div class="field">
                <label for="{{ $field }}">{{ $label }}</label>
                <div class="input-icon"><i class="fas {{ $icon }}"></i>
                    <input type="{{ $type }}" id="{{ $field }}" name="{{ $field }}" required autocomplete="{{ $auto }}" @if ($type !== 'password') value="{{ old($field) }}" @endif>
                    @if ($type === 'password')<button type="button" class="toggle-pass" aria-label="Lihat password"><i class="fas fa-eye"></i></button>@endif
                </div>
                @error($field) <span class="field-error">{{ $message }}</span> @enderror
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary btn-lg btn-block">Daftar <i class="fas fa-arrow-right"></i></button>
    </form>

    <p class="muted" style="text-align:center;margin-top:1.5rem">Sudah punya akun? <a href="{{ route($prefix.'login') }}">Masuk</a></p>
@endsection
