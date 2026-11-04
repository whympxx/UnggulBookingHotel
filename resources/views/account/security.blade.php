@extends('layouts.account')

@section('title', __('ui.account_security'))
@section('page-title', __('ui.account_security'))

@section('account')
    <div class="card">
        <div class="card-title"><i class="fas fa-id-card text-gold"></i> Data akun</div>
        @foreach (['Nama' => $user->name, 'Email' => $user->email, 'No. Handphone' => $user->phone ?: 'Belum diisi', 'Role' => ucfirst($user->role), 'Terdaftar sejak' => $user->created_at?->translatedFormat('d F Y')] as $label => $value)
            <div class="summary-row" style="border-bottom:1px solid var(--border);padding:.8rem 0"><span>{{ $label }}</span><strong style="color:var(--text)">{{ $value }}</strong></div>
        @endforeach
        <div style="display:flex;gap:.5rem;margin-top:1.2rem;flex-wrap:wrap">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary"><i class="fas fa-user-pen"></i> Ubah profil</a>
            <a href="{{ route('password.edit') }}" class="btn btn-outline"><i class="fas fa-key"></i> Ganti password</a>
        </div>
    </div>
@endsection
