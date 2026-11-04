@extends('layouts.dashboard')

@section('title', 'Dashboard')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <style>.cropper-circular .cropper-view-box, .cropper-circular .cropper-face { border-radius: 50% !important; }</style>
@endpush

@section('content')
    <div class="stat-grid">
        @foreach ([
            ['revenue', 'Total Pendapatan', 'fa-sack-dollar', '#10b981', true],
            ['orders', 'Total Orders', 'fa-receipt', '#f59e0b', false],
            ['pending_orders', 'Menunggu Bayar', 'fa-hourglass-half', '#ef4444', false],
            ['property', 'Total Hotel', 'fa-hotel', '#4f46e5', false],
            ['locations', 'Total Lokasi', 'fa-location-dot', '#0ea5e9', false],
            ['agent', 'Total Agent', 'fa-user-tie', '#7c3aed', false],
            ['kamar', 'Total Kamar', 'fa-bed', '#ec4899', false],
        ] as $i => [$key, $label, $icon, $color, $money])
            <div class="stat reveal reveal-delay-{{ $i % 4 }}" data-tilt="10" style="--c:{{ $color }}">
                <div class="ico"><i class="fas {{ $icon }}"></i></div>
                <div class="value" id="value-{{ $key }}" data-money="{{ $money ? 1 : 0 }}">{{ $money ? rupiah($stats[$key]) : $stats[$key] }}</div>
                <div class="label">{{ $label }}</div>
                @unless ($money)<canvas id="chart-{{ $key }}" width="90" height="40"></canvas>@endunless
            </div>
        @endforeach
    </div>

    <div class="grid grid-2" style="margin-top:1.5rem">
        <div class="panel reveal">
            <div class="panel-head"><h3><i class="fas fa-chart-line text-gold"></i> Pendapatan 6 bulan terakhir</h3></div>
            <canvas id="chart-revenue" height="200"></canvas>
        </div>
        <div class="panel reveal">
            <div class="panel-head">
                <h3><i class="fas fa-chart-pie text-gold"></i> Okupansi kamar hari ini</h3>
                <span class="chip"><span id="label-kamar-dipakai">{{ $stats['kamar_dipakai'] }}</span>&nbsp;dipakai · <span id="label-kamar-tersedia">{{ $stats['kamar_tersedia'] }}</span>&nbsp;tersedia</span>
            </div>
            <div style="max-width:260px;margin:auto"><canvas id="chart-kamar-bar"></canvas></div>
        </div>
    </div>
    <div class="panel reveal" style="margin-top:1.5rem">
        <div class="panel-head"><h3><i class="fas fa-chart-column text-gold"></i> Kamar tersedia & dipakai per hotel (realtime)</h3><span class="chip"><i class="fas fa-circle" style="color:var(--success);font-size:.5rem"></i> Live · 5 detik</span></div>
        <canvas id="chart-kamar-per-hotel" height="110"></canvas>
    </div>

    {{-- Modal upload foto profil --}}
    <div class="modal" id="profileModal" role="dialog" aria-modal="true">
        <div class="modal-card" style="max-width:420px">
            <div class="modal-head"><h3 style="margin:0">Ubah Foto Profil</h3><button type="button" class="icon-btn" data-modal-close aria-label="Tutup"><i class="fas fa-xmark"></i></button></div>
            <input type="file" id="profileFileInput" accept="image/*" class="input">
            <div style="max-width:280px;margin:1rem auto"><img id="profilePreview" src="" alt="" style="max-width:100%;display:none"></div>
            <button type="button" id="uploadBtn" class="btn btn-primary btn-block">Upload</button>
            <div id="profileUploadMsg" class="small" style="margin-top:.6rem;text-align:center"></div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const initial = @json($stats);
    const keys = ['orders', 'pending_orders', 'property', 'locations', 'agent', 'kamar'];
    const colors = { orders: '#f59e0b', pending_orders: '#ef4444', property: '#4f46e5', locations: '#0ea5e9', agent: '#7c3aed', kamar: '#ec4899' };
    const history = Object.fromEntries(keys.map(k => [k, [initial[k], initial[k]]]));
    const rupiah = n => 'Rp. ' + Number(n).toLocaleString('id-ID');

    const mini = Object.fromEntries(keys.map(k => [k, new Chart(document.getElementById('chart-' + k), {
        type: 'line',
        data: { labels: history[k].map(() => ''), datasets: [{ data: history[k], borderColor: colors[k], borderWidth: 2, pointRadius: 0, tension: .4, fill: true, backgroundColor: colors[k] + '22' }] },
        options: { plugins: { legend: { display: false }, tooltip: { enabled: false } }, scales: { x: { display: false }, y: { display: false } }, animation: false, responsive: false },
    })]));

    const revenueCtx = document.getElementById('chart-revenue').getContext('2d');
    const grad = revenueCtx.createLinearGradient(0, 0, 0, 220);
    grad.addColorStop(0, 'rgba(79,70,229,.45)');
    grad.addColorStop(1, 'rgba(79,70,229,0)');
    new Chart(revenueCtx, {
        type: 'line',
        data: { labels: initial.revenue_monthly.map(m => m.label), datasets: [{ label: 'Pendapatan', data: initial.revenue_monthly.map(m => m.total), borderColor: '#4f46e5', backgroundColor: grad, fill: true, tension: .4, pointRadius: 4, pointBackgroundColor: '#f5b942' }] },
        options: { plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => rupiah(c.raw) } } }, scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + (v / 1e6).toFixed(1) + ' jt' } } } },
    });

    const occupancy = new Chart(document.getElementById('chart-kamar-bar'), {
        type: 'doughnut',
        data: { labels: ['Tersedia', 'Dipakai'], datasets: [{ data: [initial.kamar_tersedia, initial.kamar_dipakai], backgroundColor: ['#10b981', '#f43f5e'], borderWidth: 0, hoverOffset: 10 }] },
        options: { cutout: '68%', plugins: { legend: { position: 'bottom' } } },
    });
    const perHotel = new Chart(document.getElementById('chart-kamar-per-hotel'), {
        type: 'bar',
        data: { labels: [], datasets: [
            { label: 'Tersedia', data: [], backgroundColor: '#10b981', borderRadius: 8 },
            { label: 'Dipakai', data: [], backgroundColor: '#f43f5e', borderRadius: 8 },
        ] },
        options: { scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } } }, animation: { duration: 400 } },
    });

    function apply(data) {
        keys.forEach(k => {
            history[k].push(data[k]);
            if (history[k].length > 12) history[k].shift();
            mini[k].data.labels = history[k].map(() => '');
            mini[k].update();
            document.getElementById('value-' + k).textContent = data[k];
        });
        document.getElementById('value-revenue').textContent = rupiah(data.revenue);
        occupancy.data.datasets[0].data = [data.kamar_tersedia, data.kamar_dipakai];
        occupancy.update();
        document.getElementById('label-kamar-tersedia').textContent = data.kamar_tersedia;
        document.getElementById('label-kamar-dipakai').textContent = data.kamar_dipakai;
        perHotel.data.labels = data.kamar_per_hotel.map(h => h.hotel);
        perHotel.data.datasets[0].data = data.kamar_per_hotel.map(h => h.tersedia);
        perHotel.data.datasets[1].data = data.kamar_per_hotel.map(h => h.dipakai);
        perHotel.update();
    }
    apply(initial);

    setInterval(() => {
        if (document.hidden) return;
        fetch(@json(route('admin.dashboard.data')), { headers: { 'Accept': 'application/json' } })
            .then(r => r.ok ? r.json() : Promise.reject()).then(apply).catch(() => {});
    }, 5000);

    // --- Upload foto profil dengan crop ---
    const profileImg = document.getElementById('admin-profile-img');
    const modal = document.getElementById('profileModal');
    const input = document.getElementById('profileFileInput');
    const preview = document.getElementById('profilePreview');
    const msg = document.getElementById('profileUploadMsg');
    const btn = document.getElementById('uploadBtn');
    let cropper = null;

    profileImg.addEventListener('click', () => { modal.classList.add('open'); msg.textContent = ''; });
    input.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        if (cropper) cropper.destroy();
        cropper = new Cropper(preview, { aspectRatio: 1, viewMode: 1, autoCropArea: 1, ready() { this.cropper.cropBox.classList.add('cropper-circular'); } });
    });
    btn.addEventListener('click', () => {
        if (!cropper) { msg.textContent = 'Pilih gambar terlebih dahulu.'; msg.style.color = 'var(--danger)'; return; }
        btn.disabled = true;
        msg.textContent = 'Mengunggah...';
        cropper.getCroppedCanvas({ width: 320, height: 320 }).toBlob(blob => {
            const body = new FormData();
            body.append('profile_img', blob, 'profile.jpg');
            fetch(@json(route('admin.profile.photo')), { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }, body })
                .then(r => r.json().then(d => ({ ok: r.ok, d })))
                .then(({ ok, d }) => {
                    btn.disabled = false;
                    if (!ok) throw new Error(d.message || 'Gagal upload.');
                    profileImg.src = d.url + '?' + Date.now();
                    modal.classList.remove('open');
                    toast('Foto profil berhasil diubah');
                })
                .catch(err => { btn.disabled = false; msg.textContent = err.message; msg.style.color = 'var(--danger)'; });
        }, 'image/jpeg', 0.95);
    });
});
</script>
@endpush
