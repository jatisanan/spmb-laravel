<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;

class PengumumanPublikController extends Controller
{
    public function index()
    {
        $pengumumen = Pengumuman::published()
            ->whereIn('target', ['semua', 'student'])
            ->latest('published_at')
            ->paginate(9);

        return view('pengumuman.index', compact('pengumumen'));
    }

    public function show(Pengumuman $pengumuman)
    {
        abort_unless(
            $pengumuman->publish &&
            in_array($pengumuman->target, ['semua', 'student']) &&
            ($pengumuman->published_at === null || $pengumuman->published_at <= now()),
            404
        );

        $lainnya = Pengumuman::published()
            ->whereIn('target', ['semua', 'student'])
            ->where('id', '!=', $pengumuman->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pengumuman.show', compact('pengumuman', 'lainnya'));
    }
}