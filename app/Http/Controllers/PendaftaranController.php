<?php

namespace App\Http\Controllers;

use App\Models\GelombangPendaftaran;
use App\Models\Jenjang;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    private const EMAIL_CACHE_TTL = 600; // 10 menit

    public function validasi(Request $request)
    {
        $this->normalizeInput($request);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $email = $request->email;
        $cacheKey = $this->emailCacheKey($email);

        $isEmailValid = Cache::remember($cacheKey, self::EMAIL_CACHE_TTL, function () use ($email) {
            return $this->checkEmailActive($email);
        });

        if (!$isEmailValid) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'email' => ['Alamat email tidak valid atau tidak dapat ditemukan. Gunakan email aktif.'],
                ],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Validasi berhasil. Silakan konfirmasi data Anda.',
        ]);
    }

    public function store(Request $request)
    {
        $this->normalizeInput($request);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $email = $request->email;
        $cacheKey = $this->emailCacheKey($email);

        $isEmailValid = Cache::remember($cacheKey, self::EMAIL_CACHE_TTL, function () use ($email) {
            return $this->checkEmailActive($email);
        });

        if (!$isEmailValid) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'email' => ['Alamat email tidak valid atau tidak dapat ditemukan.'],
                ],
            ], 422);
        }

        try {
            DB::beginTransaction();

            $jenjang   = Jenjang::findOrFail($request->jenjang_id);
            $gelombang = GelombangPendaftaran::findOrFail($request->gelombang_id);
            $nomor     = Pendaftaran::generateNomor($jenjang->kode);

            $passwordPlain = User::generatePasswordFromBirthdate($request->tanggal_lahir);

            $user = User::create([
                'name'        => $request->nama_lengkap,
                'email'       => $request->email,
                'password'    => Hash::make($passwordPlain),
                'role'        => 'student',
                'nisn'        => $request->nisn,
                'no_whatsapp' => $request->no_whatsapp,
                'is_active'   => true,
            ]);

            $pendaftaran = Pendaftaran::create([
                'nomor_pendaftaran'   => $nomor,
                'user_id'             => $user->id,
                'jenjang_id'          => $request->jenjang_id,
                'gelombang_id'        => $request->gelombang_id,
                'nama_lengkap'        => $request->nama_lengkap,
                'jenis_kelamin'       => $request->jenis_kelamin,
                'nisn'                => $request->nisn,
                'tempat_lahir'        => $request->tempat_lahir,
                'tanggal_lahir'       => $request->tanggal_lahir,
                'asal_sekolah'        => $request->asal_sekolah,
                'no_whatsapp'         => $request->no_whatsapp,
                'email'               => $request->email,
                'alamat'              => $request->alamat,
                'nama_ayah'           => $request->nama_ayah,
                'nama_ibu'            => $request->nama_ibu,
                'nama_wali'           => $request->nama_wali,
                'status_verifikasi'   => 'Menunggu Verifikasi',
                'status_ujian'        => 'Belum Dijadwalkan',
                'status_kelulusan'    => 'Menunggu Hasil',
                'status_daftar_ulang' => 'Belum Dibuka',
            ]);

            // Buat record pembayaran awal
            Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jumlah'         => $gelombang->biaya,
                'status'         => 'Belum Bayar',
            ]);

            DB::commit();

            Cache::forget($cacheKey);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil!',
                'data' => [
                    'nomor_pendaftaran' => $nomor,
                    'nama_lengkap'      => $pendaftaran->nama_lengkap,
                    'jenjang'           => $jenjang->nama,
                    'gelombang'         => $gelombang->nama,
                    'email'             => $user->email,
                    'password'          => $passwordPlain,
                    'biaya'             => (float) $gelombang->biaya,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Pendaftaran store error: ' . $e->getMessage(), [
                'email' => $request->email,
                'nisn'  => $request->nisn,
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function cekStatus(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string',
        ]);

        $pendaftaran = Pendaftaran::with(['jenjang', 'gelombang', 'pembayaran'])
            ->where('nomor_pendaftaran', $request->nomor_pendaftaran)
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor pendaftaran tidak ditemukan.',
            ], 404);
        }

        $statusPembayaran     = $pendaftaran->pembayaran?->status ?? 'Belum Bayar';
        $statusVerifikasi     = $pendaftaran->status_verifikasi;
        $statusUjian          = $pendaftaran->status_ujian;
        $statusKelulusan      = $pendaftaran->status_kelulusan;
        $statusDaftarUlang    = $pendaftaran->status_daftar_ulang;
        $linkDaftarUlang      = $pendaftaran->link_daftar_ulang;

        $bolehDaftarUlang = $statusKelulusan === 'Lulus'
            && $statusDaftarUlang === 'Belum Daftar Ulang'
            && !empty($linkDaftarUlang);

        return response()->json([
            'success' => true,
            'data' => [
                'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
                'nama_lengkap'      => $pendaftaran->nama_lengkap,
                'jenjang'           => $pendaftaran->jenjang->nama,
                'gelombang'         => $pendaftaran->gelombang?->nama ?? '—',
                'email'             => $pendaftaran->email,

                // 1. Pembayaran
                'status_pembayaran' => $statusPembayaran,

                // 2. Verifikasi Pendaftaran (berkas)
                'status_verifikasi'  => $statusVerifikasi,
                'catatan_verifikasi' => $pendaftaran->catatan_verifikasi,

                // 3. Ujian
                'status_ujian'         => $statusUjian,
                'tanggal_ujian'        => $pendaftaran->tanggal_ujian?->isoFormat('D MMMM Y'),
                'tanggal_ujian_short'  => $pendaftaran->tanggal_ujian?->isoFormat('D MMM Y'),
                'nilai_ujian'          => $pendaftaran->nilai_ujian,

                // 4. Kelulusan
                'status_kelulusan' => $statusKelulusan,

                // 5. Daftar Ulang
                'status_daftar_ulang'  => $statusDaftarUlang,
                'link_daftar_ulang'    => $linkDaftarUlang,
                'tanggal_daftar_ulang' => $pendaftaran->tanggal_daftar_ulang?->isoFormat('D MMMM Y'),

                // Flag untuk CTA
                'boleh_daftar_ulang' => $bolehDaftarUlang,
            ],
        ]);
    }

    public function getGelombang($jenjangId)
    {
        $gelombang = GelombangPendaftaran::where('jenjang_id', $jenjangId)
            ->orderBy('tanggal_mulai')
            ->get(['id', 'nama', 'biaya', 'tanggal_mulai', 'tanggal_selesai', 'tanggal_ujian', 'aktif']);

        return response()->json($gelombang);
    }

    // ============================================
    // PRIVATE HELPERS
    // ============================================

    private function normalizeInput(Request $request): void
    {
        $request->merge([
            'email'        => strtolower(trim((string) $request->email)),
            'nama_lengkap' => strtoupper(trim((string) $request->nama_lengkap)),
            'tempat_lahir' => strtoupper(trim((string) $request->tempat_lahir)),
            'asal_sekolah' => strtoupper(trim((string) $request->asal_sekolah)),
            'nama_ayah'    => strtoupper(trim((string) $request->nama_ayah)),
            'nama_ibu'     => strtoupper(trim((string) $request->nama_ibu)),
            'nama_wali'    => $request->filled('nama_wali')
                                ? strtoupper(trim((string) $request->nama_wali))
                                : null,
            'alamat'       => strtoupper(trim((string) $request->alamat)),
            'nisn'         => trim((string) $request->nisn),
            'no_whatsapp'  => trim((string) $request->no_whatsapp),
        ]);
    }

    private function rules(): array
    {
        return [
            'nama_lengkap'  => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nisn'          => 'required|digits:10|unique:pendaftarans,nisn|unique:users,nisn',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'asal_sekolah'  => 'required|string|max:150',
            'jenjang_id'    => 'required|exists:jenjangs,id',
            'gelombang_id'  => 'required|exists:gelombang_pendaftarans,id',
            'nama_ayah'     => 'required|string|max:100',
            'nama_ibu'      => 'required|string|max:100',
            'nama_wali'     => 'nullable|string|max:100',
            'no_whatsapp'   => ['required', 'string', 'regex:/^[0-9]{11,12}$/'],
            'email'         => 'required|email|max:150|unique:users,email',
            'alamat'        => 'required|string',
        ];
    }

    private function messages(): array
    {
        return [
            'nisn.digits'          => 'NISN harus 10 digit angka.',
            'nisn.unique'          => 'NISN ini sudah terdaftar.',
            'email.unique'         => 'Email ini sudah terdaftar. Gunakan email lain atau login jika sudah punya akun.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex'    => 'Nomor WhatsApp harus 11–12 digit angka.',
        ];
    }

    private function checkEmailActive(string $email): bool
    {
        try {
            $validator = new \App\Services\EmailValidationService();
            return $validator->validate($email);
        } catch (\Exception $e) {
            Log::warning('Email validation API failed: ' . $e->getMessage(), [
                'email' => $email,
            ]);
            return true;
        }
    }

    private function emailCacheKey(string $email): string
    {
        return 'email_valid:' . md5(strtolower(trim($email)));
    }
}