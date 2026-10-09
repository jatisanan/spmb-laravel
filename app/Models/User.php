<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
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