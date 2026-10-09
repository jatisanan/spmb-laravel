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

        if ($request->filled('q')) {
            $query->search($request->q);
        }
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }
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

    // ============================================
    // UPDATE VERIFIKASI
    // ============================================
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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status verifikasi berhasil diupdate.',
                'data' => $this->rowData($pendaftaran),
            ]);
        }

        return back()->with('success', 'Status verifikasi berhasil diupdate.');
    }

    // ============================================
    // UPDATE UJIAN (guard: harus Terverifikasi)
    // ============================================
    public function updateUjian(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status_verifikasi !== 'Terverifikasi') {
            $msg = 'Ujian tidak bisa dijadwalkan. Verifikasi berkas terlebih dahulu (Status: ' . $pendaftaran->status_verifikasi . ').';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data ujian berhasil diupdate.',
                'data' => $this->rowData($pendaftaran),
            ]);
        }

        return back()->with('success', 'Data ujian berhasil diupdate.');
    }

    // ============================================
    // UPDATE KELULUSAN (guard: harus Sudah Ujian)
    // ============================================
    public function updateKelulusan(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status_ujian !== 'Sudah Ujian') {
            $msg = 'Kelulusan belum bisa diubah. Pendaftar harus menyelesaikan ujian terlebih dahulu (Status Ujian: ' . $pendaftaran->status_ujian . ').';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $request->validate([
            'status_kelulusan' => 'required|in:Menunggu Hasil,Lulus,Tidak Lulus',
        ]);

        $pendaftaran->update([
            'status_kelulusan' => $request->status_kelulusan,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status kelulusan berhasil diupdate.',
                'data' => $this->rowData($pendaftaran),
            ]);
        }

        return back()->with('success', 'Status kelulusan berhasil diupdate.');
    }

    // ============================================
    // UPDATE DAFTAR ULANG (guard: harus Lulus)
    // ============================================
    public function updateDaftarUlang(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status_kelulusan !== 'Lulus') {
            $msg = 'Daftar ulang belum bisa diubah. Pendaftar harus dinyatakan LULUS terlebih dahulu (Status Kelulusan: ' . $pendaftaran->status_kelulusan . ').';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status daftar ulang berhasil diupdate.',
                'data' => $this->rowData($pendaftaran),
            ]);
        }

        return back()->with('success', 'Status daftar ulang berhasil diupdate.');
    }

    /**
     * Data ringkas untuk update baris tabel via AJAX.
     */
    private function rowData(Pendaftaran $p): array
    {
        return [
            'id' => $p->id,
            'status_verifikasi' => $p->status_verifikasi,
            'status_ujian' => $p->status_ujian,
            'status_kelulusan' => $p->status_kelulusan,
            'status_daftar_ulang' => $p->status_daftar_ulang,
            'nilai_ujian' => $p->nilai_ujian,
        ];
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
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($out, [
                'Nomor Pendaftaran', 'NISN', 'Nama Lengkap', 'Jenis Kelamin',
                'Tempat Lahir', 'Tanggal Lahir', 'Asal Sekolah',
                'Jenjang', 'Gelombang',
                'Nama Ayah', 'Nama Ibu', 'Nama Wali',
                'No WhatsApp', 'Email', 'Alamat',
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
                    $p->email,
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
            'asal_sekolah' => 'required|string|max:150',
            'jenjang_id' => 'required|exists:jenjangs,id',
            'gelombang_id' => 'required|exists:gelombang_pendaftarans,id',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'nama_wali' => 'nullable|string|max:100',
            'no_whatsapp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
        ]);

        $pendaftaran->update($validated);

        return redirect()
            ->route('admin.pendaftaran.show', $pendaftaran)
            ->with('success', 'Data pendaftar berhasil diupdate.');
    }
}