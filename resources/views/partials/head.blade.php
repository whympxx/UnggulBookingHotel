<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="{{ $site['meta_description'] }}">
<meta name="keywords" content="{{ $site['meta_keywords'] }}">
<meta name="theme-color" content="#1e1b4b">
<link rel="icon" href="{{ asset($site['logo'] ?: 'images/logo.png') }}">
<script>
    // Terapkan tema sebelum render supaya tidak berkedip
    (function () {
        let t = null;
        try { t = localStorage.getItem('theme'); } catch (e) {}
        if (!t) t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        document.documentElement.dataset.theme = t;
    })();
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/modern.css') }}?v=3">
<style>:root { --brand: {{ $site['primary_color'] }}; --gold: {{ $site['secondary_color'] }}; }</style>
<script src="{{ asset('js/app.js') }}?v=2" defer></script>
