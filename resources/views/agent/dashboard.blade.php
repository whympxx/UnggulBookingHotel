@extends('layouts.dashboard')

@section('title', 'Agent Dashboard')

@section('content')
    {{-- Dashboard --}}
    <section id="dashboard" class="dash-section active">
        <div class="panel reveal" style="margin-bottom:1.5rem;background:linear-gradient(135deg,var(--brand),var(--brand-2));color:#fff;border:0;position:relative;overflow:hidden">
            <h2 style="margin:0">Halo, {{ $agent->name }} 👋</h2>
            <p style="margin:.3rem 0 0;color:#e0e7ff">Berikut ringkasan performa hotel Anda.</p>
            <div style="position:absolute;right:40px;top:50%;transform:translateY(-50%);perspective:500px" class="hide-mobile" aria-hidden="true">
                <div class="cube" style="width:70px;height:70px">
                    @foreach (['fa-hotel', 'fa-key', 'fa-bed', 'fa-star', 'fa-chart-line', 'fa-coins'] as $i => $icon)
                        <div class="f{{ $i + 1 }}" style="font-size:1.3rem;transform:{{ ['translateZ(35px)', 'rotateY(180deg) translateZ(35px)', 'rotateY(90deg) translateZ(35px)', 'rotateY(-90deg) translateZ(35px)', 'rotateX(90deg) translateZ(35px)', 'rotateX(-90deg) translateZ(35px)'][$i] }}"><i class="fas {{ $icon }}"></i></div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat reveal" data-tilt="10" style="--c:#4f46e5"><div class="ico"><i class="fas fa-hotel"></i></div><div class="value" id="statHotels">{{ $totalHotels }}</div><div class="label">Total Hotel</div></div>
            <div class="stat reveal reveal-delay-1" data-tilt="10" style="--c:#f59e0b"><div class="ico"><i class="fas fa-calendar-check"></i></div><div class="value">{{ $totalBookings }}</div><div class="label">Total Pemesanan</div></div>
            <div class="stat reveal reveal-delay-2" data-tilt="10" style="--c:#10b981"><div class="ico"><i class="fas fa-sack-dollar"></i></div><div class="value">{{ rupiah($totalRevenue) }}</div><div class="label">Pendapatan (lunas)</div></div>
        </div>

        <div class="panel reveal" style="margin-top:1.5rem">
            <div class="panel-head"><h3><i class="fas fa-clock text-gold"></i> Pemesanan terbaru</h3><a href="#bookings" data-section="bookings" class="btn btn-outline btn-sm">Lihat semua</a></div>
            @forelse ($recentBookings->take(5) as $booking)
                <div class="room-row">
                    <div><strong>{{ $booking->hotel->name }}</strong><br><span class="muted small">{{ $booking->roomType?->name ?? '-' }} · {{ $booking->customer_name }} · {{ $booking->check_in->translatedFormat('d M Y') }}</span></div>
                    <span class="badge badge-{{ $booking->status }}">{{ $booking->statusLabel() }}</span>
                </div>
            @empty
                <p class="empty">Belum ada pemesanan.</p>
            @endforelse
        </div>
    </section>

    {{-- Tambah hotel --}}
    <section id="add-hotel" class="dash-section">
        <form class="panel" id="addHotelForm" enctype="multipart/form-data">
            <div class="panel-head"><h3><i class="fas fa-plus text-gold"></i> Tambah hotel baru</h3><span class="muted small">Otomatis mendapat tipe kamar Standard, Deluxe & Suite</span></div>
            <div class="form-grid">
                <div class="field"><label>Nama hotel</label><input type="text" name="name" required maxlength="150" placeholder="Masukkan nama hotel"></div>
                <div class="field"><label>Lokasi</label><input type="text" name="location" required maxlength="150" placeholder="Kota / alamat"></div>
                <div class="field"><label>Harga / malam (Rp)</label><input type="number" name="price" min="10000" step="1000" required placeholder="750000"></div>
                <div class="field"><label>Rating</label>
                    <select name="rating" required><option value="">Pilih rating</option>@foreach (range(1, 5) as $r)<option value="{{ $r }}">{{ $r }} Bintang</option>@endforeach</select></div>
                <div class="field"><label>Telepon</label><input type="tel" name="phone" placeholder="Nomor telepon hotel"></div>
                <div class="field"><label>Gambar hotel</label><input type="file" name="image" accept="image/*" required id="hotelImage"></div>
                <div class="field full"><label>Deskripsi</label><textarea name="description" required placeholder="Deskripsi hotel, fasilitas, dan informasi penting lainnya"></textarea></div>
            </div>
            <img id="previewImg" alt="" style="display:none;max-height:180px;border-radius:14px;margin-top:1rem">
            <div style="margin-top:1rem;display:flex;gap:.5rem">
                <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> Tambah Hotel</button>
                <button type="reset" class="btn btn-outline"><i class="fas fa-rotate-left"></i> Reset</button>
            </div>
            <div id="formMessage" class="flash hidden"></div>
        </form>
    </section>

    {{-- Kelola hotel --}}
    <section id="manage-hotels" class="dash-section">
        <div class="panel">
            <div class="panel-head">
                <h3><i class="fas fa-building text-gold"></i> Kelola hotel</h3>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                    <div class="input-icon"><i class="fas fa-magnifying-glass"></i><input class="input" id="searchHotel" placeholder="Cari hotel..." style="padding-left:2.6rem"></div>
                    <select id="ratingFilter" class="select" style="width:auto">
                        <option value="">Semua rating</option>@foreach (range(5, 1) as $r)<option value="{{ $r }}">{{ $r }} Bintang</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-auto" id="hotelsGrid"><div class="empty">Memuat...</div></div>
        </div>
    </section>

    {{-- Pemesanan --}}
    <section id="bookings" class="dash-section">
        <div class="panel">
            <div class="panel-head"><h3><i class="fas fa-calendar-check text-gold"></i> Riwayat pesanan</h3></div>
            <div class="table-wrap">
                <table class="table">
                    <thead><tr><th>Kode</th><th>Hotel</th><th>Kamar</th><th>Tamu</th><th>Menginap</th><th>Total</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($recentBookings as $booking)
                            <tr>
                                <td><strong>{{ $booking->code }}</strong></td>
                                <td>{{ $booking->hotel->name }}</td>
                                <td>{{ $booking->roomType?->name ?? '-' }}</td>
                                <td>{{ $booking->customer_name }}</td>
                                <td>{{ $booking->check_in->format('d/m/Y') }} – {{ $booking->check_out->format('d/m/Y') }}</td>
                                <td>{{ rupiah($booking->total) }}</td>
                                <td><span class="badge badge-{{ $booking->status }}">{{ $booking->statusLabel() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="empty">Belum ada pemesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Laporan --}}
    <section id="reports" class="dash-section">
        <div class="grid grid-2">
            <div class="panel">
                <div class="panel-head"><h3><i class="fas fa-calendar text-gold"></i> Laporan bulan ini</h3><button class="btn btn-primary btn-sm" data-report="monthly">Tampilkan</button></div>
                <div id="monthlyResult" class="muted small">Klik "Tampilkan" untuk memuat laporan.</div>
            </div>
            <div class="panel">
                <div class="panel-head"><h3><i class="fas fa-sack-dollar text-gold"></i> Pendapatan per hotel</h3><button class="btn btn-primary btn-sm" data-report="revenue">Tampilkan</button></div>
                <div id="revenueResult" class="muted small">Klik "Tampilkan" untuk memuat laporan.</div>
            </div>
        </div>
    </section>

    {{-- Modal edit hotel --}}
    <div class="modal" id="editHotelModal" role="dialog" aria-modal="true">
        <form class="modal-card" id="editHotelForm" enctype="multipart/form-data">
            <div class="modal-head"><h3 style="margin:0">Edit hotel</h3><button type="button" class="icon-btn" data-modal-close aria-label="Tutup"><i class="fas fa-xmark"></i></button></div>
            <input type="hidden" id="editHotelId">
            <div class="form-grid">
                <div class="field"><label>Nama hotel</label><input type="text" name="name" id="editName" required></div>
                <div class="field"><label>Lokasi</label><input type="text" name="location" id="editLocation" required></div>
                <div class="field"><label>Harga / malam</label><input type="number" name="price" id="editPrice" min="10000" required></div>
                <div class="field"><label>Rating</label><input type="number" name="rating" id="editRating" min="1" max="5" step="0.1" required></div>
                <div class="field"><label>Telepon</label><input type="text" name="phone" id="editPhone"></div>
                <div class="field"><label>Ganti gambar (opsional)</label><input type="file" name="image" accept="image/*"></div>
                <div class="field full"><label>Deskripsi</label><textarea name="description" id="editDescription" rows="5" required></textarea></div>
            </div>
            <div id="editFormMessage" class="field-error" style="margin-top:.6rem"></div>
            <div style="margin-top:1rem;display:flex;gap:.5rem;justify-content:flex-end">
                <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        window.AgentRoutes = {
            hotels: @json(route('agent.hotels.index')),
            reports: @json(route('agent.reports')),
        };
    </script>
    <script src="{{ asset('js/agent-dashboard.js') }}?v=2"></script>
@endpush
