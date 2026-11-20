

<?php $__env->startSection('title', 'Detail Pendaftar'); ?>
<?php $__env->startSection('page-title', 'Detail Pendaftar'); ?>
<?php $__env->startSection('page-subtitle', $pendaftaran->nomor_pendaftaran); ?>

<?php $__env->startSection('content'); ?>

<?php
    // Ambil status pembayaran dari RELASI (single source of truth)
    $statusPembayaran = $pendaftaran->pembayaran?->status ?? 'Belum Bayar';
?>

<div class="mb-5">
    <a href="<?php echo e(route('admin.pendaftaran.index')); ?>"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke daftar
    </a>
</div>




<div class="rounded-2xl bg-[#0d4a36] text-white p-4 shadow-sm mb-5">
    <p class="text-[10px] font-bold uppercase tracking-[.14em] text-[#d8ae45] mb-3">Status Ringkas</p>

    <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-6">

        
        <div class="rounded-lg bg-white/5 border border-white/10 px-3 py-2.5">
            <div class="flex items-center gap-1.5 mb-1">
                <i data-lucide="calendar-days" class="h-3 w-3 text-[#d6e3d0] shrink-0"></i>
                <p class="text-[9px] font-bold uppercase tracking-wide text-[#d6e3d0] truncate">Tanggal Daftar</p>
            </div>
            <?php if($pendaftaran->created_at): ?>
                <p class="text-xs font-bold leading-tight text-[#f0cf6f]">
                    <?php echo e($pendaftaran->created_at->isoFormat('dddd')); ?>

                </p>
                <p class="text-[9px] text-[#d6e3d0] leading-tight mt-0.5">
                    <?php echo e($pendaftaran->created_at->isoFormat('D MMMM Y')); ?>

                </p>
            <?php else: ?>
                <p class="text-xs font-bold leading-tight text-[#f0cf6f]">—</p>
            <?php endif; ?>
        </div>

        
        <div class="rounded-lg bg-white/5 border border-white/10 px-3 py-2.5">
            <div class="flex items-center gap-1.5 mb-1">
                <i data-lucide="wallet" class="h-3 w-3 text-[#d6e3d0] shrink-0"></i>
                <p class="text-[9px] font-bold uppercase tracking-wide text-[#d6e3d0] truncate">Pembayaran</p>
            </div>
            <p class="text-xs font-bold leading-tight <?php echo e($statusPembayaran === 'Terverifikasi' ? 'text-[#a3e08c]' : 'text-[#f0cf6f]'); ?>">
                <?php echo e($statusPembayaran); ?>

            </p>
        </div>

        
        <div class="rounded-lg bg-white/5 border border-white/10 px-3 py-2.5">
            <div class="flex items-center gap-1.5 mb-1">
                <i data-lucide="file-check" class="h-3 w-3 text-[#d6e3d0] shrink-0"></i>
                <p class="text-[9px] font-bold uppercase tracking-wide text-[#d6e3d0] truncate">Verifikasi</p>
            </div>
            <p class="text-xs font-bold leading-tight"><?php echo e($pendaftaran->status_verifikasi); ?></p>
            <?php if($pendaftaran->catatan_verifikasi): ?>
                <p class="text-[9px] text-[#f0cf6f] mt-0.5 leading-3 line-clamp-1"><?php echo e($pendaftaran->catatan_verifikasi); ?></p>
            <?php endif; ?>
        </div>

        
        <div class="rounded-lg bg-white/5 border border-white/10 px-3 py-2.5">
            <div class="flex items-center gap-1.5 mb-1">
                <i data-lucide="clipboard-list" class="h-3 w-3 text-[#d6e3d0] shrink-0"></i>
                <p class="text-[9px] font-bold uppercase tracking-wide text-[#d6e3d0] truncate">Ujian</p>
            </div>
            <p class="text-xs font-bold leading-tight"><?php echo e($pendaftaran->status_ujian); ?></p>
            <?php if($pendaftaran->tanggal_ujian): ?>
                <p class="text-[9px] text-[#d6e3d0] mt-0.5 leading-3">
                    <?php echo e($pendaftaran->tanggal_ujian->isoFormat('D MMM Y')); ?>

                </p>
            <?php endif; ?>
            <?php if($pendaftaran->nilai_ujian): ?>
                <p class="text-[9px] font-bold text-[#f0cf6f] mt-0.5">Nilai: <?php echo e($pendaftaran->nilai_ujian); ?></p>
            <?php endif; ?>
        </div>

        
        <div class="rounded-lg bg-white/5 border border-white/10 px-3 py-2.5">
            <div class="flex items-center gap-1.5 mb-1">
                <i data-lucide="award" class="h-3 w-3 text-[#d6e3d0] shrink-0"></i>
                <p class="text-[9px] font-bold uppercase tracking-wide text-[#d6e3d0] truncate">Kelulusan</p>
            </div>
            <p class="text-xs font-bold leading-tight"><?php echo e($pendaftaran->status_kelulusan); ?></p>
        </div>

        
        <div class="rounded-lg bg-white/5 border border-white/10 px-3 py-2.5">
            <div class="flex items-center gap-1.5 mb-1">
                <i data-lucide="user-check" class="h-3 w-3 text-[#d6e3d0] shrink-0"></i>
                <p class="text-[9px] font-bold uppercase tracking-wide text-[#d6e3d0] truncate">Daftar Ulang</p>
            </div>
            <p class="text-xs font-bold leading-tight"><?php echo e($pendaftaran->status_daftar_ulang); ?></p>
            <?php if($pendaftaran->tanggal_daftar_ulang): ?>
                <p class="text-[9px] text-[#d6e3d0] mt-0.5 leading-3">
                    <?php echo e($pendaftaran->tanggal_daftar_ulang->isoFormat('D MMM Y')); ?>

                </p>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if($pendaftaran->link_daftar_ulang): ?>
        <div class="mt-3 pt-3 border-t border-white/10">
            <a href="<?php echo e($pendaftaran->link_daftar_ulang); ?>" target="_blank" rel="noopener noreferrer"
               class="text-[10px] font-bold text-[#f0cf6f] hover:underline inline-flex items-center gap-1">
                <i data-lucide="external-link" class="h-3 w-3"></i>
                Form Daftar Ulang
            </a>
        </div>
    <?php endif; ?>
