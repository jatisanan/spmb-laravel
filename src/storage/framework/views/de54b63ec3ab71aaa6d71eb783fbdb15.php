

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Ringkasan aktivitas SPMB Jati Sanan'); ?>

<?php $__env->startSection('content'); ?>




<div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da] mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#0d4a36]/10">
                <i data-lucide="wallet" class="h-4 w-4 text-[#0d4a36]"></i>
            </div>
            <h3 class="display-font text-lg font-bold text-[#0d4a36]">Statistik Pembayaran</h3>
        </div>
        <a href="<?php echo e(route('admin.pembayaran.index')); ?>"
        class="text-sm font-semibold text-[#0d4a36] hover:underline">
            Kelola →
        </a>
    </div>

    <?php
        $totalBayar = max($total, 1);
        $pct = fn($n) => round($n / $totalBayar * 100);
    ?>

    
    <div class="mb-4 h-2.5 w-full overflow-hidden rounded-full bg-[#edf1ec] flex">
        <?php
            $pBelum    = $pct($statsPembayaran['belum']);
            $pMenunggu = $pct($statsPembayaran['menunggu']);
            $pTerverif = $pct($statsPembayaran['terverifikasi']);
            $pGagal    = $pct($statsPembayaran['gagal']);
        ?>
        <div class="bg-[#a3b1a0]" style="width: <?php echo e($pBelum); ?>%" title="Belum Bayar: <?php echo e($pBelum); ?>%"></div>
        <div class="bg-[#d8ae45]" style="width: <?php echo e($pMenunggu); ?>%" title="Menunggu: <?php echo e($pMenunggu); ?>%"></div>
        <div class="bg-[#5d9f3f]" style="width: <?php echo e($pTerverif); ?>%" title="Terverifikasi: <?php echo e($pTerverif); ?>%"></div>
        <div class="bg-[#963d21]" style="width: <?php echo e($pGagal); ?>%" title="Gagal: <?php echo e($pGagal); ?>%"></div>
    </div>

    
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
        <?php
            $pembayaranCards = [
                [
                    'label' => 'Belum Bayar',
                    'value' => $statsPembayaran['belum'],
                    'pct'   => $pBelum,
                    'color' => 'bg-[#edf1ec] text-[#42604c]',
                    'bar'   => 'bg-[#a3b1a0]',
                    'icon'  => 'circle-dashed',
                    'status'=> 'Belum Bayar',
                ],
                [
                    'label' => 'Menunggu Verifikasi',
                    'value' => $statsPembayaran['menunggu'],
                    'pct'   => $pMenunggu,
                    'color' => 'bg-[#fff2ca] text-[#805500]',
                    'bar'   => 'bg-[#d8ae45]',
                    'icon'  => 'clock',
                    'status'=> 'Menunggu Verifikasi',
                ],
                [
                    'label' => 'Terverifikasi',
                    'value' => $statsPembayaran['terverifikasi'],
                    'pct'   => $pTerverif,
                    'color' => 'bg-[#e8f4df] text-[#175b31]',
                    'bar'   => 'bg-[#5d9f3f]',
                    'icon'  => 'check-circle',
                    'status'=> 'Terverifikasi',
                ],
                [
                    'label' => 'Gagal',
                    'value' => $statsPembayaran['gagal'],
                    'pct'   => $pGagal,
                    'color' => 'bg-[#fff0ea] text-[#963d21]',
                    'bar'   => 'bg-[#963d21]',
                    'icon'  => 'x-circle',
                    'status'=> 'Gagal',
                ],
            ];
        ?>

        <?php $__currentLoopData = $pembayaranCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.pembayaran.index', ['status' => $c['status']])); ?>"
            class="group rounded-xl border border-[#e1e9da] bg-white p-3 hover:border-[#0d4a36]/30 hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full <?php echo e($c['color']); ?>">
                        <i data-lucide="<?php echo e($c['icon']); ?>" class="h-3.5 w-3.5"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-[#617064] truncate">
                            <?php echo e($c['label']); ?>

                        </p>
                        <div class="flex items-baseline gap-1.5">
                            <p class="display-font text-xl font-bold text-[#0d4a36]"><?php echo e($c['value']); ?></p>
                            <span class="text-[10px] font-semibold text-[#617064]"><?php echo e($c['pct']); ?>%</span>
                        </div>
                    </div>
                    <i data-lucide="chevron-right"
                    class="h-4 w-4 text-[#d6dccf] group-hover:text-[#0d4a36] transition-colors"></i>
                </div>
                <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-[#edf1ec]">
                    <div class="<?php echo e($c['bar']); ?> h-full transition-all" style="width: <?php echo e($c['pct']); ?>%"></div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
    <div class="rounded-2xl bg-[#0d4a36] p-5 text-white">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#d7e7d1]">Total Pendaftar</p>
            <i data-lucide="users" class="h-5 w-5 text-[#d8ae45]"></i>
        </div>
        <p class="display-font mt-3 text-4xl font-bold"><?php echo e($total); ?></p>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da]">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Terverifikasi</p>
            <i data-lucide="check-circle" class="h-5 w-5 text-[#5d9f3f]"></i>
        </div>
        <p class="display-font mt-3 text-4xl font-bold text-[#0d4a36]"><?php echo e($terverifikasi); ?></p>
        <p class="mt-1 text-xs text-[#617064]"><?php echo e($menunggu); ?> menunggu verifikasi</p>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da]">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Lulus Seleksi</p>
            <i data-lucide="award" class="h-5 w-5 text-[#d8ae45]"></i>
        </div>
        <p class="display-font mt-3 text-4xl font-bold text-[#0d4a36]"><?php echo e($lulus); ?></p>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da]">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Daftar Ulang</p>
            <i data-lucide="user-check" class="h-5 w-5 text-[#5d9f3f]"></i>
        </div>
        <p class="display-font mt-3 text-4xl font-bold text-[#0d4a36]"><?php echo e($daftarUlang); ?></p>
    </div>
