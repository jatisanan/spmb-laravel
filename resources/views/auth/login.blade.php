<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PPDB Jati Sanan</title>

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
        body { margin: 0; color: var(--ink); font-family: "Libre Franklin", sans-serif; }
        .display-font { font-family: "Playfair Display", serif; }
        .pattern-bg {
            background-color: #f6f1e4;
            background-image:
                radial-gradient(rgba(13, 74, 54, .08) 1px, transparent 1px),
                radial-gradient(rgba(216, 174, 69, .11) 1px, transparent 1px);
            background-position: 0 0, 14px 14px;
            background-size: 28px 28px;
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
        }
        .field-control:focus {
            border-color: #5d9f3f;
            box-shadow: 0 0 0 3px rgba(93,159,63,.18);
        }
    </style>
</head>
<body class="w-full min-h-screen pattern-bg flex items-center justify-center p-5">

    <div class="w-full max-w-md">
        {{-- Logo & Nama (DINAMIS dari Pengaturan Situs) --}}
        <div class="text-center mb-6">
            <img src="{{ \App\Models\PengaturanSitus::getImage('header_logo', 'images/logo.png') }}"
                 alt="Logo" class="mx-auto h-16 w-16 object-contain">
            <p class="mt-3 text-xs font-bold uppercase tracking-[.18em] text-[#699944]">
                {{ \App\Models\PengaturanSitus::get('header_kicker', 'Pondok Pesantren') }}
            </p>
            <h1 class="display-font mt-1 text-2xl font-bold text-[#0d4a36]">
                {{ \App\Models\PengaturanSitus::get('header_name', 'Jati Sanan') }}
            </h1>
        </div>

        {{-- Card Login --}}
        <div class="rounded-2xl border border-[#dce6d3] bg-white p-6 shadow-lg md:p-8">

            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#699944]">Portal PPDB</p>
            <h2 class="display-font mt-2 text-2xl font-bold text-[#0d4a36]">Masuk ke Akun Anda</h2>
            <p class="mt-2 text-sm leading-6 text-[#506056]">
                Gunakan email dan password yang telah terdaftar.
            </p>

            {{-- Session status --}}
            @if (session('status'))
                <div class="mt-4 rounded-lg border border-[#b9dca8] bg-[#e8f4df] px-4 py-3 text-sm text-[#175b31]">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="mb-2 block text-sm font-bold text-[#244535]">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           class="field-control"
                           placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="mb-2 block text-sm font-bold text-[#244535]">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                               required autocomplete="current-password"
                               class="field-control pr-10"
                               placeholder="••••••••">
                        <button type="button" id="toggle-password"
                                class="absolute right-2 top-1/2 -translate-y-1/2 rounded p-1.5 text-[#617064] hover:bg-[#f4f8ee]"
                                title="Lihat password">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-[#506056]">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="rounded border-[#d6dccf] text-[#0d4a36] focus:ring-[#5d9f3f]">
                        <span>Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm font-semibold text-[#0d4a36] underline hover:text-[#176346]">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Tombol --}}
                <button type="submit"
                        class="w-full rounded-lg bg-[#0d4a36] px-5 py-3 font-bold text-white transition hover:bg-[#176346]">
                    Masuk
                </button>
            </form>

            {{-- Info Pendaftaran (kalau belum punya akun) --}}
            <div class="mt-6 rounded-xl border border-[#e1e9da] bg-[#f4f8ee] p-4 text-xs leading-6 text-[#506056]">
                <p class="font-bold text-[#0d4a36] mb-1">
                    <i data-lucide="info" class="inline h-3 w-3"></i>
                    Belum punya akun?
                </p>
                <p>
                    Akun otomatis dibuat ketika Anda mendaftar sebagai santri baru di
                    <a href="{{ route('landing') }}#daftar" class="font-semibold text-[#0d4a36] underline">
                        halaman pendaftaran
                    </a>.
                    Password awal = tanggal lahir (format <code class="font-mono">ddmmyyyy</code>).
                </p>
            </div>

        </div>

        {{-- Link kembali --}}
        <p class="mt-6 text-center text-sm text-[#506056]">
            <a href="{{ route('landing') }}" class="font-semibold text-[#0d4a36] hover:underline">
                ← Kembali ke Beranda
            </a>
        </p>
    </div>

    <script>
        if (window.lucide) lucide.createIcons();

        // Toggle visibility password
        document.getElementById('toggle-password')?.addEventListener('click', function () {
            const input = document.getElementById('password');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.innerHTML = isPassword
                ? '<i data-lucide="eye-off" class="h-4 w-4"></i>'
                : '<i data-lucide="eye" class="h-4 w-4"></i>';
            if (window.lucide) lucide.createIcons();
        });
    </script>
</body>
</html>