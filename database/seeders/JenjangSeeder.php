<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use Illuminate\Database\Seeder;

class JenjangSeeder extends Seeder
{
    public function run(): void
    {
        Jenjang::updateOrCreate(['kode' => 'smp'], [
            'nama' => 'SMP Al Jumhuri',
            'label' => 'Jenjang Menengah Pertama',
            'deskripsi' => 'Masa pembentukan fondasi ilmu, adab, dan kebiasaan belajar yang baik bagi santri usia menengah pertama.',
            'aktif' => true,
        ]);

        Jenjang::updateOrCreate(['kode' => 'sma'], [
            'nama' => 'SMA Al Jumhuri',
            'label' => 'Jenjang Menengah Atas',
            'deskripsi' => 'Masa pendalaman ilmu, pembentukan karakter kepemimpinan, dan persiapan menuju pendidikan tinggi.',
            'aktif' => true,
        ]);
    }
}