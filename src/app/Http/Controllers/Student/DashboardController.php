<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BerkasPendaftaran;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $pendaftaran = $user->pendaftaran()
            ->with(['jenjang', 'gelombang', 'pembayaran', 'berkas'])
            ->first();

        $pengumuman = Pengumuman::published()
            ->whereIn('target', ['semua', 'student'])
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('student.dashboard', compact('user', 'pendaftaran', 'pengumuman'));
    }

    /**
     * Upload / ganti foto siswa (untuk siswa lama yang belum punya foto).
     */
    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'foto.required' => 'Foto siswa wajib dipilih.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        $pendaftaran = auth()->user()->pendaftaran()->first();

        if (!$pendaftaran) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $file = $request->file('foto');
        $path = $file->store('foto-siswa', 'public');

        $berkasLama = $pendaftaran->berkas()->where('jenis', 'foto')->first();

        if ($berkasLama) {
            if (Storage::disk('public')->exists($berkasLama->file_path)) {
                Storage::disk('public')->delete($berkasLama->file_path);
            }
            $berkasLama->update([
                'file_path' => $path,
                'nama_asli' => $file->getClientOriginalName(),
                'verified'  => false,
            ]);
        } else {
            BerkasPendaftaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jenis'          => 'foto',
                'file_path'      => $path,
                'nama_asli'      => $file->getClientOriginalName(),
                'verified'       => false,
            ]);
        }

        return redirect()
            ->route('student.dashboard')
            ->with('success', 'Foto siswa berhasil diupload.');
    }
}