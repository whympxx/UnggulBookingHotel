@extends('layouts.dashboard')

@section('title', 'Kode Promo')

@section('content')
    <div class="panel reveal" style="margin-bottom:1.5rem">
        <form method="POST" action="{{ $editing ? route('admin.promos.update', $editing) : route('admin.promos.store') }}">
            @csrf
            @if ($editing) @method('PUT') @endif
            <div class="panel-head"><h3>{{ $editing ? 'Edit '.$editing->code : 'Buat kode promo' }}</h3></div>
            <div class="form-grid">
                <div class="field"><label>Kode</label><input name="code" value="{{ old('code', $editing?->code) }}" required style="text-transform:uppercase" placeholder="HEMAT20"></div>
                <div class="field"><label>Tipe</label>
                    <select name="type">
                        <option value="percent" @selected(old('type', $editing?->type) === 'percent')>Persen (%)</option>
                        <option value="fixed" @selected(old('type', $editing?->type) === 'fixed')>Nominal (Rp)</option>
                    </select></div>
                <div class="field"><label>Nilai</label><input type="number" name="value" min="1" value="{{ old('value', $editing?->value) }}" required></div>
                <div class="field"><label>Maks. potongan (Rp, untuk persen)</label><input type="number" name="max_discount" min="0" value="{{ old('max_discount', $editing?->max_discount) }}"></div>
                <div class="field"><label>Min. transaksi (Rp)</label><input type="number" name="min_amount" min="0" value="{{ old('min_amount', $editing?->min_amount ?? 0) }}"></div>
                <div class="field"><label>Kuota pemakaian</label><input type="number" name="max_uses" min="1" value="{{ old('max_uses', $editing?->max_uses) }}" placeholder="Tak terbatas"></div>
                <div class="field"><label>Berlaku sampai</label><input type="date" name="expires_at" value="{{ old('expires_at', $editing?->expires_at?->toDateString()) }}"></div>
                <div class="field"><label>Deskripsi</label><input name="description" value="{{ old('description', $editing?->description) }}"></div>
                <div class="field" style="justify-content:flex-end"><label class="check"><input type="checkbox" name="active" value="1" @checked(old('active', $editing?->active ?? true))> Aktif</label></div>
            </div>
            <div style="margin-top:1rem;display:flex;gap:.5rem">
                <button class="btn btn-primary"><i class="fas fa-floppy-disk"></i> {{ $editing ? 'Update' : 'Simpan' }}</button>
                @if ($editing)<a href="{{ route('admin.promos.index') }}" class="btn btn-outline">Batal</a>@endif
            </div>
        </form>
    </div>

    <div class="grid grid-auto">
        @forelse ($promos as $promo)
            @php $expired = $promo->expires_at && $promo->expires_at->isPast(); @endphp
            <div class="panel reveal" data-tilt="8" style="position:relative;overflow:hidden;border-style:dashed;border-width:2px">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span class="pay-code" style="padding:.5rem .9rem;font-size:1.05rem;border-width:0;background:var(--brand-soft);color:var(--brand)">{{ $promo->code }}</span>
                    <span class="badge badge-{{ $promo->active && ! $expired ? 'active' : 'inactive' }}">{{ $expired ? 'Kadaluarsa' : ($promo->active ? 'Aktif' : 'Nonaktif') }}</span>
                </div>
                <div style="font-size:1.6rem;font-weight:700;margin:.8rem 0 .2rem">{{ $promo->label() }}</div>
                <p class="muted small" style="margin:0">{{ $promo->description }}</p>
                <div class="chips" style="margin:.8rem 0">
                    <span class="chip">Min. {{ rupiah($promo->min_amount) }}</span>
                    <span class="chip">Dipakai {{ $promo->used }}{{ $promo->max_uses ? '/'.$promo->max_uses : '' }}</span>
                    @if ($promo->expires_at)<span class="chip">s/d {{ $promo->expires_at->translatedFormat('d M Y') }}</span>@endif
                </div>
                <div class="actions">
                    <a href="{{ route('admin.promos.index', ['edit' => $promo->id]) }}" class="btn btn-ghost btn-sm"><i class="fas fa-pen"></i> Edit</a>
                    <form method="POST" action="{{ route('admin.promos.destroy', $promo) }}" class="inline-form" onsubmit="return confirm('Hapus kode promo ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty panel"><i class="fas fa-ticket"></i>Belum ada kode promo.</div>
        @endforelse
    </div>
@endsection
