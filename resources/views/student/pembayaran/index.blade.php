@extends('layouts.student')

@section('title', 'Pembayaran')

@section('content')

{{-- ============================================ --}}
{{-- HEADER HALAMAN --}}
{{-- ============================================ --}}
<div class="mb-5">
    <a href="{{ route('student.dashboard') }}"
       class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Dashboard
    </a>
    <h1 class="display-font mt-3 text-2xl sm:text-3xl font-bold text-[#0d4a36]">Pembayaran Biaya Pendaftaran</h1>
    <p class="text-sm text-[#617064] mt-1">{{ $pendaftaran->nomor_pendaftaran }}</p>
</div>

{{-- ============================================ --}}
{{-- FLASH MESSAGE --}}
{{-- ============================================ --}}
@if (session('success'))
    <div class="mb-5 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-sm text-green-800 flex items-start gap-2">
        <i data-lucide="check-circle" class="inline h-4 w-4 mt-0.5 shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-5 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-sm text-red-800 flex items-start gap-2">
        <i data-lucide="alert-circle" class="inline h-4 w-4 mt-0.5 shrink-0"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

@php
    // ============================================
    // KONFIGURASI WARNA STATUS
    // ============================================
    $statusConfig = match($pembayaran->status) {
        'Terverifikasi' => [
            'chip'        => 'bg-green-100 text-green-800 border border-green-300',
            'card_bg'     => 'bg-green-100',
            'card_border' => 'border-green-400',
            'eyebrow'     => 'text-green-700',
            'title'       => 'text-green-900',
            'text'        => 'text-green-800',
        ],
        'Menunggu Verifikasi' => [
            'chip'        => 'bg-amber-100 text-amber-800 border border-amber-300',
            'card_bg'     => 'bg-amber-100',
            'card_border' => 'border-amber-400',
            'eyebrow'     => 'text-amber-700',
            'title'       => 'text-amber-900',
            'text'        => 'text-amber-800',
        ],
        'Gagal' => [
            'chip'        => 'bg-red-100 text-red-800 border border-red-300',
            'card_bg'     => 'bg-red-100',
            'card_border' => 'border-red-400',
            'eyebrow'     => 'text-red-700',
            'title'       => 'text-red-900',
            'text'        => 'text-red-800',
        ],
        default => [  // Belum Bayar
            'chip'        => 'bg-slate-100 text-slate-700 border border-slate-300',
            'card_bg'     => 'bg-slate-100',
            'card_border' => 'border-slate-300',
            'eyebrow'     => 'text-slate-600',
            'title'       => 'text-slate-900',
            'text'        => 'text-slate-700',
        ],
    };
@endphp

