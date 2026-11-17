<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /** Mapping label tampilan → value enum di DB */
    private const ROLE_MAP = [
        'Petugas Penanggulangan Bencana' => 'petugas_bpbd',
        'Koordinator Relawan'            => 'koordinator_relawan',
        'Masyarakat'                     => 'masyarakat',
        'Admin Sistem'                   => 'admin_sistem',
    ];

    /** Daftar pengguna */
    public function manajemenPengguna()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.manajemen-pengguna', compact('users'));
    }

    /** Tambah pengguna baru */
    public function tambahPengguna(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', Rule::in(array_keys(self::ROLE_MAP))],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah digunakan.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
            'role.required'     => 'Peran wajib dipilih.',
        ]);

        User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? null,
            'role'      => self::ROLE_MAP[$data['role']],
            'password'  => Hash::make($data['password']),
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.manajemen-pengguna')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /** Toggle aktif / nonaktif */
    public function toggleStatus(User $user)
    {
        // Tidak boleh nonaktifkan diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat mengubah status akun Anda sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    /** Hapus pengguna */
    public function hapusPengguna(User $user)
    {
        // Tidak boleh hapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $nama = $user->name;
        $user->delete();

        return back()->with('success', "Akun {$nama} berhasil dihapus.");
    }
}
