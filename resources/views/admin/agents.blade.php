@extends('layouts.dashboard')

@section('title', 'Agent')

@php
    $social = fn ($key) => ($editing?->social[$key] ?? '#') !== '#' ? $editing?->social[$key] : '';
@endphp

@section('content')
    <div class="panel reveal" id="agentForm" style="display:{{ $editing || $errors->any() ? 'block' : 'none' }};margin-bottom:1.5rem">
        <form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('admin.agents.update', $editing) : route('admin.agents.store') }}">
            @csrf
            @if ($editing) @method('PUT') @endif
            <div class="panel-head"><h3>{{ $editing ? 'Edit '.$editing->name : 'Tambah Agent' }}</h3></div>
            <div class="form-grid">
                <div class="field"><label>Nama</label><input name="name" value="{{ old('name', $editing?->name) }}" required></div>
                <div class="field"><label>Email (untuk login)</label><input type="email" name="email" value="{{ old('email', $editing?->email) }}" required></div>
                <div class="field"><label>Password {{ $editing ? '(kosongkan jika tidak diganti)' : '' }}</label><input type="password" name="password" {{ $editing ? '' : 'required' }} autocomplete="new-password"></div>
                <div class="field"><label>Telepon</label><input name="phone" value="{{ old('phone', $editing?->phone) }}" required></div>
                <div class="field"><label>Agensi</label><input name="agency" value="{{ old('agency', $editing?->agency) }}"></div>
                <div class="field"><label>Lokasi</label><input name="location" value="{{ old('location', $editing?->location) }}" required></div>
                <div class="field"><label>Facebook URL</label><input type="url" name="facebook" value="{{ old('facebook', $social('facebook')) }}"></div>
                <div class="field"><label>Instagram URL</label><input type="url" name="instagram" value="{{ old('instagram', $social('instagram')) }}"></div>
                <div class="field"><label>X URL</label><input type="url" name="x" value="{{ old('x', $social('x')) }}"></div>
                <div class="field"><label>Foto</label><input type="file" name="avatar" accept="image/*"></div>
                <div class="field full"><label>Deskripsi</label><textarea name="bio" rows="3" required>{{ old('bio', $editing?->bio) }}</textarea></div>
            </div>
            <div style="margin-top:1rem;display:flex;gap:.5rem">
                <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> {{ $editing ? 'Update' : 'Simpan' }}</button>
                <a href="{{ route('admin.agents.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>

    <div class="panel-head reveal">
        <h3>{{ $agents->count() }} agent</h3>
        @unless ($editing)
            <button class="btn btn-primary btn-sm" onclick="document.getElementById('agentForm').style.display='block';window.scrollTo({top:0,behavior:'smooth'})"><i class="fas fa-plus"></i> Tambah Agent</button>
        @endunless
    </div>
    <div class="grid grid-auto">
        @forelse ($agents as $agent)
            <div class="panel reveal" data-tilt="8" style="text-align:center">
                <img src="{{ $agent->avatarUrl() }}" alt="" class="avatar avatar-lg" style="margin:0 auto .8rem">
                <strong>{{ $agent->name }}</strong>
                <div class="muted small">{{ $agent->email }}</div>
                <div class="muted small">{{ $agent->phone }}</div>
                <div class="chips" style="justify-content:center;margin:.8rem 0">
                    <span class="chip"><i class="fas fa-hotel"></i> {{ $agent->hotels_count }} hotel</span>
                    @if ($agent->agency)<span class="chip">{{ $agent->agency }}</span>@endif
                </div>
                <div class="actions" style="justify-content:center">
                    <a href="{{ route('admin.agents.index', ['edit' => $agent->id]) }}" class="btn btn-ghost btn-sm"><i class="fas fa-pen"></i> Edit</a>
                    <form method="POST" action="{{ route('admin.agents.destroy', $agent) }}" class="inline-form" onsubmit="return confirm('Hapus agent ini? Hotel miliknya akan menjadi tanpa agent.')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty panel"><i class="fas fa-user-tie"></i>Belum ada agent.</div>
        @endforelse
    </div>
@endsection
