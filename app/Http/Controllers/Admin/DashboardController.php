<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Pendaftaran::count();
        $terverifikasi = Pendaftaran::where('status_verifikasi', 'Terverifikasi')->count();
        $menunggu = Pendaftaran::where('status_verifikasi', 'Menunggu Verifikasi')->count();
        $lulus = Pendaftaran::where('status_kelulusan', 'Lulus')->count();
        $daftarUlang = Pendaftaran::where('status_daftar_ulang', 'Sudah Daftar Ulang')->count();

        // Statistik per jenjang
        $perJenjang = Jenjang::withCount('pendaftarans')->get();

        // 5 pendaftar terbaru
        $terbaru = Pendaftaran::with(['jenjang', 'gelombang'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'total', 'terverifikasi', 'menunggu', 'lulus', 'daftarUlang',
            'perJenjang', 'terbaru'
        ));
    }
}