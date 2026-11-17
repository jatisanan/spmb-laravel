

<?php $__env->startSection('title', 'Pembayaran'); ?>

<?php $__env->startSection('content'); ?>




<div class="mb-5">
    <a href="<?php echo e(route('student.dashboard')); ?>"
       class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Dashboard
    </a>
    <h1 class="display-font mt-3 text-2xl sm:text-3xl font-bold text-[#0d4a36]">Pembayaran Biaya Pendaftaran</h1>
    <p class="text-sm text-[#617064] mt-1"><?php echo e($pendaftaran->nomor_pendaftaran); ?></p>
</div>




<?php if(session('success')): ?>
    <div class="mb-5 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-sm text-green-800 flex items-start gap-2">
        <i data-lucide="check-circle" class="inline h-4 w-4 mt-0.5 shrink-0"></i>
        <span><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="mb-5 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-sm text-red-800 flex items-start gap-2">
        <i data-lucide="alert-circle" class="inline h-4 w-4 mt-0.5 shrink-0"></i>
        <span><?php echo e(session('error')); ?></span>
    </div>
<?php endif; ?>

<?php
    // ============================================
    // KONFIGURASI WARNA STATUS
    // ============================================
    $statusConfig = match($pembayaran->status) {
        'Terverifikasi' => [
            'chip'        => 'bg-green-100 text-green-800 border border-green-300',
            'card_bg'     => 'bg-green-100',
            'card_border' => 'border-green-400',
            'eyebrow'     => 'text-green-700',
            'title'       => 'text-green-900',
            'text'        => 'text-green-800',
        ],
        'Menunggu Verifikasi' => [
            'chip'        => 'bg-amber-100 text-amber-800 border border-amber-300',
            'card_bg'     => 'bg-amber-100',
            'card_border' => 'border-amber-400',
            'eyebrow'     => 'text-amber-700',
            'title'       => 'text-amber-900',
            'text'        => 'text-amber-800',
        ],
        'Gagal' => [
            'chip'        => 'bg-red-100 text-red-800 border border-red-300',
            'card_bg'     => 'bg-red-100',
            'card_border' => 'border-red-400',
            'eyebrow'     => 'text-red-700',
            'title'       => 'text-red-900',
            'text'        => 'text-red-800',
        ],
        default => [  // Belum Bayar
            'chip'        => 'bg-slate-100 text-slate-700 border border-slate-300',
            'card_bg'     => 'bg-slate-100',
            'card_border' => 'border-slate-300',
            'eyebrow'     => 'text-slate-600',
            'title'       => 'text-slate-900',
            'text'        => 'text-slate-700',
        ],
    };

    // ============================================
    // CEK KETERSEDIAAN METODE
    // ============================================
    $offlineAvailable  = $info && !empty($info->offline_alamat);
    $transferAvailable = $info && !empty($info->transfer_bank);
    $qrisAvailable     = $info && !empty($info->qris_image_url);

    // ============================================
    // TENTUKAN DEFAULT METODE
    // Prioritas: metode yang sudah dipilih user (kalau masih tersedia),
    // kalau tidak → pilih yang tersedia pertama
    // ============================================
    $defaultMetode = null;

    if ($pembayaran->metode) {
        $stillAvailable = match($pembayaran->metode) {
            'offline'  => $offlineAvailable,
            'transfer' => $transferAvailable,
            'qris'     => $qrisAvailable,
            default    => false,
        };
        if ($stillAvailable) {
            $defaultMetode = $pembayaran->metode;
        }
    }

    if (!$defaultMetode) {
        $defaultMetode = $offlineAvailable  ? 'offline'
            : ($transferAvailable ? 'transfer'
            : ($qrisAvailable     ? 'qris' : ''));
    }
?>

