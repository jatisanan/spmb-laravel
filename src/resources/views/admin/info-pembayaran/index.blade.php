@extends('layouts.admin')

@section('title', 'Info Pembayaran')
@section('page-title', 'Info Pembayaran')
@section('page-subtitle', 'Setting informasi pembayaran per gelombang')

@section('content')

<div class="rounded-2xl border border-[#dce6d3] bg-[#f4f8ee] p-4 sm:p-5 mb-5">
    <div class="flex items-start gap-3">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0d4a36]">
            <i data-lucide="info" class="h-5 w-5 text-[#d8ae45]"></i>
        </div>
        <div class="text-sm text-[#244535] leading-6">
            <p class="font-bold mb-1">Tentang Halaman Ini</p>
            <p>Atur informasi cara pembayaran (Offline, Transfer, QRIS) untuk <strong>setiap gelombang</strong>. Info ini akan tampil di halaman pembayaran user.</p>
        </div>
    </div>
</div>

<div class="space-y-5">
    @forelse ($gelombangs as $g)
        @php
            // Tentukan warna BACKGROUND CARD berdasarkan kode jenjang
            $kodeJenjang = strtolower($g->jenjang->kode ?? '');

            if ($kodeJenjang === 'smp') {
                // SMP — biru muda
                $bgCard       = 'bg-[#eaf3fb]';
                $borderCard   = 'border-[#c5d9e8]';
                $bgHeader     = 'bg-[#d9e9f5]';
                $borderHeader = 'border-[#c5d9e8]';
                $bgInner      = 'bg-white';
            } elseif ($kodeJenjang === 'sma') {
                // SMA — abu-abu muda
                $bgCard       = 'bg-[#f0f1ee]';
                $borderCard   = 'border-[#d6dccf]';
                $bgHeader     = 'bg-[#e3e6de]';
                $borderHeader = 'border-[#d6dccf]';
                $bgInner      = 'bg-white';
            } else {
                // Default — netral
                $bgCard       = 'bg-white';
                $borderCard   = 'border-[#e1e9da]';
                $bgHeader     = 'bg-[#f8fbf5]';
                $borderHeader = 'border-[#e1e9da]';
                $bgInner      = 'bg-[#f8faf5]';
            }
        @endphp

        <div class="rounded-2xl border {{ $borderCard }} {{ $bgCard }} shadow-sm overflow-hidden">
            <div class="p-5 border-b {{ $borderHeader }} {{ $bgHeader }} flex flex-wrap items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="display-font text-lg font-bold text-[#0d4a36]">{{ $g->nama }}</h3>
                        <span class="status-chip status-neutral">{{ $g->jenjang->nama }}</span>
                        @if ($g->aktif)
                            <span class="status-chip status-success">Aktif</span>
                        @else
                            <span class="status-chip status-neutral">Nonaktif</span>
                        @endif
                    </div>
                    <p class="text-xs text-[#617064] mt-1">
                        Biaya: <strong>Rp{{ number_format($g->biaya, 0, ',', '.') }}</strong>
                        · {{ $g->tanggal_mulai->isoFormat('D MMM Y') }} – {{ $g->tanggal_selesai->isoFormat('D MMM Y') }}
                    </p>
                </div>

                <a href="{{ route('admin.info-pembayaran.edit', $g) }}"
                   class="inline-flex items-center gap-1.5 rounded-lg bg-[#0d4a36] px-3 py-2 text-xs font-bold text-white hover:bg-[#176346]">
                    <i data-lucide="edit-3" class="h-3.5 w-3.5"></i>
                    {{ $g->infoPembayaran ? 'Edit Info' : 'Isi Info' }}
                </a>
            </div>

            <div class="p-5">
                @php $info = $g->infoPembayaran; @endphp

                @if (!$info || !$info->hasAnyMethod())
                    <p class="text-sm text-[#617064] italic text-center py-3">
                        Info pembayaran belum diisi untuk gelombang ini.
                    </p>
                @else
                    <div class="grid gap-3 sm:grid-cols-3 text-xs">
                        {{-- Offline --}}
                        <div class="rounded-lg border border-[#e1e9da] {{ $bgInner }} p-3">
                            <p class="font-bold text-[#0d4a36] mb-1">
                                <i data-lucide="building-2" class="inline h-3.5 w-3.5"></i>
                                Offline
                            </p>
                            @if ($info->offline_alamat)
                                <p class="text-[#617064] leading-5">{{ \Illuminate\Support\Str::limit($info->offline_alamat, 50) }}</p>
                                @if ($info->offline_cp_nama)
                                    <p class="text-[#617064] mt-1">CP: {{ $info->offline_cp_nama }}</p>
                                @endif
                            @else
                                <p class="text-[#a5b0a8] italic">Belum diisi</p>
                            @endif
                        </div>

                        {{-- Transfer --}}
                        <div class="rounded-lg border border-[#e1e9da] {{ $bgInner }} p-3">
                            <p class="font-bold text-[#0d4a36] mb-1">
                                <i data-lucide="credit-card" class="inline h-3.5 w-3.5"></i>
                                Transfer
                            </p>
                            @if ($info->transfer_bank)
                                <p class="text-[#617064]">{{ $info->transfer_bank }}</p>
                                <p class="font-mono text-[#617064]">{{ $info->transfer_norek }}</p>
                                <p class="text-[#617064]">a.n. {{ $info->transfer_atas_nama }}</p>
                            @else
                                <p class="text-[#a5b0a8] italic">Belum diisi</p>
                            @endif
                        </div>

                        {{-- QRIS --}}
                        <div class="rounded-lg border border-[#e1e9da] {{ $bgInner }} p-3">
                            <p class="font-bold text-[#0d4a36] mb-1">
                                <i data-lucide="qr-code" class="inline h-3.5 w-3.5"></i>
                                QRIS
                            </p>
                            @if ($info->qris_image_path)
                                <img src="{{ $info->qris_image_url }}" alt="QRIS"
                                     class="mt-1 h-20 w-20 object-contain rounded border border-[#e1e9da] bg-white">
                            @else
                                <p class="text-[#a5b0a8] italic">Belum diupload</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="rounded-2xl border border-dashed border-[#d6dccf] bg-white p-8 text-center">
            <i data-lucide="inbox" class="mx-auto h-10 w-10 text-[#d6dccf] mb-2"></i>
            <p class="text-sm text-[#617064]">Belum ada gelombang. Buat gelombang dulu di menu Jenjang.</p>
        </div>
    @endforelse
</div>

@endsection