<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — PPDB Jati Sanan</title>

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
        body { margin: 0; color: var(--ink); font-family: "Libre Franklin", sans-serif; background: #f6f8f3; }
        .display-font { font-family: "Playfair Display", serif; }

        [x-cloak] { display: none !important; }

        /* Sidebar links */
        .sidebar-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .75rem 1rem; color: #d6e3d0;
            border-radius: .5rem; font-size: .875rem; font-weight: 600;
            transition: background .15s, color .15s;
            white-space: nowrap;
        }
        .sidebar-link:hover { background: rgba(255,255,255,.08); color: #fff; }
        .sidebar-link.active { background: #d8ae45; color: #073528; }
        .sidebar-link.active:hover { background: #efd175; }

        /* Mini sidebar (tablet) — sembunyikan label */
        @media (min-width: 768px) and (max-width: 1023.98px) {
            .sidebar-label { display: none; }
            .sidebar-link { justify-content: center; padding: .75rem; }
            .sidebar-brand-text { display: none; }
        }

        .field-control {
            width: 100%; padding: .65rem .85rem; color: #193128; outline: none;
            border: 1px solid #d6dccf; border-radius: 8px; background: #fffdf8;
            transition: border-color .2s, box-shadow .2s;
        }
        .field-control:focus { border-color: #5d9f3f; box-shadow: 0 0 0 3px rgba(93,159,63,.18); }

        .status-chip { display:inline-flex; align-items:center; border-radius:999px; padding:.25rem .65rem; font-size:.7rem; font-weight:700; white-space:nowrap; }
        .status-pending { background:#fff2ca; color:#805500; }
        .status-success { background:#e8f4df; color:#175b31; }
        .status-neutral { background:#edf1ec; color:#42604c; }
        .status-danger  { background:#fff0ea; color:#963d21; }

        /* Tabel auto-scroll */
        .admin-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .admin-table { width: 100%; border-collapse: collapse; min-width: 640px; }
        .admin-table th { padding:.75rem 1rem; text-align:left; font-size:.7rem; letter-spacing:.08em; text-transform:uppercase; color:#315440; background:#eef5e9; border-bottom:1px solid #dce6d3; }
        .admin-table td { padding:.75rem 1rem; font-size:.82rem; color:#365143; border-bottom:1px solid #edf0e9; }
        .admin-table tr:hover td { background:#fbfdf9; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen" x-data="{ 
    sidebarOpen: false, 
    sidebarCollapsed: false 
}" x-init="
    sidebarCollapsed = window.innerWidth >= 768 && window.innerWidth < 1024;
    window.addEventListener('resize', () => {
        sidebarCollapsed = window.innerWidth >= 768 && window.innerWidth < 1024;
        if (window.innerWidth >= 768) sidebarOpen = false;
    });
">

<div class="flex min-h-screen">

    {{-- ===== OVERLAY (mobile) ===== --}}
    <div x-show="sidebarOpen" x-cloak
         x-transition.opacity
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside
        :class="{
            'translate-x-0': sidebarOpen,
            '-translate-x-full': !sidebarOpen,
            'lg:translate-x-0': true,
            'w-64': !sidebarCollapsed,
            'md:w-16': sidebarCollapsed,
            'lg:w-64': true
        }"
        class="fixed lg:sticky top-0 left-0 z-50 h-screen shrink-0
               bg-[#0d4a36] text-white flex flex-col
               transition-all duration-300 ease-in-out">

        {{-- Brand --}}
        <div class="p-4 border-b border-white/10 flex items-center justify-between gap-2">
            <a href="{{ route('landing') }}"
               class="flex items-center gap-3 hover:opacity-90 transition min-w-0">
                <img src="{{ \App\Models\PengaturanSitus::getImage('header_logo', 'images/logo.png') }}"
                     alt="Logo" class="h-10 w-10 object-contain shrink-0">
                <div class="sidebar-brand-text min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-[.16em] text-[#e9d28b]">Admin</p>
                    <p class="text-sm font-bold truncate">{{ \App\Models\PengaturanSitus::get('header_name', 'Jati Sanan') }}</p>
                </div>
            </a>
            {{-- Tutup di mobile --}}
            <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg hover:bg-white/10">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        {{-- Menu --}}
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               title="Dashboard">
                <i data-lucide="layout-dashboard" class="h-4 w-4 shrink-0"></i>
                <span class="sidebar-label">Dashboard</span>
            </a>
            <a href="{{ route('admin.pendaftaran.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}"
               title="Data Pendaftaran">
                <i data-lucide="clipboard-list" class="h-4 w-4 shrink-0"></i>
                <span class="sidebar-label">Data Pendaftaran</span>
            </a>
            <a href="{{ route('admin.jenjang.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.jenjang.*') ? 'active' : '' }}"
               title="Jenjang & Gelombang">
                <i data-lucide="graduation-cap" class="h-4 w-4 shrink-0"></i>
                <span class="sidebar-label">Jenjang & Gelombang</span>
            </a>
            <a href="{{ route('admin.pengumuman.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}"
               title="Pengumuman">
                <i data-lucide="megaphone" class="h-4 w-4 shrink-0"></i>
                <span class="sidebar-label">Pengumuman</span>
            </a>
            <a href="{{ route('admin.pengaturan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}"
               title="Pengaturan Situs">
                <i data-lucide="settings" class="h-4 w-4 shrink-0"></i>
                <span class="sidebar-label">Pengaturan Situs</span>
            </a>
            <a href="{{ route('admin.pengguna.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}"
               title="Pengguna">
                <i data-lucide="users" class="h-4 w-4 shrink-0"></i>
                <span class="sidebar-label">Pengguna</span>
            </a>

            <div class="my-2 border-t border-white/10"></div>

            <a href="{{ route('landing') }}" class="sidebar-link" title="Landing Page">
                <i data-lucide="external-link" class="h-4 w-4 shrink-0"></i>
                <span class="sidebar-label">Lihat Landing Page</span>
            </a>
        </nav>

        {{-- User + Logout --}}
        <div class="p-3 border-t border-white/10">
            <div class="flex items-center gap-3 px-1 py-2">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#d8ae45] text-sm font-bold text-[#073528]">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0 sidebar-label">
                    <p class="text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-[#d6e3d0] truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-lg border border-white/20 px-3 py-2 text-sm font-semibold hover:bg-white/10"
                        title="Logout">
                    <i data-lucide="log-out" class="h-4 w-4 shrink-0"></i>
                    <span class="sidebar-label">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="flex-1 flex flex-col min-w-0 w-full">

        {{-- Topbar --}}
        <header class="bg-white border-b border-[#e1e9da] sticky top-0 z-30">
            <div class="px-4 sm:px-6 py-3 sm:py-4 flex items-center gap-3">
                {{-- Hamburger — mobile only --}}
                <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 -ml-2 rounded-lg hover:bg-gray-100 shrink-0">
                    <i data-lucide="menu" class="h-5 w-5"></i>
                </button>

                <div class="flex-1 min-w-0">
                    <h1 class="display-font text-base sm:text-xl font-bold text-[#0d4a36] truncate">
                        @yield('page-title', 'Dashboard')
                    </h1>
                    <p class="text-xs text-[#617064] mt-0.5 truncate hidden sm:block">
                        @yield('page-subtitle', 'Selamat datang di admin panel')
                    </p>
                </div>

                <a href="{{ route('landing') }}"
                   class="hidden md:inline-flex items-center gap-2 rounded-lg border border-[#d6dccf] px-3 py-2 text-sm font-semibold text-[#0d4a36] hover:bg-[#f4f8ee] shrink-0">
                    <i data-lucide="external-link" class="h-4 w-4"></i>
                    <span class="hidden lg:inline">Landing Page</span>
                </a>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 p-4 sm:p-6 min-w-0">
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

        <footer class="px-4 sm:px-6 py-4 text-xs text-[#617064] border-t border-[#e1e9da]">
            &copy; {{ date('Y') }} PPDB Pondok Pesantren Jati Sanan
        </footer>
    </div>
</div>

<script>
    if (window.lucide) lucide.createIcons();
    // Re-render icon setiap kali sidebar toggle (kalau icon di dalam sidebar hidden)
    document.addEventListener('alpine:initialized', () => {
        if (window.lucide) lucide.createIcons();
    });
</script>
@stack('scripts')
</body>
</html>