@extends('layouts.dashboard')

@section('title', 'Hotel & Lokasi')

@section('content')
    <div class="panel reveal" id="hotelForm" style="display:{{ $editing || $errors->any() ? 'block' : 'none' }};margin-bottom:1.5rem">
        <form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('admin.hotels.update', $editing->id) : route('admin.hotels.store') }}">
            @csrf
            @if ($editing) @method('PUT') @endif
            <div class="panel-head"><h3>{{ $editing ? 'Edit '.$editing->name : 'Tambah Hotel' }}</h3></div>
            <div class="form-grid">
                <div class="field"><label>Nama hotel</label><input name="name" value="{{ old('name', $editing?->name) }}" required></div>
                <div class="field"><label>Lokasi</label><input name="location" value="{{ old('location', $editing?->location) }}" required></div>
                <div class="field"><label>Harga / malam (Rp)</label><input type="number" name="price" min="10000" value="{{ old('price', $editing?->price) }}" required></div>
                <div class="field"><label>Rating (0-5)</label><input type="number" step="0.1" min="0" max="5" name="rating" value="{{ old('rating', $editing?->rating ?? 4.5) }}" required></div>
                <div class="field"><label>Agent</label>
                    <select name="agent_id">
                        <option value="">- Tanpa agent -</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" @selected(old('agent_id', $editing?->agent_id) == $agent->id)>{{ $agent->name }}</option>
                        @endforeach
                    </select></div>
                <div class="field"><label>Status</label>
                    <select name="status">
                        <option value="active" @selected(old('status', $editing?->status) === 'active')>Aktif</option>
                        <option value="inactive" @selected(old('status', $editing?->status) === 'inactive')>Nonaktif</option>
                    </select></div>
                <div class="field"><label>Foto {{ $editing ? '(opsional)' : '' }}</label><input type="file" name="image" accept="image/*" {{ $editing ? '' : 'required' }}></div>
                <div class="field full"><label>Deskripsi</label><textarea name="description" rows="4">{{ old('description', $editing?->description) }}</textarea></div>
            </div>
            <div style="margin-top:1rem;display:flex;gap:.5rem">
                <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> {{ $editing ? 'Update' : 'Simpan' }}</button>
                <a href="{{ route('admin.hotels.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>

    <div class="panel reveal">
        <div class="panel-head">
            <h3>{{ $hotels->count() }} hotel</h3>
            @unless ($editing)
                <button class="btn btn-primary btn-sm" onclick="document.getElementById('hotelForm').style.display='block';window.scrollTo({top:0,behavior:'smooth'})"><i class="fas fa-plus"></i> Tambah Hotel</button>
            @endunless
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Hotel</th><th>Lokasi</th><th>Harga</th><th>Rating</th><th>Agent</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($hotels as $hotel)
                        <tr>
                            <td><div style="display:flex;align-items:center;gap:.7rem"><img src="{{ $hotel->imageUrl() }}" alt="" class="thumb"><strong>{{ $hotel->name }}</strong></div></td>
                            <td>{{ $hotel->location }}</td>
                            <td>{{ $hotel->formattedPrice() }}</td>
                            <td><i class="fas fa-star" style="color:var(--gold-2)"></i> {{ number_format($hotel->rating, 1) }}</td>
                            <td>{{ $hotel->agent?->name ?? '-' }}</td>
                            <td><span class="badge badge-{{ $hotel->status }}">{{ $hotel->status === 'active' ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="actions">
                                <a href="{{ route('hotels.show', $hotel) }}" class="btn btn-outline btn-sm" title="Lihat" target="_blank"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.hotels.index', ['edit' => $hotel->id]) }}" class="btn btn-ghost btn-sm" title="Edit"><i class="fas fa-pen"></i></a>
                                <form method="POST" action="{{ route('admin.hotels.destroy', $hotel->id) }}" class="inline-form" onsubmit="return confirm('Hapus hotel ini beserta kamar & pesanannya?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
