<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'nomor_pendaftaran', 'user_id', 'jenjang_id', 'gelombang_id',
        'nama_lengkap', 'jenis_kelamin', 'nisn', 'tempat_lahir', 'tanggal_lahir',
        'asal_sekolah', 'no_whatsapp', 'email', 'alamat',

        'nama_ayah', 'nama_ibu', 'nama_wali',
        'status_verifikasi', 'catatan_verifikasi',
        'status_ujian', 'tanggal_ujian', 'nilai_ujian',
        'status_kelulusan', 'status_daftar_ulang', 'tanggal_daftar_ulang',
        'link_daftar_ulang',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_ujian' => 'date',
        'tanggal_daftar_ulang' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function gelombang()
    {
        return $this->belongsTo(GelombangPendaftaran::class, 'gelombang_id');
    }

    public function berkas()
    {
        return $this->hasMany(BerkasPendaftaran::class);
    }

    public static function generateNomor(string $kodeJenjang): string
    {
        $tahun = now()->year;
        $prefix = "SPMB-{$tahun}-" . strtoupper($kodeJenjang) . "-";

        $last = self::where('nomor_pendaftaran', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $urutan = $last ? ((int) substr($last->nomor_pendaftaran, -4)) + 1 : 1;

        return $prefix . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('nomor_pendaftaran', 'like', "%{$keyword}%")
              ->orWhere('nama_lengkap', 'like', "%{$keyword}%")
              ->orWhere('nisn', 'like', "%{$keyword}%")
              ->orWhere('no_whatsapp', 'like', "%{$keyword}%");
        });
    }
}