<?php

namespace Database\Seeders;

use App\Models\GelombangPendaftaran;
use App\Models\Jenjang;
use Illuminate\Database\Seeder;

class GelombangSeeder extends Seeder
{
    public function run(): void
    {
        $smp = Jenjang::where('kode', 'smp')->first();
        $sma = Jenjang::where('kode', 'sma')->first();

        // SMA
        $dataSma = [
            ['Indent', '2026-10-01', '2026-12-31', '2026-12-31', 100000],
            ['Gelombang 1', '2027-01-01', '2027-03-31', '2027-03-31', 125000],
            ['Gelombang 2', '2027-04-01', '2027-06-30', null, 175000],
        ];

        foreach ($dataSma as $d) {
            GelombangPendaftaran::create([
                'jenjang_id' => $sma->id,
                'nama' => $d[0],
                'tanggal_mulai' => $d[1],
                'tanggal_selesai' => $d[2],
                'tanggal_ujian' => $d[3],
                'biaya' => $d[4],
                'aktif' => true,
            ]);
        }

        // SMP
        $dataSmp = [
            ['Indent', '2026-10-01', '2026-12-31', '2026-12-31', 75000],
            ['Gelombang 1', '2027-01-01', '2027-03-31', '2027-03-31', 100000],
            ['Gelombang 2', '2027-04-01', '2027-06-30', null, 150000],
        ];

        foreach ($dataSmp as $d) {
            GelombangPendaftaran::create([
                'jenjang_id' => $smp->id,
                'nama' => $d[0],
                'tanggal_mulai' => $d[1],
                'tanggal_selesai' => $d[2],
                'tanggal_ujian' => $d[3],
                'biaya' => $d[4],
                'aktif' => true,
            ]);
        }
    }
}