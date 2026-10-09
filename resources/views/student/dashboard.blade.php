<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Santri — PPDB Jati Sanan</title>

    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.577.0/dist/umd/lucide.min.js"></script>

    <style>
        :root {
            --forest: #0d4a36;
            --deep-forest: #073528;
            --leaf: #5d9f3f;
            --gold: #d8ae45;
            --cream: #f6f1e4;
            --ink: #193128;
        }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: "Libre Franklin", sans-serif;
            background-color: #f6f1e4;
            background-image:
                radial-gradient(rgba(13, 74, 54, .08) 1px, transparent 1px),
                radial-gradient(rgba(216, 174, 69, .11) 1px, transparent 1px);
            background-position: 0 0, 14px 14px;
            background-size: 28px 28px;
            min-height: 100vh;
        }
        .display-font { font-family: "Playfair Display", serif; }
        .status-chip {
            display: inline-flex; align-items: center;
            border-radius: 999px; padding: .3rem .7rem;
            font-size: .75rem; font-weight: 700; white-space: nowrap;
        }
        .status-pending { background: #fff2ca; color: #805500; }
        .status-success { background: #e8f4df; color: #175b31; }
        .status-neutral { background: #edf1ec; color: #42604c; }
        .status-danger  { background: #fff0ea; color: #963d21; }
    </style>
</head>
<body>

{{-- ============================================ --}}
{{-- HEADER --}}
{{-- ============================================ --}}
<header class="w-full border-b-4 border-[#d8ae45] bg-[#0d4a36] text-white">
    <div class="mx-auto flex max-w-5xl items-center justify-between gap-3 px-4 sm:px-5 py-3">
        <a href="{{ route('landing') }}" class="flex items-center gap-3 min-w-0">
            <img src="{{ \App\Models\PengaturanSitus::getImage('header_logo', 'images/logo.png') }}"
                 alt="Logo" class="h-10 w-10 object-contain shrink-0">
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-[.18em] text-[#e9d28b] truncate">
                    Portal Santri
                </p>
                <p class="text-sm font-bold truncate">
                    {{ \App\Models\PengaturanSitus::get('header_name', 'Jati Sanan') }}
                </p>
            </div>
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('landing') }}"
               class="hidden sm:inline-flex items-center gap-1.5 rounded-lg border border-white/30 px-3 py-2 text-xs font-semibold hover:bg-white/10">
                <i data-lucide="home" class="h-3.5 w-3.5"></i>
                Beranda
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-white/30 px-3 py-2 text-xs font-semibold hover:bg-white/10">
                    <i data-lucide="log-out" class="h-3.5 w-3.5"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>

<main class="mx-auto max-w-5xl px-4 sm:px-5 py-6 sm:py-8">

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
                    <span class="status-chip status-neutral">{{ $pendaftaran->gelombang->nama }}</span>
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- STATUS RINGKAS (4 KARTU) --}}
        {{-- ============================================ --}}
        <h2 class="display-font text-lg sm:text-xl font-bold text-[#0d4a36] mb-3">Status Pendaftaran</h2>

        <div class="grid gap-4 grid-cols-2 lg:grid-cols-4 mb-5">

            {{-- Verifikasi --}}
            @php
                $clsVerif = match($pendaftaran->status_verifikasi) {
                    'Terverifikasi' => 'status-success',
                    'Perlu Perbaikan' => 'status-danger',
                    default => 'status-pending',
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
                    'Lulus' => 'status-success',
                    'Tidak Lulus' => 'status-danger',
                    default => 'status-pending',
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
                    default => 'status-neutral',
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
        {{-- CTA DAFTAR ULANG (kalau lulus & belum daftar ulang) --}}
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
        {{-- Belum daftar --}}
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

</main>

<footer class="mx-auto max-w-5xl px-4 sm:px-5 py-6 text-center text-xs text-[#617064]">
    &copy; {{ date('Y') }} {{ \App\Models\PengaturanSitus::get('footer_title', 'PPDB Jati Sanan') }}
</footer>

<script>
    if (window.lucide) lucide.createIcons();
</script>
</body>
</html>