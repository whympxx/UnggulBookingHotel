@if (session('success'))
    <div class="flash flash-success" role="status"><i class="fas fa-circle-check"></i> <div>{{ session('success') }}</div></div>
@endif
@if (session('error'))
    <div class="flash flash-error" role="alert"><i class="fas fa-circle-exclamation"></i> <div>{{ session('error') }}</div></div>
@endif
@if ($errors->any() && ($showErrors ?? true))
    <div class="flash flash-error" role="alert">
        <i class="fas fa-circle-exclamation"></i>
        <div>
            Periksa kembali isian Anda:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
