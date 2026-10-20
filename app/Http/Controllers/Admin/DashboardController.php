<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index()
    {
        $total         = Pendaftaran::count();
        $terverifikasi = Pendaftaran::where('status_verifikasi', 'Terverifikasi')->count();
        $menunggu      = Pendaftaran::where('status_verifikasi', 'Menunggu Verifikasi')->count();
        $lulus         = Pendaftaran::where('status_kelulusan', 'Lulus')->count();
        $daftarUlang   = Pendaftaran::where('status_daftar_ulang', 'Sudah Daftar Ulang')->count();

        // ====== STATISTIK PEMBAYARAN ======
        $bayarBelum = Pendaftaran::where(function ($q) {
            $q->whereDoesntHave('pembayaran')
              ->orWhereHas('pembayaran', fn($qq) => $qq->where('status', 'Belum Bayar'));
        })->count();

        $bayarMenunggu      = Pembayaran::where('status', 'Menunggu Verifikasi')->count();
        $bayarTerverifikasi = Pembayaran::where('status', 'Terverifikasi')->count();
        $bayarGagal         = Pembayaran::where('status', 'Gagal')->count();

        $statsPembayaran = [
            'belum'         => $bayarBelum,
            'menunggu'      => $bayarMenunggu,
            'terverifikasi' => $bayarTerverifikasi,
            'gagal'         => $bayarGagal,
            'total'         => $bayarBelum + $bayarMenunggu + $bayarTerverifikasi + $bayarGagal,
        ];
        // ==================================

        $perJenjang = Jenjang::withCount('pendaftarans')->get();

        $terbaru = Pendaftaran::with(['jenjang', 'gelombang'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'total', 'terverifikasi', 'menunggu', 'lulus', 'daftarUlang',
            'perJenjang', 'terbaru', 'statsPembayaran'
        ));
    }
}