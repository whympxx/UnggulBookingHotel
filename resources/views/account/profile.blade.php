@extends('layouts.account')

@section('title', 'Profil')
@section('page-title', __('ui.edit_profile'))

@section('account')
    <form class="card" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display:flex;align-items:center;gap:1.2rem;margin-bottom:1.5rem;flex-wrap:wrap">
            <div data-tilt="15" style="border-radius:50%"><img src="{{ $user->avatarUrl() }}" alt="Foto profil" class="avatar avatar-lg" id="avatarPreview"></div>
            <label class="btn btn-outline" for="avatar"><i class="fas fa-camera"></i> Ganti foto</label>
            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">
            <span class="muted small">JPG, PNG, WEBP maks. 2MB</span>
        </div>
        <div class="form-grid">
            <div class="field"><label for="name">Nama</label><input id="name" name="name" value="{{ old('name', $user->name) }}" required></div>
            <div class="field"><label for="email">Email</label><input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required></div>
            <div class="field"><label for="phone">Nomor telepon</label><input id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+62 812 3456 7890"></div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:1.2rem"><i class="fas fa-floppy-disk"></i> Simpan profil</button>
    </form>
@endsection

@push('scripts')
<script>
    document.getElementById('avatar').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) document.getElementById('avatarPreview').src = URL.createObjectURL(file);
    });
</script>
@endpush
