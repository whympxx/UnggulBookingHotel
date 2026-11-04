@php $labels = ['Pilih hotel', 'Data tamu', 'Pembayaran', 'Selesai']; @endphp
<div class="steps" aria-label="Langkah pemesanan">
    @foreach ($labels as $i => $label)
        <div class="step {{ $i + 1 < $current ? 'done' : ($i + 1 === $current ? 'current' : '') }}">
            <b>@if ($i + 1 < $current)<i class="fas fa-check"></i>@else{{ $i + 1 }}@endif</b> {{ $label }}
        </div>
    @endforeach
</div>