</div>


<div class="rounded-2xl bg-white p-5 shadow-sm border border-[#e1e9da] mb-6">
    <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Statistik per Jenjang</h3>
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $perJenjang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center justify-between rounded-xl bg-[#f4f8ee] p-3">
                <div>
                    <p class="text-sm font-bold text-[#0d4a36]"><?php echo e($j->nama); ?></p>
                    <p class="text-xs text-[#617064]"><?php echo e($j->label ?? ''); ?></p>
                </div>
                <p class="display-font text-2xl font-bold text-[#0d4a36]"><?php echo e($j->pendaftarans_count); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-[#617064]">Belum ada data jenjang.</p>
        <?php endif; ?>
    </div>
</div>




<?php $__empty_1 = true; $__currentLoopData = $terbaruPerJenjang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenjangId => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $j     = $group['jenjang'];
        $items = $group['items'];
        $lower = strtolower($j->nama);

        if (str_contains($lower, 'smp')) {
            $bgHeader   = 'bg-[#d9e9f5]';
            $borderCard = 'border-[#c5d9e8]';
            $chipColor  = 'bg-[#1e4d75] text-white';
        } elseif (str_contains($lower, 'sma')) {
            $bgHeader   = 'bg-[#e3e6de]';
            $borderCard = 'border-[#d6dccf]';
            $chipColor  = 'bg-[#4b5347] text-white';
        } else {
            $bgHeader   = 'bg-[#f8fbf5]';
            $borderCard = 'border-[#e1e9da]';
            $chipColor  = 'bg-[#edf1ec] text-[#42604c]';
        }
    ?>

    <div class="rounded-2xl border <?php echo e($borderCard); ?> bg-white shadow-sm overflow-hidden mb-5">
        
        <div class="<?php echo e($bgHeader); ?> px-5 py-3 border-b <?php echo e($borderCard); ?> flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <h3 class="display-font text-base font-bold text-[#0d4a36]">
                    Pendaftar Terbaru — <?php echo e($j->nama); ?>

                </h3>
                <span class="inline-flex items-center rounded-full <?php echo e($chipColor); ?> px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide">
                    <?php echo e($items->count()); ?> terbaru
                </span>
            </div>
            <a href="<?php echo e(route('admin.pendaftaran.index', ['jenjang_id' => $j->id])); ?>"
               class="text-xs font-semibold text-[#0d4a36] hover:underline whitespace-nowrap">
                Lihat semua →
            </a>
        </div>

        
        <div class="overflow-x-auto">
            <table class="admin-table w-full">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Status Verifikasi</th>
                        <th style="text-align: center !important;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_2 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <?php
                            $cls = match($p->status_verifikasi) {
                                'Terverifikasi' => 'status-success',
                                'Perlu Perbaikan' => 'status-danger',
                                default => 'status-pending',
                            };
                        ?>
                        <tr>
                            <td class="font-mono font-bold text-[#0d4a36] whitespace-nowrap">
                                <?php echo e($p->nomor_pendaftaran); ?>

                            </td>
                            <td class="whitespace-nowrap">
                                <p class="font-semibold text-[#0d4a36]"><?php echo e($p->nama_lengkap); ?></p>
                                <p class="text-xs text-[#617064]"><?php echo e($p->jenis_kelamin); ?></p>
                            </td>
                            <td class="whitespace-nowrap">
                                <span class="status-chip <?php echo e($cls); ?>"><?php echo e($p->status_verifikasi); ?></span>
                            </td>
                            <td class="whitespace-nowrap" style="text-align: center !important;">
                                <a href="<?php echo e(route('admin.pendaftaran.show', $p)); ?>"
                                class="inline-flex items-center justify-center gap-1 rounded-lg bg-[#0d4a36] border-2 border-[#0d4a36] px-3 py-1.5 text-xs font-bold text-white shadow-md hover:bg-[#176346] hover:border-[#176346] hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-[#617064]">
                                Belum ada pendaftar <?php echo e($j->nama); ?>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="px-5 py-2 text-[10px] text-[#617064] border-t <?php echo e($borderCard); ?>">
            Menampilkan <?php echo e($items->count()); ?> pendaftar terbaru <?php echo e($j->nama); ?>

        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="rounded-2xl border border-dashed border-[#d6dccf] bg-white p-8 text-center mb-6">
        <i data-lucide="inbox" class="mx-auto h-10 w-10 text-[#d6dccf] mb-2"></i>
        <p class="text-sm text-[#617064]">Belum ada pendaftar.</p>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>