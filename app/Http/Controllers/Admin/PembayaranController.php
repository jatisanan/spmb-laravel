<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    /**
     * Index — tampilkan SEMUA pendaftar.
     */
    public function index(Request $request)
    {
        $baseQuery = Pendaftaran::with(['jenjang', 'gelombang', 'pembayaran']);

        if ($request->filled('q')) {
            $q = $request->q;
            $baseQuery->where(function ($qq) use ($q) {
                $qq->where('nama_lengkap', 'like', "%{$q}%")
                ->orWhere('nomor_pendaftaran', 'like', "%{$q}%")
                ->orWhere('nisn', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'Belum Bayar') {
                $baseQuery->where(function ($qq) {
                    $qq->whereDoesntHave('pembayaran')
                    ->orWhereHas('pembayaran', fn($q) => $q->where('status', 'Belum Bayar'));
                });
            } else {
                $baseQuery->whereHas('pembayaran', fn($q) => $q->where('status', $request->status));
            }
        }

        // Urutkan jenjang: SMP dulu, lalu SMA, sisanya
        $jenjangs = Jenjang::orderByRaw("
            CASE
                WHEN LOWER(nama) LIKE '%smp%' THEN 1
                WHEN LOWER(nama) LIKE '%sma%' THEN 2
                ELSE 3
            END
        ")->get();

        $targetJenjangs = $request->filled('jenjang_id')
            ? $jenjangs->where('id', $request->jenjang_id)
            : $jenjangs;

        $paginated = [];
        foreach ($targetJenjangs as $j) {
            $paginated[$j->id] = [
                'jenjang' => $j,
                'items' => (clone $baseQuery)
                    ->where('jenjang_id', $j->id)
                    ->latest()
                    ->paginate(10, ['*'], 'page_' . $j->id)
                    ->withQueryString(),
            ];
        }

        // Stats (tetap global, tidak per jenjang)
        $totalPendaftar = Pendaftaran::count();

        $belumBayar = Pendaftaran::where(function ($q) {
            $q->whereDoesntHave('pembayaran')
            ->orWhereHas('pembayaran', fn($qq) => $qq->where('status', 'Belum Bayar'));
        })->count();

        $menunggu      = Pembayaran::where('status', 'Menunggu Verifikasi')->count();
        $terverifikasi = Pembayaran::where('status', 'Terverifikasi')->count();
        $gagal         = Pembayaran::where('status', 'Gagal')->count();

        // === BREAKDOWN PER JENJANG ===
        // Kelompokkan jenjang: SMP, SMA, Lainnya
        // === BREAKDOWN PER JENJANG (dengan rincian L/P) ===
        $smpIds = $jenjangs->filter(fn($j) => str_contains(strtolower($j->nama), 'smp'))->pluck('id');
        $smaIds = $jenjangs->filter(fn($j) => str_contains(strtolower($j->nama), 'sma'))->pluck('id');

        // Helper: hitung total + L + P untuk sekumpulan jenjang_id
        $demo = function ($ids) {
            $base = Pendaftaran::whereIn('jenjang_id', $ids);
            return [
                'total'     => (clone $base)->count(),
                'laki'      => (clone $base)->where('jenis_kelamin', 'Laki-laki')->count(),
                'perempuan' => (clone $base)->where('jenis_kelamin', 'Perempuan')->count(),
            ];
        };

        // Helper: hitung berdasarkan status pembayaran
        $demoByPembayaran = function ($ids, string $status) {
            $base = Pendaftaran::whereIn('jenjang_id', $ids);

            if ($status === 'Belum Bayar') {
                $base->where(function ($qq) {
                    $qq->whereDoesntHave('pembayaran')
                       ->orWhereHas('pembayaran', fn($x) => $x->where('status', 'Belum Bayar'));
                });
            } else {
                $base->whereHas('pembayaran', fn($x) => $x->where('status', $status));
            }

            return [
                'total'     => (clone $base)->count(),
                'laki'      => (clone $base)->where('jenis_kelamin', 'Laki-laki')->count(),
                'perempuan' => (clone $base)->where('jenis_kelamin', 'Perempuan')->count(),
            ];
        };

        $breakdown = [
            'total'          => ['smp' => $demo($smpIds), 'sma' => $demo($smaIds)],
            'belum_bayar'    => ['smp' => $demoByPembayaran($smpIds, 'Belum Bayar'),         'sma' => $demoByPembayaran($smaIds, 'Belum Bayar')],
            'menunggu'       => ['smp' => $demoByPembayaran($smpIds, 'Menunggu Verifikasi'), 'sma' => $demoByPembayaran($smaIds, 'Menunggu Verifikasi')],
            'terverifikasi'  => ['smp' => $demoByPembayaran($smpIds, 'Terverifikasi'),       'sma' => $demoByPembayaran($smaIds, 'Terverifikasi')],
            'gagal'          => ['smp' => $demoByPembayaran($smpIds, 'Gagal'),               'sma' => $demoByPembayaran($smaIds, 'Gagal')],
        ];

        $stats = [
            'total'         => $totalPendaftar,
            'belum_bayar'   => $belumBayar,
            'menunggu'      => $menunggu,
            'terverifikasi' => $terverifikasi,
            'gagal'         => $gagal,
            'breakdown'     => $breakdown,
        ];

        return view('admin.pembayaran.index', compact('paginated', 'jenjangs', 'stats'));
    }

    /**
     * Show — detail pembayaran 1 pendaftar.
     * Auto-create record Pembayaran kalau belum ada.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['jenjang', 'gelombang', 'pembayaran.verifier']);

        $gelombangHilang = ($pendaftaran->gelombang === null);

        $record = $pendaftaran->pembayaran;

        if (!$record) {
            $jumlah = $pendaftaran->gelombang?->biaya ?? 0;

            $record = Pembayaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jumlah'         => $jumlah,
                'status'         => 'Belum Bayar',
            ]);

            Log::info('Auto-create pembayaran', [
                'pendaftaran_id' => $pendaftaran->id,
                'jumlah'         => $jumlah,
                'gelombang_hilang' => $gelombangHilang,
            ]);
        }

        return view('admin.pembayaran.show', [
            'pendaftaran'     => $pendaftaran,
            'pembayaran'      => $record,
            'gelombangHilang' => $gelombangHilang,
        ]);
    }

    /**
     * Verifikasi — update status pembayaran.
     * NOTE: Tidak ada sync manual. Admin/Pendaftaran baca status dari relasi.
     */
    public function verifikasi(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status'        => 'required|in:Terverifikasi,Gagal,Menunggu Verifikasi,Belum Bayar',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $pembayaran->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
            'verified_by'   => auth()->id(),
            'verified_at'   => now(),
        ]);

        if ($request->expectsJson()) {
            // Hitung ulang breakdown untuk jenjang SMP & SMA agar modal bisa update real-time
            $smpIds = Jenjang::whereRaw("LOWER(nama) LIKE '%smp%'")->pluck('id');
            $smaIds = Jenjang::whereRaw("LOWER(nama) LIKE '%sma%'")->pluck('id');

            $demoBy = function ($ids, string $status) {
                $base = Pendaftaran::whereIn('jenjang_id', $ids)
                    ->whereHas('pembayaran', fn($x) => $x->where('status', $status));
                return [
                    'total'     => (clone $base)->count(),
                    'laki'      => (clone $base)->where('jenis_kelamin', 'Laki-laki')->count(),
                    'perempuan' => (clone $base)->where('jenis_kelamin', 'Perempuan')->count(),
                ];
            };

            return response()->json([
                'success' => true,
                'message' => 'Status pembayaran berhasil diupdate.',
                'data'    => [
                    'id'                => $pembayaran->id,
                    'status'            => $pembayaran->status,
                    'status_pembayaran' => $pembayaran->status,
                    'pendaftaran_id'    => $pembayaran->pendaftaran_id,
                    'breakdown_jenjang' => [
                        'terverifikasi' => ['smp' => $demoBy($smpIds, 'Terverifikasi'), 'sma' => $demoBy($smaIds, 'Terverifikasi')],
                        'menunggu'      => ['smp' => $demoBy($smpIds, 'Menunggu Verifikasi'), 'sma' => $demoBy($smaIds, 'Menunggu Verifikasi')],
                        'gagal'         => ['smp' => $demoBy($smpIds, 'Gagal'), 'sma' => $demoBy($smaIds, 'Gagal')],
                    ],
                ],
            ]);
        }

        return back()->with('success', 'Status pembayaran berhasil diupdate.');
    }
}