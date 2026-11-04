<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Website setting. Versi lama mencetak custom_js & google_analytics mentah ke
 * halaman (celah XSS) dan pengaturannya tidak dipakai di halaman lain.
 */
class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', ['settings' => Setting::allValues()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_title' => ['required', 'string', 'max:100'],
            'welcome_message' => ['nullable', 'string', 'max:255'],
            'primary_color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'secondary_color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'url'],
            'facebook' => ['nullable', 'url'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'footer_text' => ['nullable', 'string', 'max:255'],
            'default_language' => ['required', 'in:id,en,ja,zh'],
            'timezone' => ['required', 'timezone'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp,ico', 'max:2048'],
        ]);

        $data['maintenance_mode'] = $request->boolean('maintenance_mode') ? '1' : '0';

        if ($request->hasFile('logo')) {
            ImageUpload::delete(Setting::get('logo'));
            $data['logo'] = ImageUpload::store($request->file('logo'), 'branding');
        } else {
            unset($data['logo']);
        }

        Setting::putMany($data);

        return back()->with('success', 'Pengaturan website disimpan.');
    }
}
