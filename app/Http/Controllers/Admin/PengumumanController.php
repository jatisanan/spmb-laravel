<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::query();

        if ($request->filled('target')) {
            $query->where('target', $request->target);
        }

        if ($request->filled('status')) {
            $query->where('publish', $request->status === 'publish');
        }

        $pengumumen = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pengumuman.index', compact('pengumumen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
            'target' => 'required|in:semua,admin,student',
            'publish' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['publish'] = $request->boolean('publish');
        $validated['published_at'] = $validated['published_at'] ?? now();

        Pengumuman::create($validated);

        return back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
            'target' => 'required|in:semua,admin,student',
            'publish' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['publish'] = $request->boolean('publish');

        $pengumuman->update($validated);

        return back()->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;
        $pengumuman->delete();

        return back()->with('success', "Pengumuman \"{$judul}\" berhasil dihapus.");
    }

    public function toggle(Pengumuman $pengumuman)
    {
        $pengumuman->update([
            'publish' => !$pengumuman->publish,
            'published_at' => $pengumuman->published_at ?? now(),
        ]);

        return back()->with('success', 'Status publikasi berhasil diubah.');
    }
}