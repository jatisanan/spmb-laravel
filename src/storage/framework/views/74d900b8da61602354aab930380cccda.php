

<?php $__env->startSection('title', 'Data Pendaftaran'); ?>
<?php $__env->startSection('page-title', 'Data Pendaftaran'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola semua pendaftar SPMB Jati Sanan'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .quick-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: .375rem;
        padding: .625rem 1rem;
        font-size: .8125rem;
        font-weight: 600;
        color: #617064;
        border-bottom: 2px solid transparent;
        white-space: nowrap;
        transition: color .15s, border-color .15s;
    }
    .quick-tab-btn:hover:not(:disabled) { color: #0d4a36; }
    .quick-tab-btn.active {
        color: #0d4a36;
        border-bottom-color: #d8ae45;
    }
    .quick-tab-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        color: #a5b0a8;
    }
    .quick-tab-btn:disabled:hover { color: #a5b0a8; border-bottom-color: transparent; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>




<?php
    $bd = $stats['breakdown'];

    $cards = [
        [
            'label' => 'Total Pendaftar',
            'value' => $stats['total'],
            'color' => 'bg-[#edf1ec] text-[#42604c]',
            'icon'  => 'users',
            'smp'   => $bd['total']['smp'],
            'sma'   => $bd['total']['sma'],
        ],
        [
            'label' => 'Menunggu Verifikasi',
            'value' => $stats['menunggu_verifikasi'],
            'color' => 'bg-[#fff2ca] text-[#805500]',
            'icon'  => 'clock',
            'smp'   => $bd['verifikasi_menunggu']['smp'],
            'sma'   => $bd['verifikasi_menunggu']['sma'],
        ],
        [
            'label' => 'Terverifikasi',
            'value' => $stats['terverifikasi'],
            'color' => 'bg-[#e8f4df] text-[#175b31]',
            'icon'  => 'check-circle',
            'smp'   => $bd['verifikasi_terverifikasi']['smp'],
            'sma'   => $bd['verifikasi_terverifikasi']['sma'],
        ],
        [
            'label' => 'Lulus',
            'value' => $stats['lulus'],
            'color' => 'bg-[#e8f4df] text-[#175b31]',
            'icon'  => 'award',
            'smp'   => $bd['lulus']['smp'],
            'sma'   => $bd['lulus']['sma'],
        ],
    ];
?>

<div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 mb-5">
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-xl border border-[#e1e9da] bg-white p-4 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full <?php echo e($c['color']); ?>">
                    <i data-lucide="<?php echo e($c['icon']); ?>" class="h-4 w-4"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-[#617064]"><?php echo e($c['label']); ?></p>
                    <p class="text-lg font-bold text-[#0d4a36]"><?php echo e($c['value']); ?></p>

                    
                    <div class="mt-2 space-y-2">

                        
                        <div class="rounded-lg border border-[#c5d9e8] bg-[#f4f8fc] px-2.5 py-1.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] font-bold text-[#1e4d75]">SMP</span>
                                <span class="text-[11px] font-bold text-[#0d4a36]"><?php echo e($c['smp']['total']); ?> orang</span>
                            </div>
                            <div class="mt-0.5 flex flex-wrap items-center gap-x-2 text-[10px] text-[#617064]">
                                <span>Laki-laki: <strong class="text-[#1e4d75]"><?php echo e($c['smp']['laki']); ?></strong></span>
                                <span class="text-[#a5b0a8]">·</span>
                                <span>Perempuan: <strong class="text-[#963d21]"><?php echo e($c['smp']['perempuan']); ?></strong></span>
                            </div>
                        </div>

                        
                        <div class="rounded-lg border border-[#d6dccf] bg-[#f7f9f4] px-2.5 py-1.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] font-bold text-[#4b5347]">SMA</span>
                                <span class="text-[11px] font-bold text-[#0d4a36]"><?php echo e($c['sma']['total']); ?> orang</span>
                            </div>
                            <div class="mt-0.5 flex flex-wrap items-center gap-x-2 text-[10px] text-[#617064]">
                                <span>Laki-laki: <strong class="text-[#4b5347]"><?php echo e($c['sma']['laki']); ?></strong></span>
                                <span class="text-[#a5b0a8]">·</span>
                                <span>Perempuan: <strong class="text-[#963d21]"><?php echo e($c['sma']['perempuan']); ?></strong></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<form method="GET" action="<?php echo e(route('admin.pendaftaran.index')); ?>"
      class="rounded-2xl border border-[#e1e9da] bg-white p-4 sm:p-5 shadow-sm mb-5">
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
        <div class="sm:col-span-2">
            <label for="q" class="mb-1.5 block text-xs font-bold text-[#244535]">Cari</label>
            <input type="search" name="q" id="q" value="<?php echo e(request('q')); ?>"
                   placeholder="Nama, nomor, NISN, atau WA..."
                   class="field-control">
        </div>
        <div>
            <label for="jenjang_id" class="mb-1.5 block text-xs font-bold text-[#244535]">Jenjang</label>
            <select name="jenjang_id" id="jenjang_id" class="field-control">
                <option value="">Semua</option>
                <?php $__currentLoopData = $jenjangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($j->id); ?>" <?php if(request('jenjang_id') == $j->id): echo 'selected'; endif; ?>><?php echo e($j->nama); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label for="status_verifikasi" class="mb-1.5 block text-xs font-bold text-[#244535]">Verifikasi</label>
            <select name="status_verifikasi" id="status_verifikasi" class="field-control">
                <option value="">Semua</option>
                <?php $__currentLoopData = ['Menunggu Verifikasi', 'Terverifikasi', 'Perlu Perbaikan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php if(request('status_verifikasi') === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label for="status_kelulusan" class="mb-1.5 block text-xs font-bold text-[#244535]">Kelulusan</label>
            <select name="status_kelulusan" id="status_kelulusan" class="field-control">
                <option value="">Semua</option>
                <?php $__currentLoopData = ['Menunggu Hasil', 'Lulus', 'Tidak Lulus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php if(request('status_kelulusan') === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    <div class="mt-4 flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-2 sm:gap-3">
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] w-full sm:w-auto">
            <i data-lucide="search" class="h-4 w-4"></i>
            Terapkan Filter
        </button>

        <?php if(request()->hasAny(['q', 'jenjang_id', 'status_verifikasi', 'status_kelulusan'])): ?>
            <a href="<?php echo e(route('admin.pendaftaran.index')); ?>"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee] w-full sm:w-auto">
                <i data-lucide="x" class="h-4 w-4"></i>
                Reset
            </a>
        <?php endif; ?>

        <a href="<?php echo e(route('admin.pendaftaran.export', request()->query())); ?>"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#0d4a36] px-4 py-2 text-sm font-bold text-[#0d4a36] hover:bg-[#f4f8ee] w-full sm:w-auto sm:ml-auto">
            <i data-lucide="download" class="h-4 w-4"></i>
            Export CSV
        </a>
    </div>
</form>




<?php $__empty_1 = true; $__currentLoopData = $paginated; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenjangId => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                <h3 class="display-font text-base font-bold text-[#0d4a36]"><?php echo e($j->nama); ?></h3>
                <span class="inline-flex items-center rounded-full <?php echo e($chipColor); ?> px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide">
                    <?php echo e($items->total()); ?> pendaftar
                </span>
            </div>
        </div>

        
        <div class="overflow-x-auto">
            <table class="admin-table" style="min-width: 1300px;">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Tanggal</th>
                        <th class="whitespace-nowrap">Nomor</th>
                        <th class="whitespace-nowrap">Nama</th>
                        <th class="whitespace-nowrap">NISN</th>
                        <th class="whitespace-nowrap">Pembayaran</th>
                        <th class="whitespace-nowrap">Verifikasi SPMB</th>
                        <th class="whitespace-nowrap">Ujian</th>
                        <th class="whitespace-nowrap">Kelulusan</th>
                        <th class="whitespace-nowrap">Daftar Ulang</th>
                        <th class="whitespace-nowrap text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_2 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <?php
                            $statusPembayaran = $p->pembayaran?->status ?? 'Belum Bayar';

                            $bisaVerifikasi = $statusPembayaran === 'Terverifikasi';
                            $bisaUjian = $p->status_verifikasi === 'Terverifikasi';
                            $bisaLulus = $p->status_ujian === 'Sudah Ujian';
                            $bisaDaftarUlang = $p->status_kelulusan === 'Lulus';

                            $commonData = [
                                'id' => $p->id,
                                'nomor' => $p->nomor_pendaftaran,
                                'nama' => $p->nama_lengkap,
                                'status-pembayaran' => $statusPembayaran,
                                'verifikasi' => $p->status_verifikasi,
                                'catatan' => $p->catatan_verifikasi ?? '',
                                'ujian' => $p->status_ujian,
                                'tanggal-ujian' => $p->tanggal_ujian?->format('Y-m-d') ?? '',
                                'nilai' => $p->nilai_ujian ?? '',
                                'kelulusan' => $p->status_kelulusan,
                                'daftar-ulang' => $p->status_daftar_ulang,
                                'tanggal-daftar-ulang' => $p->tanggal_daftar_ulang?->format('Y-m-d') ?? '',
                                'link-daftar-ulang' => $p->link_daftar_ulang ?? '',
                                'bisa-verifikasi' => $bisaVerifikasi ? '1' : '0',
                                'bisa-ujian' => $bisaUjian ? '1' : '0',
                                'bisa-lulus' => $bisaLulus ? '1' : '0',
                                'bisa-daftar-ulang' => $bisaDaftarUlang ? '1' : '0',
                            ];
                        ?>
                        <tr data-pendaftaran-id="<?php echo e($p->id); ?>">
                            <td class="whitespace-nowrap align-middle">
                                <?php if($p->created_at): ?>
                                    <p class="text-xs font-semibold text-[#244535] leading-tight">
                                        <?php echo e($p->created_at->isoFormat('dddd')); ?>

                                    </p>
                                    <p class="text-[10px] text-[#617064] leading-tight">
                                        <?php echo e($p->created_at->isoFormat('D MMMM Y')); ?>

                                    </p>
                                <?php else: ?>
                                    <span class="text-xs text-[#617064]">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="font-mono font-bold text-[#0d4a36] whitespace-nowrap align-middle">
                                <?php echo e($p->nomor_pendaftaran); ?>

                            </td>

                            <td class="whitespace-nowrap align-middle">
                                <p class="font-semibold text-[#0d4a36]"><?php echo e($p->nama_lengkap); ?></p>
                                <p class="text-xs text-[#617064]"><?php echo e($p->jenis_kelamin); ?></p>
                            </td>
                            <td class="font-mono whitespace-nowrap align-middle"><?php echo e($p->nisn); ?></td>

                            
                            <td class="whitespace-nowrap align-middle" data-cell="pembayaran">
                                <a href="<?php echo e(route('admin.pembayaran.show', $p)); ?>"
                                   class="inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                                          <?php echo e($statusPembayaran === 'Terverifikasi'
                                                  ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                                                  : ($statusPembayaran === 'Gagal'
                                                      ? 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
                                                      : ($statusPembayaran === 'Menunggu Verifikasi'
                                                          ? 'bg-[#fff2ca] border-[#f0e0a8] text-[#805500]'
                                                          : 'bg-[#edf1ec] border-[#d6dccf] text-[#617064]'))); ?>"
                                   title="Lihat detail pembayaran">
                                    <i data-lucide="wallet" class="h-3.5 w-3.5"></i>
                                    <?php echo e($statusPembayaran); ?>

                                </a>
                            </td>

                            
                            <td data-cell="verifikasi" class="whitespace-nowrap align-middle">
                                <?php if($bisaVerifikasi): ?>
                                    <button type="button"
                                            class="btn-quick-action inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all
                                                   <?php echo e($p->status_verifikasi === 'Terverifikasi'
                                                           ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                                                           : ($p->status_verifikasi === 'Perlu Perbaikan'
                                                               ? 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
                                                               : 'bg-[#fff2ca] border-[#f0e0a8] text-[#805500]')); ?>"
                                            title="Klik untuk verifikasi"
                                            data-quick-tab-target="verifikasi"
                                            <?php $__currentLoopData = $commonData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> data-<?php echo e($key); ?>="<?php echo e($val); ?>" <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>
                                        <i data-lucide="file-check" class="h-3.5 w-3.5"></i>
                                        <?php echo e($p->status_verifikasi); ?>

                                    </button>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#edf1ec] border-2 border-[#d6dccf] px-3 py-1.5 text-xs font-bold text-[#617064] cursor-not-allowed"
                                          title="Pembayaran belum terverifikasi">
                                        <i data-lucide="lock" class="h-3.5 w-3.5"></i>
                                        <?php echo e($p->status_verifikasi); ?>

                                    </span>
                                <?php endif; ?>
                            </td>

                            
                            <td data-cell="ujian" class="whitespace-nowrap align-middle">
                                <?php if($bisaUjian): ?>
                                    <button type="button"
                                            class="btn-quick-action inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all
                                                   <?php echo e($p->status_ujian === 'Sudah Ujian'
                                                           ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                                                           : ($p->status_ujian === 'Terjadwal'
                                                               ? 'bg-[#e0f2fe] border-[#bae6fd] text-[#0369a1]'
                                                               : 'bg-[#fff2ca] border-[#f0e0a8] text-[#805500]')); ?>"
                                            title="Klik untuk atur ujian"
                                            data-quick-tab-target="ujian"
                                            <?php $__currentLoopData = $commonData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> data-<?php echo e($key); ?>="<?php echo e($val); ?>" <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>
                                        <i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i>
                                        <?php if($p->nilai_ujian): ?>
                                            Nilai <?php echo e($p->nilai_ujian); ?>

                                        <?php else: ?>
                                            <?php echo e($p->status_ujian); ?>

                                        <?php endif; ?>
                                    </button>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#edf1ec] border-2 border-[#d6dccf] px-3 py-1.5 text-xs font-bold text-[#617064] cursor-not-allowed"
                                          title="Verifikasi berkas dulu">
                                        <i data-lucide="lock" class="h-3.5 w-3.5"></i>
                                        <?php echo e($p->status_ujian); ?>

                                    </span>
                                <?php endif; ?>
                            </td>

                            
                            <td data-cell="kelulusan" class="whitespace-nowrap align-middle">
                                <?php if($bisaLulus): ?>
                                    <button type="button"
                                            class="btn-quick-action inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all
                                                   <?php echo e($p->status_kelulusan === 'Lulus'
                                                           ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                                                           : ($p->status_kelulusan === 'Tidak Lulus'
                                                               ? 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
                                                               : 'bg-[#fff2ca] border-[#f0e0a8] text-[#805500]')); ?>"
                                            title="Klik untuk atur kelulusan"
                                            data-quick-tab-target="kelulusan"
                                            <?php $__currentLoopData = $commonData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> data-<?php echo e($key); ?>="<?php echo e($val); ?>" <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>
                                        <i data-lucide="award" class="h-3.5 w-3.5"></i>
                                        <?php echo e($p->status_kelulusan); ?>

                                    </button>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#edf1ec] border-2 border-[#d6dccf] px-3 py-1.5 text-xs font-bold text-[#617064] cursor-not-allowed"
                                          title="Ujian belum selesai">
                                        <i data-lucide="lock" class="h-3.5 w-3.5"></i>
                                        <?php echo e($p->status_kelulusan); ?>

                                    </span>
                                <?php endif; ?>
                            </td>

                            
                            <td data-cell="daftar-ulang" class="whitespace-nowrap align-middle">
                                <?php if($bisaDaftarUlang): ?>
                                    <button type="button"
                                            class="btn-quick-action inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all
                                                   <?php echo e($p->status_daftar_ulang === 'Sudah Daftar Ulang'
                                                           ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                                                           : ($p->status_daftar_ulang === 'Belum Daftar Ulang'
                                                               ? 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
                                                               : 'bg-[#edf1ec] border-[#d6dccf] text-[#617064]')); ?>"
                                            title="Klik untuk atur daftar ulang"
                                            data-quick-tab-target="daftar-ulang"
                                            <?php $__currentLoopData = $commonData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> data-<?php echo e($key); ?>="<?php echo e($val); ?>" <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>
                                        <i data-lucide="user-check" class="h-3.5 w-3.5"></i>
                                        <?php echo e($p->status_daftar_ulang); ?>

                                    </button>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#edf1ec] border-2 border-[#d6dccf] px-3 py-1.5 text-xs font-bold text-[#617064] cursor-not-allowed"
                                          title="Pendaftar belum lulus">
                                        <i data-lucide="lock" class="h-3.5 w-3.5"></i>
                                        <?php echo e($p->status_daftar_ulang); ?>

                                    </span>
                                <?php endif; ?>
                            </td>

                            
                            <td class="whitespace-nowrap align-middle">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="<?php echo e(route('admin.pendaftaran.show', $p)); ?>"
                                       class="inline-flex items-center gap-1 rounded-lg bg-[#0d4a36] border-2 border-[#0d4a36] px-3 py-1.5 text-xs font-bold text-white shadow-md hover:bg-[#176346] hover:border-[#176346] hover:shadow-lg hover:-translate-y-0.5 transition-all"
                                       title="Detail">
                                        Detail
                                    </a>

                                    <a href="<?php echo e(route('admin.pendaftaran.edit', $p)); ?>"
                                       class="inline-flex items-center justify-center rounded-lg border border-[#d6dccf] p-1.5 text-[#0d4a36] hover:bg-[#f4f8ee]"
                                       title="Edit">
                                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                    </a>

                                    <?php if(auth()->user()->isSuperAdmin()): ?>
                                        <button type="button"
                                                class="btn-delete inline-flex items-center justify-center rounded-lg border border-[#f2c1ae] bg-[#fff0ea] p-1.5 text-[#963d21] hover:bg-[#ffe0d1]"
                                                title="Hapus"
                                                data-id="<?php echo e($p->id); ?>"
                                                data-nomor="<?php echo e($p->nomor_pendaftaran); ?>"
                                                data-nama="<?php echo e($p->nama_lengkap); ?>">
                                            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <tr>
                            <td colspan="10" class="px-4 py-6 text-center text-sm text-[#617064]">
                                Tidak ada pendaftar <?php echo e($j->nama); ?> pada halaman ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if($items->hasPages()): ?>
            <div class="px-5 py-3 border-t <?php echo e($borderCard); ?> bg-[#fafcf8]">
                <?php echo e($items->links()); ?>

            </div>
        <?php endif; ?>

        
        <div class="px-5 py-2 text-[10px] text-[#617064] border-t <?php echo e($borderCard); ?>">
            Menampilkan <?php echo e($items->firstItem() ?? 0); ?>–<?php echo e($items->lastItem() ?? 0); ?>

            dari <?php echo e($items->total()); ?> pendaftar <?php echo e($j->nama); ?>

        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="rounded-2xl border border-dashed border-[#d6dccf] bg-white p-8 text-center">
        <i data-lucide="inbox" class="mx-auto h-10 w-10 text-[#d6dccf] mb-2"></i>
        <p class="text-sm text-[#617064]">Belum ada data pendaftar.</p>
    </div>
<?php endif; ?>


<p class="mt-3 text-[10px] text-[#617064]">
    <i data-lucide="info" class="inline h-3 w-3"></i>
    Klik tombol berwarna di kolom status untuk mengubah data. Tombol <strong>abu-abu</strong> berarti masih terkunci (menunggu tahap sebelumnya).
</p>




<div id="toast" class="fixed bottom-5 right-5 z-[100] hidden max-w-sm rounded-xl bg-white border border-[#e1e9da] shadow-2xl px-5 py-4">
    <div class="flex items-start gap-3">
        <div id="toast-icon" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full">
            <i data-lucide="check" class="h-4 w-4 text-white"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p id="toast-message" class="text-sm font-semibold text-[#244535]"></p>
        </div>
        <button type="button" onclick="document.getElementById('toast').classList.add('hidden')" class="p-1 hover:bg-[#f4f8ee] rounded">
            <i data-lucide="x" class="h-4 w-4 text-[#617064]"></i>
        </button>
    </div>
</div>




<div id="quick-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-4">
    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl overflow-hidden max-h-[92vh] flex flex-col">

        <div class="bg-[#0d4a36] px-5 py-4 text-white flex items-center justify-between shrink-0">
            <div class="min-w-0">
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#e9d28b]">Aksi Cepat</p>
                <p id="quick-title" class="text-sm font-bold mt-0.5 truncate"></p>
            </div>
            <button type="button" data-close-quick class="p-1.5 rounded-lg hover:bg-white/10 shrink-0">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="bg-[#f8faf5] border-b border-[#e1e9da] px-3 pt-3 flex gap-1 overflow-x-auto shrink-0">
            <button type="button" data-quick-tab="verifikasi" class="quick-tab-btn" id="tab-verifikasi">
                <i data-lucide="file-check" class="h-3.5 w-3.5"></i> Verifikasi
            </button>
            <button type="button" data-quick-tab="ujian" class="quick-tab-btn" id="tab-ujian">
                <i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i> Ujian
            </button>
            <button type="button" data-quick-tab="kelulusan" class="quick-tab-btn" id="tab-kelulusan">
                <i data-lucide="award" class="h-3.5 w-3.5"></i> Kelulusan
            </button>
            <button type="button" data-quick-tab="daftar-ulang" class="quick-tab-btn" id="tab-daftar-ulang">
                <i data-lucide="user-check" class="h-3.5 w-3.5"></i> Daftar Ulang
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-5">

            
            <div data-quick-content="verifikasi" class="quick-tab-content hidden">
                <div id="quick-verifikasi-warning" class="hidden mb-4 rounded-lg bg-[#fff0ea] border border-[#f2c1ae] p-3 text-xs text-[#963d21]">
                    <i data-lucide="info" class="inline h-3.5 w-3.5"></i>
                    Pembayaran harus <strong>Terverifikasi</strong> terlebih dahulu. Status saat ini:
                    <strong id="quick-verifikasi-pembayaran">—</strong>
                </div>
                <form id="quick-form-verifikasi" class="space-y-4 ajax-form">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Verifikasi</label>
                        <select name="status_verifikasi" id="quick-verifikasi" class="field-control">
                            <?php $__currentLoopData = ['Menunggu Verifikasi', 'Terverifikasi', 'Perlu Perbaikan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>"><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Catatan (opsional)</label>
                        <textarea name="catatan_verifikasi" id="quick-catatan" rows="3" class="field-control" placeholder="Contoh: Berkas kurang lengkap..."></textarea>
                    </div>
                    <button type="submit" class="btn-save w-full rounded-lg bg-[#0d4a36] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-wait">
                        Simpan Verifikasi
                    </button>
                </form>
            </div>

            
            <div data-quick-content="ujian" class="quick-tab-content hidden">
                <form id="quick-form-ujian" class="space-y-4 ajax-form">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Ujian</label>
                        <select name="status_ujian" id="quick-ujian" class="field-control">
                            <?php $__currentLoopData = ['Belum Dijadwalkan', 'Terjadwal', 'Sudah Ujian']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>"><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Ujian</label>
                            <input type="date" name="tanggal_ujian" id="quick-tanggal-ujian" class="field-control">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nilai Ujian</label>
                            <input type="text" name="nilai_ujian" id="quick-nilai" placeholder="85" class="field-control">
                        </div>
                    </div>
                    <button type="submit" class="btn-save w-full rounded-lg bg-[#0d4a36] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-wait">
                        Simpan Ujian
                    </button>
                </form>
            </div>

            
            <div data-quick-content="kelulusan" class="quick-tab-content hidden">
                <form id="quick-form-kelulusan" class="space-y-4 ajax-form">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Kelulusan</label>
                        <select name="status_kelulusan" id="quick-kelulusan" class="field-control">
                            <?php $__currentLoopData = ['Menunggu Hasil', 'Lulus', 'Tidak Lulus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>"><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-save w-full rounded-lg bg-[#0d4a36] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-wait">
                        Simpan Kelulusan
                    </button>
                </form>
            </div>

            
            <div data-quick-content="daftar-ulang" class="quick-tab-content hidden">
                <form id="quick-form-daftar-ulang" class="space-y-4 ajax-form">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Daftar Ulang</label>
                        <select name="status_daftar_ulang" id="quick-daftar-ulang" class="field-control">
                            <?php $__currentLoopData = ['Belum Dibuka', 'Belum Daftar Ulang', 'Sudah Daftar Ulang']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>"><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Link Form Daftar Ulang (opsional)</label>
                        <input type="url" name="link_daftar_ulang" id="quick-link-daftar-ulang" placeholder="https://forms.gle/..." class="field-control">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Daftar Ulang (opsional)</label>
                        <input type="date" name="tanggal_daftar_ulang" id="quick-tanggal-daftar-ulang" class="field-control">
                    </div>
                    <button type="submit" class="btn-save w-full rounded-lg bg-[#0d4a36] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-wait">
                        Simpan Daftar Ulang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>




<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">
        <div class="bg-[#fff0ea] px-6 py-5 text-center border-b border-[#f2c1ae]">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#963d21] mb-3">
                <i data-lucide="alert-triangle" class="h-7 w-7 text-white"></i>
            </div>
            <h3 class="display-font text-xl font-bold text-[#963d21]">Hapus Pendaftar?</h3>
            <p class="text-sm text-[#617064] mt-1">Tindakan ini tidak bisa dibatalkan.</p>
        </div>
        <div class="px-6 py-5">
            <div class="rounded-xl bg-[#f8faf5] border border-[#e1e9da] p-4 space-y-2 text-sm">
                <div class="flex justify-between gap-3">
                    <span class="text-[#617064]">Nomor</span>
                    <span id="del-nomor" class="font-mono font-bold text-[#0d4a36] text-right"></span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-[#617064]">Nama</span>
                    <span id="del-nama" class="font-semibold text-[#0d4a36] text-right"></span>
                </div>
            </div>
            <form id="delete-form" method="POST" class="mt-5 flex flex-wrap gap-2 justify-end">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="button" data-close-delete
                        class="rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                    Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#963d21] px-4 py-2 text-sm font-bold text-white hover:bg-[#7a2f19]">
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>';

    const ROUTES = {
        verifikasi: '<?php echo e(route("admin.pendaftaran.verifikasi", ":id")); ?>',
        ujian: '<?php echo e(route("admin.pendaftaran.ujian", ":id")); ?>',
        kelulusan: '<?php echo e(route("admin.pendaftaran.kelulusan", ":id")); ?>',
        daftarUlang: '<?php echo e(route("admin.pendaftaran.daftar-ulang", ":id")); ?>',
        destroy: '<?php echo e(route("admin.pendaftaran.destroy", ":id")); ?>',
    };

    const toast = document.getElementById('toast');
    const toastIcon = document.getElementById('toast-icon');
    const toastMessage = document.getElementById('toast-message');
    let toastTimeout;

    function showToast(message, type = 'success') {
        clearTimeout(toastTimeout);
        toastIcon.className = 'flex h-8 w-8 shrink-0 items-center justify-center rounded-full ' +
            (type === 'success' ? 'bg-[#5d9f3f]' : 'bg-[#963d21]');
        toastIcon.innerHTML = type === 'success'
            ? '<i data-lucide="check" class="h-4 w-4 text-white"></i>'
            : '<i data-lucide="x" class="h-4 w-4 text-white"></i>';
        toastMessage.textContent = message;
        toast.classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
        toastTimeout = setTimeout(() => toast.classList.add('hidden'), 3500);
    }

    function updateRow(id, data) {
        const row = document.querySelector(`tr[data-pendaftaran-id="${id}"]`);
        if (!row) return;

        if (data.status_pembayaran !== undefined) {
            const cell = row.querySelector('[data-cell="pembayaran"]');
            if (cell) {
                const a = cell.querySelector('a');
                if (a) {
                    const cls = data.status_pembayaran === 'Terverifikasi' ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                              : data.status_pembayaran === 'Gagal' ? 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
                              : data.status_pembayaran === 'Menunggu Verifikasi' ? 'bg-[#fff2ca] border-[#f0e0a8] text-[#805500]'
                              : 'bg-[#edf1ec] border-[#d6dccf] text-[#617064]';
                    a.className = 'inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all ' + cls;
                    a.innerHTML = `<i data-lucide="wallet" class="h-3.5 w-3.5"></i> ${data.status_pembayaran}`;
                }
            }
        }

        if (data.status_verifikasi !== undefined) {
            const cell = row.querySelector('[data-cell="verifikasi"]');
            if (cell) {
                const btn = cell.querySelector('.btn-quick-action');
                if (btn) {
                    const cls = data.status_verifikasi === 'Terverifikasi' ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                              : data.status_verifikasi === 'Perlu Perbaikan' ? 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
                              : 'bg-[#fff2ca] border-[#f0e0a8] text-[#805500]';
                    btn.className = 'btn-quick-action inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all ' + cls;
                    btn.innerHTML = `<i data-lucide="file-check" class="h-3.5 w-3.5"></i> ${data.status_verifikasi}`;
                }
            }
        }

        if (data.status_ujian !== undefined) {
            const cell = row.querySelector('[data-cell="ujian"]');
            if (cell) {
                const btn = cell.querySelector('.btn-quick-action');
                if (btn) {
                    const label = data.nilai_ujian ? `Nilai ${data.nilai_ujian}` : data.status_ujian;
                    const cls = data.status_ujian === 'Sudah Ujian' ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                              : data.status_ujian === 'Terjadwal' ? 'bg-[#e0f2fe] border-[#bae6fd] text-[#0369a1]'
                              : 'bg-[#fff2ca] border-[#f0e0a8] text-[#805500]';
                    btn.className = 'btn-quick-action inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all ' + cls;
                    btn.innerHTML = `<i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i> ${label}`;
                }
            }
        }

        if (data.status_kelulusan !== undefined) {
            const cell = row.querySelector('[data-cell="kelulusan"]');
            if (cell) {
                const btn = cell.querySelector('.btn-quick-action');
                if (btn) {
                    const cls = data.status_kelulusan === 'Lulus' ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                              : data.status_kelulusan === 'Tidak Lulus' ? 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
                              : 'bg-[#fff2ca] border-[#f0e0a8] text-[#805500]';
                    btn.className = 'btn-quick-action inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all ' + cls;
                    btn.innerHTML = `<i data-lucide="award" class="h-3.5 w-3.5"></i> ${data.status_kelulusan}`;
                }
            }
        }

        if (data.status_daftar_ulang !== undefined) {
            const cell = row.querySelector('[data-cell="daftar-ulang"]');
            if (cell) {
                const btn = cell.querySelector('.btn-quick-action');
                if (btn) {
                    const cls = data.status_daftar_ulang === 'Sudah Daftar Ulang' ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
                              : data.status_daftar_ulang === 'Belum Daftar Ulang' ? 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
                              : 'bg-[#edf1ec] border-[#d6dccf] text-[#617064]';
                    btn.className = 'btn-quick-action inline-flex items-center gap-1.5 rounded-lg border-2 px-3 py-1.5 text-xs font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all ' + cls;
                    btn.innerHTML = `<i data-lucide="user-check" class="h-3.5 w-3.5"></i> ${data.status_daftar_ulang}`;
                }
            }
        }

        if (window.lucide) lucide.createIcons();

        // Update dataset tombol quick-action
        const anyBtn = row.querySelector('.btn-quick-action');
        if (anyBtn) {
            if (data.status_pembayaran !== undefined) {
                anyBtn.dataset.statusPembayaran = data.status_pembayaran;
                anyBtn.dataset.bisaVerifikasi = data.status_pembayaran === 'Terverifikasi' ? '1' : '0';
            }
            if (data.status_verifikasi !== undefined) {
                anyBtn.dataset.verifikasi = data.status_verifikasi;
                anyBtn.dataset.bisaUjian = data.status_verifikasi === 'Terverifikasi' ? '1' : '0';
            }
            if (data.status_ujian !== undefined) {
                anyBtn.dataset.ujian = data.status_ujian;
                anyBtn.dataset.bisaLulus = data.status_ujian === 'Sudah Ujian' ? '1' : '0';
            }
            if (data.status_kelulusan !== undefined) {
                anyBtn.dataset.kelulusan = data.status_kelulusan;
                anyBtn.dataset.bisaDaftarUlang = data.status_kelulusan === 'Lulus' ? '1' : '0';
            }
            if (data.status_daftar_ulang !== undefined) {
                anyBtn.dataset.daftarUlang = data.status_daftar_ulang;
            }
            if (data.nilai_ujian !== undefined) {
                anyBtn.dataset.nilai = data.nilai_ujian || '';
            }
        }
    }

    function updateTabStates(data) {
        const tabVerifikasi = document.getElementById('tab-verifikasi');
        const tabUjian = document.getElementById('tab-ujian');
        const tabKelulusan = document.getElementById('tab-kelulusan');
        const tabDaftarUlang = document.getElementById('tab-daftar-ulang');

        if (data.status_pembayaran !== undefined) {
            tabVerifikasi.disabled = data.status_pembayaran !== 'Terverifikasi';
            tabVerifikasi.title = tabVerifikasi.disabled
                ? 'Pembayaran harus Terverifikasi dulu (status: ' + data.status_pembayaran + ')'
                : '';

            const warning = document.getElementById('quick-verifikasi-warning');
            const warningText = document.getElementById('quick-verifikasi-pembayaran');
            if (warning && warningText) {
                if (data.status_pembayaran !== 'Terverifikasi') {
                    warningText.textContent = data.status_pembayaran;
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            }
        }
        if (data.status_verifikasi !== undefined) {
            tabUjian.disabled = data.status_verifikasi !== 'Terverifikasi';
            tabUjian.title = tabUjian.disabled ? 'Verifikasi harus Terverifikasi dulu' : '';
        }
        if (data.status_ujian !== undefined) {
            tabKelulusan.disabled = data.status_ujian !== 'Sudah Ujian';
            tabKelulusan.title = tabKelulusan.disabled ? 'Ujian harus Sudah Ujian dulu' : '';
        }
        if (data.status_kelulusan !== undefined) {
            tabDaftarUlang.disabled = data.status_kelulusan !== 'Lulus';
            tabDaftarUlang.title = tabDaftarUlang.disabled ? 'Kelulusan harus Lulus dulu' : '';
        }
    }

    const deleteModal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');
    const delNomor = document.getElementById('del-nomor');
    const delNama = document.getElementById('del-nama');

    function openDeleteModal(id, nomor, nama) {
        deleteForm.action = ROUTES.destroy.replace(':id', id);
        delNomor.textContent = nomor;
        delNama.textContent = nama;
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        if (window.lucide) lucide.createIcons();
    }
    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    const quickModal = document.getElementById('quick-modal');
    const quickTitle = document.getElementById('quick-title');
    const quickTabBtns = document.querySelectorAll('[data-quick-tab]');
    const quickTabContents = document.querySelectorAll('[data-quick-content]');
    let currentPendaftaranId = null;

    function activateQuickTab(tabKey) {
        quickTabBtns.forEach(b => b.classList.toggle('active', b.dataset.quickTab === tabKey));
        quickTabContents.forEach(c => c.classList.toggle('hidden', c.dataset.quickContent !== tabKey));
        if (window.lucide) lucide.createIcons();
    }

    function openQuickModal(data) {
        currentPendaftaranId = data.id;

        document.getElementById('quick-form-verifikasi').action = ROUTES.verifikasi.replace(':id', data.id);
        document.getElementById('quick-form-ujian').action = ROUTES.ujian.replace(':id', data.id);
        document.getElementById('quick-form-kelulusan').action = ROUTES.kelulusan.replace(':id', data.id);
        document.getElementById('quick-form-daftar-ulang').action = ROUTES.daftarUlang.replace(':id', data.id);

        quickTitle.textContent = data.nama + ' — ' + data.nomor;
        document.getElementById('quick-verifikasi').value = data.verifikasi;
        document.getElementById('quick-catatan').value = data.catatan || '';
        document.getElementById('quick-ujian').value = data.ujian;
        document.getElementById('quick-tanggal-ujian').value = data.tanggalUjian || '';
        document.getElementById('quick-nilai').value = data.nilai || '';
        document.getElementById('quick-kelulusan').value = data.kelulusan;
        document.getElementById('quick-daftar-ulang').value = data.daftarUlang;
        document.getElementById('quick-tanggal-daftar-ulang').value = data.tanggalDaftarUlang || '';
        document.getElementById('quick-link-daftar-ulang').value = data.linkDaftarUlang || '';

        const warning = document.getElementById('quick-verifikasi-warning');
        const warningText = document.getElementById('quick-verifikasi-pembayaran');
        if (warning && warningText) {
            if (data.statusPembayaran && data.statusPembayaran !== 'Terverifikasi') {
                warningText.textContent = data.statusPembayaran;
                warning.classList.remove('hidden');
            } else {
                warning.classList.add('hidden');
            }
        }

        const tabVerifikasi = document.getElementById('tab-verifikasi');
        const tabUjian = document.getElementById('tab-ujian');
        const tabKelulusan = document.getElementById('tab-kelulusan');
        const tabDaftarUlang = document.getElementById('tab-daftar-ulang');

        tabVerifikasi.disabled = data.bisaVerifikasi !== '1';
        tabUjian.disabled = data.bisaUjian !== '1';
        tabKelulusan.disabled = data.bisaLulus !== '1';
        tabDaftarUlang.disabled = data.bisaDaftarUlang !== '1';

        tabVerifikasi.title = data.bisaVerifikasi === '1' ? '' : 'Pembayaran harus Terverifikasi dulu';
        tabUjian.title = data.bisaUjian === '1' ? '' : 'Verifikasi harus Terverifikasi dulu';
        tabKelulusan.title = data.bisaLulus === '1' ? '' : 'Ujian harus Sudah Ujian dulu';
        tabDaftarUlang.title = data.bisaDaftarUlang === '1' ? '' : 'Kelulusan harus Lulus dulu';

        quickModal.classList.remove('hidden');
        quickModal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        if (data.targetTab && !document.getElementById('tab-' + data.targetTab).disabled) {
            activateQuickTab(data.targetTab);
        } else if (data.bisaVerifikasi === '1') activateQuickTab('verifikasi');
        else if (data.bisaUjian === '1') activateQuickTab('ujian');
        else if (data.bisaLulus === '1') activateQuickTab('kelulusan');
        else if (data.bisaDaftarUlang === '1') activateQuickTab('daftar-ulang');
        else activateQuickTab('verifikasi');

        if (window.lucide) lucide.createIcons();
    }

    function closeQuickModal() {
        quickModal.classList.add('hidden');
        quickModal.classList.remove('flex');
        document.body.style.overflow = '';
        currentPendaftaranId = null;
    }

    document.querySelectorAll('.ajax-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = form.querySelector('.btn-save');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';

            try {
                const formData = new FormData(form);

                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await res.json();

                if (data.success) {
                    updateRow(currentPendaftaranId, data.data);
                    updateTabStates(data.data);
                    showToast(data.message || 'Berhasil disimpan', 'success');
                } else {
                    showToast(data.message || 'Gagal menyimpan', 'error');
                }
            } catch (err) {
                console.error(err);
                showToast('Terjadi kesalahan. Coba lagi.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    });

    document.addEventListener('click', function (e) {
        const delBtn = e.target.closest('.btn-delete');
        if (delBtn) {
            openDeleteModal(delBtn.dataset.id, delBtn.dataset.nomor, delBtn.dataset.nama);
            return;
        }
        if (e.target.closest('[data-close-delete]')) { closeDeleteModal(); return; }
        if (e.target.id === 'delete-modal') { closeDeleteModal(); return; }

        const quickBtn = e.target.closest('.btn-quick-action');
        if (quickBtn) {
            openQuickModal({
                id: quickBtn.dataset.id,
                nomor: quickBtn.dataset.nomor,
                nama: quickBtn.dataset.nama,
                statusPembayaran: quickBtn.dataset.statusPembayaran,
                verifikasi: quickBtn.dataset.verifikasi,
                catatan: quickBtn.dataset.catatan,
                ujian: quickBtn.dataset.ujian,
                tanggalUjian: quickBtn.dataset.tanggalUjian,
                nilai: quickBtn.dataset.nilai,
                kelulusan: quickBtn.dataset.kelulusan,
                daftarUlang: quickBtn.dataset.daftarUlang,
                tanggalDaftarUlang: quickBtn.dataset.tanggalDaftarUlang,
                linkDaftarUlang: quickBtn.dataset.linkDaftarUlang,
                bisaVerifikasi: quickBtn.dataset.bisaVerifikasi,
                bisaUjian: quickBtn.dataset.bisaUjian,
                bisaLulus: quickBtn.dataset.bisaLulus,
                bisaDaftarUlang: quickBtn.dataset.bisaDaftarUlang,
                targetTab: quickBtn.dataset.quickTabTarget,
            });
            return;
        }

        const tabBtn = e.target.closest('[data-quick-tab]');
        if (tabBtn && !tabBtn.disabled) {
            activateQuickTab(tabBtn.dataset.quickTab);
            return;
        }

        if (e.target.closest('[data-close-quick]')) { closeQuickModal(); return; }
        if (e.target.id === 'quick-modal') { closeQuickModal(); }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (!deleteModal.classList.contains('hidden')) closeDeleteModal();
            if (!quickModal.classList.contains('hidden')) closeQuickModal();
        }
    });
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/pendaftaran/index.blade.php ENDPATH**/ ?>