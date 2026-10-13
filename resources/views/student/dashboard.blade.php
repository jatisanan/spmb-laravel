@extends('layouts.student')

@section('title', 'Dashboard Santri')

@section('content')

{{-- ============================================ --}}
{{-- KARTU SAMBUTAN --}}
{{-- ============================================ --}}
<div class="rounded-2xl bg-[#0d4a36] text-white p-5 sm:p-6 shadow-lg mb-5">
    <div class="flex items-center gap-4">
        <div class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-full bg-[#d8ae45] text-xl sm:text-2xl font-bold text-[#073528]">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="min-w-0">
            <p class="text-xs font-bold uppercase tracking-[.14em] text-[#e9d28b]">Selamat datang,</p>
            <h1 class="display-font mt-1 text-xl sm:text-2xl font-bold truncate">{{ $user->name }}</h1>
            <p class="text-xs text-[#d6e3d0] mt-0.5 truncate">{{ $user->email }}</p>
        </div>
    </div>
</div>

@if ($pendaftaran)

    {{-- ============================================ --}}
    {{-- NOMOR PENDAFTARAN --}}
    {{-- ============================================ --}}
    <div class="rounded-2xl bg-white border border-[#dce6d3] p-5 sm:p-6 shadow-sm mb-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#699944]">Nomor Pendaftaran</p>
                <p class="display-font mt-1 text-2xl sm:text-3xl font-bold text-[#0d4a36] tracking-wide break-all">
                    {{ $pendaftaran->nomor_pendaftaran }}
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="status-chip status-neutral">{{ $pendaftaran->jenjang->nama }}</span>
                <span class="status-chip status-neutral">{{ $pendaftaran->gelombang?->nama ?? '—' }}</span>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- RINGKASAN PEMBAYARAN --}}
    {{-- ============================================ --}}
    @php
        $pembayaran = $pendaftaran->pembayaran;
        $statusBayar = $pembayaran?->status ?? 'Belum Bayar';
        $clsBayar = match($statusBayar) {
            'Terverifikasi'       => 'status-success',
            'Menunggu Verifikasi' => 'status-pending',
            'Gagal'               => 'status-danger',
            default               => 'status-neutral',
        };
        $jumlahBayar = $pembayaran?->jumlah ?? $pendaftaran->gelombang?->biaya ?? 0;
    @endphp

    <a href="{{ route('student.pembayaran.index') }}"
       class="block rounded-2xl bg-white border border-[#dce6d3] p-5 sm:p-6 shadow-sm mb-5 hover:border-[#d8ae45] hover:shadow-md transition">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#fff8dd]">
                    <i data-lucide="wallet" class="h-5 w-5 text-[#805500]"></i>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.14em] text-[#699944]">Pembayaran</p>
                    <p class="display-font text-lg font-bold text-[#0d4a36]">
                        Rp{{ number_format($jumlahBayar, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <span class="status-chip {{ $clsBayar }}">{{ $statusBayar }}</span>
        </div>
        <p class="text-xs text-[#617064] inline-flex items-center gap-1">
            Lihat detail &amp; upload bukti bayar
            <i data-lucide="arrow-right" class="h-3 w-3"></i>
        </p>
    </a>

    {{-- ============================================ --}}
    {{-- STATUS RINGKAS (5 KARTU) --}}
    {{-- ============================================ --}}
    <h2 class="display-font text-lg sm:text-xl font-bold text-[#0d4a36] mb-3">Status Pendaftaran</h2>

    <div class="grid gap-4 grid-cols-2 lg:grid-cols-5 mb-5">

        {{-- Pembayaran --}}
        <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Pembayaran</p>
                <i data-lucide="wallet" class="h-4 w-4 text-[#805500]"></i>
            </div>
            <span class="status-chip {{ $clsBayar }}">{{ $statusBayar }}</span>
            <p class="mt-2 text-xs text-[#617064]">
                Rp{{ number_format($jumlahBayar, 0, ',', '.') }}
            </p>
        </div>

        {{-- Verifikasi --}}
        @php
            $clsVerif = match($pendaftaran->status_verifikasi) {
                'Terverifikasi'   => 'status-success',
                'Perlu Perbaikan' => 'status-danger',
                default           => 'status-pending',
            };
        @endphp
        <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Verifikasi</p>
                <i data-lucide="file-check" class="h-4 w-4 text-[#5d9f3f]"></i>
            </div>
            <span class="status-chip {{ $clsVerif }}">{{ $pendaftaran->status_verifikasi }}</span>
            @if ($pendaftaran->catatan_verifikasi)
                <p class="mt-2 text-xs text-[#963d21] leading-5">{{ $pendaftaran->catatan_verifikasi }}</p>
            @endif
        </div>

        {{-- Ujian --}}
        <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Ujian</p>
                <i data-lucide="clipboard-list" class="h-4 w-4 text-[#5d9f3f]"></i>
            </div>
            <span class="status-chip status-neutral">{{ $pendaftaran->status_ujian }}</span>
            @if ($pendaftaran->tanggal_ujian)
                <p class="mt-2 text-xs text-[#617064]">
                    <i data-lucide="calendar" class="inline h-3 w-3"></i>
                    {{ $pendaftaran->tanggal_ujian->isoFormat('D MMMM Y') }}
                </p>
            @endif
            @if ($pendaftaran->nilai_ujian)
                <p class="mt-2 text-xs font-bold text-[#0d4a36]">Nilai: {{ $pendaftaran->nilai_ujian }}</p>
            @endif
        </div>

        {{-- Kelulusan --}}
        @php
            $clsLulus = match($pendaftaran->status_kelulusan) {
                'Lulus'       => 'status-success',
                'Tidak Lulus' => 'status-danger',
                default       => 'status-pending',
            };
        @endphp
        <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Kelulusan</p>
                <i data-lucide="award" class="h-4 w-4 text-[#d8ae45]"></i>
            </div>
            <span class="status-chip {{ $clsLulus }}">{{ $pendaftaran->status_kelulusan }}</span>
        </div>

        {{-- Daftar Ulang --}}
        @php
            $clsDaftar = match($pendaftaran->status_daftar_ulang) {
                'Sudah Daftar Ulang' => 'status-success',
                'Belum Daftar Ulang' => 'status-danger',
                default              => 'status-neutral',
            };
        @endphp
        <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Daftar Ulang</p>
                <i data-lucide="user-check" class="h-4 w-4 text-[#5d9f3f]"></i>
            </div>
            <span class="status-chip {{ $clsDaftar }}">{{ $pendaftaran->status_daftar_ulang }}</span>
            @if ($pendaftaran->tanggal_daftar_ulang)
                <p class="mt-2 text-xs text-[#617064]">
                    <i data-lucide="calendar" class="inline h-3 w-3"></i>
                    {{ $pendaftaran->tanggal_daftar_ulang->isoFormat('D MMMM Y') }}
                </p>
            @endif
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- TOMBOL DOWNLOAD KARTU UJIAN --}}
    {{-- ============================================ --}}
    @if (in_array($pendaftaran->status_ujian, ['Terjadwal', 'Sudah Ujian']))
        <div class="rounded-2xl border border-[#d8ae45] bg-[#fff8dd] p-5 sm:p-6 mb-5">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#d8ae45]">
                    <i data-lucide="file-text" class="h-6 w-6 text-[#073528]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="display-font text-lg font-bold text-[#0d4a36]">
                        Kartu Ujian Tersedia
                    </p>
                    <p class="mt-1 text-sm text-[#617064] leading-6">
                        @if($pendaftaran->tanggal_ujian)
                            Jadwal ujian Anda: <strong>{{ $pendaftaran->tanggal_ujian->isoFormat('dddd, D MMMM Y') }}</strong>.
                        @endif
                        Silakan download kartu ujian dan bawa saat ujian seleksi.
                    </p>
                </div>
                <a href="{{ route('student.kartu.download') }}"
                   class="inline-flex w-full sm:w-auto justify-center items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] transition shrink-0">
                    <i data-lucide="download" class="h-4 w-4"></i>
                    Download Kartu Ujian
                </a>
            </div>
        </div>
    @endif

    {{-- ============================================ --}}
    {{-- CTA DAFTAR ULANG --}}
    {{-- ============================================ --}}
    @if ($pendaftaran->status_kelulusan === 'Lulus'
         && $pendaftaran->status_daftar_ulang === 'Belum Daftar Ulang'
         && $pendaftaran->link_daftar_ulang)
        <div class="rounded-2xl border-2 border-dashed border-[#b9dca8] bg-[#e8f4df] p-5 sm:p-6 mb-5">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#0d4a36]">
                    <i data-lucide="clipboard-check" class="h-6 w-6 text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="display-font text-lg sm:text-xl font-bold text-[#175b31]">
                        Selamat! Anda dinyatakan <span class="text-[#0d4a36]">LULUS</span>
                    </p>
                    <p class="mt-1 text-sm text-[#175b31] leading-6">
                        Silakan lanjutkan proses daftar ulang dengan mengklik tombol di bawah.
                    </p>
                    <a href="{{ $pendaftaran->link_daftar_ulang }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="mt-3 inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] transition">
                        <span>Lanjut Daftar Ulang</span>
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================================ --}}
    {{-- INFO DETAIL PENDAFTARAN --}}
    {{-- ============================================ --}}
    <h2 class="display-font text-lg sm:text-xl font-bold text-[#0d4a36] mb-3">Data Pendaftaran</h2>

    <div class="rounded-2xl bg-white border border-[#dce6d3] p-5 sm:p-6 shadow-sm mb-5">
        <dl class="grid gap-4 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-xs text-[#617064]">NISN</dt>
                <dd class="font-mono font-semibold text-[#244535] mt-0.5">{{ $pendaftaran->nisn }}</dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Jenis Kelamin</dt>
                <dd class="text-[#244535] mt-0.5">{{ $pendaftaran->jenis_kelamin }}</dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Tempat, Tanggal Lahir</dt>
                <dd class="text-[#244535] mt-0.5">
                    {{ $pendaftaran->tempat_lahir }},
                    {{ $pendaftaran->tanggal_lahir?->isoFormat('D MMMM Y') }}
                </dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Asal Sekolah</dt>
                <dd class="text-[#244535] mt-0.5">{{ $pendaftaran->asal_sekolah }}</dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Nama Ayah</dt>
                <dd class="text-[#244535] mt-0.5">{{ $pendaftaran->nama_ayah ?: '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Nama Ibu</dt>
                <dd class="text-[#244535] mt-0.5">{{ $pendaftaran->nama_ibu ?: '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">No. WhatsApp</dt>
                <dd class="text-[#244535] mt-0.5">{{ $pendaftaran->no_whatsapp }}</dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Email</dt>
                <dd class="text-[#244535] mt-0.5 break-all">{{ $pendaftaran->email ?? '—' }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs text-[#617064]">Alamat</dt>
                <dd class="text-[#244535] mt-0.5">{{ $pendaftaran->alamat }}</dd>
            </div>
        </dl>
    </div>

@else

    {{-- ============================================ --}}
    {{-- BELUM DAFTAR --}}
    {{-- ============================================ --}}
    <div class="rounded-2xl border-2 border-dashed border-[#d6dccf] bg-white p-8 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#fff2ca] mb-4">
            <i data-lucide="alert-circle" class="h-8 w-8 text-[#805500]"></i>
        </div>
        <h2 class="display-font text-xl font-bold text-[#0d4a36]">Anda Belum Mendaftar</h2>
        <p class="mt-2 text-sm text-[#617064] max-w-md mx-auto">
            Akun Anda belum terhubung dengan data pendaftaran. Silakan isi formulir PPDB terlebih dahulu.
        </p>
        <a href="{{ route('landing') }}#daftar"
           class="mt-5 inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-3 font-bold text-white hover:bg-[#176346]">
            <i data-lucide="edit-3" class="h-4 w-4"></i>
            Isi Formulir Pendaftaran
        </a>
    </div>

@endif

{{-- ============================================ --}}
{{-- PENGUMUMAN --}}
{{-- ============================================ --}}
@if ($pengumuman->isNotEmpty())
    <h2 class="display-font text-lg sm:text-xl font-bold text-[#0d4a36] mb-3 mt-8">
        <i data-lucide="megaphone" class="inline h-5 w-5"></i>
        Pengumuman
    </h2>

    <div class="space-y-3">
        @foreach ($pengumuman as $p)
            <article class="rounded-2xl bg-white border border-[#dce6d3] p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <h3 class="font-bold text-[#0d4a36]">{{ $p->judul }}</h3>
                    <span class="text-xs text-[#617064] whitespace-nowrap shrink-0">
                        {{ $p->published_at?->isoFormat('D MMM Y') }}
                    </span>
                </div>
                <p class="text-sm text-[#536057] leading-6 whitespace-pre-line">{{ $p->isi }}</p>
            </article>
        @endforeach
    </div>
@endif

@endsection