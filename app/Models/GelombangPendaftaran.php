<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GelombangPendaftaran extends Model
{
    protected $fillable = [
        'jenjang_id', 'nama', 'tanggal_mulai', 'tanggal_selesai',
        'tanggal_ujian', 'biaya', 'catatan', 'aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_ujian' => 'date',
        'biaya' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'gelombang_id');
    }

    public function isOpen(): bool
    {
        return $this->aktif && now()->between($this->tanggal_mulai, $this->tanggal_selesai);
    }
}