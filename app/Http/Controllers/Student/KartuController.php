<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSitus;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KartuController extends Controller
{
    public function download()
    {
        $user = Auth::user();
        $pendaftaran = $user->pendaftaran;

        if (!$pendaftaran) {
            abort(404, 'Data pendaftaran tidak ditemukan.');
        }

        if (!in_array($pendaftaran->status_ujian, ['Terjadwal', 'Sudah Ujian'])) {
            return back()->with('error', 'Kartu ujian belum tersedia. Tunggu jadwal ujian dari admin.');
        }

        $pendaftaran->load(['jenjang', 'gelombang']);

        // === Semua info dari Pengaturan Situs ===
        $info = [
            // Header
            'header_kicker' => PengaturanSitus::get('header_kicker', 'Pondok Pesantren'),
            'header_name' => PengaturanSitus::get('header_name', 'Jati Sanan'),
            'logo_base64' => $this->getLogoBase64(),

            // Yayasan
            'yayasan_nama' => PengaturanSitus::get('yayasan_nama', 'Yayasan Pendidikan dan Dakwah Jati Sanan'),
            'yayasan_singkat' => PengaturanSitus::get('yayasan_singkat', 'LPD Jati Sanan'),
            'yayasan_alamat' => PengaturanSitus::get('yayasan_alamat', ''),
            'yayasan_kota' => PengaturanSitus::get('yayasan_kota', ''),
            'yayasan_telp' => PengaturanSitus::get('yayasan_telp', ''),
            'yayasan_email' => PengaturanSitus::get('yayasan_email', ''),
            'yayasan_website' => PengaturanSitus::get('yayasan_website', ''),
            'yayasan_tahun_ajaran' => PengaturanSitus::get('yayasan_tahun_ajaran', date('Y') . '/' . (date('Y') + 1)),
            'yayasan_kepala' => PengaturanSitus::get('yayasan_kepala', ''),
            'yayasan_nip_kepala' => PengaturanSitus::get('yayasan_nip_kepala', ''),

            // Footer
            'footer_title' => PengaturanSitus::get('footer_title', 'Pondok Pesantren Jati Sanan'),
        ];

        $pdf = Pdf::loadView('student.kartu-pdf', [
            'pendaftaran' => $pendaftaran,
            'user' => $user,
            'info' => $info,
            'tanggalCetak' => now()->isoFormat('D MMMM Y'),
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'kartu-ujian-' . $pendaftaran->nomor_pendaftaran . '.pdf';

        return $pdf->download($filename);
    }

    private function getLogoBase64(): ?string
    {
        $path = PengaturanSitus::get('header_logo');

        if (!$path) {
            $fallback = public_path('images/logo.png');
            if (file_exists($fallback)) {
                return 'data:image/png;base64,' . base64_encode(file_get_contents($fallback));
            }
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            $content = @file_get_contents($path);
            if ($content !== false) {
                $mime = 'image/png';
                if (str_contains($path, '.jpg') || str_contains($path, '.jpeg')) $mime = 'image/jpeg';
                elseif (str_contains($path, '.webp')) $mime = 'image/webp';
                elseif (str_contains($path, '.svg')) $mime = 'image/svg+xml';
                return 'data:' . $mime . ';base64,' . base64_encode($content);
            }
        }

        if (Storage::disk('public')->exists($path)) {
            $fullPath = storage_path('app/public/' . $path);
            $mime = mime_content_type($fullPath) ?: 'image/png';
            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
        }

        if (file_exists(public_path($path))) {
            $fullPath = public_path($path);
            $mime = mime_content_type($fullPath) ?: 'image/png';
            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
        }

        $fallback = public_path('images/logo.png');
        if (file_exists($fallback)) {
            return 'data:image/png;base64,' . base64_encode(file_get_contents($fallback));
        }

        return null;
    }
}