</div>

<div class="grid gap-5 lg:grid-cols-3">

    
    <div class="lg:col-span-2 space-y-5">

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Data Santri</h3>
                <span class="status-chip status-neutral"><?php echo e($pendaftaran->jenjang->nama); ?></span>
            </div>

            <dl class="grid gap-3 sm:grid-cols-2 text-sm">
                <div>
                    <dt class="text-xs text-[#617064]">Nomor Pendaftaran</dt>
                    <dd class="font-mono font-bold text-[#0d4a36]"><?php echo e($pendaftaran->nomor_pendaftaran); ?></dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">NISN</dt>
                    <dd class="font-mono text-[#244535]"><?php echo e($pendaftaran->nisn); ?></dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Nama Lengkap</dt>
                    <dd class="font-semibold text-[#244535]"><?php echo e($pendaftaran->nama_lengkap); ?></dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Jenis Kelamin</dt>
                    <dd class="text-[#244535]"><?php echo e($pendaftaran->jenis_kelamin); ?></dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Tempat, Tanggal Lahir</dt>
                    <dd class="text-[#244535]">
                        <?php echo e($pendaftaran->tempat_lahir); ?>,
                        <?php echo e($pendaftaran->tanggal_lahir?->isoFormat('D MMMM Y')); ?>

                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Asal Sekolah</dt>
                    <dd class="text-[#244535]"><?php echo e($pendaftaran->asal_sekolah); ?></dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Gelombang</dt>
                    <dd class="text-[#244535]"><?php echo e($pendaftaran->gelombang?->nama ?? '—'); ?></dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Email</dt>
                    <dd class="text-[#244535]"><?php echo e($pendaftaran->email ?? '—'); ?></dd>
                </div>

                
                <div>
                    <dt class="text-xs text-[#617064]">No. WhatsApp</dt>
                    <dd class="text-[#244535]">
                        <?php if($pendaftaran->no_whatsapp): ?>
                            <a href="https://wa.me/<?php echo e(preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pendaftaran->no_whatsapp))); ?>"
                               target="_blank" rel="noopener noreferrer"
                               class="text-[#0d4a36] font-semibold hover:underline inline-flex items-center gap-1">
                                <i data-lucide="message-circle" class="h-3.5 w-3.5"></i>
                                <?php echo e($pendaftaran->no_whatsapp); ?>

                            </a>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </dd>
                </div>

                <div class="sm:col-span-2">
                    <dt class="text-xs text-[#617064]">Alamat</dt>
                    <dd class="text-[#244535]"><?php echo e($pendaftaran->alamat); ?></dd>
                </div>
            </dl>
        </div>

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Data Orang Tua / Wali</h3>
            <dl class="grid gap-3 sm:grid-cols-3 text-sm">
                <div>
                    <dt class="text-xs text-[#617064]">Nama Ayah</dt>
                    <dd class="font-semibold text-[#244535]"><?php echo e($pendaftaran->nama_ayah ?: '—'); ?></dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Nama Ibu</dt>
                    <dd class="font-semibold text-[#244535]"><?php echo e($pendaftaran->nama_ibu ?: '—'); ?></dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Nama Wali</dt>
                    <dd class="font-semibold text-[#244535]"><?php echo e($pendaftaran->nama_wali ?: '—'); ?></dd>
                </div>
            </dl>
        </div>

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Berkas Pendaftaran</h3>

            <?php if($pendaftaran->berkas->isEmpty()): ?>
                <div class="rounded-xl border border-dashed border-[#d6dccf] bg-[#f8faf5] p-5 text-center">
                    <i data-lucide="file-x" class="mx-auto h-7 w-7 text-[#d6dccf] mb-2"></i>
                    <p class="text-sm text-[#617064]">Belum ada berkas yang diunggah.</p>
                </div>
            <?php else: ?>
                <div class="space-y-2">
                    <?php $__currentLoopData = $pendaftaran->berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-lg border border-[#e1e9da] bg-[#f8faf5] px-4 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#0d4a36]">
                                    <i data-lucide="file-text" class="h-5 w-5 text-white"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-[#244535]"><?php echo e($b->label); ?></p>
                                    <p class="text-xs text-[#617064] truncate"><?php echo e($b->nama_asli); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <?php if($b->verified): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-[#e8f4df] px-2.5 py-1 text-xs font-bold text-[#175b31]">
                                        <i data-lucide="check-circle" class="h-3 w-3"></i>
                                        Terverifikasi
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-[#fff2ca] px-2.5 py-1 text-xs font-bold text-[#805500]">
                                        <i data-lucide="clock" class="h-3 w-3"></i>
                                        Belum Diverifikasi
                                    </span>
                                <?php endif; ?>
                                <a href="<?php echo e(asset('storage/' . $b->file_path)); ?>" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 rounded-lg border border-[#d6dccf] px-3 py-1.5 text-xs font-semibold text-[#244535] hover:bg-white">
                                    <i data-lucide="eye" class="h-3 w-3"></i>
                                    Lihat
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm
            <?php echo e($statusPembayaran !== 'Terverifikasi' ? 'opacity-60' : ''); ?>">
            <div class="flex items-center justify-between mb-4">
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Verifikasi Berkas</h3>
                <?php if($statusPembayaran !== 'Terverifikasi'): ?>
                    <span class="status-chip status-pending">
                        <i data-lucide="lock" class="inline h-3 w-3 mr-1"></i>
                        Terkunci
                    </span>
                <?php endif; ?>
            </div>

            <?php if($statusPembayaran !== 'Terverifikasi'): ?>
                <p class="mb-3 text-xs text-[#963d21] bg-[#fff0ea] rounded-lg p-3 border border-[#f2c1ae]">
                    <i data-lucide="info" class="inline h-3 w-3"></i>
                    Pembayaran harus <strong>Terverifikasi</strong> terlebih dahulu sebelum berkas pendaftaran bisa diverifikasi.
                    Status pembayaran saat ini:
                    <a href="<?php echo e($pendaftaran->pembayaran ? route('admin.pembayaran.show', $pendaftaran->pembayaran) : '#'); ?>"
                       class="font-bold underline">
                        <?php echo e($statusPembayaran); ?>

                    </a>
                </p>
            <?php endif; ?>

            <?php if($pendaftaran->catatan_verifikasi): ?>
                <div class="mb-4 rounded-lg border border-[#dce6d3] bg-[#f4f8ee] p-3">
                    <p class="text-xs font-bold text-[#0d4a36] mb-1">Catatan Verifikasi Saat Ini:</p>
                    <p class="text-sm text-[#315440]"><?php echo e($pendaftaran->catatan_verifikasi); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.pendaftaran.verifikasi', $pendaftaran)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="space-y-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Verifikasi</label>
                        <select name="status_verifikasi" class="field-control"
                            <?php echo e($statusPembayaran !== 'Terverifikasi' ? 'disabled' : ''); ?>>
                            <?php $__currentLoopData = ['Menunggu Verifikasi', 'Terverifikasi', 'Perlu Perbaikan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>" <?php if($pendaftaran->status_verifikasi === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Catatan (opsional)</label>
                        <textarea name="catatan_verifikasi" rows="2" class="field-control"
                            <?php echo e($statusPembayaran !== 'Terverifikasi' ? 'disabled' : ''); ?>><?php echo e($pendaftaran->catatan_verifikasi); ?></textarea>
                    </div>
                    <button type="submit"
                        class="rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-not-allowed"
                        <?php echo e($statusPembayaran !== 'Terverifikasi' ? 'disabled' : ''); ?>>
                        Simpan Verifikasi
                    </button>
                </div>
            </form>
        </div>

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm
            <?php echo e($pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'opacity-60' : ''); ?>">
            <div class="flex items-center justify-between mb-4">
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Jadwal & Nilai Ujian</h3>
                <?php if($pendaftaran->status_verifikasi !== 'Terverifikasi'): ?>
                    <span class="status-chip status-pending">
                        <i data-lucide="lock" class="inline h-3 w-3 mr-1"></i>
                        Terkunci
                    </span>
                <?php endif; ?>
            </div>

            <?php if($pendaftaran->status_verifikasi !== 'Terverifikasi'): ?>
                <p class="mb-3 text-xs text-[#963d21] bg-[#fff0ea] rounded-lg p-3 border border-[#f2c1ae]">
                    <i data-lucide="info" class="inline h-3 w-3"></i>
                    Verifikasi berkas terlebih dahulu sebelum menjadwalkan ujian.
                </p>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.pendaftaran.ujian', $pendaftaran)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Ujian</label>
                        <select name="status_ujian" class="field-control"
                            <?php echo e($pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'disabled' : ''); ?>>
                            <?php $__currentLoopData = ['Belum Dijadwalkan', 'Terjadwal', 'Sudah Ujian']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>" <?php if($pendaftaran->status_ujian === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Ujian</label>
                        <input type="date" name="tanggal_ujian" value="<?php echo e($pendaftaran->tanggal_ujian?->format('Y-m-d')); ?>"
                            class="field-control"
                            <?php echo e($pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'disabled' : ''); ?>>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nilai Ujian</label>
                        <input type="text" name="nilai_ujian" value="<?php echo e($pendaftaran->nilai_ujian); ?>" placeholder="85"
                            class="field-control"
                            <?php echo e($pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'disabled' : ''); ?>>
                    </div>
                </div>
                <button type="submit"
                    class="mt-3 rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-not-allowed"
                    <?php echo e($pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'disabled' : ''); ?>>
                    Simpan Ujian
                </button>
            </form>
        </div>

    </div>

    
    <div class="space-y-5">

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[#0d4a36]">Pembayaran</h3>
                <span class="status-chip <?php echo e($statusPembayaran === 'Terverifikasi' ? 'status-success' :
                    ($statusPembayaran === 'Gagal' ? 'status-danger' :
                    ($statusPembayaran === 'Menunggu Verifikasi' ? 'status-pending' : 'status-neutral'))); ?>">
                    <?php echo e($statusPembayaran); ?>

                </span>
            </div>

            <?php if($pendaftaran->pembayaran): ?>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-[#617064]">Jumlah</dt>
                        <dd class="font-bold text-[#0d4a36]">Rp<?php echo e(number_format($pendaftaran->pembayaran->jumlah, 0, ',', '.')); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-[#617064]">Metode</dt>
                        <dd class="text-[#244535]"><?php echo e($pendaftaran->pembayaran->metode_label); ?></dd>
                    </div>
                </dl>

                <a href="<?php echo e(route('admin.pembayaran.show', $pendaftaran)); ?>"
                class="mt-3 inline-flex items-center gap-1 rounded-lg border border-[#0d4a36] px-3 py-1.5 text-xs font-bold text-[#0d4a36] hover:bg-[#f4f8ee]">
                    Lihat Detail Pembayaran
                    <i data-lucide="arrow-right" class="h-3 w-3"></i>
                </a>
            <?php else: ?>
                <p class="text-sm text-[#617064]">Belum ada data pembayaran.</p>
            <?php endif; ?>
        </div>

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm
            <?php echo e($pendaftaran->status_ujian !== 'Sudah Ujian' ? 'opacity-60' : ''); ?>">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[#0d4a36]">Kelulusan</h3>
                <?php if($pendaftaran->status_ujian !== 'Sudah Ujian'): ?>
                    <span class="status-chip status-pending">
                        <i data-lucide="lock" class="inline h-3 w-3 mr-1"></i>
                        Terkunci
                    </span>
                <?php endif; ?>
            </div>

            <?php if($pendaftaran->status_ujian !== 'Sudah Ujian'): ?>
                <p class="mb-3 text-xs text-[#963d21] bg-[#fff0ea] rounded-lg p-2.5 border border-[#f2c1ae]">
                    <i data-lucide="info" class="inline h-3 w-3"></i>
                    Pendaftar harus menyelesaikan ujian terlebih dahulu (Status Ujian: <?php echo e($pendaftaran->status_ujian); ?>).
                </p>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.pendaftaran.kelulusan', $pendaftaran)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <select name="status_kelulusan" class="field-control"
                    <?php echo e($pendaftaran->status_ujian !== 'Sudah Ujian' ? 'disabled' : ''); ?>>
                    <?php $__currentLoopData = ['Menunggu Hasil', 'Lulus', 'Tidak Lulus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php if($pendaftaran->status_kelulusan === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit"
                    class="mt-3 w-full rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-not-allowed"
                    <?php echo e($pendaftaran->status_ujian !== 'Sudah Ujian' ? 'disabled' : ''); ?>>
                    Update Kelulusan
                </button>
            </form>
        </div>

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm
            <?php echo e($pendaftaran->status_kelulusan !== 'Lulus' ? 'opacity-60' : ''); ?>"
            x-data="{ status: '<?php echo e($pendaftaran->status_daftar_ulang); ?>' }">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[#0d4a36]">Daftar Ulang</h3>
                <?php if($pendaftaran->status_kelulusan !== 'Lulus'): ?>
                    <span class="status-chip status-pending">
                        <i data-lucide="lock" class="inline h-3 w-3 mr-1"></i>
                        Terkunci
                    </span>
                <?php endif; ?>
            </div>

            <?php if($pendaftaran->status_kelulusan !== 'Lulus'): ?>
                <p class="mb-3 text-xs text-[#963d21] bg-[#fff0ea] rounded-lg p-2.5 border border-[#f2c1ae]">
                    <i data-lucide="info" class="inline h-3 w-3"></i>
                    Pendaftar harus dinyatakan LULUS terlebih dahulu.
                </p>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.pendaftaran.daftar-ulang', $pendaftaran)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <div class="space-y-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Daftar Ulang</label>
                        <select name="status_daftar_ulang" x-model="status" class="field-control"
                            <?php echo e($pendaftaran->status_kelulusan !== 'Lulus' ? 'disabled' : ''); ?>>
                            <?php $__currentLoopData = ['Belum Dibuka', 'Belum Daftar Ulang', 'Sudah Daftar Ulang']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>" <?php if($pendaftaran->status_daftar_ulang === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <?php if($pendaftaran->status_kelulusan === 'Lulus'): ?>
                        <template x-if="status !== 'Belum Dibuka'">
                            <div class="space-y-3">
                                <div>
                                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">Link Form Daftar Ulang</label>
                                    <input type="url" name="link_daftar_ulang" value="<?php echo e($pendaftaran->link_daftar_ulang); ?>"
                                        placeholder="https://forms.gle/..." class="field-control">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Daftar Ulang</label>
                                    <input type="date" name="tanggal_daftar_ulang"
                                        value="<?php echo e($pendaftaran->tanggal_daftar_ulang?->format('Y-m-d')); ?>"
                                        class="field-control">
                                </div>
                            </div>
                        </template>
                    <?php endif; ?>

                    <button type="submit"
                        class="w-full rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-not-allowed"
                        <?php echo e($pendaftaran->status_kelulusan !== 'Lulus' ? 'disabled' : ''); ?>>
                        Update Daftar Ulang
                    </button>
                </div>
            </form>
        </div>

        
        <?php if(auth()->user()->isSuperAdmin()): ?>
            <div class="rounded-2xl border border-[#f2c1ae] bg-[#fff8f5] p-5">
                <h3 class="font-bold text-[#963d21] mb-2">Zona Berbahaya</h3>
                <p class="text-xs text-[#963d21] mb-3">Hapus data pendaftaran ini secara permanen.</p>
                <form method="POST" action="<?php echo e(route('admin.pendaftaran.destroy', $pendaftaran)); ?>"
                    onsubmit="return confirm('Yakin hapus pendaftaran <?php echo e($pendaftaran->nomor_pendaftaran); ?>? Tindakan ini tidak bisa dibatalkan.')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full rounded-lg border border-[#963d21] px-4 py-2 text-sm font-bold text-[#963d21] hover:bg-[#963d21] hover:text-white">
                        Hapus Pendaftaran
                    </button>
                </form>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/pendaftaran/show.blade.php ENDPATH**/ ?>