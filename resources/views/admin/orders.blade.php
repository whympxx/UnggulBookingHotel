@extends('layouts.dashboard')

@section('title', 'Orders')

@section('content')
    @if ($editing)
        <form class="panel reveal" method="POST" action="{{ route('admin.orders.update', $editing) }}" style="margin-bottom:1.5rem">
            @csrf @method('PUT')
            <div class="panel-head"><h3>Edit order {{ $editing->code }}</h3><span class="muted small">Total sekarang {{ rupiah($editing->total) }} — dihitung ulang otomatis jika tanggal diubah</span></div>
            <div class="form-grid">
                <div class="field"><label>Customer</label><input name="customer_name" value="{{ old('customer_name', $editing->customer_name) }}" required></div>
                <div class="field"><label>Check-in</label><input type="date" name="check_in" value="{{ old('check_in', $editing->check_in->toDateString()) }}" required></div>
                <div class="field"><label>Check-out</label><input type="date" name="check_out" value="{{ old('check_out', $editing->check_out->toDateString()) }}" required></div>
                <div class="field"><label>Status</label>
                    <select name="status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $editing->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select></div>
            </div>
            <div style="margin-top:1rem;display:flex;gap:.5rem">
                <button class="btn btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    @endif

    <div class="panel reveal">
        <form method="GET" class="panel-head">
            <h3>{{ $orders->total() }} order</h3>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                <div class="input-icon"><i class="fas fa-magnifying-glass"></i><input class="input" name="q" value="{{ request('q') }}" placeholder="Kode / nama customer" style="padding-left:2.6rem"></div>
                <select name="status" class="select" style="width:auto" onchange="this.form.submit()">
                    <option value="">Semua status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary btn-sm">Filter</button>
            </div>
        </form>
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Kode</th><th>Customer</th><th>Hotel</th><th>Menginap</th><th>Total</th><th>Bayar</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>{{ $order->code }}</strong><br><span class="muted small">{{ $order->created_at->format('d/m/Y H:i') }}</span></td>
                            <td>{{ $order->customer_name }}<br><span class="muted small">{{ $order->customer_email }}</span></td>
                            <td>
                                @if ($order->hotel)
                                    <div style="display:flex;gap:.5rem;align-items:center"><img src="{{ $order->hotel->imageUrl() }}" alt="" class="thumb" style="width:46px;height:34px"> {{ $order->hotel->name }}</div>
                                    <span class="muted small">{{ $order->roomType?->name }}</span>
                                @else - @endif
                            </td>
                            <td>{{ $order->check_in->format('d/m/Y') }} – {{ $order->check_out->format('d/m/Y') }}<br><span class="muted small">{{ $order->nights }} malam</span></td>
                            <td>{{ rupiah($order->total) }}</td>
                            <td>{{ $order->payment?->methodLabel() ?? '-' }}@if ($order->payment?->promo_code)<br><span class="chip" style="padding:.1rem .5rem">{{ $order->payment->promo_code }}</span>@endif</td>
                            <td><span class="badge badge-{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                            <td class="actions">
                                @if ($order->payment)
                                    <a href="{{ route('payment.invoice', $order->payment) }}" class="btn btn-outline btn-sm" title="Invoice"><i class="fas fa-file-invoice"></i></a>
                                @endif
                                <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['edit' => $order->id])) }}" class="btn btn-ghost btn-sm" title="Edit"><i class="fas fa-pen"></i></a>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="empty">Belum ada order.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
@endsection
