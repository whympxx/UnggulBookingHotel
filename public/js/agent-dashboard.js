// Dashboard agent: navigasi section, CRUD hotel via JSON, dan laporan.
document.addEventListener('DOMContentLoaded', function () {
    const routes = window.AgentRoutes;
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const rupiah = n => 'Rp. ' + Number(n || 0).toLocaleString('id-ID');

    function api(url, options = {}) {
        return fetch(url, {
            ...options,
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', ...(options.headers || {}) },
        }).then(async res => {
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                throw new Error(data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Terjadi kesalahan.'));
            }
            return data;
        });
    }

    // --- Navigasi section ---
    const sections = document.querySelectorAll('.dash-section');
    function showSection(id) {
        if (!document.getElementById(id)) id = 'dashboard';
        sections.forEach(s => s.classList.toggle('active', s.id === id));
        document.querySelectorAll('.dash-nav [data-section]').forEach(l => l.classList.toggle('active', l.dataset.section === id));
        document.getElementById('dashSide')?.classList.remove('open');
        if (id === 'manage-hotels') loadHotels();
        window.initReveal && window.initReveal(document.getElementById(id));
    }
    document.querySelectorAll('[data-section]').forEach(l => l.addEventListener('click', e => {
        e.preventDefault();
        history.replaceState(null, '', '#' + l.dataset.section);
        showSection(l.dataset.section);
    }));
    showSection(location.hash.slice(1) || 'dashboard');

    // --- Tambah hotel ---
    const addForm = document.getElementById('addHotelForm');
    const formMessage = document.getElementById('formMessage');
    const previewImg = document.getElementById('previewImg');
    document.getElementById('hotelImage').addEventListener('change', e => {
        const file = e.target.files[0];
        previewImg.style.display = file ? 'block' : 'none';
        if (file) previewImg.src = URL.createObjectURL(file);
    });
    addForm.addEventListener('reset', () => { previewImg.style.display = 'none'; formMessage.classList.add('hidden'); });

    function showMessage(text, ok) {
        formMessage.className = 'flash ' + (ok ? 'flash-success' : 'flash-error');
        formMessage.textContent = text;
    }

    addForm.addEventListener('submit', e => {
        e.preventDefault();
        const btn = addForm.querySelector('[type=submit]');
        btn.disabled = true;
        api(routes.hotels, { method: 'POST', body: new FormData(addForm) })
            .then(data => {
                showMessage(data.message, true);
                toast(data.message);
                addForm.reset();
                const stat = document.getElementById('statHotels');
                stat.textContent = parseInt(stat.textContent, 10) + 1;
            })
            .catch(err => showMessage(err.message, false))
            .finally(() => { btn.disabled = false; });
    });

    // --- Kelola hotel ---
    const grid = document.getElementById('hotelsGrid');
    const search = document.getElementById('searchHotel');
    const rating = document.getElementById('ratingFilter');
    let timer;
    search.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(loadHotels, 300); });
    rating.addEventListener('change', loadHotels);

    function loadHotels() {
        grid.innerHTML = '<div class="empty">Memuat...</div>';
        const params = new URLSearchParams({ search: search.value });
        if (rating.value) params.set('rating', rating.value);
        api(routes.hotels + '?' + params)
            .then(data => renderHotels(data.data))
            .catch(err => { grid.innerHTML = '<div class="empty">' + esc(err.message) + '</div>'; });
    }

    function renderHotels(hotels) {
        if (!hotels.length) {
            grid.innerHTML = '<div class="empty" style="grid-column:1/-1"><i class="fas fa-hotel"></i>Tidak ada hotel. Tambahkan hotel atau ubah filter.</div>';
            return;
        }
        grid.innerHTML = hotels.map(h => {
            const desc = h.description.length > 90 ? h.description.substring(0, 90) + '...' : h.description;
            return `
            <article class="hotel-card" data-tilt="8">
                <div class="media">
                    <img src="${esc(h.image)}" alt="${esc(h.name)}">
                    <span class="rating-pill"><i class="fas fa-star"></i> ${Number(h.rating).toFixed(1)}</span>
                    <span class="price-tag">${esc(h.price_label)} <small>/ malam</small></span>
                </div>
                <div class="body">
                    <h3>${esc(h.name)}</h3>
                    <div class="meta"><i class="fas fa-location-dot"></i> ${esc(h.location)}</div>
                    <p class="muted small" style="margin:0">${esc(desc)}</p>
                    <div class="card-actions">
                        <button class="btn btn-ghost btn-sm" data-edit="${h.id}"><i class="fas fa-pen"></i> Edit</button>
                        <button class="btn btn-danger btn-sm" style="flex:0 0 auto" data-delete="${h.id}" aria-label="Hapus"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </article>`;
        }).join('');
        window.initTilt && window.initTilt(grid);
    }

    const modal = document.getElementById('editHotelModal');
    const editForm = document.getElementById('editHotelForm');
    const editMsg = document.getElementById('editFormMessage');

    grid.addEventListener('click', e => {
        const editBtn = e.target.closest('[data-edit]');
        const delBtn = e.target.closest('[data-delete]');
        if (editBtn) {
            api(routes.hotels + '/' + editBtn.dataset.edit).then(({ data }) => {
                document.getElementById('editHotelId').value = data.id;
                document.getElementById('editName').value = data.name;
                document.getElementById('editLocation').value = data.location;
                document.getElementById('editPrice').value = data.price;
                document.getElementById('editRating').value = data.rating;
                document.getElementById('editPhone').value = data.phone || '';
                document.getElementById('editDescription').value = data.description;
                editMsg.textContent = '';
                modal.classList.add('open');
            }).catch(err => toast(err.message, 'error'));
        }
        if (delBtn && confirm('Yakin ingin menghapus hotel ini?')) {
            api(routes.hotels + '/' + delBtn.dataset.delete, { method: 'DELETE' })
                .then(d => {
                    toast(d.message);
                    loadHotels();
                    const stat = document.getElementById('statHotels');
                    stat.textContent = Math.max(0, parseInt(stat.textContent, 10) - 1);
                })
                .catch(err => toast(err.message, 'error'));
        }
    });

    editForm.addEventListener('submit', e => {
        e.preventDefault();
        const id = document.getElementById('editHotelId').value;
        const body = new FormData(editForm);
        body.append('_method', 'PUT'); // upload file harus lewat POST
        api(routes.hotels + '/' + id, { method: 'POST', body })
            .then(d => { modal.classList.remove('open'); toast(d.message); loadHotels(); })
            .catch(err => { editMsg.textContent = err.message; });
    });

    // --- Laporan ---
    let revenueChart;
    document.querySelectorAll('[data-report]').forEach(btn => btn.addEventListener('click', () => {
        const type = btn.dataset.report;
        const box = document.getElementById(type === 'monthly' ? 'monthlyResult' : 'revenueResult');
        box.innerHTML = 'Memuat...';
        api(routes.reports + '?type=' + type).then(data => {
            if (type === 'monthly') {
                box.innerHTML = `
                    <div class="summary-row"><span>Total pemesanan</span><strong style="color:var(--text)">${data.total_bookings}</strong></div>
                    <div class="summary-row"><span>Pendapatan lunas</span><strong style="color:var(--text)">${rupiah(data.total_revenue)}</strong></div>
                    <div class="summary-row"><span>Hotel terpopuler</span><strong style="color:var(--text)">${esc(data.top_hotel)}</strong></div>`;
                return;
            }
            const names = Object.keys(data.revenue_per_hotel);
            if (!names.length) { box.innerHTML = 'Belum ada pendapatan.'; return; }
            box.innerHTML = '<canvas id="revenueChart" height="220"></canvas>';
            if (revenueChart) revenueChart.destroy();
            revenueChart = new Chart(document.getElementById('revenueChart'), {
                type: 'bar',
                data: { labels: names, datasets: [{ label: 'Pendapatan', data: names.map(n => data.revenue_per_hotel[n]), backgroundColor: ['#4f46e5', '#7c3aed', '#f59e0b', '#10b981', '#0ea5e9'], borderRadius: 10 }] },
                options: { indexAxis: 'y', plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => rupiah(c.raw) } } }, scales: { x: { beginAtZero: true } } },
            });
        }).catch(err => { box.textContent = err.message; });
    }));
});
