<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $fillable = [
        'kode', 'nama', 'label', 'deskripsi', 'logo_path', 'aktif',
    ];

    protected $casts = ['aktif' => 'boolean'];

    public function gelombang()
    {
        return $this->hasMany(GelombangPendaftaran::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}