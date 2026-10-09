<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\Jenjang;
use Illuminate\Http\Request;

class GelombangController extends Controller
{
    public function store(Request $request, Jenjang $jenjang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tanggal_ujian' => 'nullable|date',
            'biaya' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:500',
        ]);

        $validated['jenjang_id'] = $jenjang->id;
        $validated['aktif'] = true;

        GelombangPendaftaran::create($validated);

        return back()->with('success', "Gelombang {$validated['nama']} berhasil ditambahkan.");
    }

    public function update(Request $request, GelombangPendaftaran $gelombang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tanggal_ujian' => 'nullable|date',
            'biaya' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:500',
            'aktif' => 'boolean',
        ]);

        $gelombang->update($validated);

        return back()->with('success', "Gelombang {$gelombang->nama} berhasil diupdate.");
    }

    public function destroy(GelombangPendaftaran $gelombang)
    {
        // Cek apakah ada pendaftar di gelombang ini
        if ($gelombang->pendaftarans()->exists()) {
            return back()->with('error', 'Tidak bisa hapus gelombang yang sudah memiliki pendaftar.');
        }

        $nama = $gelombang->nama;
        $gelombang->delete();

        return back()->with('success', "Gelombang {$nama} berhasil dihapus.");
    }

    public function toggle(GelombangPendaftaran $gelombang)
    {
        $gelombang->update(['aktif' => !$gelombang->aktif]);

        return back()->with('success', "Status gelombang {$gelombang->nama} berhasil diubah.");
    }
}