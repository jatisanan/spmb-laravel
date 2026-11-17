<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pengumuman->judul); ?> - SPMB Jati Sanan</title>
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.577.0/dist/umd/lucide.min.js"></script>
    <style>
        .display-font { font-family: "Playfair Display", serif; }
    </style>
</head>
<body class="bg-[#f6f1e4] min-h-screen flex flex-col">

    
    <header class="bg-[#0d4a36] text-white border-b-4 border-[#d8ae45] sticky top-0 z-50 shrink-0">
        <div class="mx-auto max-w-4xl px-4 py-3 flex items-center justify-between">
            <a href="<?php echo e(route('landing')); ?>" class="flex items-center gap-2 text-sm font-bold hover:text-[#f1cf72]">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
                Kembali ke Beranda
            </a>
            <span class="text-xs uppercase tracking-widest text-[#e9d28b]">Pengumuman</span>
        </div>
    </header>

    
    <main class="flex-1 mx-auto w-full max-w-4xl px-4 py-10">

        
        <article class="rounded-2xl border border-[#e1e9da] bg-white p-6 sm:p-8 shadow-sm">
            <p class="text-xs text-[#617064] mb-3">
                <i data-lucide="clock" class="inline h-3 w-3"></i>
                <?php echo e($pengumuman->published_at?->isoFormat('D MMMM Y, HH:mm') ?? $pengumuman->created_at->isoFormat('D MMMM Y, HH:mm')); ?>

            </p>

            <h1 class="display-font text-2xl sm:text-3xl font-bold text-[#0d4a36] mb-6 leading-tight">
                <?php echo e($pengumuman->judul); ?>

            </h1>

            <div class="prose prose-sm sm:prose-base max-w-none text-[#365143] leading-7 whitespace-pre-line">
                <?php echo preg_replace(
                    '/(https?:\/\/[^\s]+)/',
                    '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-[#0d4a36] underline font-semibold hover:text-[#5d9f3f]">$1</a>',
                    e($pengumuman->isi)
                ); ?>

            </div>
        </article>

        
        <?php if($lainnya->isNotEmpty()): ?>
            <section class="mt-10">
                <h2 class="display-font text-xl font-bold text-[#0d4a36] mb-4">Pengumuman Lainnya</h2>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $lainnya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('pengumuman.show', $p->id)); ?>"
                           class="rounded-xl border border-[#d8e3d0] bg-white p-4 shadow-sm hover:border-[#5d9f3f] transition">
                            <p class="text-xs text-[#617064] mb-1">
                                <?php echo e($p->published_at?->isoFormat('D MMM Y')); ?>

                            </p>
                            <h3 class="font-bold text-[#0d4a36] line-clamp-2"><?php echo e($p->judul); ?></h3>
                            <p class="mt-2 text-xs text-[#536057] line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($p->isi, 80)); ?></p>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endif; ?>

    </main>

    
    <footer class="bg-[#073528] text-white text-center py-6 shrink-0">
        <p class="text-xs text-[#d6e3d0]"><?php echo e(\App\Models\PengaturanSitus::get('footer_copyright', '© SPMB Jati Sanan')); ?></p>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html><?php /**PATH /var/www/html/resources/views/pengumuman/show.blade.php ENDPATH**/ ?>