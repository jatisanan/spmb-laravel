<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PPDB Pondok Pesantren Jati Sanan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.577.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --forest: #0d4a36;
            --deep-forest: #073528;
            --leaf: #5d9f3f;
            --gold: #d8ae45;
            --cream: #f6f1e4;
            --ink: #193128;
        }

        [x-cloak] { display: none !important; }

        html { scroll-behavior: smooth; }
        body { margin: 0; color: var(--ink); font-family: "Libre Franklin", sans-serif; overflow-x: hidden; }
        .display-font { font-family: "Playfair Display", serif; }
        .pattern-bg {
            background-color: #f6f1e4;
            background-image:
                radial-gradient(rgba(13, 74, 54, .08) 1px, transparent 1px),
                radial-gradient(rgba(216, 174, 69, .11) 1px, transparent 1px);
            background-position: 0 0, 14px 14px;
            background-size: 28px 28px;
        }
        .hero-wash { background: linear-gradient(90deg, rgba(7,53,40,.97) 0%, rgba(7,53,40,.90) 47%, rgba(7,53,40,.35) 100%); }
        @media (max-width: 767.98px) {
            .hero-wash { background: linear-gradient(180deg, rgba(7,53,40,.75) 0%, rgba(7,53,40,.95) 60%, rgba(7,53,40,.98) 100%); }
        }
        .arch-frame {
            overflow: hidden;
            border: 8px solid #f8f4e9;
            border-radius: 150px 150px 24px 24px;
            box-shadow: 18px 18px 0 rgba(216,174,69,.85);
        }
        @media (max-width: 639.98px) {
            .arch-frame {
                border-width: 6px;
                box-shadow: 10px 10px 0 rgba(216,174,69,.85);
            }
        }
        .field-control {
            width: 100%;
            padding: .8rem .9rem;
            color: #193128;
            outline: none;
            border: 1px solid #d6dccf;
            border-radius: 10px;
            background: #fffdf8;
            transition: border-color .2s, box-shadow .2s;
            font-size: 16px;
        }
        .field-control:focus { border-color: #5d9f3f; box-shadow: 0 0 0 3px rgba(93,159,63,.18); }
        .focus-ring:focus-visible { outline: 3px solid #f0c955; outline-offset: 3px; }
        .reveal { animation: rise .7s ease both; }
        @keyframes rise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
        .status-chip { display: inline-flex; align-items: center; border-radius: 999px; padding: .35rem .65rem; font-size: .75rem; font-weight: 700; white-space: nowrap; }
        .status-pending { background: #fff2ca; color: #805500; }
        .status-success { background: #e8f4df; color: #175b31; }
        .status-neutral { background: #edf1ec; color: #42604c; }
        .status-danger { background: #fff0ea; color: #963d21; }

        /* ===== JENJANG PICKER & FORM WRAPPER ===== */
        #form-wrapper {
            animation: slideDown .45s cubic-bezier(.22,.9,.32,1) both;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .jenjang-card {
            position: relative;
            transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease, background .25s ease;
        }
        .jenjang-card:hover { transform: translateY(-3px); }
        .jenjang-card.active {
            box-shadow: 0 0 0 3px rgba(93,159,63,.18), 0 10px 25px -12px rgba(13,74,54,.35);
        }
        .jenjang-card[data-jenjang-kode="smp"]:hover,
        .jenjang-card[data-jenjang-kode="smp"].active {
            border-color: #5d9f3f;
            background: #f4f8ee;
        }
        .jenjang-card[data-jenjang-kode="sma"]:hover,
        .jenjang-card[data-jenjang-kode="sma"].active {
            border-color: #d8ae45;
            background: #fffaf0;
        }
        .jenjang-card[data-jenjang-kode="sma"].active {
            box-shadow: 0 0 0 3px rgba(216,174,69,.20), 0 10px 25px -12px rgba(13,74,54,.35);
        }
    </style>
</head>
<body class="w-full min-h-screen pattern-bg">

{{-- ============================================ --}}
{{-- HEADER --}}
{{-- ============================================ --}}
<header x-data="{ open: false }"
        class="w-full border-b-4 border-[#d8ae45] bg-[#0d4a36] text-white sticky top-0 z-50">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 sm:gap-4 px-4 sm:px-5 py-3">

        {{-- Logo --}}
        <a href="{{ route('landing') }}" class="flex items-center gap-2 sm:gap-3 min-w-0">
            <img src="{{ \App\Models\PengaturanSitus::getImage('header_logo', 'images/logo.png') }}"
                 alt="Logo" class="h-10 w-10 sm:h-12 sm:w-12 object-contain shrink-0">
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-[.18em] text-[#e9d28b] truncate">
                    {{ \App\Models\PengaturanSitus::get('header_kicker', 'Pondok Pesantren') }}
                </p>
                <p class="text-sm font-bold truncate">
                    {{ \App\Models\PengaturanSitus::get('header_name', 'Jati Sanan') }}
                </p>
            </div>
        </a>

        {{-- Navigasi + Login (desktop ≥ md) --}}
        <nav class="hidden items-center gap-4 text-sm md:flex">
            <a href="#tentang" class="hover:text-[#f1cf72]">Tentang</a>
            <a href="#jenjang" class="hover:text-[#f1cf72]">Jenjang</a>
            <a href="#pengumuman" class="hover:text-[#f1cf72]">Pengumuman</a>
            <a href="#biaya" class="hover:text-[#f1cf72]">Biaya</a>
            <a href="#daftar" class="rounded bg-[#d8ae45] px-4 py-2 font-bold text-[#073528] hover:bg-[#efd175]">Daftar</a>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="rounded border border-[#f1cf72] px-4 py-2 font-bold text-[#f1cf72] hover:bg-[#f1cf72] hover:text-[#073528]">
                        Admin
                    </a>
                @else
                    <a href="{{ route('student.dashboard') }}" class="rounded border border-[#f1cf72] px-4 py-2 font-bold text-[#f1cf72] hover:bg-[#f1cf72] hover:text-[#073528]">
                        Dashboard
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-[#d6e3d0] hover:text-[#f1cf72]">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded border border-white/40 px-4 py-2 font-semibold hover:bg-white/10">
                    Login
                </a>
            @endauth
        </nav>

        {{-- Mobile: tombol Login/Dashboard + hamburger --}}
        <div class="flex items-center gap-2 md:hidden shrink-0">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('student.dashboard') }}"
                   class="rounded border border-[#f1cf72] px-3 py-2 text-xs sm:text-sm font-bold text-[#f1cf72]">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="rounded border border-white/40 px-3 py-2 text-xs sm:text-sm font-semibold">
                    Login
                </a>
            @endauth

            <button type="button" @click="open = !open"
                    class="p-2 rounded-lg hover:bg-white/10"
                    aria-label="Menu">
                <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Menu mobile dropdown --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden border-t border-white/10 bg-[#0a3e2d]">
        <nav class="flex flex-col px-4 py-3 text-sm">
            <a href="#tentang" @click="open = false" class="py-2.5 border-b border-white/10 hover:text-[#f1cf72]">Tentang</a>
            <a href="#jenjang" @click="open = false" class="py-2.5 border-b border-white/10 hover:text-[#f1cf72]">Jenjang</a>
            <a href="#pengumuman" @click="open = false" class="py-2.5 border-b border-white/10 hover:text-[#f1cf72]">Pengumuman</a>
            <a href="#biaya" @click="open = false" class="py-2.5 border-b border-white/10 hover:text-[#f1cf72]">Biaya</a>

            <a href="#daftar" @click="open = false"
               class="mt-3 rounded bg-[#d8ae45] px-4 py-2.5 text-center font-bold text-[#073528] hover:bg-[#efd175]">
                Daftar Sekarang
            </a>

            @auth
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full rounded border border-white/30 px-4 py-2.5 font-semibold text-[#d6e3d0] hover:bg-white/10">
                        Logout
                    </button>
                </form>
            @endauth
        </nav>
    </div>
</header>

<main>

{{-- ============================================ --}}
{{-- HERO --}}
{{-- ============================================ --}}
<section id="beranda" class="relative w-full overflow-hidden bg-[#073528]">
    <img src="{{ \App\Models\PengaturanSitus::getImage('hero_image', 'images/hero-gate.jpg') }}"
         alt="Gerbang" class="absolute inset-0 h-full w-full object-cover">
    <div class="hero-wash absolute inset-0"></div>

    <div class="relative mx-auto flex min-h-[520px] sm:min-h-[560px] md:min-h-[620px] max-w-6xl items-center px-4 sm:px-5 py-14 sm:py-16 md:py-20">
        <div class="reveal max-w-2xl text-white">
            <div class="inline-flex items-center gap-2 rounded-full bg-[#d8ae45] px-3 sm:px-4 py-1.5 sm:py-2 text-[10px] sm:text-xs font-bold uppercase tracking-[.12em] text-[#073528]">
                <i data-lucide="sparkles" class="h-3.5 w-3.5 sm:h-4 sm:w-4"></i>
                <span>{{ \App\Models\PengaturanSitus::get('hero_badge', 'Penerimaan Santri Baru') }}</span>
            </div>
            <h1 class="display-font mt-5 sm:mt-6 max-w-xl text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                {{ \App\Models\PengaturanSitus::get('hero_title') }}
            </h1>
            <p class="mt-4 sm:mt-5 max-w-xl text-sm sm:text-base md:text-lg leading-7 sm:leading-8 text-[#f5f0dd]">
                {{ \App\Models\PengaturanSitus::get('hero_description') }}
            </p>
            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
                <a href="#daftar" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#d8ae45] px-5 py-3 font-bold text-[#073528] shadow-lg hover:bg-[#f0d271]">
                    <span>Pilih Jenjang &amp; Daftar</span>
                    <i data-lucide="arrow-down" class="h-5 w-5"></i>
                </a>
                <a href="#tentang" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/50 px-5 py-3 font-semibold text-white hover:bg-white/10">
                    <span>{{ \App\Models\PengaturanSitus::get('hero_info_text', 'Kenali Pesantren Kami') }}</span>
                    <i data-lucide="arrow-right" class="h-5 w-5"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- TENTANG --}}
{{-- ============================================ --}}
<section id="tentang" class="w-full bg-[#fffdf7] py-12 sm:py-16">
    <div class="mx-auto grid max-w-6xl items-center gap-8 lg:gap-12 px-4 sm:px-5 lg:grid-cols-2">
        <div class="relative mx-auto w-full max-w-md lg:max-w-none">
            <div class="arch-frame">
                <img src="{{ \App\Models\PengaturanSitus::getImage('about_image', 'images/building.jpg') }}"
                     alt="Gedung" class="h-[320px] sm:h-[360px] lg:h-[390px] w-full object-cover">
            </div>
            <div class="absolute -bottom-6 right-2 sm:right-4 lg:right-8 rounded-xl bg-[#0d4a36] p-4 sm:p-5 text-white shadow-xl max-w-[200px]">
                <p class="display-font text-2xl sm:text-3xl font-bold text-[#f0cf6f]">
                    {{ \App\Models\PengaturanSitus::get('about_experience_number', '25+') }}
                </p>
                <p class="mt-1 text-xs sm:text-sm leading-5">
                    {{ \App\Models\PengaturanSitus::get('about_experience_text') }}
                </p>
            </div>
        </div>
        <div class="pt-7 lg:pt-0">
            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#699944]">
                {{ \App\Models\PengaturanSitus::get('about_eyebrow') }}
            </p>
            <h2 class="display-font mt-3 text-2xl sm:text-3xl md:text-4xl font-bold leading-tight text-[#0d4a36]">
                {{ \App\Models\PengaturanSitus::get('about_title') }}
            </h2>
            <p class="mt-4 sm:mt-5 text-sm sm:text-base leading-7 sm:leading-8 text-[#4b5d53]">
                {{ \App\Models\PengaturanSitus::get('about_description') }}
            </p>
            <div class="mt-6 sm:mt-7 grid gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-[#dce6d3] bg-[#f4f8ee] p-4">
                    <i data-lucide="book-open-check" class="mb-3 h-6 w-6 text-[#5d9f3f]"></i>
                    <p class="font-bold text-[#0d4a36]">{{ \App\Models\PengaturanSitus::get('value_faith_title') }}</p>
                    <p class="mt-1 text-xs leading-5 text-[#56705f]">{{ \App\Models\PengaturanSitus::get('value_faith_text') }}</p>
                </div>
                <div class="rounded-xl border border-[#dce6d3] bg-[#f4f8ee] p-4">
                    <i data-lucide="heart-handshake" class="mb-3 h-6 w-6 text-[#5d9f3f]"></i>
                    <p class="font-bold text-[#0d4a36]">{{ \App\Models\PengaturanSitus::get('value_character_title') }}</p>
                    <p class="mt-1 text-xs leading-5 text-[#56705f]">{{ \App\Models\PengaturanSitus::get('value_character_text') }}</p>
                </div>
                <div class="rounded-xl border border-[#dce6d3] bg-[#f4f8ee] p-4">
                    <i data-lucide="graduation-cap" class="mb-3 h-6 w-6 text-[#5d9f3f]"></i>
                    <p class="font-bold text-[#0d4a36]">{{ \App\Models\PengaturanSitus::get('value_achievement_title') }}</p>
                    <p class="mt-1 text-xs leading-5 text-[#56705f]">{{ \App\Models\PengaturanSitus::get('value_achievement_text') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- JENJANG --}}
{{-- ============================================ --}}
<section id="jenjang" class="w-full bg-[#e9f0e3] py-12 sm:py-16">
    <div class="mx-auto max-w-6xl px-4 sm:px-5">
        <div class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#699944]">
                {{ \App\Models\PengaturanSitus::get('program_eyebrow') }}
            </p>
            <h2 class="display-font mt-3 text-2xl sm:text-3xl md:text-4xl font-bold text-[#0d4a36]">
                {{ \App\Models\PengaturanSitus::get('program_title') }}
            </h2>
            <p class="mt-4 text-sm sm:text-base leading-7 text-[#506056]">
                {{ \App\Models\PengaturanSitus::get('program_description') }}
            </p>
        </div>

        <div class="mt-8 sm:mt-9 grid gap-5 sm:gap-6 md:grid-cols-2">
            @foreach ($jenjangs as $j)
                @if ($j->kode === 'smp')
                    <article class="rounded-2xl border border-[#d8e3d0] bg-white p-5 sm:p-6 shadow-sm">
                        <div class="flex items-center gap-4 sm:gap-5">
                            <img src="{{ \App\Models\PengaturanSitus::getImage('jenjang_smp_logo', 'images/logo-smp.png') }}"
                                 alt="Logo SMP" class="h-16 w-16 sm:h-20 sm:w-20 object-contain shrink-0">
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#71974f]">{{ $j->label }}</p>
                                <h3 class="mt-1 text-lg sm:text-xl font-bold text-[#0d4a36]">{{ $j->nama }}</h3>
                            </div>
                        </div>
                        <p class="mt-4 sm:mt-5 text-sm sm:text-base leading-7 text-[#536057]">{{ $j->deskripsi }}</p>
                    </article>
                @else
                    <article class="rounded-2xl bg-[#0d4a36] p-5 sm:p-6 shadow-sm">
                        <div class="flex items-center gap-4 sm:gap-5">
                            <img src="{{ \App\Models\PengaturanSitus::getImage('jenjang_sma_logo', 'images/logo-sma.png') }}"
                                 alt="Logo SMA" class="h-16 w-16 sm:h-20 sm:w-20 object-contain shrink-0">
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#ebd484]">{{ $j->label }}</p>
                                <h3 class="mt-1 text-lg sm:text-xl font-bold text-white">{{ $j->nama }}</h3>
                            </div>
                        </div>
                        <p class="mt-4 sm:mt-5 text-sm sm:text-base leading-7 text-[#e0ebdc]">{{ $j->deskripsi }}</p>
                    </article>
                @endif
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- BIAYA --}}
{{-- ============================================ --}}
<section id="biaya" class="w-full bg-[#f1f5eb] py-12 sm:py-16">
    <div class="mx-auto max-w-6xl px-4 sm:px-5">
        <div class="mb-8 sm:mb-9 max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#699944]">Informasi Pendaftaran</p>
            <h2 class="display-font mt-3 text-2xl sm:text-3xl md:text-4xl font-bold text-[#0d4a36]">Biaya &amp; Timeline Pendaftaran</h2>
            <p class="mt-4 text-sm sm:text-base leading-7 text-[#506056]">Pilih jenjang dan gelombang yang sesuai.</p>
        </div>

        <div class="grid gap-5 sm:gap-6 lg:grid-cols-2">
            @foreach ($jenjangs as $j)
                <article class="rounded-2xl border border-[#d8e3d0] bg-white p-5 sm:p-6 shadow-sm">
                    <h3 class="display-font text-xl sm:text-2xl font-bold text-[#0d4a36]">{{ $j->nama }}</h3>
                    <div class="mt-4 sm:mt-5 space-y-3">
                        @foreach ($j->gelombang as $g)
                            @php $aktif = $g->aktif; @endphp
                            <div class="rounded-xl p-3.5 sm:p-4 transition
                                {{ $aktif
                                    ? 'bg-[#f4f8ee] border border-[#dce6d3]'
                                    : 'bg-[#f6f6f6] border border-dashed border-[#d6dccf] opacity-75' }}">

                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <strong class="text-sm sm:text-base {{ $aktif ? 'text-[#0d4a36]' : 'text-[#617064]' }}">
                                            {{ $g->nama }}
                                        </strong>

                                        @if ($aktif)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-[#e8f4df] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#175b31]">
                                                <span class="relative flex h-1.5 w-1.5">
                                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#5d9f3f] opacity-75"></span>
                                                    <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-[#5d9f3f]"></span>
                                                </span>
                                                Buka
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-[#edf1ec] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#617064]">
                                                <i data-lucide="lock" class="h-2.5 w-2.5"></i>
                                                Tutup
                                            </span>
                                        @endif
                                    </div>

                                    <span class="text-xs sm:text-sm {{ $aktif ? 'text-[#506056]' : 'text-[#8a9490]' }}">
                                        {{ $g->tanggal_mulai->isoFormat('D MMM') }} – {{ $g->tanggal_selesai->isoFormat('D MMM Y') }}
                                    </span>
                                </div>

                                <p class="mt-2 text-xs sm:text-sm {{ $aktif ? 'text-[#506056]' : 'text-[#8a9490]' }}">
                                    Biaya pendaftaran: <strong>Rp{{ number_format($g->biaya, 0, ',', '.') }}</strong>
                                </p>

                                @if($g->tanggal_ujian)
                                    <p class="mt-1 text-xs sm:text-sm {{ $aktif ? 'text-[#699944]' : 'text-[#a5b0a8]' }}">
                                        Ujian: {{ $g->tanggal_ujian->isoFormat('D MMMM Y') }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- PENGUMUMAN --}}
{{-- ============================================ --}}
@php
    $pengumumanPublik = \App\Models\Pengumuman::published()
        ->whereIn('target', ['semua', 'student'])
        ->latest('published_at')
        ->take(3)
        ->get();
@endphp

@if ($pengumumanPublik->isNotEmpty())
<section id="pengumuman" class="w-full bg-[#fffdf7] py-12 sm:py-16">
    <div class="mx-auto max-w-6xl px-4 sm:px-5">
        <div class="mb-8 sm:mb-9 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[.18em] text-[#699944]">Informasi Terbaru</p>
                <h2 class="display-font mt-3 text-2xl sm:text-3xl md:text-4xl font-bold text-[#0d4a36]">Pengumuman</h2>
                <p class="mt-4 text-sm sm:text-base leading-7 text-[#506056]">Ikuti informasi terbaru seputar PPDB Jati Sanan.</p>
            </div>
            <a href="{{ route('pengumuman.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-[#0d4a36] px-4 py-2 text-sm font-bold text-[#0d4a36] hover:bg-[#f4f8ee] shrink-0">
                Lihat Semua
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            @foreach ($pengumumanPublik as $p)
                <a href="{{ route('pengumuman.show', $p->id) }}"
                class="group rounded-2xl border border-[#d8e3d0] bg-white p-5 shadow-sm hover:border-[#5d9f3f] hover:shadow-md transition block">
                    <p class="text-xs text-[#617064] mb-2">
                        <i data-lucide="clock" class="inline h-3 w-3"></i>
                        {{ $p->published_at?->isoFormat('D MMMM Y') }}
                    </p>
                    <h3 class="font-bold text-[#0d4a36] mb-2 line-clamp-2 group-hover:text-[#5d9f3f] transition">{{ $p->judul }}</h3>
                    <p class="text-sm text-[#536057] leading-6 line-clamp-3">{{ \Illuminate\Support\Str::limit($p->isi, 150) }}</p>
                    <p class="mt-3 text-xs font-bold text-[#0d4a36] group-hover:text-[#5d9f3f] inline-flex items-center gap-1">
                        Baca selengkapnya
                        <i data-lucide="arrow-right" class="h-3 w-3"></i>
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================ --}}
{{-- FORM PENDAFTARAN --}}
{{-- ============================================ --}}
<section id="daftar" class="w-full bg-[#fffdf7] py-12 sm:py-16">
    <div class="mx-auto max-w-5xl px-4 sm:px-5">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#699944]">
                {{ \App\Models\PengaturanSitus::get('form_eyebrow') }}
            </p>
            <h2 class="display-font mt-3 text-2xl sm:text-3xl md:text-4xl font-bold text-[#0d4a36]">
                {{ \App\Models\PengaturanSitus::get('form_title') }}
            </h2>
            <p class="mt-4 text-sm sm:text-base leading-7 text-[#506056]">
                {{ \App\Models\PengaturanSitus::get('form_description') }}
            </p>
        </div>

        {{-- ============================================ --}}
        {{-- STEP 1: PILIH JENJANG --}}
        {{-- ============================================ --}}
        <div id="jenjang-picker" class="mx-auto mt-8 sm:mt-10 max-w-3xl">
            <p class="mb-4 text-center text-sm font-bold uppercase tracking-[.14em] text-[#699944]">
                Langkah 1 — Pilih Jenjang
            </p>

            <div class="grid gap-4 sm:gap-6 sm:grid-cols-2">
                @foreach ($jenjangs as $j)
                    @php
                        $isSma = $j->kode === 'sma';
                        $accentText = $isSma ? 'text-[#b58a1e]' : 'text-[#5d9f3f]';
                        $accentBg   = $isSma ? 'bg-[#fff8e8]' : 'bg-[#f4f8ee]';
                        $iconName   = $isSma ? 'graduation-cap' : 'book-open';
                        $logoKey    = 'jenjang_' . $j->kode . '_logo';
                        $logoFallback = 'images/logo-' . $j->kode . '.png';
                    @endphp
                    <button type="button"
                            data-jenjang-id="{{ $j->id }}"
                            data-jenjang-nama="{{ $j->nama }}"
                            data-jenjang-kode="{{ $j->kode }}"
                            data-jenjang-deskripsi="{{ \Illuminate\Support\Str::limit($j->deskripsi, 120) }}"
                            class="jenjang-card group relative overflow-hidden rounded-2xl border-2 border-[#d8e3d0] bg-white p-5 sm:p-6 text-left focus-ring">
                        <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full {{ $accentBg }} transition"></div>

                        <div class="relative flex items-center gap-4">
                            <img src="{{ \App\Models\PengaturanSitus::getImage($logoKey, $logoFallback) }}"
                                 alt="Logo {{ $j->nama }}"
                                 class="h-14 w-14 sm:h-16 sm:w-16 object-contain shrink-0">
                            <div class="min-w-0">
                                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-[.14em] {{ $accentText }}">
                                    {{ $j->label }}
                                </p>
                                <h3 class="mt-1 text-base sm:text-lg font-bold text-[#0d4a36]">
                                    Daftar {{ $j->nama }}
                                </h3>
                            </div>
                        </div>

                        <p class="relative mt-3 sm:mt-4 text-xs sm:text-sm leading-6 text-[#536057] line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($j->deskripsi, 110) }}
                        </p>

                        <div class="relative mt-4 inline-flex items-center gap-2 text-sm font-bold {{ $accentText }}">
                            <i data-lucide="{{ $iconName }}" class="h-4 w-4"></i>
                            <span>Isi Formulir</span>
                            <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- STEP 2: FORM (Tersembunyi sampai jenjang dipilih) --}}
        {{-- ============================================ --}}
        <div id="form-wrapper" class="hidden">

            {{-- Judul dinamis --}}
            <div class="mb-5 sm:mb-6 rounded-xl bg-[#f4f8ee] border border-[#dce6d3] px-4 sm:px-5 py-4">
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#699944]">Langkah 2 — Isi Formulir</p>
                <h3 id="form-jenjang-title" class="display-font mt-1 text-xl sm:text-2xl font-bold text-[#0d4a36]">
                    Formulir Pendaftaran
                </h3>
                <p id="form-jenjang-subtitle" class="mt-1 text-xs sm:text-sm text-[#536057] leading-6"></p>
            </div>

            <aside class="mb-8 rounded-2xl border border-[#dce6d3] bg-[#f4f8ee] p-4 sm:p-5 md:p-7 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0d4a36]">
                        <i data-lucide="folder-open" class="h-5 w-5 text-[#d8ae45]"></i>
                    </div>
                    <h3 class="display-font text-lg sm:text-xl font-bold text-[#0d4a36]">
                        Dokumen yang Perlu Disiapkan
                    </h3>
                </div>

                <ol class="grid gap-3 sm:grid-cols-2">
                    <li class="flex items-start gap-3 rounded-xl border border-[#e1e9da] bg-white px-4 py-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-sm font-bold text-white">1</span>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-[#244535]">Akta Kelahiran</p>
                            <p class="text-xs text-[#617064] mt-0.5">Asli dan FC sebanyak 3 lembar</p>
                        </div>
                    </li>

                    <li class="flex items-start gap-3 rounded-xl border border-[#e1e9da] bg-white px-4 py-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-sm font-bold text-white">2</span>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-[#244535]">KTP Ayah dan Ibu/Wali</p>
                            <p class="text-xs text-[#617064] mt-0.5">Asli dan FC sebanyak 3 lembar</p>
                        </div>
                    </li>

                    <li class="flex items-start gap-3 rounded-xl border border-[#e1e9da] bg-white px-4 py-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-sm font-bold text-white">3</span>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-[#244535]">Kartu Keluarga</p>
                            <p class="text-xs text-[#617064] mt-0.5">Asli dan FC sebanyak 3 lembar</p>
                        </div>
                    </li>

                    <li class="flex items-start gap-3 rounded-xl border border-[#e1e9da] bg-white px-4 py-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-sm font-bold text-white">4</span>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-[#244535]">FC Data Identitas Murid pada Rapor</p>
                            <p class="text-xs text-[#617064] mt-0.5">2 lembar</p>
                        </div>
                    </li>

                    <li class="flex items-start gap-3 rounded-xl border border-[#e1e9da] bg-white px-4 py-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-sm font-bold text-white">5</span>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <p class="text-sm font-bold text-[#244535]">Surat Keterangan Lulus (SKL)</p>
                                <span class="text-xs font-bold uppercase tracking-wide text-[#805500] bg-[#fff2ca] rounded-full px-2 py-0.5">Opsional</span>
                            </div>
                            <p class="text-xs text-[#617064] mt-0.5">Atau FC Ijazah</p>
                        </div>
                    </li>

                    <li class="flex items-start gap-3 rounded-xl border border-[#e1e9da] bg-white px-4 py-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-sm font-bold text-white">6</span>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <p class="text-sm font-bold text-[#244535]">Sertifikat TKA</p>
                                <span class="text-xs font-bold uppercase tracking-wide text-[#805500] bg-[#fff2ca] rounded-full px-2 py-0.5">Opsional</span>
                            </div>
                        </div>
                    </li>
                </ol>
            </aside>

            {{-- Tombol kembali --}}
            <div class="mt-8 sm:mt-10 mb-4">
                <button type="button" id="back-to-picker"
                        class="inline-flex items-center gap-2 rounded-lg border border-[#d6dccf] bg-white px-4 py-2 text-sm font-semibold text-[#0d4a36] hover:bg-[#f4f8ee] transition">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Ganti Jenjang
                </button>
            </div>

            <form id="registration-form" class="form-shell rounded-2xl border border-[#e2e4d8] bg-white p-5 sm:p-6 md:p-9" novalidate>
                @csrf
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="nama-lengkap" class="mb-2 block text-sm font-bold text-[#244535]">Nama Lengkap</label>
                        <input id="nama-lengkap" name="nama_lengkap" type="text" required class="field-control">
                    </div>
                    <div>
                        <label for="jenis-kelamin" class="mb-2 block text-sm font-bold text-[#244535]">Jenis Kelamin</label>
                        <select id="jenis-kelamin" name="jenis_kelamin" required class="field-control">
                            <option value="" selected disabled>Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="nisn" class="mb-2 block text-sm font-bold text-[#244535]">NISN (10 digit)</label>
                        <input id="nisn" name="nisn" type="text" inputmode="numeric" pattern="[0-9]{10}" minlength="10" maxlength="10" required class="field-control">
                    </div>
                    <div>
                        <label for="tempat-lahir" class="mb-2 block text-sm font-bold text-[#244535]">Tempat Lahir</label>
                        <input id="tempat-lahir" name="tempat_lahir" type="text" required class="field-control">
                    </div>
                    <div>
                        <label for="tanggal-lahir" class="mb-2 block text-sm font-bold text-[#244535]">Tanggal Lahir</label>
                        <input id="tanggal-lahir" name="tanggal_lahir" type="date" required class="field-control">
                    </div>
                    <div>
                        <label for="asal-sekolah" class="mb-2 block text-sm font-bold text-[#244535]">Asal Sekolah</label>
                        <input id="asal-sekolah" name="asal_sekolah" type="text" required class="field-control">
                    </div>

                    {{-- Jenjang (auto dari picker, readonly) --}}
                    <div>
                        <label for="jenjang-id" class="mb-2 block text-sm font-bold text-[#244535]">Jenjang Pendaftaran</label>
                        <select id="jenjang-id" name="jenjang_id" required class="field-control bg-[#f8faf5] cursor-not-allowed text-[#4b5d53]" aria-readonly="true">
                            <option value="" selected disabled>Pilih jenjang di atas</option>
                            @foreach ($jenjangs as $j)
                                <option value="{{ $j->id }}" data-kode="{{ $j->kode }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-[#69786e]">Jenjang dipilih dari tombol di atas. Klik "Ganti Jenjang" untuk mengubah.</p>
                    </div>

                    <div>
                        <label for="gelombang-id" class="mb-2 block text-sm font-bold text-[#244535]">Gelombang</label>
                        <select id="gelombang-id" name="gelombang_id" required class="field-control" disabled>
                            <option value="">Pilih jenjang terlebih dahulu</option>
                        </select>
                        <p id="gelombang-info" class="mt-1 text-xs text-[#699944]"></p>
                    </div>
                    <div>
                        <label for="nama-ayah" class="mb-2 block text-sm font-bold text-[#244535]">Nama Ayah</label>
                        <input id="nama-ayah" name="nama_ayah" type="text" required class="field-control">
                    </div>
                    <div>
                        <label for="nama-ibu" class="mb-2 block text-sm font-bold text-[#244535]">Nama Ibu</label>
                        <input id="nama-ibu" name="nama_ibu" type="text" required class="field-control">
                    </div>
                    <div>
                        <label for="nama-wali" class="mb-2 block text-sm font-bold text-[#244535]">Nama Wali (opsional)</label>
                        <input id="nama-wali" name="nama_wali" type="text" class="field-control">
                    </div>
                    <div>
                        <label for="no-whatsapp" class="mb-2 block text-sm font-bold text-[#244535]">No. WhatsApp</label>
                        <input id="no-whatsapp" name="no_whatsapp" type="tel"
                            inputmode="numeric"
                            pattern="[0-9]{11,12}"
                            minlength="11"
                            maxlength="12"
                            required
                            title="Nomor WhatsApp harus 11–12 digit angka. Contoh: 081234567890"
                            class="field-control"
                            placeholder="08xxxxxxxxxx">
                        <p class="mt-1 text-xs text-[#69786e]">11–12 digit angka, contoh: 081234567890</p>
                    </div>
                    <div class="md:col-span-2">
                        <label for="email" class="mb-2 block text-sm font-bold text-[#244535]">Email Aktif</label>
                        <input id="email" name="email" type="email" required autocomplete="email"
                               title="Masukkan alamat email yang valid. Contoh: nama@email.com"
                               class="field-control" placeholder="nama@email.com">
                        <p class="mt-1 text-xs leading-5 text-[#69786e]">
                            Email ini akan digunakan untuk membuat akun login. Password awal adalah tanggal lahir Anda (ddmmyyyy).
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat" class="mb-2 block text-sm font-bold text-[#244535]">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="4" required class="field-control resize-y"></textarea>
                    </div>
                </div>

                <div class="mt-7 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 border-t border-[#ebeee6] pt-6">
                    <p class="max-w-xl text-xs leading-5 text-[#69786e]">
                        {{ \App\Models\PengaturanSitus::get('form_note') }}
                    </p>
                    <button id="submit-button" type="submit" class="inline-flex w-full sm:w-auto shrink-0 items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-6 py-3 font-bold text-white transition hover:bg-[#176346] disabled:cursor-wait disabled:opacity-70">
                        <i data-lucide="send" class="h-4 w-4"></i>
                        <span>Kirim Pendaftaran</span>
                    </button>
                </div>

                <div id="form-message" class="mt-5 hidden rounded-lg px-4 py-3 text-sm"></div>
            </form>
        </div>{{-- /#form-wrapper --}}

        {{-- ============================================ --}}
        {{-- CEK STATUS --}}
        {{-- ============================================ --}}
        <section class="mt-10 rounded-2xl border border-[#dce6d3] bg-[#f4f8ee] p-5 sm:p-6 md:p-8">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.18em] text-[#699944]">Cek Status</p>
                    <h2 class="display-font mt-2 text-xl sm:text-2xl font-bold text-[#0d4a36]">Lacak Pendaftaran Anda</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#506056]">
                        Masukkan nomor pendaftaran Anda untuk melihat status terkini.
                    </p>
                </div>
            </div>

            <form id="status-form" class="mt-5 grid gap-4 sm:grid-cols-[1fr_auto]">
                <div>
                    <label for="status-number" class="mb-2 block text-sm font-bold text-[#244535]">Nomor Pendaftaran</label>
                    <input id="status-number" type="text" required class="field-control" autocomplete="off" placeholder="SPMB-2026-SMP-0001 / SPMB-2026-SMA-0001">
                </div>
                <button type="submit" class="self-end w-full sm:w-auto rounded-lg bg-[#0d4a36] px-5 py-3 font-bold text-white hover:bg-[#176346]">
                    Cek Status
                </button>
            </form>

            <div id="status-message" class="mt-4 hidden rounded-lg px-4 py-3 text-sm"></div>

            <div id="status-result" class="mt-5 hidden rounded-xl border border-[#dce6d3] bg-white p-4 sm:p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[.12em] text-[#699944]">Nomor Pendaftaran</p>
                        <p id="result-number" class="mt-1 font-mono font-bold text-[#0d4a36] break-all"></p>
                    </div>
                    <span id="result-jenjang" class="status-chip status-neutral"></span>
                </div>
                <p id="result-nama" class="mt-3 text-sm font-bold text-[#244535]"></p>

                <div class="mt-5 grid gap-3 grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg bg-[#f6f8f3] p-3">
                        <p class="text-xs text-[#617064]">Verifikasi</p>
                        <p id="result-verification" class="mt-1 text-sm font-bold text-[#244535]"></p>
                    </div>

                    <div class="rounded-lg bg-[#f6f8f3] p-3">
                        <p class="text-xs text-[#617064]">Ujian</p>
                        <p id="result-exam" class="mt-1 text-sm font-bold text-[#244535]"></p>
                        <p id="result-exam-date" class="mt-0.5 text-xs text-[#617064]"></p>
                        <p id="result-exam-score" class="mt-0.5 text-xs font-bold text-[#0d4a36]"></p>
                    </div>

                    <div class="rounded-lg bg-[#f6f8f3] p-3">
                        <p class="text-xs text-[#617064]">Kelulusan</p>
                        <p id="result-graduation" class="mt-1 text-sm font-bold text-[#244535]"></p>
                    </div>

                    <div class="rounded-lg bg-[#f6f8f3] p-3">
                        <p class="text-xs text-[#617064]">Daftar Ulang</p>
                        <p id="result-reregistration" class="mt-1 text-sm font-bold text-[#244535]"></p>
                        <p id="result-reregistration-date" class="mt-0.5 text-xs text-[#617064]"></p>
                    </div>
                </div>

                <p id="result-score" class="mt-4 hidden rounded-lg bg-[#fff8dd] px-3 py-2 text-sm text-[#76530d]"></p>

                <div id="reregistration-cta" class="mt-5 hidden">
                    <div class="rounded-xl border-2 border-dashed border-[#b9dca8] bg-[#e8f4df] p-4 sm:p-5">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0d4a36]">
                                <i data-lucide="clipboard-check" class="h-5 w-5 text-white"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-[#175b31] text-sm sm:text-base">
                                    Anda dinyatakan <span class="text-[#0d4a36]">LULUS</span>!
                                </p>
                                <p class="mt-1 text-xs sm:text-sm text-[#175b31] leading-6">
                                    Silakan lanjutkan proses daftar ulang dengan mengklik tombol di bawah.
                                </p>
                                <a id="reregistration-link"
                                href="#"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-3 inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-4 sm:px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] transition">
                                    <span>Lanjut Daftar Ulang</span>
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

{{-- ============================================ --}}
{{-- MODAL KONFIRMASI DATA --}}
{{-- ============================================ --}}
<div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden max-h-[92vh] flex flex-col">

        <div class="bg-[#d8ae45] px-5 sm:px-6 py-4 sm:py-5 text-center text-[#073528] shrink-0">
            <div class="mx-auto flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-full bg-white mb-3">
                <i data-lucide="clipboard-check" class="h-7 w-7 sm:h-8 sm:w-8 text-[#0d4a36]"></i>
            </div>
            <h3 class="display-font text-xl sm:text-2xl font-bold">Konfirmasi Data</h3>
            <p class="text-sm mt-1 text-[#5c4818]">Periksa kembali sebelum data dikirim</p>
        </div>

        <div class="px-5 sm:px-6 py-4 sm:py-5 overflow-y-auto space-y-3">

            <p class="text-xs leading-5 text-[#617064]">
                Pastikan data di bawah ini sudah benar. Setelah dikirim, data <strong>tidak dapat diubah sendiri</strong> —
                harus menghubungi admin untuk perbaikan.
            </p>

            <div class="rounded-xl bg-[#f4f8ee] border border-[#dce6d3] p-4 space-y-3 text-sm">
                <div>
                    <p class="text-xs font-semibold text-[#617064] uppercase tracking-wide">Nama Lengkap</p>
                    <p id="confirm-nama" class="mt-0.5 font-bold text-[#0d4a36] break-words">—</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-[#617064] uppercase tracking-wide">Tempat, Tanggal Lahir</p>
                    <p id="confirm-ttl" class="mt-0.5 font-bold text-[#0d4a36] break-words">—</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-[#617064] uppercase tracking-wide">NISN</p>
                    <p id="confirm-nisn" class="mt-0.5 font-mono font-bold text-[#0d4a36] break-all">—</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-[#617064] uppercase tracking-wide">No. WhatsApp</p>
                    <p id="confirm-wa" class="mt-0.5 font-mono font-bold text-[#0d4a36] break-all">—</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-[#617064] uppercase tracking-wide">Email</p>
                    <p id="confirm-email" class="mt-0.5 font-mono font-bold text-[#0d4a36] break-all">—</p>
                </div>
            </div>

            <p class="text-xs leading-5 text-[#963d21] bg-[#fff0ea] rounded-lg p-3 border border-[#f2c1ae]">
                <i data-lucide="alert-triangle" class="inline h-3.5 w-3.5"></i>
                <strong>Perhatian:</strong> Password awal akun Anda adalah <strong>tanggal lahir (ddmmyyyy)</strong>.
                Pastikan tanggal lahir di atas sudah benar — kalau salah, Anda tidak bisa login.
            </p>
        </div>

        <div class="px-5 sm:px-6 py-4 bg-[#f8faf5] border-t border-[#e1e9da] flex flex-col-reverse sm:flex-row sm:justify-end gap-2 shrink-0">
            <button type="button" data-close-confirm
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d6dccf] px-4 py-2.5 text-sm font-semibold text-[#244535] hover:bg-white w-full sm:w-auto">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali &amp; Edit
            </button>
            <button type="button" id="confirm-submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-wait w-full sm:w-auto">
                <i data-lucide="check" class="h-4 w-4"></i>
                <span id="confirm-submit-text">Ya, Data Benar</span>
            </button>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- MODAL SUKSES --}}
{{-- ============================================ --}}
<div id="success-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden max-h-[92vh] flex flex-col">

        <div class="bg-[#0d4a36] px-5 sm:px-6 py-4 sm:py-5 text-center text-white shrink-0">
            <div class="mx-auto flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-full bg-[#d8ae45] mb-3">
                <i data-lucide="check" class="h-7 w-7 sm:h-8 sm:w-8 text-[#073528]"></i>
            </div>
            <h3 class="display-font text-xl sm:text-2xl font-bold">Pendaftaran Berhasil!</h3>
            <p class="text-sm text-[#d6e3d0] mt-1">Simpan informasi di bawah ini</p>
        </div>

        <div class="px-5 sm:px-6 py-4 sm:py-5 space-y-4 overflow-y-auto">
            <div class="rounded-xl bg-[#f4f8ee] border border-[#dce6d3] p-4 text-center">
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#699944]">Nomor Pendaftaran</p>
                <p id="modal-nomor" class="display-font mt-1 text-xl sm:text-2xl font-bold text-[#0d4a36] tracking-wide break-all"></p>
                <button type="button" data-copy="modal-nomor"
                        class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-[#0d4a36] hover:underline">
                    <i data-lucide="copy" class="h-3 w-3"></i> Salin
                </button>
            </div>

            <div class="grid gap-2 text-sm">
                <div class="flex justify-between gap-2">
                    <span class="text-[#617064]">Nama</span>
                    <span id="modal-nama" class="font-semibold text-[#0d4a36] text-right break-all"></span>
                </div>
                <div class="flex justify-between gap-2">
                    <span class="text-[#617064]">Jenjang</span>
                    <span id="modal-jenjang" class="font-semibold text-[#0d4a36] text-right"></span>
                </div>
                <div class="flex justify-between gap-2">
                    <span class="text-[#617064]">Gelombang</span>
                    <span id="modal-gelombang" class="font-semibold text-[#0d4a36] text-right"></span>
                </div>
            </div>

            <div class="border-t border-[#e1e9da] pt-4">
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#699944] mb-3">Akun Login Anda</p>

                <div class="mb-3">
                    <label class="text-xs text-[#617064]">Email</label>
                    <div class="flex items-center gap-2 mt-1">
                        <input id="modal-email" type="text" readonly
                               class="flex-1 min-w-0 rounded-lg border border-[#d6dccf] bg-[#f8faf5] px-3 py-2 text-xs sm:text-sm font-mono text-[#244535]">
                        <button type="button" data-copy="modal-email"
                                class="shrink-0 rounded-lg border border-[#d6dccf] p-2 hover:bg-[#f4f8ee]">
                            <i data-lucide="copy" class="h-4 w-4 text-[#0d4a36]"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="text-xs text-[#617064]">Password (tanggal lahir)</label>
                    <div class="flex items-center gap-2 mt-1">
                        <input id="modal-password" type="text" readonly
                               class="flex-1 min-w-0 rounded-lg border border-[#d6dccf] bg-[#f8faf5] px-3 py-2 text-xs sm:text-sm font-mono text-[#244535]">
                        <button type="button" data-copy="modal-password"
                                class="shrink-0 rounded-lg border border-[#d6dccf] p-2 hover:bg-[#f4f8ee]">
                            <i data-lucide="copy" class="h-4 w-4 text-[#0d4a36]"></i>
                        </button>
                    </div>
                </div>

                <p class="mt-3 text-xs leading-5 text-[#963d21] bg-[#fff0ea] rounded-lg p-3 border border-[#f2c1ae]">
                    <i data-lucide="alert-triangle" class="inline h-3 w-3"></i>
                    <strong>Penting:</strong> Segera ganti password setelah login pertama.
                </p>

                <div class="border-t border-[#e1e9da] pt-4 mt-4">
                    <p class="text-xs font-bold uppercase tracking-[.14em] text-[#699944] mb-3">Langkah Selanjutnya</p>

                    <div class="rounded-xl bg-[#fff8dd] border border-[#f0e0a8] p-4 mb-3 text-center">
                        <p class="text-xs text-[#805500] font-semibold">Biaya Pendaftaran</p>
                        <p class="display-font mt-1 text-2xl font-bold text-[#0d4a36]">
                            Rp<span id="modal-biaya">0</span>
                        </p>
                        <p class="text-xs text-[#805500] mt-1">Login untuk melihat cara pembayaran & upload bukti.</p>
                    </div>

                    <ol class="space-y-2 text-sm text-[#244535]">
                        <li class="flex items-start gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-[10px] font-bold text-white">1</span>
                            <span>Login dengan akun di atas</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-[10px] font-bold text-white">2</span>
                            <span>Buka menu <strong>Pembayaran</strong> di dashboard</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-[10px] font-bold text-white">3</span>
                            <span>Pilih metode: <strong>Offline / Transfer / QRIS</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-[10px] font-bold text-white">4</span>
                            <span>Upload bukti bayar, tunggu verifikasi admin</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="px-5 sm:px-6 py-4 bg-[#f8faf5] border-t border-[#e1e9da] flex flex-wrap gap-2 justify-end shrink-0">
            <button type="button" data-close-modal
                    class="rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-white">
                Tutup
            </button>
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                <i data-lucide="log-in" class="h-4 w-4"></i>
                Login Sekarang
            </a>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- MODAL ERROR / VALIDASI --}}
{{-- ============================================ --}}
<div id="error-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-4">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">

        <div class="bg-[#963d21] px-5 sm:px-6 py-4 sm:py-5 text-center text-white shrink-0">
            <div class="mx-auto flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-full bg-[#fff0ea] mb-3">
                <i data-lucide="alert-triangle" class="h-7 w-7 sm:h-8 sm:w-8 text-[#963d21]"></i>
            </div>
            <h3 class="display-font text-xl sm:text-2xl font-bold">Periksa Kembali</h3>
            <p class="text-sm text-[#f5d5c9] mt-1">Ada isian yang perlu diperbaiki</p>
        </div>

        <div class="px-5 sm:px-6 py-4 sm:py-5 overflow-y-auto">
            <ul id="error-modal-list" class="space-y-2 text-sm text-[#963d21]"></ul>
        </div>

        <div class="px-5 sm:px-6 py-4 bg-[#fff8f5] border-t border-[#f2c1ae] flex justify-end shrink-0">
            <button type="button" data-close-error-modal
                    class="rounded-lg bg-[#963d21] px-5 py-2 text-sm font-bold text-white hover:bg-[#7a2f19]">
                Mengerti
            </button>
        </div>
    </div>
</div>

</main>

{{-- ============================================ --}}
{{-- FOOTER --}}
{{-- ============================================ --}}
<footer class="w-full bg-[#073528] py-8 sm:py-10 px-4 text-center text-white">
    <img src="{{ \App\Models\PengaturanSitus::getImage('footer_logo', 'images/logo.png') }}"
         alt="Logo" class="mx-auto h-12 w-12 sm:h-14 sm:w-14 object-contain">
    <p class="mt-3 text-sm sm:text-base font-bold">
        {{ \App\Models\PengaturanSitus::get('footer_title', 'Pondok Pesantren Jati Sanan') }}
    </p>
    <p class="mt-2 max-w-md mx-auto text-xs sm:text-sm leading-6 text-[#d6e3d0]">
        {{ \App\Models\PengaturanSitus::get('footer_text') }}
    </p>
    <p class="mt-3 text-[10px] sm:text-xs text-[#d6e3d0]">
        {{ \App\Models\PengaturanSitus::get('footer_copyright') }}
    </p>
</footer>

{{-- ============================================ --}}
{{-- SCRIPTS --}}
{{-- ============================================ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) lucide.createIcons();
    });
    document.addEventListener('alpine:initialized', () => {
        if (window.lucide) lucide.createIcons();
    });
</script>

<script>
(function () {
    'use strict';

    // ============================================
    // CONFIG & HELPERS
    // ============================================
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    const ROUTES = {
        validasi:  '{{ route("daftar.validasi") }}',
        daftar:    '{{ route("daftar.store") }}',
        cekStatus: '{{ route("cek-status") }}',
    };

    const $ = (id) => document.getElementById(id);

    // ============================================
    // AUTO UPPERCASE — SEMUA INPUT FORM
    // ============================================
    const uppercaseFields = [
        'nama_lengkap',
        'tempat_lahir',
        'asal_sekolah',
        'nama_ayah',
        'nama_ibu',
        'nama_wali',
        'alamat',
    ];

    uppercaseFields.forEach((name) => {
        const el = document.querySelector(`[name="${name}"]`);
        if (!el) return;

        el.addEventListener('input', function () {
            const start = this.selectionStart;
            const end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        });
    });

    // ============================================
    // AUTO LOWERCASE — KHUSUS EMAIL
    // ============================================
    const lowercaseFields = ['email'];

    lowercaseFields.forEach((name) => {
        const el = document.querySelector(`[name="${name}"]`);
        if (!el) return;

        el.addEventListener('input', function () {
            const start = this.selectionStart;
            const end = this.selectionEnd;
            this.value = this.value.toLowerCase();
            this.setSelectionRange(start, end);
        });
    });

    // ============================================
    // HELPER: Show / Hide Message
    // ============================================
    function showMsg(el, text, type = 'error') {
        el.className = 'mt-5 rounded-lg px-4 py-3 text-sm border ' + (
            type === 'error'
                ? 'border-[#f2c1ae] bg-[#fff0ea] text-[#963d21]'
                : 'border-[#b9dca8] bg-[#e8f4df] text-[#175b31]'
        );
        el.innerHTML = text;
        el.classList.remove('hidden');
    }

    function hideMsg(el) {
        el.className = 'mt-5 hidden rounded-lg px-4 py-3 text-sm';
        el.innerHTML = '';
    }

    // ============================================
    // HELPER: Show / Hide Modal
    // ============================================
    function showModal(id) {
        const m = $(id);
        if (m) {
            m.classList.remove('hidden');
            m.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function hideModal(id) {
        const m = $(id);
        if (m) {
            m.classList.add('hidden');
            m.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    // ============================================
    // HELPER: Error Modal
    // ============================================
    function showErrorModal(messages) {
        const modal = $('error-modal');
        const list  = $('error-modal-list');
        if (!modal || !list) return;

        list.innerHTML = '';
        messages.forEach((msg) => {
            const li = document.createElement('li');
            li.className = 'flex items-start gap-2 rounded-lg bg-[#fff0ea] px-3 py-2 border border-[#f2c1ae]';
            li.innerHTML = '<i data-lucide="x-circle" class="h-4 w-4 mt-0.5 shrink-0"></i><span>' + msg + '</span>';
            list.appendChild(li);
        });

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        if (window.lucide) lucide.createIcons();
    }

    function hideErrorModal() {
        const modal = $('error-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    // ============================================
    // HELPER: Copy Text
    // ============================================
    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const original = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="check" class="h-3 w-3"></i> Tersalin';
            if (window.lucide) lucide.createIcons();
            setTimeout(() => {
                btn.innerHTML = original;
                if (window.lucide) lucide.createIcons();
            }, 1500);
        });
    }

    // ============================================
    // HELPER: Format Tanggal Indonesia
    // ============================================
    function formatTanggalIndonesia(isoDate) {
        if (!isoDate) return '—';
        try {
            const d = new Date(isoDate + 'T00:00:00');
            return d.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
            });
        } catch (e) {
            return isoDate;
        }
    }

    // ============================================
    // JENJANG PICKER — Tampilkan Form Setelah Pilih
    // ============================================
    const jenjangPicker = $('jenjang-picker');
    const formWrapper   = $('form-wrapper');
    const jenjangSelect = $('jenjang-id');
    const formTitle     = $('form-jenjang-title');
    const formSubtitle  = $('form-jenjang-subtitle');

    function showFormForJenjang(id, nama, kode, deskripsi) {
        // Set dropdown jenjang
        jenjangSelect.value = id;
        jenjangSelect.dispatchEvent(new Event('change')); // trigger load gelombang

        // Update judul + subjudul
        formTitle.textContent = 'Formulir Pendaftaran ' + nama;
        formSubtitle.textContent = deskripsi || '';

        // Sembunyikan picker, tampilkan form
        jenjangPicker.classList.add('hidden');
        formWrapper.classList.remove('hidden');

        // Scroll + focus
        setTimeout(() => {
            formWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (window.lucide) lucide.createIcons();
            setTimeout(() => $('nama-lengkap')?.focus(), 350);
        }, 50);
    }

    document.querySelectorAll('.jenjang-card').forEach((card) => {
        card.addEventListener('click', function () {
            document.querySelectorAll('.jenjang-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            showFormForJenjang(
                this.dataset.jenjangId,
                this.dataset.jenjangNama,
                this.dataset.jenjangKode,
                this.dataset.jenjangDeskripsi
            );
        });
    });

    // Tombol "Ganti Jenjang"
    $('back-to-picker')?.addEventListener('click', function () {
        formWrapper.classList.add('hidden');
        jenjangPicker.classList.remove('hidden');
        document.querySelectorAll('.jenjang-card').forEach(c => c.classList.remove('active'));

        // Reset dropdown jenjang & gelombang
        jenjangSelect.value = '';
        const gelombangSelect = $('gelombang-id');
        gelombangSelect.innerHTML = '<option value="">Pilih jenjang terlebih dahulu</option>';
        gelombangSelect.disabled = true;
        $('gelombang-info').textContent = '';

        setTimeout(() => {
            jenjangPicker.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 50);
    });

    // ============================================
    // DROPDOWN GELOMBANG
    // ============================================
    $('jenjang-id').addEventListener('change', async function () {
        const jenjangId = this.value;
        const gelombangSelect = $('gelombang-id');
        const info = $('gelombang-info');

        if (!jenjangId) return;

        gelombangSelect.disabled = true;
        gelombangSelect.innerHTML = '<option>Memuat...</option>';

        try {
            const res = await fetch(`/gelombang/${jenjangId}`);
            const data = await res.json();

            gelombangSelect.innerHTML = '<option value="">Pilih gelombang</option>';

            data.forEach((g) => {
                const opt = document.createElement('option');
                opt.value = g.id;

                const isAktif = g.aktif === true || g.aktif === 1 || g.aktif === '1';

                if (isAktif) {
                    opt.textContent = `${g.nama} — Rp${Number(g.biaya).toLocaleString('id-ID')}`;
                } else {
                    opt.textContent = `${g.nama} (TUTUP) — Rp${Number(g.biaya).toLocaleString('id-ID')}`;
                    opt.disabled = true;
                    opt.className = 'text-[#a5b0a8]';
                }

                opt.dataset.biaya = g.biaya;
                opt.dataset.aktif = isAktif ? '1' : '0';
                gelombangSelect.appendChild(opt);
            });

            gelombangSelect.disabled = false;
            info.textContent = '';
        } catch (e) {
            info.textContent = 'Gagal memuat gelombang.';
        }
    });

    $('gelombang-id').addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        const info = $('gelombang-info');

        if (!opt || !opt.value) {
            info.textContent = '';
            return;
        }

        if (opt.dataset.aktif === '0') {
            info.textContent = '⚠️ Gelombang ini sudah ditutup.';
            info.className = 'mt-1 text-xs text-[#963d21]';
        } else {
            info.textContent = opt.dataset.biaya
                ? `Biaya: Rp${Number(opt.dataset.biaya).toLocaleString('id-ID')}`
                : '';
            info.className = 'mt-1 text-xs text-[#699944]';
        }
    });

    // ============================================
    // STATE: Form yang Menunggu Konfirmasi
    // ============================================
    let pendingForm = null;
    let isSubmitting = false;
    let isValidated = false;

    // ============================================
    // SUBMIT STEP 1 — Validasi HTML5 + Validasi Server
    // ============================================
    $('registration-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        const form = this;
        const btn = $('submit-button');
        const originalBtnText = btn.querySelector('span').textContent;
        btn.disabled = true;
        btn.querySelector('span').textContent = 'Memeriksa data...';

        try {
            const fd = new FormData(form);
            const res = await fetch(ROUTES.validasi, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: fd,
            });

            const data = await res.json();

            if (data.success) {
                isValidated = true;

                const tglLahir = fd.get('tanggal_lahir') || '';
                $('confirm-nama').textContent  = (fd.get('nama_lengkap') || '—').trim();
                $('confirm-ttl').textContent   = `${(fd.get('tempat_lahir') || '—').trim()}, ${formatTanggalIndonesia(tglLahir)}`;
                $('confirm-nisn').textContent  = (fd.get('nisn') || '—').trim();
                $('confirm-wa').textContent    = (fd.get('no_whatsapp') || '—').trim();
                $('confirm-email').textContent = (fd.get('email') || '—').trim();

                pendingForm = form;
                showModal('confirm-modal');
                if (window.lucide) lucide.createIcons();

            } else if (data.errors) {
                const list = Object.values(data.errors).flat();
                showErrorModal(list);
            } else {
                showErrorModal([data.message || 'Validasi gagal.']);
            }

        } catch (err) {
            console.error('[validasi] Error:', err);
            showErrorModal(['Gagal memeriksa data. Periksa koneksi Anda.']);
        } finally {
            btn.disabled = false;
            btn.querySelector('span').textContent = originalBtnText;
        }
    });

    // ============================================
    // SUBMIT STEP 2 — User Klik "Ya, Data Benar"
    // ============================================
    $('confirm-submit').addEventListener('click', async function () {
        if (isSubmitting || !pendingForm || !isValidated) return;

        isSubmitting = true;

        const confirmBtn = this;
        const confirmText = $('confirm-submit-text');
        const originalConfirmText = confirmText.textContent;
        confirmBtn.disabled = true;
        confirmText.textContent = 'Menyimpan...';

        hideModal('confirm-modal');

        const btn = $('submit-button');
        const msg = $('form-message');
        btn.disabled = true;
        btn.querySelector('span').textContent = 'Menyimpan...';
        hideMsg(msg);

        const formData = new FormData(pendingForm);

        try {
            const res = await fetch(ROUTES.daftar, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: formData,
            });

            const data = await res.json();
            console.log('[daftar] Response:', data);

            if (data.success) {
                const d = data.data;

                $('modal-nomor').textContent     = d.nomor_pendaftaran;
                $('modal-nama').textContent      = d.nama_lengkap;
                $('modal-jenjang').textContent   = d.jenjang;
                $('modal-gelombang').textContent = d.gelombang;
                $('modal-email').value           = d.email;
                $('modal-password').value        = d.password;
                $('modal-biaya').textContent = Number(d.biaya || 0).toLocaleString('id-ID');

                showModal('success-modal');
                if (window.lucide) lucide.createIcons();

                // Reset form
                pendingForm.reset();
                $('gelombang-id').innerHTML = '<option value="">Pilih jenjang terlebih dahulu</option>';
                $('gelombang-id').disabled = true;
                $('gelombang-info').textContent = '';
                pendingForm = null;
                isValidated = false;

                // Reset ke picker
                jenjangSelect.value = '';
                formWrapper.classList.add('hidden');
                jenjangPicker.classList.remove('hidden');
                document.querySelectorAll('.jenjang-card').forEach(c => c.classList.remove('active'));

            } else if (data.errors) {
                const list = Object.values(data.errors).flat();
                showErrorModal(list);
            } else {
                showErrorModal([data.message || 'Terjadi kesalahan.']);
            }
        } catch (err) {
            console.error('[daftar] Error:', err);
            showErrorModal(['Gagal menyimpan. Periksa koneksi Anda dan coba lagi.']);
        } finally {
            isSubmitting = false;
            confirmBtn.disabled = false;
            confirmText.textContent = originalConfirmText;
            btn.disabled = false;
            btn.querySelector('span').textContent = 'Kirim Pendaftaran';
        }
    });

    // ============================================
    // SUBMIT — CEK STATUS
    // ============================================
    $('status-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        const num = $('status-number').value.trim();
        const msg = $('status-message');
        const result = $('status-result');
        result.classList.add('hidden');

        const formData = new FormData();
        formData.append('nomor_pendaftaran', num);

        try {
            const res = await fetch(ROUTES.cekStatus, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: formData,
            });
            const data = await res.json();

            if (data.success) {
                const d = data.data;

                $('result-number').textContent = d.nomor_pendaftaran;
                $('result-nama').textContent   = d.nama_lengkap;
                $('result-jenjang').textContent = d.jenjang;

                $('result-verification').textContent = d.status_verifikasi;

                $('result-exam').textContent = d.status_ujian;
                $('result-exam-date').textContent = d.tanggal_ujian ? '📅 ' + d.tanggal_ujian : '';
                $('result-exam-score').textContent = d.nilai_ujian ? 'Nilai: ' + d.nilai_ujian : '';

                $('result-graduation').textContent = d.status_kelulusan;

                $('result-reregistration').textContent = d.status_daftar_ulang;
                $('result-reregistration-date').textContent = d.tanggal_daftar_ulang ? '📅 ' + d.tanggal_daftar_ulang : '';

                const score = $('result-score');
                if (d.nilai_ujian) {
                    score.textContent = 'Nilai ujian: ' + d.nilai_ujian;
                    score.classList.remove('hidden');
                } else {
                    score.classList.add('hidden');
                }

                const cta = $('reregistration-cta');
                const ctaLink = $('reregistration-link');

                const bolehDaftarUlang =
                    d.status_kelulusan === 'Lulus' &&
                    d.status_daftar_ulang === 'Belum Daftar Ulang' &&
                    d.link_daftar_ulang;

                if (bolehDaftarUlang) {
                    ctaLink.href = d.link_daftar_ulang;
                    cta.classList.remove('hidden');
                } else {
                    cta.classList.add('hidden');
                }

                result.classList.remove('hidden');
                hideMsg(msg);

                if (window.lucide) lucide.createIcons();
            } else {
                showMsg(msg, data.message || 'Data tidak ditemukan.');
                msg.className = 'mt-4 rounded-lg px-4 py-3 text-sm border border-[#f2c1ae] bg-[#fff0ea] text-[#963d21]';
            }
        } catch (err) {
            showMsg(msg, 'Gagal memuat data.');
            msg.className = 'mt-4 rounded-lg px-4 py-3 text-sm border border-[#f2c1ae] bg-[#fff0ea] text-[#963d21]';
        }
    });

    // ============================================
    // DELEGATED CLICKS — SEMUA MODAL
    // ============================================
    document.addEventListener('click', function (e) {

        const copyBtn = e.target.closest('[data-copy]');
        if (copyBtn) {
            const el = $(copyBtn.dataset.copy);
            const text = el ? (el.value !== undefined ? el.value : el.textContent) : '';
            if (text) copyText(text, copyBtn);
            return;
        }

        if (e.target.closest('[data-close-modal]')) {
            hideModal('success-modal');
            return;
        }

        if (e.target.closest('[data-close-error-modal]')) {
            hideErrorModal();
            return;
        }

        if (e.target.closest('[data-close-confirm]')) {
            hideModal('confirm-modal');
            pendingForm = null;
            isValidated = false;
            setTimeout(() => {
                const firstField = $('nama-lengkap');
                if (firstField) {
                    firstField.focus();
                    firstField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 100);
            return;
        }

        if (e.target.id === 'success-modal') hideModal('success-modal');
        if (e.target.id === 'error-modal')   hideErrorModal();
        if (e.target.id === 'confirm-modal') {
            hideModal('confirm-modal');
            pendingForm = null;
        }
    });

    // ============================================
    // ESCAPE KEY — TUTUP SEMUA MODAL
    // ============================================
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            hideModal('success-modal');
            hideErrorModal();
            hideModal('confirm-modal');
            pendingForm = null;
        }
    });

})();
</script>

</body>
</html>