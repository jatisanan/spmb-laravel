<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'jumlah',
        'metode',
        'status',
        'bukti_path',
        'bukti_nama_asli',
        'uploaded_at',
        'deadline_at',
        'catatan_admin',
        'verified_by',
        'verified_at',
        'status_pembayaran',
    ];

    protected $casts = [
        'jumlah'      => 'decimal:2',
        'uploaded_at' => 'datetime',
        'deadline_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    // ============================================
    // RELASI
    // ============================================
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');  // ← explicit
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');  // ← sudah explicit ✅
    }
    
    // ============================================
    // HELPER: Badge class untuk UI
    // ============================================
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Terverifikasi'       => 'status-success',
            'Menunggu Verifikasi' => 'status-pending',
            'Gagal'               => 'status-danger',
            default               => 'status-neutral',
        };
    }

    // ============================================
    // HELPER: Label metode
    // ============================================
    public function getMetodeLabelAttribute(): string
    {
        return match ($this->metode) {
            'offline'  => 'Offline (Kantor)',
            'transfer' => 'Transfer Bank',
            'qris'     => 'QRIS',
            default    => '—',
        };
    }

    // ============================================
    // HELPER: Cek boleh upload ulang
    // ============================================
    public function bisaUploadUlang(): bool
    {
        return in_array($this->status, ['Belum Bayar', 'Gagal']);
    }
}