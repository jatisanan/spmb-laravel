<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Santri') — PPDB Jati Sanan</title>

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
        [x-cloak] { display: none !important; }

        .status-chip {
            display: inline-flex; align-items: center;
            border-radius: 999px; padding: .3rem .7rem;
            font-size: .75rem; font-weight: 700; white-space: nowrap;
        }
        .status-pending { background: #fff2ca; color: #805500; }
        .status-success { background: #e8f4df; color: #175b31; }
        .status-neutral { background: #edf1ec; color: #42604c; }
        .status-danger  { background: #fff0ea; color: #963d21; }

        .field-control {
            width: 100%; padding: .65rem .85rem; color: #193128; outline: none;
            border: 1px solid #d6dccf; border-radius: 8px; background: #fffdf8;
            transition: border-color .2s, box-shadow .2s;
        }
        .field-control:focus { border-color: #5d9f3f; box-shadow: 0 0 0 3px rgba(93,159,63,.18); }
    </style>
    @stack('styles')
</head>
<body>

{{-- ============================================ --}}
{{-- HEADER --}}
{{-- ============================================ --}}
<header class="sticky top-0 z-40 w-full border-b-4 border-[#d8ae45] bg-[#0d4a36] text-white"
        x-data="{ open: false }">
    <div class="mx-auto flex max-w-5xl items-center justify-between gap-3 px-4 sm:px-5 py-3">

        {{-- Brand --}}
        <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 min-w-0">
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

        {{-- Menu desktop --}}
        <nav class="hidden md:flex items-center gap-1 text-sm">
            <a href="{{ route('student.dashboard') }}"
               class="rounded-lg px-3 py-2 font-semibold hover:bg-white/10 {{ request()->routeIs('student.dashboard') ? 'bg-white/10' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('student.pembayaran.index') }}"
               class="rounded-lg px-3 py-2 font-semibold hover:bg-white/10 {{ request()->routeIs('student.pembayaran.*') ? 'bg-white/10' : '' }}">
                Pembayaran
            </a>
            <a href="{{ route('landing') }}"
               class="rounded-lg border border-white/30 px-3 py-2 text-xs font-semibold hover:bg-white/10">
                <i data-lucide="home" class="inline h-3.5 w-3.5 mr-1"></i>
                Beranda
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit"
                        class="rounded-lg border border-white/30 px-3 py-2 text-xs font-semibold hover:bg-white/10">
                    <i data-lucide="log-out" class="inline h-3.5 w-3.5 mr-1"></i>
                    Logout
                </button>
            </form>
        </nav>

        {{-- Menu mobile --}}
        <button type="button" @click="open = !open"
                class="md:hidden p-2 -mr-2 rounded-lg hover:bg-white/10">
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Dropdown mobile --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden border-t border-white/10 bg-[#0a3e2d]">
        <nav class="flex flex-col px-4 py-3 text-sm">
            <a href="{{ route('student.dashboard') }}" @click="open = false"
               class="py-2.5 border-b border-white/10 hover:text-[#f1cf72]">
                Dashboard
            </a>
            <a href="{{ route('student.pembayaran.index') }}" @click="open = false"
               class="py-2.5 border-b border-white/10 hover:text-[#f1cf72]">
                Pembayaran
            </a>
            <a href="{{ route('landing') }}" @click="open = false"
               class="py-2.5 border-b border-white/10 hover:text-[#f1cf72]">
                Beranda
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                        class="w-full rounded border border-white/30 px-4 py-2.5 font-semibold text-[#d6e3d0] hover:bg-white/10">
                    Logout
                </button>
            </form>
        </nav>
    </div>
</header>

{{-- ============================================ --}}
{{-- CONTENT --}}
{{-- ============================================ --}}
<main class="mx-auto max-w-5xl px-4 sm:px-5 py-6 sm:py-8">

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-[#b9dca8] bg-[#e8f4df] px-4 py-3 text-sm text-[#175b31] flex items-start gap-2">
            <i data-lucide="check-circle" class="h-5 w-5 shrink-0 mt-0.5"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-5 rounded-xl border border-[#f2c1ae] bg-[#fff0ea] px-4 py-3 text-sm text-[#963d21] flex items-start gap-2">
            <i data-lucide="alert-circle" class="h-5 w-5 shrink-0 mt-0.5"></i>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @yield('content')
</main>

<footer class="mx-auto max-w-5xl px-4 sm:px-5 py-6 text-center text-xs text-[#617064]">
    &copy; {{ date('Y') }} {{ \App\Models\PengaturanSitus::get('footer_title', 'PPDB Jati Sanan') }}
</footer>

<script>
    if (window.lucide) lucide.createIcons();
    document.addEventListener('alpine:initialized', () => {
        if (window.lucide) lucide.createIcons();
    });
</script>
@stack('scripts')
</body>
</html>