<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\InfoPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoPembayaranController extends Controller
{
    public function index()
    {
        $gelombangs = GelombangPendaftaran::with(['jenjang', 'infoPembayaran'])
            ->orderBy('jenjang_id')
            ->orderBy('tanggal_mulai')
            ->get();

        return view('admin.info-pembayaran.index', compact('gelombangs'));
    }

    public function edit(GelombangPendaftaran $gelombang)
    {
        $gelombang->load(['jenjang', 'infoPembayaran']);
        $info = $gelombang->infoPembayaran ?? new InfoPembayaran(['gelombang_id' => $gelombang->id]);

        return view('admin.info-pembayaran.edit', compact('gelombang', 'info'));
    }

    public function update(Request $request, GelombangPendaftaran $gelombang)
    {
        $validated = $request->validate([
            // Offline
            'offline_alamat'     => 'nullable|string|max:255',
            'offline_cp_nama'    => 'nullable|string|max:100',
            'offline_cp_hp'      => 'nullable|string|max:20',
            'offline_jam'        => 'nullable|string|max:100',
            'offline_catatan'    => 'nullable|string|max:500',

            // Transfer
            'transfer_bank'      => 'nullable|string|max:100',
            'transfer_norek'     => 'nullable|string|max:50',
            'transfer_atas_nama' => 'nullable|string|max:100',
            'transfer_cabang'    => 'nullable|string|max:100',

            // Umum
            'catatan_umum'       => 'nullable|string|max:500',

            // QRIS
            'qris_image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $info = InfoPembayaran::firstOrNew(['gelombang_id' => $gelombang->id]);

        // Handle QRIS upload
        if ($request->hasFile('qris_image')) {
            // Hapus lama
            if ($info->qris_image_path && Storage::disk('public')->exists($info->qris_image_path)) {
                Storage::disk('public')->delete($info->qris_image_path);
            }
            $path = $request->file('qris_image')->store('qris', 'public');
            $validated['qris_image_path'] = $path;
        }

        // Handle hapus QRIS
        if ($request->boolean('hapus_qris') && $info->qris_image_path) {
            if (Storage::disk('public')->exists($info->qris_image_path)) {
                Storage::disk('public')->delete($info->qris_image_path);
            }
            $validated['qris_image_path'] = null;
        }

        unset($validated['qris_image'], $validated['hapus_qris']);
        $info->fill($validated);
        $info->gelombang_id = $gelombang->id;
        $info->save();

        return redirect()
            ->route('admin.info-pembayaran.index')
            ->with('success', 'Info pembayaran berhasil disimpan.');
    }
}