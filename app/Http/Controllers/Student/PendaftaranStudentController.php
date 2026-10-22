<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\Jenjang;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PendaftaranStudentController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        // Kalau sudah daftar → balik ke dashboard
        if ($user->pendaftaran()->exists()) {
            return redirect()->route('student.dashboard');
        }

        $jenjangs = Jenjang::with(['gelombang' => fn($q) => $q->orderBy('tanggal_mulai')])->get();

        return view('student.pendaftaran', compact('user', 'jenjangs'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->pendaftaran()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap'  => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nisn'          => 'required|digits:10|unique:pendaftarans,nisn',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'asal_sekolah'  => 'required|string|max:150',
            'jenjang_id'    => 'required|exists:jenjangs,id',
            'gelombang_id'  => 'required|exists:gelombang_pendaftarans,id',
            'nama_ayah'     => 'required|string|max:100',
            'nama_ibu'      => 'required|string|max:100',
            'nama_wali'     => 'nullable|string|max:100',
            'no_whatsapp'   => ['required', 'string', 'regex:/^[0-9]{11,12}$/'],
            'alamat'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $jenjang   = Jenjang::findOrFail($request->jenjang_id);
            $gelombang = GelombangPendaftaran::findOrFail($request->gelombang_id);
            $nomor     = Pendaftaran::generateNomor($jenjang->kode);

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
                'email'               => $user->email,
                'alamat'              => $request->alamat,
                'nama_ayah'           => $request->nama_ayah,
                'nama_ibu'            => $request->nama_ibu,
                'nama_wali'           => $request->nama_wali,
                'status_verifikasi'   => 'Menunggu Verifikasi',
                'status_ujian'        => 'Belum Dijadwalkan',
                'status_kelulusan'    => 'Menunggu Hasil',
                'status_daftar_ulang' => 'Belum Dibuka',
            ]);

            Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jumlah'         => $gelombang->biaya,
                'status'         => 'Belum Bayar',
            ]);

            $user->update([
                'name' => $request->nama_lengkap,
                'nisn' => $request->nisn,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil!',
                'data' => [
                    'nomor_pendaftaran' => $nomor,
                    'redirect'          => route('student.dashboard'),
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Student pendaftaran error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data.',
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}