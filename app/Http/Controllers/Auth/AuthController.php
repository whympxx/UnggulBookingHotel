<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Login & registrasi untuk tiga role. Sebelumnya login.php, Register.php,
 * admin_register.php dan agent_register.php tidak memproses form sama sekali,
 * dan admin/agent login memakai database "hotel_db" yang tidak pernah dibuat.
 */
class AuthController extends Controller
{
    private const TITLES = ['user' => 'Login', 'agent' => 'Agent Login', 'admin' => 'Admin Login'];

    public function showLogin(string $role): View
    {
        return view('auth.login', ['role' => $role, 'title' => self::TITLES[$role]]);
    }

    public function login(Request $request, string $role): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials + ['role' => $role], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(Auth::user()->homeRoute());
    }

    public function showRegister(string $role): View
    {
        abort_if($role === 'admin' && ! $this->adminRegistrationEnabled(), 404);

        return view('auth.register', ['role' => $role]);
    }

    public function register(Request $request, string $role): RedirectResponse
    {
        abort_if($role === 'admin' && ! $this->adminRegistrationEnabled(), 404);

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
        if ($role === 'agent') {
            $rules['agency'] = ['required', 'string', 'max:150'];
        }
        if ($role === 'admin') {
            // Registrasi admin harus memakai kode undangan dari .env
            $rules['admin_code'] = ['required', 'string', function ($attr, $value, $fail) {
                if (! hash_equals((string) config('app.admin_registration_code'), (string) $value)) {
                    $fail('Kode registrasi admin tidak valid.');
                }
            }];
        }

        $data = $request->validate($rules);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'agency' => $data['agency'] ?? null,
            'role' => $role,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($user->homeRoute())->with('success', 'Registrasi berhasil. Selamat datang, '.$user->name.'!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tombol "Ganti Akun" di Setting
        return redirect()->route($request->boolean('switch') ? 'auth.select' : 'home');
    }

    private function adminRegistrationEnabled(): bool
    {
        return filled(config('app.admin_registration_code'));
    }
}
