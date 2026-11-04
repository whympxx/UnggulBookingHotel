@extends('layouts.auth')

@section('title', 'Lupa Password')
@section('visual-title', 'Tenang, kami bantu pulihkan akun Anda.')

@section('content')
    <h1>Lupa password?</h1>
    <p class="muted">Masukkan email akun Anda. Kami akan mengirim link untuk membuat password baru.</p>

    @include('partials.flash', ['showErrors' => false])

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <div class="input-icon"><i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"></div>
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-paper-plane"></i> Kirim link reset</button>
    </form>
    <p class="muted" style="text-align:center;margin-top:1.5rem">Ingat password? <a href="{{ route('auth.select') }}">Masuk</a></p>
@endsection
