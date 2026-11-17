<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin Sistem ──────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@sigapbanjir.demo'],
            [
                'name'     => 'Rizal Hakim',
                'email'    => 'admin@sigapbanjir.demo',
                'phone'    => '0812-0000-0001',
                'password' => Hash::make('admin123'),
                'role'     => 'admin_sistem',
                'is_active' => true,
            ]
        );

        // ── Petugas BPBD ─────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'petugas@sigapbanjir.demo'],
            [
                'name'     => 'Cut Nurmala',
                'email'    => 'petugas@sigapbanjir.demo',
                'phone'    => '0812-0000-0002',
                'password' => Hash::make('petugas123'),
                'role'     => 'petugas_bpbd',
                'is_active' => true,
            ]
        );

        // ── Koordinator Relawan ───────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'koordinator@sigapbanjir.demo'],
            [
                'name'     => 'Teuku Faisal',
                'email'    => 'koordinator@sigapbanjir.demo',
                'phone'    => '0812-0000-0003',
                'password' => Hash::make('koordinator123'),
                'role'     => 'koordinator_relawan',
                'is_active' => true,
            ]
        );

        // ── Masyarakat (akun demo) ────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'warga@sigapbanjir.demo'],
            [
                'name'     => 'Siti Rahmah',
                'email'    => 'warga@sigapbanjir.demo',
                'phone'    => '0812-0000-0004',
                'password' => Hash::make('sigap123'),
                'role'     => 'masyarakat',
                'is_active' => true,
            ]
        );
    }
}
