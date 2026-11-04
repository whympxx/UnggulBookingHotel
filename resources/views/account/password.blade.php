@extends('layouts.account')

@section('title', __('ui.change_password'))
@section('page-title', __('ui.change_password'))

@section('account')
    <form class="card" action="{{ route('password.change') }}" method="POST" style="max-width:560px">
        @csrf
        @method('PUT')
        <div style="display:grid;gap:1rem">
            @foreach ([
                ['current_password', 'Password lama', 'current-password'],
                ['password', 'Password baru (min. 8 karakter)', 'new-password'],
                ['password_confirmation', 'Konfirmasi password baru', 'new-password'],
            ] as [$field, $label, $auto])
                <div class="field">
                    <label for="{{ $field }}">{{ $label }}</label>
                    <div class="input-icon"><i class="fas fa-lock"></i>
                        <input type="password" id="{{ $field }}" name="{{ $field }}" required autocomplete="{{ $auto }}">
                        <button type="button" class="toggle-pass" aria-label="Lihat password"><i class="fas fa-eye"></i></button></div>
                    @error($field) <span class="field-error">{{ $message }}</span> @enderror
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:1.2rem"><i class="fas fa-check"></i> Konfirmasi</button>
    </form>
@endsection
