// Estimasi harga di form booking/checkout. Hanya tampilan: total final dihitung server.
document.addEventListener('DOMContentLoaded', function () {
    const checkIn = document.getElementById('check_in');
    const checkOut = document.getElementById('check_out');
    if (!checkIn || !checkOut) return;

    const fmt = n => 'Rp. ' + Math.round(n).toLocaleString('id-ID');
    const set = (id, v) => { const el = document.getElementById(id); if (el) el.textContent = v; };

    function nights() {
        if (!checkIn.value || !checkOut.value) return 0;
        const diff = (new Date(checkOut.value) - new Date(checkIn.value)) / 86400000;
        return diff > 0 ? Math.round(diff) : 0;
    }

    // Harga per malam dari radio tipe kamar (booking satuan) atau select per hotel (keranjang)
    function perNight() {
        let sum = 0;
        document.querySelectorAll('input[name="room_type_id"]:checked').forEach(r => { sum += parseInt(r.dataset.price || '0', 10); });
        document.querySelectorAll('select[name^="rooms["]').forEach(s => { sum += parseInt(s.options[s.selectedIndex]?.dataset.price || '0', 10); });
        return sum;
    }

    function calculate() {
        const n = nights();
        const p = perNight();
        set('sumPerNight', p ? fmt(p) : '-');
        set('sumNights', n ? n + ' malam' : '-');
        if (!n || !p) { ['sumSubtotal', 'sumTax', 'sumService', 'total-price'].forEach(id => set(id, '-')); return; }
        const subtotal = p * n;
        const tax = Math.round(subtotal * 0.10);
        const service = Math.round(subtotal * 0.01);
        set('sumSubtotal', fmt(subtotal));
        set('sumTax', fmt(tax));
        set('sumService', fmt(service));
        set('total-price', fmt(subtotal + tax + service));
    }

    checkIn.addEventListener('change', function () {
        if (this.value) {
            const next = new Date(this.value);
            next.setDate(next.getDate() + 1);
            checkOut.min = next.toISOString().split('T')[0];
            if (!checkOut.value || checkOut.value <= this.value) checkOut.value = checkOut.min;
        }
        calculate();
    });
    checkOut.addEventListener('change', calculate);
    document.querySelectorAll('input[name="room_type_id"], select[name^="rooms["]').forEach(el => el.addEventListener('change', calculate));
    calculate();
});
