<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPendaftaran extends Model
{
    protected $fillable = ['pendaftaran_id', 'jenis', 'file_path', 'nama_asli', 'verified'];

    protected $casts = ['verified' => 'boolean'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function getLabelAttribute(): string
    {
        return match ($this->jenis) {
            'akta_lahir' => 'Akta Kelahiran',
            'ktp_orangtua' => 'KTP Orang Tua',
            'kartu_keluarga' => 'Kartu Keluarga',
            'rapor' => 'Rapor',
            'ijazah' => 'Ijazah',
            'foto' => 'Foto 3x4',
            default => ucfirst(str_replace('_', ' ', $this->jenis)),
        };
    }
}