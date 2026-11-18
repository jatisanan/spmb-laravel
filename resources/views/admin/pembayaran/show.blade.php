@extends('layouts.admin')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('page-subtitle', $pembayaran->pendaftaran->nomor_pendaftaran)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.pembayaran.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke daftar
    </a>
</div>
@if (!empty($gelombangHilang))
    <div class="mb-5 rounded-2xl border border-[#f2c1ae] bg-[#fff0ea] p-4 flex items-start gap-3">
        <i data-lucide="alert-triangle" class="h-5 w-5 text-[#963d21] shrink-0 mt-0.5"></i>
        <div>
            <p class="font-bold text-[#963d21] text-sm">Gelombang sudah dihapus</p>
            <p class="text-xs text-[#963d21] mt-1 leading-5">
                Gelombang yang dipilih pendaftar ini sudah dihapus oleh admin. Nominal pembayaran
                mungkin tidak akurat. Silakan hubungi pendaftar untuk konfirmasi, atau
                update manual status pembayarannya.
            </p>
        </div>
    </div>
@endif

<div class="grid gap-5 lg:grid-cols-3">

    {{-- ============================================ --}}
    {{-- KIRI: Detail --}}
    {{-- ============================================ --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Info Pendaftar --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Data Pendaftar</h3>

            <dl class="grid gap-3 sm:grid-cols-2 text-sm">
                <div>
                    <dt class="text-xs text-[#617064]">Nomor Pendaftaran</dt>
                    <dd class="font-mono font-bold text-[#0d4a36] mt-0.5">{{ $pembayaran->pendaftaran->nomor_pendaftaran }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">NISN</dt>
                    <dd class="font-mono text-[#244535] mt-0.5">{{ $pembayaran->pendaftaran->nisn }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Nama Lengkap</dt>
                    <dd class="font-semibold text-[#244535] mt-0.5">{{ $pembayaran->pendaftaran->nama_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Jenjang</dt>
                    <dd class="text-[#244535] mt-0.5">{{ $pembayaran->pendaftaran->jenjang->nama }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Gelombang</dt>
                    <dd class="text-[#244535] mt-0.5">
                        {{ $pendaftaran->gelombang?->nama ?? '— (gelombang dihapus)' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">No. WhatsApp</dt>
                    <dd class="text-[#244535] mt-0.5">
                        @if ($pembayaran->pendaftaran->no_whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pembayaran->pendaftaran->no_whatsapp)) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="text-[#0d4a36] font-semibold hover:underline inline-flex items-center gap-1">
                                <i data-lucide="message-circle" class="h-3.5 w-3.5"></i>
                                {{ $pembayaran->pendaftaran->no_whatsapp }}
                            </a>
                        @else
                            —
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Info Pembayaran --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Informasi Pembayaran</h3>
                <span class="status-chip {{ $pembayaran->status_badge }}">{{ $pembayaran->status }}</span>
            </div>

            <dl class="grid gap-3 sm:grid-cols-2 text-sm">
                <div>
                    <dt class="text-xs text-[#617064]">Jumlah Tagihan</dt>
                    <dd class="display-font font-bold text-[#0d4a36] mt-0.5 text-lg">
                        Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Metode</dt>
                    <dd class="text-[#244535] mt-0.5">{{ $pembayaran->metode_label }}</dd>
                </div>
                @if ($pembayaran->uploaded_at)
                    <div>
                        <dt class="text-xs text-[#617064]">Waktu Upload</dt>
                        <dd class="text-[#244535] mt-0.5">{{ $pembayaran->uploaded_at->isoFormat('D MMM Y, HH:mm') }}</dd>
                    </div>
                @endif
                @if ($pembayaran->verified_at)
                    <div>
                        <dt class="text-xs text-[#617064]">Waktu Verifikasi</dt>
                        <dd class="text-[#244535] mt-0.5">{{ $pembayaran->verified_at->isoFormat('D MMM Y, HH:mm') }}</dd>
                    </div>
                @endif
                @if ($pembayaran->verifier)
                    <div>
                        <dt class="text-xs text-[#617064]">Diverifikasi Oleh</dt>
                        <dd class="text-[#244535] mt-0.5">{{ $pembayaran->verifier->name }}</dd>
                    </div>
                @endif
            </dl>

            @if ($pembayaran->catatan_admin)
                <div class="mt-4 rounded-lg border border-[#f0e0a8] bg-[#fff8dd] p-3">
                    <p class="text-xs font-bold text-[#805500] mb-1">Catatan Admin:</p>
                    <p class="text-sm text-[#5c4818]">{{ $pembayaran->catatan_admin }}</p>
                </div>
            @endif
        </div>

        {{-- Bukti Bayar --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Bukti Bayar</h3>

            @if ($pembayaran->bukti_path)
                @php
                    $ext = strtolower(pathinfo($pembayaran->bukti_path, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png']);
                @endphp

                @if ($isImage)
                    <a href="{{ asset('storage/' . $pembayaran->bukti_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $pembayaran->bukti_path) }}"
                             alt="Bukti Bayar"
                             class="max-w-full max-h-96 rounded-lg border border-[#e1e9da]">
                    </a>
                @else
                    <div class="rounded-lg border border-[#e1e9da] bg-[#f8faf5] p-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#0d4a36]">
                            <i data-lucide="file-text" class="h-5 w-5 text-white"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-[#244535]">{{ $pembayaran->bukti_nama_asli }}</p>
                        </div>
                        <a href="{{ asset('storage/' . $pembayaran->bukti_path) }}" target="_blank"
                           class="rounded-lg border border-[#d6dccf] px-3 py-1.5 text-xs font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                            Buka
                        </a>
                    </div>
                @endif
            @else
                <div class="rounded-xl border border-dashed border-[#d6dccf] bg-[#f8faf5] p-5 text-center">
                    <i data-lucide="file-x" class="mx-auto h-7 w-7 text-[#d6dccf] mb-2"></i>
                    <p class="text-sm text-[#617064]">Belum ada bukti bayar.</p>
                </div>
            @endif
        </div>

    </div>

    {{-- ============================================ --}}
    {{-- KANAN: Form Verifikasi --}}
    {{-- ============================================ --}}
    <div class="space-y-5">

        {{-- Summary Card --}}
        <div class="rounded-2xl bg-[#0d4a36] text-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-[.14em] text-[#d8ae45]">Status Saat Ini</p>
            <p class="display-font mt-2 text-xl font-bold">{{ $pembayaran->status }}</p>
        </div>

        {{-- Form Verifikasi --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="font-bold text-[#0d4a36] mb-3">Verifikasi Pembayaran</h3>

            @if (!$pembayaran->bukti_path && !in_array($pembayaran->status, ['Terverifikasi', 'Gagal']))
                <div class="mb-3 rounded-lg border border-[#f0e0a8] bg-[#fff8dd] p-3 text-xs text-[#805500]">
                    <i data-lucide="info" class="inline h-3 w-3"></i>
                    Belum ada bukti bayar. Tunggu user upload dulu.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}">
                @csrf
                @method('PATCH')

                <div class="space-y-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status</label>
                        <select name="status" required class="field-control">
                            @foreach (['Belum Bayar', 'Menunggu Verifikasi', 'Terverifikasi', 'Gagal'] as $s)
                                <option value="{{ $s }}" @selected($pembayaran->status === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Catatan (opsional)</label>
                        <textarea name="catatan_admin" rows="3" class="field-control"
                                  placeholder="Contoh: Bukti tidak jelas, mohon upload ulang...">{{ $pembayaran->catatan_admin }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full rounded-lg bg-[#0d4a36] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                        Simpan Verifikasi
                    </button>
                </div>
            </form>
        </div>

        {{-- Quick Action --}}
        @if ($pembayaran->bukti_path && $pembayaran->status === 'Menunggu Verifikasi')
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
                <h3 class="font-bold text-[#0d4a36] mb-3 text-sm">Aksi Cepat</h3>
                <div class="space-y-2">
                    <form method="POST" action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="Terverifikasi">
                        <button type="submit"
                                class="w-full rounded-lg bg-[#175b31] px-4 py-2 text-sm font-bold text-white hover:bg-[#0d4a36]">
                            <i data-lucide="check" class="inline h-4 w-4 mr-1"></i>
                            Setujui (Terverifikasi)
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="Gagal">
                        <button type="submit"
                                class="w-full rounded-lg border border-[#963d21] px-4 py-2 text-sm font-bold text-[#963d21] hover:bg-[#963d21] hover:text-white">
                            <i data-lucide="x" class="inline h-4 w-4 mr-1"></i>
                            Tolak (Gagal)
                        </button>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection