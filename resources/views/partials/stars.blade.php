<span class="stars" aria-label="Rating {{ $rating }} dari 5">@for ($i = 1; $i <= 5; $i++)<i class="fas fa-star {{ $i <= round($rating) ? '' : 'off' }}"></i>@endfor</span>
