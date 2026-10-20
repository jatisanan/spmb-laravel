@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas SPMB Jati Sanan')

@section('content')

{{-- ============================================ --}}
{{-- STATISTIK PEMBAYARAN --}}
{{-- ============================================ --}}
<div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da] mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#0d4a36]/10">
                <i data-lucide="wallet" class="h-4 w-4 text-[#0d4a36]"></i>
            </div>
            <h3 class="display-font text-lg font-bold text-[#0d4a36]">Statistik Pembayaran</h3>
        </div>
        <a href="{{ route('admin.pembayaran.index') }}"
        class="text-sm font-semibold text-[#0d4a36] hover:underline">
            Kelola →
        </a>
    </div>

    @php
        $totalBayar = max($total, 1);
        $pct = fn($n) => round($n / $totalBayar * 100);
    @endphp

    {{-- Progress bar gabungan --}}
    <div class="mb-4 h-2.5 w-full overflow-hidden rounded-full bg-[#edf1ec] flex">
        @php
            $pBelum    = $pct($statsPembayaran['belum']);
            $pMenunggu = $pct($statsPembayaran['menunggu']);
            $pTerverif = $pct($statsPembayaran['terverifikasi']);
            $pGagal    = $pct($statsPembayaran['gagal']);
        @endphp
        <div class="bg-[#a3b1a0]" style="width: {{ $pBelum }}%" title="Belum Bayar: {{ $pBelum }}%"></div>
        <div class="bg-[#d8ae45]" style="width: {{ $pMenunggu }}%" title="Menunggu: {{ $pMenunggu }}%"></div>
        <div class="bg-[#5d9f3f]" style="width: {{ $pTerverif }}%" title="Terverifikasi: {{ $pTerverif }}%"></div>
        <div class="bg-[#963d21]" style="width: {{ $pGagal }}%" title="Gagal: {{ $pGagal }}%"></div>
    </div>

    {{-- 4 mini card --}}
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $pembayaranCards = [
                [
                    'label' => 'Belum Bayar',
                    'value' => $statsPembayaran['belum'],
                    'pct'   => $pBelum,
                    'color' => 'bg-[#edf1ec] text-[#42604c]',
                    'bar'   => 'bg-[#a3b1a0]',
                    'icon'  => 'circle-dashed',
                    'status'=> 'Belum Bayar',
                ],
                [
                    'label' => 'Menunggu Verifikasi',
                    'value' => $statsPembayaran['menunggu'],
                    'pct'   => $pMenunggu,
                    'color' => 'bg-[#fff2ca] text-[#805500]',
                    'bar'   => 'bg-[#d8ae45]',
                    'icon'  => 'clock',
                    'status'=> 'Menunggu Verifikasi',
                ],
                [
                    'label' => 'Terverifikasi',
                    'value' => $statsPembayaran['terverifikasi'],
                    'pct'   => $pTerverif,
                    'color' => 'bg-[#e8f4df] text-[#175b31]',
                    'bar'   => 'bg-[#5d9f3f]',
                    'icon'  => 'check-circle',
                    'status'=> 'Terverifikasi',
                ],
                [
                    'label' => 'Gagal',
                    'value' => $statsPembayaran['gagal'],
                    'pct'   => $pGagal,
                    'color' => 'bg-[#fff0ea] text-[#963d21]',
                    'bar'   => 'bg-[#963d21]',
                    'icon'  => 'x-circle',
                    'status'=> 'Gagal',
                ],
            ];
        @endphp

        @foreach ($pembayaranCards as $c)
            <a href="{{ route('admin.pembayaran.index', ['status' => $c['status']]) }}"
            class="group rounded-xl border border-[#e1e9da] bg-white p-3 hover:border-[#0d4a36]/30 hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $c['color'] }}">
                        <i data-lucide="{{ $c['icon'] }}" class="h-3.5 w-3.5"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-[#617064] truncate">
                            {{ $c['label'] }}
                        </p>
                        <div class="flex items-baseline gap-1.5">
                            <p class="display-font text-xl font-bold text-[#0d4a36]">{{ $c['value'] }}</p>
                            <span class="text-[10px] font-semibold text-[#617064]">{{ $c['pct'] }}%</span>
                        </div>
                    </div>
                    <i data-lucide="chevron-right"
                    class="h-4 w-4 text-[#d6dccf] group-hover:text-[#0d4a36] transition-colors"></i>
                </div>
                <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-[#edf1ec]">
                    <div class="{{ $c['bar'] }} h-full transition-all" style="width: {{ $c['pct'] }}%"></div>
                </div>
            </a>
        @endforeach
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
    <div class="rounded-2xl bg-[#0d4a36] p-5 text-white">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#d7e7d1]">Total Pendaftar</p>
            <i data-lucide="users" class="h-5 w-5 text-[#d8ae45]"></i>
        </div>
        <p class="display-font mt-3 text-4xl font-bold">{{ $total }}</p>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da]">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Terverifikasi</p>
            <i data-lucide="check-circle" class="h-5 w-5 text-[#5d9f3f]"></i>
        </div>
        <p class="display-font mt-3 text-4xl font-bold text-[#0d4a36]">{{ $terverifikasi }}</p>
        <p class="mt-1 text-xs text-[#617064]">{{ $menunggu }} menunggu verifikasi</p>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da]">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Lulus Seleksi</p>
            <i data-lucide="award" class="h-5 w-5 text-[#d8ae45]"></i>
        </div>
        <p class="display-font mt-3 text-4xl font-bold text-[#0d4a36]">{{ $lulus }}</p>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da]">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Daftar Ulang</p>
            <i data-lucide="user-check" class="h-5 w-5 text-[#5d9f3f]"></i>
        </div>
        <p class="display-font mt-3 text-4xl font-bold text-[#0d4a36]">{{ $daftarUlang }}</p>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-3 mb-6">
    {{-- Statistik per Jenjang --}}
    <div class="lg:col-span-1 rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da]">
        <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Statistik per Jenjang</h3>
        <div class="space-y-3">
            @forelse ($perJenjang as $j)
                <div class="flex items-center justify-between rounded-xl bg-[#f4f8ee] p-3">
                    <div>
                        <p class="text-sm font-bold text-[#0d4a36]">{{ $j->nama }}</p>
                        <p class="text-xs text-[#617064]">{{ $j->label }}</p>
                    </div>
                    <p class="display-font text-2xl font-bold text-[#0d4a36]">{{ $j->pendaftarans_count }}</p>
                </div>
            @empty
                <p class="text-sm text-[#617064]">Belum ada data jenjang.</p>
            @endforelse
        </div>
    </div>

    {{-- Pendaftar Terbaru --}}
    <div class="lg:col-span-2 rounded-2xl bg-white shadow-sm border border-[#e1e9da]">
        <div class="p-5 flex items-center justify-between border-b border-[#e1e9da]">
            <h3 class="display-font text-lg font-bold text-[#0d4a36]">Pendaftar Terbaru</h3>
            <a href="{{ route('admin.pendaftaran.index') }}" class="text-sm font-semibold text-[#0d4a36] hover:underline">
                Lihat semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Jenjang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($terbaru as $p)
                        <tr>
                            <td class="font-mono font-bold text-[#0d4a36]">{{ $p->nomor_pendaftaran }}</td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->jenjang->nama }}</td>
                            <td>
                                @php
                                    $cls = match($p->status_verifikasi) {
                                        'Terverifikasi' => 'status-success',
                                        'Perlu Perbaikan' => 'status-danger',
                                        default => 'status-pending',
                                    };
                                @endphp
                                <span class="status-chip {{ $cls }}">{{ $p->status_verifikasi }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-[#617064]">
                                Belum ada pendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection