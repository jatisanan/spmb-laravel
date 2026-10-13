<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InfoPembayaran extends Model
{
    protected $table = 'info_pembayaran';

    protected $fillable = [
        'gelombang_id',
        'offline_alamat', 'offline_cp_nama', 'offline_cp_hp', 'offline_jam', 'offline_catatan',
        'transfer_bank', 'transfer_norek', 'transfer_atas_nama', 'transfer_cabang',
        'qris_image_path',
        'catatan_umum',
    ];

    public function gelombang()
    {
        return $this->belongsTo(GelombangPendaftaran::class, 'gelombang_id');
    }

    public function getQrisImageUrlAttribute(): ?string
    {
        if (!$this->qris_image_path) return null;
        if (Storage::disk('public')->exists($this->qris_image_path)) {
            return asset('storage/' . $this->qris_image_path);
        }
        return null;
    }

    /**
     * Cek apakah minimal ada satu metode yang diisi.
     */
    public function hasAnyMethod(): bool
    {
        return $this->offline_alamat
            || $this->transfer_norek
            || $this->qris_image_path;
    }
}