<?php

namespace App\Http\Controllers;

use App\Models\GelombangPendaftaran;
use App\Models\Jenjang;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * Simpan pendaftaran baru + buat akun user otomatis.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nisn' => 'required|digits:10|unique:pendaftarans,nisn|unique:users,nisn',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'asal_sekolah' => 'required|string|max:150',
            'jenjang_id' => 'required|exists:jenjangs,id',
            'gelombang_id' => 'required|exists:gelombang_pendaftarans,id',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'nama_wali' => 'nullable|string|max:100',
            'no_whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:150|unique:users,email',
            'alamat' => 'required|string',
        ], [
            'nisn.digits' => 'NISN harus 10 digit angka.',
            'nisn.unique' => 'NISN ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar. Gunakan email lain atau login jika sudah punya akun.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $jenjang = Jenjang::findOrFail($request->jenjang_id);
            $gelombang = GelombangPendaftaran::findOrFail($request->gelombang_id);
            $nomor = Pendaftaran::generateNomor($jenjang->kode);

            // === 1. Buat User Baru ===
            $passwordPlain = User::generatePasswordFromBirthdate($request->tanggal_lahir);

            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($passwordPlain),
                'role' => 'student',
                'nisn' => $request->nisn,
                'no_whatsapp' => $request->no_whatsapp,
                'is_active' => true,
            ]);

            // === 2. Buat Pendaftaran ===
            $pendaftaran = Pendaftaran::create([
                'nomor_pendaftaran' => $nomor,
                'user_id' => $user->id,
                'jenjang_id' => $request->jenjang_id,
                'gelombang_id' => $request->gelombang_id,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nisn' => $request->nisn,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'asal_sekolah' => $request->asal_sekolah,
                'no_whatsapp' => $request->no_whatsapp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'nama_wali' => $request->nama_wali,
                'status_verifikasi' => 'Menunggu Verifikasi',
                'status_ujian' => 'Belum Dijadwalkan',
                'status_kelulusan' => 'Menunggu Hasil',
                'status_daftar_ulang' => 'Belum Dibuka',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil!',
                'data' => [
                    'nomor_pendaftaran' => $nomor,
                    'nama_lengkap' => $pendaftaran->nama_lengkap,
                    'jenjang' => $jenjang->nama,
                    'gelombang' => $gelombang->nama,
                    'email' => $user->email,
                    'password' => $passwordPlain,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Cek status pendaftaran by nomor.
     */
    public function cekStatus(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string',
        ]);

        $pendaftaran = Pendaftaran::with(['jenjang', 'gelombang'])
            ->where('nomor_pendaftaran', $request->nomor_pendaftaran)
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor pendaftaran tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
                'nama_lengkap' => $pendaftaran->nama_lengkap,
                'jenjang' => $pendaftaran->jenjang->nama,
                'gelombang' => $pendaftaran->gelombang->nama,
                'email' => $pendaftaran->email,

                'status_verifikasi' => $pendaftaran->status_verifikasi,
                'catatan_verifikasi' => $pendaftaran->catatan_verifikasi,

                'status_ujian' => $pendaftaran->status_ujian,
                'tanggal_ujian' => $pendaftaran->tanggal_ujian?->isoFormat('D MMMM Y'),
                'tanggal_ujian_short' => $pendaftaran->tanggal_ujian?->isoFormat('D MMM Y'),
                'nilai_ujian' => $pendaftaran->nilai_ujian,

                'status_kelulusan' => $pendaftaran->status_kelulusan,

                'status_daftar_ulang' => $pendaftaran->status_daftar_ulang,
                'link_daftar_ulang' => $pendaftaran->link_daftar_ulang,
                'tanggal_daftar_ulang' => $pendaftaran->tanggal_daftar_ulang?->isoFormat('D MMMM Y'),
            ],
        ]);
    }

    /**
     * Ambil gelombang berdasarkan jenjang (dropdown dinamis).
     */
    public function getGelombang($jenjangId)
    {
        $gelombang = GelombangPendaftaran::where('jenjang_id', $jenjangId)
            ->where('aktif', true)
            ->orderBy('tanggal_mulai')
            ->get(['id', 'nama', 'biaya', 'tanggal_mulai', 'tanggal_selesai', 'tanggal_ujian']);

        return response()->json($gelombang);
    }
}