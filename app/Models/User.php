<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    public function isMasyarakat(): bool
    {
        return $this->role === 'masyarakat';
    }

    public function isPetugasBpbd(): bool
    {
        return $this->role === 'petugas_bpbd';
    }

    public function isKoordinator(): bool
    {
        return $this->role === 'koordinator_relawan';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin_sistem';
    }

    /** Redirect path setelah login */
    public function dashboardRoute(): string
    {
        return match($this->role) {
            'admin_sistem'        => route('admin.dashboard'),
            'petugas_bpbd'        => route('petugas.dashboard'),
            'koordinator_relawan' => route('koordinator.dashboard'),
            default               => route('home'),
        };
    }

    /** Label peran untuk tampilan */
    public function roleLabel(): string
    {
        return match($this->role) {
            'masyarakat'          => 'Masyarakat',
            'petugas_bpbd'        => 'Petugas BPBD',
            'koordinator_relawan' => 'Koordinator Relawan',
            'admin_sistem'        => 'Admin Sistem',
            default               => 'Pengguna',
        };
    }

    /** Inisial untuk avatar */
    public function initials(): string
    {
        $words = explode(' ', trim($this->name));
        $init  = strtoupper(substr($words[0], 0, 1));
        if (count($words) > 1) {
            $init .= strtoupper(substr($words[1], 0, 1));
        }
        return $init;
    }
}