<div class="max-w-3xl mx-auto space-y-5">

    
    
    
    <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#0d4a36] text-xs font-bold text-white">1</span>
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Tagihan Pembayaran</h3>
            </div>
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold <?php echo e($statusConfig['chip']); ?>">
                <?php echo e($pembayaran->status); ?>

            </span>
        </div>

        <dl class="grid gap-3 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-xs text-[#617064]">Nomor Pendaftaran</dt>
                <dd class="font-mono font-bold text-[#0d4a36] mt-0.5"><?php echo e($pendaftaran->nomor_pendaftaran); ?></dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Nama</dt>
                <dd class="font-semibold text-[#244535] mt-0.5"><?php echo e($pendaftaran->nama_lengkap); ?></dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Jenjang</dt>
                <dd class="text-[#244535] mt-0.5"><?php echo e($pendaftaran->jenjang->nama); ?></dd>
            </div>
            <div>
                <dt class="text-xs text-[#617064]">Gelombang</dt>
                <dd class="text-[#244535] mt-0.5"><?php echo e($pendaftaran->gelombang?->nama ?? '—'); ?></dd>
            </div>
        </dl>

        <div class="mt-4 rounded-xl bg-[#fff8dd] border border-[#f0e0a8] p-4 text-center">
            <p class="text-xs font-bold uppercase tracking-[.14em] text-[#805500]">Total yang Harus Dibayar</p>
            <p class="display-font mt-1 text-2xl sm:text-3xl font-bold text-[#0d4a36]">
                Rp<?php echo e(number_format($pembayaran->jumlah, 0, ',', '.')); ?>

            </p>
        </div>
    </div>

    
    
    
    <?php if($pembayaran->status === 'Terverifikasi'): ?>
        <div class="rounded-2xl border-2 border-green-400 bg-green-100 p-6 text-center">
            <i data-lucide="check-circle-2" class="mx-auto h-12 w-12 text-green-700 mb-3"></i>
            <p class="font-bold text-green-900 text-lg">Pembayaran Terverifikasi</p>
            <p class="text-sm text-green-800 mt-1">Terima kasih. Lanjutkan proses berikutnya.</p>
            <?php if($pembayaran->verified_at): ?>
                <p class="text-xs text-green-700 mt-2">
                    Diverifikasi: <?php echo e($pembayaran->verified_at->isoFormat('D MMMM Y, HH:mm')); ?>

                </p>
            <?php endif; ?>
        </div>

    
    
    
    <?php elseif($pembayaran->status === 'Menunggu Verifikasi'): ?>
        <div class="rounded-2xl border-2 border-amber-400 bg-amber-100 p-6 text-center">
            <i data-lucide="clock" class="mx-auto h-12 w-12 text-amber-700 mb-3"></i>
            <p class="font-bold text-amber-900 text-lg">Menunggu Verifikasi Admin</p>
            <p class="text-sm text-amber-800 mt-1">Bukti bayar Anda sedang diperiksa. Tunggu maks 1×24 jam.</p>
            <?php if($pembayaran->uploaded_at): ?>
                <p class="text-xs text-amber-700 mt-2">
                    Upload: <?php echo e($pembayaran->uploaded_at->isoFormat('D MMMM Y, HH:mm')); ?>

                </p>
            <?php endif; ?>
            <?php if($pembayaran->bukti_path): ?>
                <a href="<?php echo e(asset('storage/' . $pembayaran->bukti_path)); ?>"
                   target="_blank"
                   class="mt-3 inline-flex items-center gap-1 text-xs text-amber-900 font-semibold hover:underline">
                    <i data-lucide="file-text" class="h-3 w-3"></i>
                    Lihat bukti yang diupload
                </a>
            <?php endif; ?>
        </div>

    
    
    
    <?php else: ?>

        
        <?php if($pembayaran->status === 'Gagal' && $pembayaran->catatan_admin): ?>
            <div class="rounded-2xl border-2 border-red-300 bg-red-50 p-5">
                <div class="flex items-start gap-3">
                    <i data-lucide="alert-triangle" class="h-5 w-5 text-red-700 shrink-0 mt-0.5"></i>
                    <div>
                        <p class="font-bold text-red-900 text-sm">Bukti sebelumnya ditolak</p>
                        <p class="text-sm text-red-800 mt-1"><?php echo e($pembayaran->catatan_admin); ?></p>
                        <p class="text-xs text-red-700 mt-2">Silakan upload ulang bukti yang benar.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        
        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm"
             x-data="{ metode: '<?php echo e($defaultMetode); ?>' }">

            
            
            
            <div class="flex items-center gap-2 mb-4">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#0d4a36] text-xs font-bold text-white">2</span>
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Pilih Metode & Lakukan Pembayaran</h3>
            </div>

            <?php if(!$offlineAvailable && !$transferAvailable && !$qrisAvailable): ?>
                <div class="rounded-xl border border-dashed border-[#d6dccf] bg-[#f8faf5] p-5 text-center">
                    <i data-lucide="info" class="mx-auto h-7 w-7 text-[#d6dccf] mb-2"></i>
                    <p class="text-sm text-[#617064]">Informasi pembayaran belum tersedia. Hubungi admin.</p>
                </div>
            <?php else: ?>

                
                <div class="grid gap-2 sm:grid-cols-3 mb-5">

                    
                    <button type="button"
                            <?php if($offlineAvailable): ?> @click="metode = 'offline'" <?php endif; ?>
                            <?php if(!$offlineAvailable): echo 'disabled'; endif; ?>
                            :class="metode === 'offline' && <?php echo e($offlineAvailable ? 'true' : 'false'); ?>

                                ? 'border-[#0d4a36] bg-[#f4f8ee] ring-2 ring-[#0d4a36]/20'
                                : '<?php echo e($offlineAvailable
                                    ? 'border-[#e1e9da] bg-white hover:bg-[#f8faf5] cursor-pointer'
                                    : 'border-[#e1e9da] bg-[#f8faf5] opacity-50 cursor-not-allowed'); ?>'"
                            class="relative rounded-xl border-2 p-3 text-left transition">
                        <i data-lucide="building-2" class="h-5 w-5 mb-1.5 <?php echo e($offlineAvailable ? 'text-[#0d4a36]' : 'text-[#94a3b8]'); ?>"></i>
                        <p class="text-sm font-bold <?php echo e($offlineAvailable ? 'text-[#0d4a36]' : 'text-[#94a3b8]'); ?>">Offline</p>
                        <p class="text-xs <?php echo e($offlineAvailable ? 'text-[#617064]' : 'text-[#94a3b8]'); ?> mt-0.5">
                            <?php echo e($offlineAvailable ? 'Datang ke kantor' : 'Belum tersedia'); ?>

                        </p>

                        <?php if(!$offlineAvailable): ?>
                            <span class="absolute top-2 right-2 text-[9px] font-bold uppercase tracking-wide bg-[#e1e9da] text-[#94a3b8] rounded-full px-2 py-0.5">
                                Kosong
                            </span>
                        <?php endif; ?>
                    </button>

                    
                    <button type="button"
                            <?php if($transferAvailable): ?> @click="metode = 'transfer'" <?php endif; ?>
                            <?php if(!$transferAvailable): echo 'disabled'; endif; ?>
                            :class="metode === 'transfer' && <?php echo e($transferAvailable ? 'true' : 'false'); ?>

                                ? 'border-[#0d4a36] bg-[#f4f8ee] ring-2 ring-[#0d4a36]/20'
                                : '<?php echo e($transferAvailable
                                    ? 'border-[#e1e9da] bg-white hover:bg-[#f8faf5] cursor-pointer'
                                    : 'border-[#e1e9da] bg-[#f8faf5] opacity-50 cursor-not-allowed'); ?>'"
                            class="relative rounded-xl border-2 p-3 text-left transition">
                        <i data-lucide="credit-card" class="h-5 w-5 mb-1.5 <?php echo e($transferAvailable ? 'text-[#0d4a36]' : 'text-[#94a3b8]'); ?>"></i>
                        <p class="text-sm font-bold <?php echo e($transferAvailable ? 'text-[#0d4a36]' : 'text-[#94a3b8]'); ?>">Transfer</p>
                        <p class="text-xs <?php echo e($transferAvailable ? 'text-[#617064]' : 'text-[#94a3b8]'); ?> mt-0.5">
                            <?php echo e($transferAvailable ? 'Via bank' : 'Belum tersedia'); ?>

                        </p>

                        <?php if(!$transferAvailable): ?>
                            <span class="absolute top-2 right-2 text-[9px] font-bold uppercase tracking-wide bg-[#e1e9da] text-[#94a3b8] rounded-full px-2 py-0.5">
                                Kosong
                            </span>
                        <?php endif; ?>
                    </button>

                    
                    <button type="button"
                            <?php if($qrisAvailable): ?> @click="metode = 'qris'" <?php endif; ?>
                            <?php if(!$qrisAvailable): echo 'disabled'; endif; ?>
                            :class="metode === 'qris' && <?php echo e($qrisAvailable ? 'true' : 'false'); ?>

                                ? 'border-[#0d4a36] bg-[#f4f8ee] ring-2 ring-[#0d4a36]/20'
                                : '<?php echo e($qrisAvailable
                                    ? 'border-[#e1e9da] bg-white hover:bg-[#f8faf5] cursor-pointer'
                                    : 'border-[#e1e9da] bg-[#f8faf5] opacity-50 cursor-not-allowed'); ?>'"
                            class="relative rounded-xl border-2 p-3 text-left transition">
                        <i data-lucide="qr-code" class="h-5 w-5 mb-1.5 <?php echo e($qrisAvailable ? 'text-[#0d4a36]' : 'text-[#94a3b8]'); ?>"></i>
                        <p class="text-sm font-bold <?php echo e($qrisAvailable ? 'text-[#0d4a36]' : 'text-[#94a3b8]'); ?>">QRIS</p>
                        <p class="text-xs <?php echo e($qrisAvailable ? 'text-[#617064]' : 'text-[#94a3b8]'); ?> mt-0.5">
                            <?php echo e($qrisAvailable ? 'Scan QR' : 'Belum tersedia'); ?>

                        </p>

                        <?php if(!$qrisAvailable): ?>
                            <span class="absolute top-2 right-2 text-[9px] font-bold uppercase tracking-wide bg-[#e1e9da] text-[#94a3b8] rounded-full px-2 py-0.5">
                                Kosong
                            </span>
                        <?php endif; ?>
                    </button>
                </div>

                
                <div class="rounded-xl bg-[#f4f8ee] border border-[#dce6d3] p-4 sm:p-5">

                    
                    <div x-show="metode === 'offline'" x-cloak class="space-y-2 text-sm">
                        <p class="font-bold text-[#0d4a36] flex items-center gap-2">
                            <i data-lucide="building-2" class="h-4 w-4"></i>
                            Datang langsung ke kantor:
                        </p>
                        <p class="text-[#244535]"><?php echo e($info->offline_alamat); ?></p>
                        <?php if($info->offline_cp_nama): ?>
                            <p class="text-[#617064]">
                                CP: <strong><?php echo e($info->offline_cp_nama); ?></strong>
                                <?php if($info->offline_cp_hp): ?>
                                    —
                                    <a href="https://wa.me/<?php echo e(preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $info->offline_cp_hp))); ?>"
                                       target="_blank" rel="noopener noreferrer"
                                       class="text-[#0d4a36] font-semibold hover:underline">
                                        <?php echo e($info->offline_cp_hp); ?>

                                    </a>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                        <?php if($info->offline_jam): ?>
                            <p class="text-[#617064]">Jam operasional: <?php echo e($info->offline_jam); ?></p>
                        <?php endif; ?>
                        <?php if($info->offline_catatan): ?>
                            <p class="text-xs text-[#617064] mt-2 pt-2 border-t border-[#dce6d3]"><?php echo e($info->offline_catatan); ?></p>
                        <?php endif; ?>
                    </div>

                    
                    <div x-show="metode === 'transfer'" x-cloak class="space-y-2 text-sm">
                        <p class="font-bold text-[#0d4a36] flex items-center gap-2">
                            <i data-lucide="credit-card" class="h-4 w-4"></i>
                            Transfer ke rekening:
                        </p>
                        <div class="grid gap-2 mt-2">
                            <div class="flex justify-between gap-2 bg-white rounded-lg px-3 py-2">
                                <span class="text-[#617064]">Bank</span>
                                <span class="font-bold text-[#244535]"><?php echo e($info->transfer_bank); ?></span>
                            </div>
                            <div class="flex justify-between gap-2 bg-white rounded-lg px-3 py-2">
                                <span class="text-[#617064]">No. Rekening</span>
                                <span class="font-mono font-bold text-[#244535]"><?php echo e($info->transfer_norek); ?></span>
                            </div>
                            <div class="flex justify-between gap-2 bg-white rounded-lg px-3 py-2">
                                <span class="text-[#617064]">Atas Nama</span>
                                <span class="font-bold text-[#244535]"><?php echo e($info->transfer_atas_nama); ?></span>
                            </div>
                            <?php if($info->transfer_cabang): ?>
                                <div class="flex justify-between gap-2 bg-white rounded-lg px-3 py-2">
                                    <span class="text-[#617064]">Cabang</span>
                                    <span class="text-[#244535]"><?php echo e($info->transfer_cabang); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="text-xs text-[#617064] mt-2">
                            <i data-lucide="info" class="inline h-3 w-3"></i>
                            Simpan bukti transfer untuk diupload di langkah 3.
                        </p>
                    </div>

                    
                    <div x-show="metode === 'qris'" x-cloak class="space-y-3 text-sm text-center">
                        <p class="font-bold text-[#0d4a36] flex items-center justify-center gap-2">
                            <i data-lucide="qr-code" class="h-4 w-4"></i>
                            Scan QRIS berikut:
                        </p>
                        <img src="<?php echo e($info->qris_image_url); ?>" alt="QRIS"
                             class="mx-auto max-w-[260px] rounded-lg border-2 border-[#d8ae45] bg-white p-2">
                        <p class="text-xs text-[#617064]">Pastikan nominal sesuai tagihan, lalu screenshot bukti.</p>
                    </div>
                </div>

                <?php if($info->catatan_umum): ?>
                    <p class="mt-3 text-xs text-[#617064] bg-[#f8faf5] rounded-lg p-3 border border-[#e1e9da]">
                        <i data-lucide="info" class="inline h-3 w-3"></i>
                        <?php echo e($info->catatan_umum); ?>

                    </p>
                <?php endif; ?>
            <?php endif; ?>

            
            
            
            <?php if($offlineAvailable || $transferAvailable || $qrisAvailable): ?>
                <div class="mt-5 pt-5 border-t border-[#e1e9da]">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#0d4a36] text-xs font-bold text-white">3</span>
                        <h3 class="display-font text-lg font-bold text-[#0d4a36]">
                            <?php echo e($pembayaran->bukti_path ? 'Upload Ulang Bukti' : 'Upload Bukti Bayar'); ?>

                        </h3>
                    </div>

                    <?php if($pembayaran->bukti_path && $pembayaran->status === 'Gagal'): ?>
                        <div class="mb-3 rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-3">
                            <p class="text-xs text-[#617064] mb-1">Bukti terakhir:</p>
                            <a href="<?php echo e(asset('storage/' . $pembayaran->bukti_path)); ?>"
                               target="_blank"
                               class="text-xs text-[#0d4a36] font-semibold hover:underline inline-flex items-center gap-1">
                                <i data-lucide="file-text" class="h-3 w-3"></i>
                                <?php echo e($pembayaran->bukti_nama_asli); ?>

                            </a>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('student.pembayaran.upload')); ?>"
                          enctype="multipart/form-data" class="space-y-3">
                        <?php echo csrf_field(); ?>

                        
                        <input type="hidden" name="metode" :value="metode">

                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-[#244535]">Bukti Bayar</label>
                            <input type="file" name="bukti" required accept=".jpg,.jpeg,.png,.pdf"
                                   class="field-control text-xs">
                            <p class="mt-1 text-xs text-[#617064]">JPG, PNG, atau PDF. Maks 2MB.</p>
                        </div>

                        <?php $__errorArgs = ['bukti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>  <p class="text-xs text-red-700"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['metode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-700"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <button type="submit"
                                class="w-full rounded-lg bg-[#0d4a36] px-4 py-3 text-sm font-bold text-white hover:bg-[#176346]">
                            <i data-lucide="upload" class="inline h-4 w-4 mr-1"></i>
                            Kirim Bukti Bayar
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/student/pembayaran.blade.php ENDPATH**/ ?>