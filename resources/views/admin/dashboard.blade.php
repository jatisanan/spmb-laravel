@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas PPDB Jati Sanan')

@section('content')

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