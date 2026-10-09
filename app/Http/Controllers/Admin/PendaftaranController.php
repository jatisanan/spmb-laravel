<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['jenjang', 'gelombang']);

        // Search
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // Filter jenjang
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }

        // Filter verifikasi
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        // Filter kelulusan
        if ($request->filled('status_kelulusan')) {
            $query->where('status_kelulusan', $request->status_kelulusan);
        }

        $pendaftarans = $query->latest()->paginate(15)->withQueryString();
        $jenjangs = Jenjang::all();

        return view('admin.pendaftaran.index', compact('pendaftarans', 'jenjangs'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['jenjang', 'gelombang', 'berkas']);
        $jenjangs = Jenjang::all();

        return view('admin.pendaftaran.show', compact('pendaftaran', 'jenjangs'));
    }

    public function updateVerifikasi(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:Menunggu Verifikasi,Terverifikasi,Perlu Perbaikan',
            'catatan_verifikasi' => 'nullable|string|max:500',
        ]);

        $pendaftaran->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        return back()->with('success', 'Status verifikasi berhasil diupdate.');
    }

    public function updateUjian(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status_ujian' => 'required|in:Belum Dijadwalkan,Terjadwal,Sudah Ujian',
            'tanggal_ujian' => 'nullable|date',
            'nilai_ujian' => 'nullable|string|max:20',
        ]);

        $pendaftaran->update([
            'status_ujian' => $request->status_ujian,
            'tanggal_ujian' => $request->tanggal_ujian,
            'nilai_ujian' => $request->nilai_ujian,
        ]);

        return back()->with('success', 'Data ujian berhasil diupdate.');
    }

    public function updateKelulusan(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status_kelulusan' => 'required|in:Menunggu Hasil,Lulus,Tidak Lulus',
        ]);

        $pendaftaran->update([
            'status_kelulusan' => $request->status_kelulusan,
        ]);

        return back()->with('success', 'Status kelulusan berhasil diupdate.');
    }

    public function updateDaftarUlang(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status_daftar_ulang' => 'required|in:Belum Dibuka,Sudah Daftar Ulang,Belum Daftar Ulang',
            'tanggal_daftar_ulang' => 'nullable|date',
            'link_daftar_ulang' => 'nullable|url|max:500',
        ], [
            'link_daftar_ulang.url' => 'Link harus berupa URL yang valid (contoh: https://...).',
        ]);

        $pendaftaran->update([
            'status_daftar_ulang' => $request->status_daftar_ulang,
            'tanggal_daftar_ulang' => $request->tanggal_daftar_ulang,
            'link_daftar_ulang' => $request->link_daftar_ulang,
        ]);

        return back()->with('success', 'Status daftar ulang berhasil diupdate.');
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        $nomor = $pendaftaran->nomor_pendaftaran;
        $pendaftaran->delete();

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', "Pendaftaran {$nomor} berhasil dihapus.");
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Pendaftaran::with(['jenjang', 'gelombang']);

        if ($request->filled('q')) $query->search($request->q);
        if ($request->filled('jenjang_id')) $query->where('jenjang_id', $request->jenjang_id);
        if ($request->filled('status_verifikasi')) $query->where('status_verifikasi', $request->status_verifikasi);
        if ($request->filled('status_kelulusan')) $query->where('status_kelulusan', $request->status_kelulusan);

        $data = $query->latest()->get();

        $filename = 'pendaftar-SPMB-' . date('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($data) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            // === Header CSV (tambah Email) ===
            fputcsv($out, [
                'Nomor Pendaftaran', 'NISN', 'Nama Lengkap', 'Jenis Kelamin',
                'Tempat Lahir', 'Tanggal Lahir', 'Asal Sekolah',
                'Jenjang', 'Gelombang',
                'Nama Ayah', 'Nama Ibu', 'Nama Wali',
                'No WhatsApp', 'Email', 'Alamat',       // ← Email ditambahkan
                'Status Verifikasi', 'Status Ujian', 'Tanggal Ujian', 'Nilai Ujian',
                'Status Kelulusan', 'Status Daftar Ulang', 'Tanggal Daftar Ulang',
                'Tanggal Daftar',
            ]);

            foreach ($data as $p) {
                fputcsv($out, [
                    $p->nomor_pendaftaran,
                    $p->nisn,
                    $p->nama_lengkap,
                    $p->jenis_kelamin,
                    $p->tempat_lahir,
                    $p->tanggal_lahir?->format('Y-m-d'),
                    $p->asal_sekolah,
                    $p->jenjang->nama,
                    $p->gelombang->nama,
                    $p->nama_ayah,
                    $p->nama_ibu,
                    $p->nama_wali,
                    $p->no_whatsapp,
                    $p->email,                          // ← Email ditambahkan
                    $p->alamat,
                    $p->status_verifikasi,
                    $p->status_ujian,
                    $p->tanggal_ujian?->format('Y-m-d'),
                    $p->nilai_ujian,
                    $p->status_kelulusan,
                    $p->status_daftar_ulang,
                    $p->tanggal_daftar_ulang?->format('Y-m-d'),
                    $p->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['jenjang', 'gelombang']);
        $jenjangs = Jenjang::with(['gelombang' => function ($q) {
            $q->where('aktif', true)->orderBy('tanggal_mulai');
        }])->where('aktif', true)->get();

        return view('admin.pendaftaran.edit', compact('pendaftaran', 'jenjangs'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nisn' => 'required|string|size:10|unique:pendaftarans,nisn,' . $pendaftaran->id,
            'tempat_lahir' => 'required|string|max:100',
            // 'tanggal_lahir' => DIHAPUS — tidak boleh diubah
            'asal_sekolah' => 'required|string|max:150',
            'jenjang_id' => 'required|exists:jenjangs,id',
            'gelombang_id' => 'required|exists:gelombang_pendaftarans,id',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'nama_wali' => 'nullable|string|max:100',
            'no_whatsapp' => 'required|string|max:20',
            // 'email' => DIHAPUS — tidak boleh diubah
            'alamat' => 'required|string|max:500',
        ]);

        $pendaftaran->update($validated);

        return redirect()
            ->route('admin.pendaftaran.show', $pendaftaran)
            ->with('success', 'Data pendaftar berhasil diupdate.');
    }
}