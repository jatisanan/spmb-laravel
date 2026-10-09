<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pendaftaran = $user->pendaftaran?->load(['jenjang', 'gelombang']);

        // Pengumuman untuk santri
        $pengumuman = Pengumuman::published()
            ->whereIn('target', ['semua', 'student'])
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('student.dashboard', compact('user', 'pendaftaran', 'pengumuman'));
    }
}