<div class="grid gap-5 lg:grid-cols-3">

    {{-- ============================================ --}}
    {{-- KOLOM KANAN: Upload Bukti (di mobile jadi DI ATAS) --}}
    {{-- ============================================ --}}
    <div class="space-y-5 order-1 lg:order-2">

        {{-- Status Card — WARNA SOLID SESUAI STATUS --}}
        <div class="rounded-2xl {{ $statusConfig['card_bg'] }} border {{ $statusConfig['card_border'] }} p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-[.14em] {{ $statusConfig['eyebrow'] }}">Status Pembayaran</p>
            <p class="display-font mt-2 text-xl font-bold {{ $statusConfig['title'] }}">{{ $pembayaran->status }}</p>
            @if ($pembayaran->uploaded_at)
                <p class="text-xs {{ $statusConfig['text'] }} mt-1">
                    <i data-lucide="upload" class="inline h-3 w-3"></i>
                    Upload: {{ $pembayaran->uploaded_at->isoFormat('D MMM Y, HH:mm') }}
                </p>
            @endif
            @if ($pembayaran->verified_at)
                <p class="text-xs {{ $statusConfig['text'] }} mt-1">
                    <i data-lucide="check-circle" class="inline h-3 w-3"></i>
                    Verifikasi: {{ $pembayaran->verified_at->isoFormat('D MMM Y, HH:mm') }}
                </p>
            @endif
        </div>

        {{-- Upload Form --}}
        @if ($pembayaran->status !== 'Terverifikasi')
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
                <h3 class="font-bold text-[#0d4a36] mb-3">
                    {{ $pembayaran->bukti_path ? 'Upload Ulang Bukti' : 'Upload Bukti Bayar' }}
                </h3>

                @if ($pembayaran->status === 'Gagal' && $pembayaran->catatan_admin)
                    <div class="mb-3 rounded-lg border border-red-300 bg-red-100 p-3 text-xs text-red-800">
                        <p class="font-bold mb-1">Alasan penolakan:</p>
                        <p>{{ $pembayaran->catatan_admin }}</p>
                    </div>
                @endif

                @if ($pembayaran->status === 'Menunggu Verifikasi')
                    <div class="rounded-lg border border-amber-300 bg-amber-100 p-3 text-xs text-amber-800">
                        <i data-lucide="clock" class="inline h-3 w-3"></i>
                        Bukti bayar sedang menunggu verifikasi admin. Tunggu maks 1×24 jam.
                    </div>
                @else
                    @if ($pembayaran->bukti_path)
                        <div class="mb-3 rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-3">
                            <p class="text-xs text-[#617064] mb-1">Bukti terakhir:</p>
                            <a href="{{ asset('storage/' . $pembayaran->bukti_path) }}"
                               target="_blank"
                               class="text-xs text-[#0d4a36] font-semibold hover:underline inline-flex items-center gap-1">
                                <i data-lucide="file-text" class="h-3 w-3"></i>
                                {{ $pembayaran->bukti_nama_asli }}
                            </a>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student.pembayaran.upload') }}"
                          enctype="multipart/form-data" class="space-y-3">
                        @csrf

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-[#244535]">Metode Pembayaran</label>
                            <select name="metode" required class="field-control">
                                <option value="">Pilih metode</option>
                                <option value="offline" @selected($pembayaran->metode === 'offline')>Offline (Kantor)</option>
                                <option value="transfer" @selected($pembayaran->metode === 'transfer')>Transfer Bank</option>
                                <option value="qris" @selected($pembayaran->metode === 'qris')>QRIS</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-[#244535]">Bukti Bayar</label>
                            <input type="file" name="bukti" required accept=".jpg,.jpeg,.png,.pdf"
                                   class="field-control text-xs">
                            <p class="mt-1 text-xs text-[#617064]">JPG, PNG, atau PDF. Maks 2MB.</p>
                        </div>

                        @error('bukti')  <p class="text-xs text-red-700">{{ $message }}</p> @enderror
                        @error('metode') <p class="text-xs text-red-700">{{ $message }}</p> @enderror

                        <button type="submit"
                                class="w-full rounded-lg bg-[#0d4a36] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                            <i data-lucide="upload" class="inline h-4 w-4 mr-1"></i>
                            Kirim Bukti
                        </button>
                    </form>
                @endif
            </div>
        @else
            <div class="rounded-2xl border-2 border-green-400 bg-green-100 p-5 text-center">
                <i data-lucide="check-circle-2" class="mx-auto h-10 w-10 text-green-700 mb-2"></i>
                <p class="font-bold text-green-900">Pembayaran Terverifikasi</p>
                <p class="text-xs text-green-800 mt-1">Terima kasih. Lanjutkan proses berikutnya.</p>
            </div>
        @endif

    </div>

    {{-- ============================================ --}}
    {{-- KOLOM KIRI: Info (di mobile jadi DI BAWAH) --}}
    {{-- ============================================ --}}
    <div class="lg:col-span-2 space-y-5 order-2 lg:order-1">

        {{-- === INFO TAGIHAN === --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Tagihan Pembayaran</h3>
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $statusConfig['chip'] }}">
                    {{ $pembayaran->status }}
                </span>
            </div>

            <dl class="grid gap-3 sm:grid-cols-2 text-sm">
                <div>
                    <dt class="text-xs text-[#617064]">Nomor Pendaftaran</dt>
                    <dd class="font-mono font-bold text-[#0d4a36] mt-0.5">{{ $pendaftaran->nomor_pendaftaran }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Nama</dt>
                    <dd class="font-semibold text-[#244535] mt-0.5">{{ $pendaftaran->nama_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Jenjang</dt>
                    <dd class="text-[#244535] mt-0.5">{{ $pendaftaran->jenjang->nama }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Gelombang</dt>
                    <dd class="text-[#244535] mt-0.5">{{ $pendaftaran->gelombang?->nama ?? '—' }}</dd>
                </div>
            </dl>

            <div class="mt-4 rounded-xl bg-[#fff8dd] border border-[#f0e0a8] p-4 text-center">
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#805500]">Total yang Harus Dibayar</p>
                <p class="display-font mt-1 text-2xl sm:text-3xl font-bold text-[#0d4a36]">
                    Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- === TATA CARA PEMBAYARAN === --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Tata Cara Pembayaran</h3>

            @if (!$info || !$info->hasAnyMethod())
                <div class="rounded-xl border border-dashed border-[#d6dccf] bg-[#f8faf5] p-5 text-center">
                    <i data-lucide="info" class="mx-auto h-7 w-7 text-[#d6dccf] mb-2"></i>
                    <p class="text-sm text-[#617064]">Informasi pembayaran belum tersedia. Hubungi admin.</p>
                </div>
            @else
                <div x-data="{ metode: 'offline' }" class="space-y-4">

                    {{-- Tab buttons --}}
                    <div class="flex flex-wrap gap-2 border-b border-[#e1e9da]">
                        <button type="button" @click="metode = 'offline'"
                                :class="metode === 'offline' ? 'border-[#d8ae45] text-[#0d4a36]' : 'border-transparent text-[#617064]'"
                                class="px-4 py-2.5 text-sm font-bold border-b-2 -mb-px transition">
                            <i data-lucide="building-2" class="inline h-4 w-4 mr-1"></i>
                            Offline (Kantor)
                        </button>
                        <button type="button" @click="metode = 'transfer'"
                                :class="metode === 'transfer' ? 'border-[#d8ae45] text-[#0d4a36]' : 'border-transparent text-[#617064]'"
                                class="px-4 py-2.5 text-sm font-bold border-b-2 -mb-px transition">
                            <i data-lucide="credit-card" class="inline h-4 w-4 mr-1"></i>
                            Transfer Bank
                        </button>
                        <button type="button" @click="metode = 'qris'"
                                :class="metode === 'qris' ? 'border-[#d8ae45] text-[#0d4a36]' : 'border-transparent text-[#617064]'"
                                class="px-4 py-2.5 text-sm font-bold border-b-2 -mb-px transition">
                            <i data-lucide="qr-code" class="inline h-4 w-4 mr-1"></i>
                            QRIS
                        </button>
                    </div>

                    {{-- OFFline --}}
                    <div x-show="metode === 'offline'" class="space-y-3 text-sm">
                        @if ($info->offline_alamat)
                            <div class="rounded-xl bg-[#f4f8ee] p-4 space-y-2">
                                <p class="font-bold text-[#0d4a36]">Datang langsung ke kantor:</p>
                                <p class="text-[#244535]">{{ $info->offline_alamat }}</p>
                                @if ($info->offline_cp_nama)
                                    <p class="text-[#617064]">
                                        CP: <strong>{{ $info->offline_cp_nama }}</strong>
                                        @if ($info->offline_cp_hp)
                                            —
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $info->offline_cp_hp)) }}"
                                               target="_blank" rel="noopener noreferrer"
                                               class="text-[#0d4a36] font-semibold hover:underline">
                                                {{ $info->offline_cp_hp }}
                                            </a>
                                        @endif
                                    </p>
                                @endif
                                @if ($info->offline_jam)
                                    <p class="text-[#617064]">Jam operasional: {{ $info->offline_jam }}</p>
                                @endif
                                @if ($info->offline_catatan)
                                    <p class="text-xs text-[#617064] mt-2 pt-2 border-t border-[#dce6d3]">{{ $info->offline_catatan }}</p>
                                @endif
                            </div>
                        @else
                            <p class="text-[#617064] italic">Info offline belum diisi admin.</p>
                        @endif
                    </div>

                    {{-- Transfer --}}
                    <div x-show="metode === 'transfer'" x-cloak class="space-y-3 text-sm">
                        @if ($info->transfer_bank)
                            <div class="rounded-xl bg-[#f4f8ee] p-4 space-y-2">
                                <p class="font-bold text-[#0d4a36]">Transfer ke rekening:</p>
                                <div class="grid gap-2">
                                    <div class="flex justify-between gap-2">
                                        <span class="text-[#617064]">Bank</span>
                                        <span class="font-bold text-[#244535]">{{ $info->transfer_bank }}</span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-[#617064]">No. Rekening</span>
                                        <span class="font-mono font-bold text-[#244535]">{{ $info->transfer_norek }}</span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-[#617064]">Atas Nama</span>
                                        <span class="font-bold text-[#244535]">{{ $info->transfer_atas_nama }}</span>
                                    </div>
                                    @if ($info->transfer_cabang)
                                        <div class="flex justify-between gap-2">
                                            <span class="text-[#617064]">Cabang</span>
                                            <span class="text-[#244535]">{{ $info->transfer_cabang }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p class="text-[#617064] italic">Info transfer belum diisi admin.</p>
                        @endif
                    </div>

                    {{-- QRIS --}}
                    <div x-show="metode === 'qris'" x-cloak class="space-y-3 text-sm">
                        @if ($info->qris_image_url)
                            <div class="rounded-xl bg-[#f4f8ee] p-4 text-center space-y-3">
                                <p class="font-bold text-[#0d4a36]">Scan QRIS berikut:</p>
                                <img src="{{ $info->qris_image_url }}" alt="QRIS"
                                     class="mx-auto max-w-[280px] rounded-lg border-2 border-[#d8ae45] bg-white p-2">
                                <p class="text-xs text-[#617064]">Pastikan nominal sesuai tagihan.</p>
                            </div>
                        @else
                            <p class="text-[#617064] italic">QRIS belum diupload admin.</p>
                        @endif
                    </div>

                    @if ($info->catatan_umum)
                        <p class="text-xs text-[#617064] bg-[#f8faf5] rounded-lg p-3 border border-[#e1e9da]">
                            <i data-lucide="info" class="inline h-3 w-3"></i>
                            {{ $info->catatan_umum }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

    </div>
</div>

@endsection