@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <h1>Buat password baru</h1>
    <p class="muted">Gunakan minimal 8 karakter.</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="field">
            <label for="email">Email</label>
            <div class="input-icon"><i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required></div>
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label for="password">Password baru</label>
            <div class="input-icon"><i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" required autocomplete="new-password">
                <button type="button" class="toggle-pass" aria-label="Lihat password"><i class="fas fa-eye"></i></button></div>
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label for="password_confirmation">Konfirmasi password</label>
            <div class="input-icon"><i class="fas fa-lock"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"></div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Simpan password</button>
    </form>
@endsection
