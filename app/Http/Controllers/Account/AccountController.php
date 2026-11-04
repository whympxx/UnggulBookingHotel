<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SetLocale;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/**
 * Pengaturan akun. Versi lama: profile.php, account_security.php,
 * change_password.php & ganti_password.php hanya tampilan statis
 * (data dummy, tombol tidak menyimpan apa pun, logout hanya reload halaman).
 */
class AccountController extends Controller
{
    public function settings(): View
    {
        return view('account.settings');
    }

    public function security(Request $request): View
    {
        return view('account.security', ['user' => $request->user()]);
    }

    public function editProfile(Request $request): View
    {
        return view('account.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            ImageUpload::delete($user->avatar);
            $data['avatar'] = ImageUpload::store($request->file('avatar'), 'avatars');
        } else {
            unset($data['avatar']);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword(): View
    {
        return view('account.password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'different:current_password', Password::min(8)],
        ], [
            'current_password.current_password' => 'Password lama salah.',
            'password.different' => 'Password baru harus berbeda dari password lama.',
        ]);

        $request->user()->update(['password' => $data['password']]);

        return back()->with('success', 'Password berhasil diganti.');
    }

    public function language(Request $request): View|RedirectResponse
    {
        $lang = $request->query('reset') ? 'id' : $request->query('lang');

        if ($lang !== null) {
            abort_unless(in_array($lang, SetLocale::SUPPORTED, true), 404);
            $request->session()->put('language', $lang);
            $request->user()?->update(['language' => $lang]);

            return redirect()->route('language');
        }

        return view('account.language', ['current' => app()->getLocale()]);
    }
}
