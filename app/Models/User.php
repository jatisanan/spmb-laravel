<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // === KONSTANTA ROLE ===
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN       = 'admin';
    public const ROLE_STUDENT     = 'student';

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nisn', 'no_whatsapp', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }

    // === HELPER BARU ===
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Bisa akses panel /admin (admin ATAU super_admin).
     */
    public function canAccessAdmin(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN], true);
    }

    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class);
    }

    /**
     * Generate password dari tanggal lahir (ddmmyyyy).
     */
    public static function generatePasswordFromBirthdate($tanggalLahir): string
    {
        return \Carbon\Carbon::parse($tanggalLahir)->format('dmY');
    }
}