<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;

class WelcomeController extends Controller
{
    public function index()
    {
        $jenjangs = Jenjang::with(['gelombang' => function ($q) {
            $q->where('aktif', true)->orderBy('tanggal_mulai');
        }])->where('aktif', true)->get();

        return view('welcome', compact('jenjangs'));
    }
}