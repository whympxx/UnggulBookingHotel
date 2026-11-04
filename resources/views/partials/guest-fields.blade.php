{{-- Data tamu & tanggal menginap (dipakai di booking satuan dan checkout keranjang) --}}
<div class="form-grid">
    <div class="field">
        <label for="check_in">Check-in</label>
        <input type="date" id="check_in" name="check_in" value="{{ old('check_in', now()->addDay()->toDateString()) }}" min="{{ now()->toDateString() }}" required>
        @error('check_in') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field">
        <label for="check_out">Check-out</label>
        <input type="date" id="check_out" name="check_out" value="{{ old('check_out', now()->addDays(2)->toDateString()) }}" min="{{ now()->addDay()->toDateString() }}" required>
        @error('check_out') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field">
        <label for="guests">Jumlah tamu</label>
        <select id="guests" name="guests" required>
            @foreach (range(1, 4) as $n)
                <option value="{{ $n }}" @selected(old('guests', 2) == $n)>{{ $n }} tamu</option>
            @endforeach
        </select>
        @error('guests') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field">
        <label for="customer_name">Nama lengkap</label>
        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $user->name) }}" required maxlength="100">
        @error('customer_name') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field">
        <label for="customer_email">Email</label>
        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $user->email) }}" required>
        @error('customer_email') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field">
        <label for="customer_phone">Nomor telepon</label>
        <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $user->phone) }}" required placeholder="08xxxxxxxxxx">
        @error('customer_phone') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="field full">
        <label for="special_requests">Permintaan khusus (opsional)</label>
        <textarea id="special_requests" name="special_requests" rows="3" maxlength="500" placeholder="Contoh: kamar bebas asap rokok, check-in lebih awal...">{{ old('special_requests') }}</textarea>
    </div>
</div>
