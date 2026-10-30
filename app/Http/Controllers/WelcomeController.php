<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;

class WelcomeController extends Controller
{
    public function index()
    {
        $jenjangs = Jenjang::with(['gelombang' => function ($q) {
            $q->orderBy('tanggal_mulai');   // ← filter aktif DIHAPUS
        }])->where('aktif', true)->get();    // ← filter aktif jenjang TETAP

        return view('welcome', compact('jenjangs'));
    }
}