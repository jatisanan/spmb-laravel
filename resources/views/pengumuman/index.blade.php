<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Pengumuman - SPMB Jati Sanan</title>
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.577.0/dist/umd/lucide.min.js"></script>
</head>
<body class="bg-[#f6f1e4] min-h-screen">

    <header class="bg-[#0d4a36] text-white border-b-4 border-[#d8ae45] sticky top-0 z-50">
        <div class="mx-auto max-w-5xl px-4 py-3 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 text-sm font-bold hover:text-[#f1cf72]">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
                Kembali ke Beranda
            </a>
            <span class="text-xs uppercase tracking-widest text-[#e9d28b]">Semua Pengumuman</span>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-10">
        <h1 class="display-font text-3xl font-bold text-[#0d4a36] mb-6">Pengumuman</h1>

        @if($pengumumen->isEmpty())
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-10 text-center">
                <p class="text-[#617064]">Belum ada pengumuman.</p>
            </div>
        @else
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach($pengumumen as $p)
                    <a href="{{ route('pengumuman.show', $p->id) }}"
                       class="group rounded-2xl border border-[#d8e3d0] bg-white p-5 shadow-sm hover:border-[#5d9f3f] hover:shadow-md transition block">
                        <p class="text-xs text-[#617064] mb-2">
                            <i data-lucide="clock" class="inline h-3 w-3"></i>
                            {{ $p->published_at?->isoFormat('D MMMM Y') }}
                        </p>
                        <h3 class="font-bold text-[#0d4a36] mb-2 line-clamp-2 group-hover:text-[#5d9f3f] transition">{{ $p->judul }}</h3>
                        <p class="text-sm text-[#536057] leading-6 line-clamp-3">{{ \Illuminate\Support\Str::limit($p->isi, 150) }}</p>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">{{ $pengumumen->links() }}</div>
        @endif
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>