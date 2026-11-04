@extends('layouts.dashboard')

@section('title', 'Tipe Kamar')

@section('content')
    <div class="panel reveal" style="margin-bottom:1.5rem">
        <div class="panel-head"><h3><i class="fas fa-chart-column text-gold"></i> Kamar tersedia & dipakai per hotel</h3></div>
        <canvas id="roomsStatusChart" height="100"></canvas>
    </div>

    <div class="grid grid-2">
        @foreach ($hotels as $hotel)
            <div class="panel reveal">
                <div class="panel-head">
                    <div style="display:flex;gap:.8rem;align-items:center">
                        <img src="{{ $hotel->imageUrl() }}" alt="" class="thumb">
                        <div><strong>{{ $hotel->name }}</strong><br><span class="muted small">{{ $hotel->formattedPrice() }}/malam · {{ $hotel->totalRooms() }} kamar</span></div>
                    </div>
                </div>

                @foreach ($hotel->roomTypes as $room)
                    <form id="room-{{ $room->id }}" method="POST" action="{{ route('admin.rooms.update', $room) }}">@csrf @method('PUT')</form>
                    <form id="room-del-{{ $room->id }}" method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Hapus tipe kamar ini?')">@csrf @method('DELETE')</form>
                @endforeach
                <form id="room-new-{{ $hotel->id }}" method="POST" action="{{ route('admin.rooms.store', $hotel->id) }}">@csrf</form>

                <div class="table-wrap">
                    <table class="table">
                        <thead><tr><th>Tipe</th><th>Jumlah</th><th>× Harga</th><th>Terpakai</th><th></th></tr></thead>
                        <tbody>
                            @foreach ($hotel->roomTypes as $room)
                                @php $f = 'room-'.$room->id; @endphp
                                <tr>
                                    <td><input form="{{ $f }}" name="name" value="{{ $room->name }}" required style="width:100%;min-width:110px"><br><span class="muted small">{{ rupiah($room->pricePerNight()) }}</span></td>
                                    <td><input form="{{ $f }}" type="number" name="total_rooms" min="1" value="{{ $room->total_rooms }}" required style="width:70px"></td>
                                    <td><input form="{{ $f }}" type="number" name="price_multiplier" step="0.1" min="0.5" max="10" value="{{ $room->price_multiplier }}" required style="width:70px"></td>
                                    <td>{{ $room->occupiedCount() }}</td>
                                    <td class="actions">
                                        <button form="{{ $f }}" class="btn btn-success btn-sm" title="Simpan"><i class="fas fa-floppy-disk"></i></button>
                                        <button form="room-del-{{ $room->id }}" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            @php $f = 'room-new-'.$hotel->id; @endphp
                            <tr>
                                <td><input form="{{ $f }}" name="name" placeholder="Tipe baru" required style="width:100%;min-width:110px"></td>
                                <td><input form="{{ $f }}" type="number" name="total_rooms" min="1" value="1" required style="width:70px"></td>
                                <td><input form="{{ $f }}" type="number" name="price_multiplier" step="0.1" min="0.5" max="10" value="1" required style="width:70px"></td>
                                <td></td>
                                <td><button form="{{ $f }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
<script>
    const rows = @json($chart);
    new Chart(document.getElementById('roomsStatusChart'), {
        type: 'bar',
        data: {
            labels: rows.map(r => r.name),
            datasets: [
                { label: 'Tersedia', data: rows.map(r => r.available), backgroundColor: '#10b981', borderRadius: 8 },
                { label: 'Dipakai', data: rows.map(r => r.occupied), backgroundColor: '#f43f5e', borderRadius: 8 },
            ],
        },
        options: { scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } } } },
    });
</script>
@endpush
