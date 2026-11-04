// Interaksi umum situs: tema gelap, navbar, dropdown, tilt 3D, scroll reveal,
// wishlist, keranjang, toast, counter, lightbox & toggle password.
(function () {
    const root = document.documentElement;
    const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content;
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ---------- Tema ----------
    function applyTheme(theme) {
        root.dataset.theme = theme;
        document.querySelectorAll('[data-theme-icon]').forEach(i => {
            i.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        });
    }
    window.toggleTheme = function () {
        const next = root.dataset.theme === 'dark' ? 'light' : 'dark';
        try { localStorage.setItem('theme', next); } catch (e) {}
        applyTheme(next);
        document.dispatchEvent(new CustomEvent('themechange', { detail: next }));
    };

    // ---------- Toast ----------
    window.toast = function (message, type = 'success') {
        let stack = document.querySelector('.toast-stack');
        if (!stack) { stack = document.createElement('div'); stack.className = 'toast-stack'; document.body.appendChild(stack); }
        const el = document.createElement('div');
        el.className = 'toast ' + type;
        el.setAttribute('role', 'status');
        el.innerHTML = '<i class="fas ' + (type === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check') + '"></i><span></span>';
        el.querySelector('span').textContent = message;
        stack.appendChild(el);
        setTimeout(() => { el.style.transition = '.3s'; el.style.opacity = '0'; el.style.transform = 'translateX(30px)'; }, 3200);
        setTimeout(() => el.remove(), 3600);
    };

    // ---------- 3D tilt ----------
    function initTilt(scope = document) {
        if (reduceMotion || window.matchMedia('(hover: none)').matches) return;
        scope.querySelectorAll('[data-tilt]:not([data-tilt-ready])').forEach(el => {
            el.dataset.tiltReady = '1';
            el.classList.add('tilt');
            const max = parseFloat(el.dataset.tilt) || 10;
            if (!el.querySelector('.tilt-glare')) {
                const glare = document.createElement('span');
                glare.className = 'tilt-glare';
                el.appendChild(glare);
            }
            el.addEventListener('mousemove', e => {
                const r = el.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width;
                const y = (e.clientY - r.top) / r.height;
                el.style.transform = `perspective(900px) rotateX(${(0.5 - y) * max}deg) rotateY(${(x - 0.5) * max}deg) translateY(-6px)`;
                el.style.setProperty('--gx', x * 100 + '%');
                el.style.setProperty('--gy', y * 100 + '%');
            });
            el.addEventListener('mouseleave', () => { el.style.transform = ''; });
        });
    }
    window.initTilt = initTilt;

    // ---------- Scroll reveal ----------
    function initReveal(scope = document) {
        const items = scope.querySelectorAll('.reveal:not(.in)');
        if (!('IntersectionObserver' in window) || reduceMotion) { items.forEach(i => i.classList.add('in')); return; }
        const io = new IntersectionObserver(entries => entries.forEach(en => {
            if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
        }), { threshold: 0.12 });
        items.forEach(i => io.observe(i));
    }
    window.initReveal = initReveal;

    // ---------- Counter angka ----------
    function initCounters() {
        document.querySelectorAll('[data-count]').forEach(el => {
            const target = parseFloat(el.dataset.count);
            const decimals = (el.dataset.count.split('.')[1] || '').length;
            const io = new IntersectionObserver(([en]) => {
                if (!en.isIntersecting) return;
                io.disconnect();
                const start = performance.now();
                const dur = reduceMotion ? 1 : 1400;
                const tick = now => {
                    const p = Math.min(1, (now - start) / dur);
                    const eased = 1 - Math.pow(1 - p, 3);
                    el.textContent = (target * eased).toLocaleString('id-ID', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }) + (el.dataset.suffix || '');
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            });
            io.observe(el);
        });
    }

    // ---------- Request JSON ----------
    function postJson(url) {
        return fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf(), 'Accept': 'application/json' } })
            .then(async res => {
                const data = await res.json().catch(() => ({}));
                if (res.status === 401) { const e = new Error('login'); e.login = true; throw e; }
                if (!res.ok) throw new Error(data.message || 'Terjadi kesalahan.');
                return data;
            });
    }

    function setBadge(name, count) {
        document.querySelectorAll('[data-badge="' + name + '"]').forEach(b => {
            b.textContent = count;
            b.classList.toggle('hidden', !count);
        });
    }

    document.addEventListener('click', function (e) {
        // Wishlist
        const wish = e.target.closest('[data-wishlist-url]');
        if (wish) {
            e.preventDefault();
            postJson(wish.dataset.wishlistUrl).then(d => {
                document.querySelectorAll('[data-wishlist-url="' + wish.dataset.wishlistUrl + '"]').forEach(b => {
                    b.classList.toggle('active', d.added);
                    const icon = b.querySelector('i');
                    if (icon) icon.className = (d.added ? 'fas' : 'far') + ' fa-heart';
                    if (b.dataset.label !== undefined) b.querySelector('span').textContent = d.added ? 'Tersimpan' : 'Simpan';
                });
                setBadge('wishlist', d.count);
                toast(d.added ? 'Ditambahkan ke wishlist' : 'Dihapus dari wishlist');
            }).catch(err => err.login ? (location.href = wish.dataset.loginUrl) : toast(err.message, 'error'));
            return;
        }

        // Keranjang
        const cart = e.target.closest('[data-cart-url]');
        if (cart) {
            e.preventDefault();
            postJson(cart.dataset.cartUrl).then(d => {
                setBadge('cart', d.count);
                toast('Ditambahkan ke keranjang');
                cart.classList.add('active');
            }).catch(err => err.login ? (location.href = cart.dataset.loginUrl) : toast('Login sebagai customer untuk memakai keranjang.', 'error'));
            return;
        }

        // Dropdown
        const ddToggle = e.target.closest('[data-dropdown]');
        document.querySelectorAll('.dropdown.open').forEach(d => { if (!ddToggle || d !== ddToggle.parentElement) d.classList.remove('open'); });
        if (ddToggle) { e.preventDefault(); ddToggle.parentElement.classList.toggle('open'); }

        // Toggle password
        const pass = e.target.closest('.toggle-pass');
        if (pass) {
            const input = pass.parentElement.querySelector('input');
            input.type = input.type === 'password' ? 'text' : 'password';
            pass.querySelector('i').className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        }

        // Lightbox galeri
        const lb = e.target.closest('[data-lightbox]');
        if (lb) {
            e.preventDefault();
            const box = document.getElementById('lightbox');
            if (box) { box.querySelector('img').src = lb.getAttribute('href'); box.classList.add('open'); }
        }
        if (e.target.closest('[data-lightbox-close]') || e.target.id === 'lightbox') {
            document.getElementById('lightbox')?.classList.remove('open');
        }

        // Modal
        const openModal = e.target.closest('[data-modal-open]');
        if (openModal) document.getElementById(openModal.dataset.modalOpen)?.classList.add('open');
        if (e.target.closest('[data-modal-close]') || e.target.classList.contains('modal')) {
            e.target.closest('.modal')?.classList.remove('open');
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal.open, .lightbox.open').forEach(m => m.classList.remove('open'));
            document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        applyTheme(root.dataset.theme || 'light');

        // Navbar: transparan di atas hero, solid saat scroll
        const nav = document.querySelector('.navbar');
        const onScroll = () => nav && nav.classList.toggle('scrolled', window.scrollY > 30);
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        document.querySelectorAll('[data-nav-toggle]').forEach(btn => btn.addEventListener('click', () => {
            document.querySelector(btn.dataset.navToggle)?.classList.toggle('open');
        }));

        initTilt();
        initReveal();
        initCounters();

        document.querySelector('.page-loader')?.classList.add('done');
    });
})();
