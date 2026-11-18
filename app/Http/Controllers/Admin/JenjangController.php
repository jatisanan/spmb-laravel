<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JenjangController extends Controller
{
    public function index()
    {
        $jenjangs = Jenjang::withCount('pendaftarans')
            ->with(['gelombang' => fn ($q) => $q->orderBy('tanggal_mulai')])
            ->orderBy('kode')
            ->get();

        return view('admin.jenjang.index', compact('jenjangs'));
    }

    public function edit(Jenjang $jenjang)
    {
        return view('admin.jenjang.edit', compact('jenjang'));
    }

    public function update(Request $request, Jenjang $jenjang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'label' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
            'aktif' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        // Handle upload logo
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($jenjang->logo_path && Storage::disk('public')->exists($jenjang->logo_path)) {
                Storage::disk('public')->delete($jenjang->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('jenjang', 'public');
        }

        $jenjang->update($validated);

        return redirect()
            ->route('admin.jenjang.index')
            ->with('success', "Jenjang {$jenjang->nama} berhasil diupdate.");
    }

    public function toggle(Jenjang $jenjang)
    {
        $jenjang->update(['aktif' => !$jenjang->aktif]);

        return back()->with('success', "Status {$jenjang->nama} berhasil diubah.");
    }
}