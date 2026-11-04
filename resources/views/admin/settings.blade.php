@extends('layouts.dashboard')

@section('title', 'Website Setting')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" style="display:grid;gap:1.5rem">
        @csrf
        @method('PUT')

        <div class="panel reveal">
            <div class="panel-head"><h3><i class="fas fa-palette text-gold"></i> Identitas & tampilan</h3></div>
            <div class="form-grid">
                <div class="field"><label>Judul website</label><input name="site_title" value="{{ old('site_title', $settings['site_title']) }}" required></div>
                <div class="field"><label>Pesan sambutan (hero beranda)</label><input name="welcome_message" value="{{ old('welcome_message', $settings['welcome_message']) }}"></div>
                <div class="field"><label>Warna utama</label><input type="color" name="primary_color" value="{{ old('primary_color', $settings['primary_color']) }}"></div>
                <div class="field"><label>Warna aksen</label><input type="color" name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color']) }}"></div>
                <div class="field"><label>Logo</label>
                    <div style="display:flex;gap:.6rem;align-items:center">
                        <img src="{{ asset($settings['logo'] ?: 'images/logo.png') }}" alt="Logo" style="height:42px;border-radius:10px">
                        <input type="file" name="logo" accept="image/*">
                    </div></div>
                <div class="field"><label>Bahasa default</label>
                    <select name="default_language">
                        @foreach (['id' => 'Indonesia', 'en' => 'English', 'ja' => '日本語', 'zh' => '中文'] as $code => $label)
                            <option value="{{ $code }}" @selected(old('default_language', $settings['default_language']) === $code)>{{ $label }}</option>
                        @endforeach
                    </select></div>
                <div class="field"><label>Zona waktu</label><input name="timezone" value="{{ old('timezone', $settings['timezone']) }}" required></div>
            </div>
        </div>

        <div class="grid grid-2">
            <div class="panel reveal">
                <div class="panel-head"><h3><i class="fas fa-magnifying-glass text-gold"></i> SEO</h3></div>
                <div style="display:grid;gap:1rem">
                    <div class="field"><label>Meta description</label><input name="meta_description" value="{{ old('meta_description', $settings['meta_description']) }}"></div>
                    <div class="field"><label>Meta keywords</label><input name="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords']) }}"></div>
                    <div class="field"><label>Teks footer</label><input name="footer_text" value="{{ old('footer_text', $settings['footer_text']) }}"></div>
                </div>
            </div>
            <div class="panel reveal">
                <div class="panel-head"><h3><i class="fas fa-address-book text-gold"></i> Kontak & sosial media</h3></div>
                <div class="form-grid">
                    <div class="field"><label>Alamat</label><input name="address" value="{{ old('address', $settings['address']) }}"></div>
                    <div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email', $settings['email']) }}"></div>
                    <div class="field"><label>Telepon</label><input name="phone" value="{{ old('phone', $settings['phone']) }}"></div>
                    <div class="field"><label>WhatsApp</label><input name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp']) }}"></div>
                    <div class="field"><label>Instagram URL</label><input type="url" name="instagram" value="{{ old('instagram', $settings['instagram']) }}"></div>
                    <div class="field"><label>Facebook URL</label><input type="url" name="facebook" value="{{ old('facebook', $settings['facebook']) }}"></div>
                </div>
            </div>
        </div>

        <div class="panel reveal" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap">
            <label class="check"><input type="checkbox" name="maintenance_mode" value="1" @checked(old('maintenance_mode', $settings['maintenance_mode']) === '1')>
                <span><strong style="color:var(--text)">Mode maintenance</strong><br><span class="small">Halaman publik ditutup sementara; admin tetap bisa masuk.</span></span></label>
            <button class="btn btn-primary btn-lg"><i class="fas fa-floppy-disk"></i> Simpan Pengaturan</button>
        </div>
    </form>
@endsection
