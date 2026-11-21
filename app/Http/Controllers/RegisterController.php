<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'phone'                 => ['required', 'string', 'max:20'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'agree'                 => ['accepted'],
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar.',
            'phone.required'        => 'Nomor telepon wajib diisi.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
            'agree.accepted'        => 'Anda harus menyetujui kebijakan privasi.',
        ]);

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'password'  => Hash::make($data['password']),
            'role'      => 'masyarakat',
            'is_active' => true,
        ]);

        // Login otomatis setelah daftar
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!');
    }
}
