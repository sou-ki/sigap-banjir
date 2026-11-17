<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /** Proses login */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');
        $credentials['is_active'] = true;

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            return redirect()->intended($user->dashboardRoute());
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau kata sandi salah.']);
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('masuk');
    }

    public function sendResetLink(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($credentials);

        if ($status === Password::RESET_LINK_SENT || $status === Password::INVALID_USER) {
            return back()->with('status', 'Jika email tersebut terdaftar, tautan pengaturan ulang akan dikirim. Periksa kotak masuk Anda.');
        }

        return back()->withErrors([
            'email' => $status === Password::RESET_THROTTLED
                ? 'Permintaan terlalu sering. Silakan tunggu sebelum mencoba kembali.'
                : 'Tautan pengaturan ulang tidak dapat dikirim. Silakan coba kembali.',
        ]);
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-sandi', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $credentials = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $status = Password::reset(
            $credentials,
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('masuk')
                ->with('status', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru.');
        }

        return back()->withInput($request->only('email'))->withErrors([
            'email' => $status === Password::INVALID_USER
                ? 'Email tidak ditemukan.'
                : 'Tautan pengaturan ulang tidak valid atau sudah kedaluwarsa. Minta tautan baru.',
        ]);
    }
}
