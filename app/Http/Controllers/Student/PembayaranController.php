<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Halaman utama pembayaran.
     * - Auto-create record Pembayaran kalau belum ada (snapshot biaya).
     * - Kalau user pindah gelombang, sync nominal.
     */
    public function index()
    {
        $user = auth()->user();

        $pendaftaran = $user->pendaftaran()
            ->with(['jenjang', 'gelombang.infoPembayaran', 'pembayaran'])
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum memiliki data pendaftaran.');
        }

        $pembayaran = $this->ensurePembayaran($pendaftaran);

        // Refresh relasi
        $pendaftaran->load(['gelombang.infoPembayaran', 'pembayaran']);
        $pembayaran = $pendaftaran->pembayaran;
        $info = $pendaftaran->gelombang->infoPembayaran;

        return view('student.pembayaran.index', compact('pendaftaran', 'pembayaran', 'info'));
    }

    /**
     * Upload bukti bayar.
     */
    public function uploadBukti(Request $request)
    {
        $request->validate([
            'metode' => 'required|in:offline,transfer,qris',
            'bukti'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'bukti.mimes' => 'File harus JPG, PNG, atau PDF.',
            'bukti.max'   => 'Ukuran file maksimal 2MB.',
        ]);

        $pendaftaran = auth()->user()->pendaftaran()->first();
        if (!$pendaftaran) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $pembayaran = $this->ensurePembayaran($pendaftaran);

        if ($pembayaran->status === 'Terverifikasi') {
            return back()->with('error', 'Pembayaran sudah terverifikasi, tidak bisa upload ulang.');
        }

        if ($pembayaran->status === 'Menunggu Verifikasi') {
            return back()->with('error', 'Bukti bayar Anda sedang diverifikasi admin. Tunggu hasilnya.');
        }

        // Hapus file lama
        if ($pembayaran->bukti_path && Storage::disk('public')->exists($pembayaran->bukti_path)) {
            Storage::disk('public')->delete($pembayaran->bukti_path);
        }

        // Simpan file baru
        $file = $request->file('bukti');
        $path = $file->store('bukti-bayar', 'public');

        $pembayaran->update([
            'metode'          => $request->metode,
            'bukti_path'      => $path,
            'bukti_nama_asli' => $file->getClientOriginalName(),
            'status'          => 'Menunggu Verifikasi',
            'uploaded_at'     => now(),
            'catatan_admin'   => null,
            'verified_by'     => null,
            'verified_at'     => null,
        ]);

        // NOTE: Tidak ada sync manual ke pendaftaran.status_pembayaran.
        // Semua pembacaan status pembayaran dilakukan via relasi $pendaftaran->pembayaran.

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * Pastikan record Pembayaran ada & sinkron dengan gelombang saat ini.
     * Kalau user pindah gelombang, nominal di-update (hanya kalau belum upload / belum diverifikasi).
     */
    private function ensurePembayaran($pendaftaran): Pembayaran
    {
        $pembayaran = $pendaftaran->pembayaran;

        // Belum ada → buat baru dengan snapshot biaya gelombang
        if (!$pembayaran) {
            $pembayaran = Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jumlah'         => $pendaftaran->gelombang->biaya,
                'status'         => 'Belum Bayar',
            ]);

            return $pembayaran;
        }

        // Sudah ada → cek apakah biaya gelombang berubah?
        $biayaSekarang = $pendaftaran->gelombang->biaya;

        if ($pembayaran->jumlah != $biayaSekarang) {
            // Update nominal HANYA kalau belum pernah upload / belum diverifikasi
            if (in_array($pembayaran->status, ['Belum Bayar', 'Gagal'])) {
                $pembayaran->update(['jumlah' => $biayaSekarang]);
            }
        }

        return $pembayaran;
    }
}