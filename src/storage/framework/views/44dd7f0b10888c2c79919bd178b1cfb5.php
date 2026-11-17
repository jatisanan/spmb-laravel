

<?php $__env->startSection('title', 'Edit Pendaftar'); ?>
<?php $__env->startSection('page-title', 'Edit Data Pendaftar'); ?>
<?php $__env->startSection('page-subtitle', $pendaftaran->nomor_pendaftaran . ' — ' . $pendaftaran->nama_lengkap); ?>

<?php $__env->startSection('content'); ?>

<?php
    $isSuperAdmin = auth()->user()->isSuperAdmin();
?>


<div class="mb-5 rounded-2xl border border-[#dce6d3] bg-[#f4f8ee] p-4 sm:p-5">
    <div class="flex items-start gap-3">
        <i data-lucide="info" class="h-5 w-5 text-[#0d4a36] shrink-0 mt-0.5"></i>
        <div class="text-sm text-[#315440] leading-6">
            <p class="font-bold text-[#0d4a36]">Perhatian</p>
            <ul class="mt-1 list-disc list-inside space-y-1">
                <?php if($isSuperAdmin): ?>
                    <li>Sebagai <strong>Super Admin</strong>, Anda dapat mengubah <strong>semua field</strong> termasuk <strong>Nomor Pendaftaran</strong>, <strong>Tanggal Lahir</strong>, dan <strong>Email</strong>.</li>
                    <li>Perubahan pada Nomor Pendaftaran / Email / Tanggal Lahir dapat memengaruhi login &amp; referensi pendaftar. Lakukan dengan hati-hati.</li>
                <?php else: ?>
                    <li><strong>Nomor Pendaftaran, Tanggal Lahir, dan Email</strong> tidak dapat diubah karena dipakai untuk akun login.</li>
                    <li>Kalau salah satu dari field tersebut salah, <strong>hapus pendaftaran ini</strong> dan minta pendaftar mengisi ulang.</li>
                <?php endif; ?>
                <li><strong>Berkas</strong> dan <strong>Status</strong> hanya bisa dilihat di sini. Untuk mengubahnya, buka halaman detail pendaftar.</li>
            </ul>
        </div>
    </div>
</div>

<form method="POST" action="<?php echo e(route('admin.pendaftaran.update', $pendaftaran)); ?>"
      class="rounded-2xl border border-[#e1e9da] bg-white shadow-sm overflow-hidden">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>

    <div class="p-4 sm:p-6 md:p-8">
        
        <div class="mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Data Pribadi
            </h3>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            
            <div class="sm:col-span-2">
                <label for="nomor_pendaftaran" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nomor Pendaftaran
                    <?php if (! ($isSuperAdmin)): ?>
                        <span class="ml-1 inline-flex items-center gap-1 rounded-full bg-[#edf1ec] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#42604c]">
                            <i data-lucide="lock" class="h-2.5 w-2.5"></i>
                            Terkunci
                        </span>
                    <?php endif; ?>
                </label>
                <input id="nomor_pendaftaran" name="nomor_pendaftaran" type="text"
                       value="<?php echo e(old('nomor_pendaftaran', $pendaftaran->nomor_pendaftaran)); ?>"
                       <?php if($isSuperAdmin): ?>
                           required
                           class="field-control font-mono <?php $__errorArgs = ['nomor_pendaftaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       <?php else: ?>
                           readonly
                           class="field-control bg-[#f6f8f3] font-mono cursor-not-allowed"
                       <?php endif; ?>>
                <?php if($isSuperAdmin): ?>
                    <p class="mt-1 text-xs text-[#963d21]">
                        <i data-lucide="alert-triangle" class="inline h-3 w-3"></i>
                        Format: <code>SPMB-YYYY-KODE-0001</code>. Mengubah nomor dapat memengaruhi referensi/login pendaftar.
                    </p>
                    <?php $__errorArgs = ['nomor_pendaftaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php else: ?>
                    <p class="mt-1 text-xs text-[#69786e]">Nomor ini tidak dapat diubah.</p>
                <?php endif; ?>
            </div>

            <div>
                <label for="nama_lengkap" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nama Lengkap <span class="text-[#963d21]">*</span>
                </label>
                <input id="nama_lengkap" name="nama_lengkap" type="text" required
                       value="<?php echo e(old('nama_lengkap', $pendaftaran->nama_lengkap)); ?>"
                       class="field-control <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="jenis_kelamin" class="mb-2 block text-sm font-bold text-[#244535]">
                    Jenis Kelamin <span class="text-[#963d21]">*</span>
                </label>
                <select id="jenis_kelamin" name="jenis_kelamin" required
                        class="field-control <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="Laki-laki" <?php if(old('jenis_kelamin', $pendaftaran->jenis_kelamin) === 'Laki-laki'): echo 'selected'; endif; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if(old('jenis_kelamin', $pendaftaran->jenis_kelamin) === 'Perempuan'): echo 'selected'; endif; ?>>Perempuan</option>
                </select>
                <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="nisn" class="mb-2 block text-sm font-bold text-[#244535]">
                    NISN (10 digit) <span class="text-[#963d21]">*</span>
                </label>
                <input id="nisn" name="nisn" type="text" required
                       inputmode="numeric" pattern="[0-9]{10}" minlength="10" maxlength="10"
                       value="<?php echo e(old('nisn', $pendaftaran->nisn)); ?>"
                       class="field-control font-mono <?php $__errorArgs = ['nisn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['nisn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="tempat_lahir" class="mb-2 block text-sm font-bold text-[#244535]">
                    Tempat Lahir <span class="text-[#963d21]">*</span>
                </label>
                <input id="tempat_lahir" name="tempat_lahir" type="text" required
                       value="<?php echo e(old('tempat_lahir', $pendaftaran->tempat_lahir)); ?>"
                       class="field-control <?php $__errorArgs = ['tempat_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['tempat_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="tanggal_lahir" class="mb-2 block text-sm font-bold text-[#244535]">
                    Tanggal Lahir
                    <?php if (! ($isSuperAdmin)): ?>
                        <span class="ml-1 inline-flex items-center gap-1 rounded-full bg-[#edf1ec] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#42604c]">
                            <i data-lucide="lock" class="h-2.5 w-2.5"></i>
                            Terkunci
                        </span>
                    <?php endif; ?>
                </label>
                <input id="tanggal_lahir" name="tanggal_lahir" type="date"
                       value="<?php echo e(old('tanggal_lahir', $pendaftaran->tanggal_lahir?->format('Y-m-d'))); ?>"
                       <?php if($isSuperAdmin): ?>
                           required
                           class="field-control <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       <?php else: ?>
                           readonly
                           class="field-control bg-[#f6f8f3] cursor-not-allowed"
                       <?php endif; ?>>
                <?php if($isSuperAdmin): ?>
                    <p class="mt-1 text-xs text-[#963d21]">
                        <i data-lucide="alert-triangle" class="inline h-3 w-3"></i>
                        Password awal user dibuat dari tanggal ini (ddmmyyyy). Perubahan tidak otomatis mengubah password lama.
                    </p>
                    <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php else: ?>
                    <p class="mt-1 text-xs text-[#69786e]">
                        Dipakai sebagai password awal user (ddmmyyyy). Tidak dapat diubah.
                    </p>
                <?php endif; ?>
            </div>

            <div class="sm:col-span-2">
                <label for="asal_sekolah" class="mb-2 block text-sm font-bold text-[#244535]">
                    Asal Sekolah <span class="text-[#963d21]">*</span>
                </label>
                <input id="asal_sekolah" name="asal_sekolah" type="text" required
                       value="<?php echo e(old('asal_sekolah', $pendaftaran->asal_sekolah)); ?>"
                       class="field-control <?php $__errorArgs = ['asal_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['asal_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        
        <div class="mt-8 mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Data Pendaftaran
            </h3>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="jenjang_id" class="mb-2 block text-sm font-bold text-[#244535]">
                    Jenjang <span class="text-[#963d21]">*</span>
                </label>
                <select id="jenjang_id" name="jenjang_id" required
                        class="field-control <?php $__errorArgs = ['jenjang_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__currentLoopData = $jenjangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($j->id); ?>" <?php if(old('jenjang_id', $pendaftaran->jenjang_id) == $j->id): echo 'selected'; endif; ?>>
                            <?php echo e($j->nama); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['jenjang_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="gelombang_id" class="mb-2 block text-sm font-bold text-[#244535]">
                    Gelombang <span class="text-[#963d21]">*</span>
                </label>
                <select id="gelombang_id" name="gelombang_id" required
                        class="field-control <?php $__errorArgs = ['gelombang_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__currentLoopData = $jenjangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $j->gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($g->id); ?>" <?php if(old('gelombang_id', $pendaftaran->gelombang_id) == $g->id): echo 'selected'; endif; ?>>
                                <?php echo e($j->nama); ?> — <?php echo e($g->nama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['gelombang_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        
        <div class="mt-8 mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Data Orang Tua / Wali
            </h3>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="nama_ayah" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nama Ayah <span class="text-[#963d21]">*</span>
                </label>
                <input id="nama_ayah" name="nama_ayah" type="text" required
                       value="<?php echo e(old('nama_ayah', $pendaftaran->nama_ayah)); ?>"
                       class="field-control <?php $__errorArgs = ['nama_ayah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['nama_ayah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="nama_ibu" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nama Ibu <span class="text-[#963d21]">*</span>
                </label>
                <input id="nama_ibu" name="nama_ibu" type="text" required
                       value="<?php echo e(old('nama_ibu', $pendaftaran->nama_ibu)); ?>"
                       class="field-control <?php $__errorArgs = ['nama_ibu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['nama_ibu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="sm:col-span-2">
                <label for="nama_wali" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nama Wali (opsional)
                </label>
                <input id="nama_wali" name="nama_wali" type="text"
                       value="<?php echo e(old('nama_wali', $pendaftaran->nama_wali)); ?>"
                       class="field-control <?php $__errorArgs = ['nama_wali'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['nama_wali'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        
        <div class="mt-8 mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Kontak & Alamat
            </h3>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="no_whatsapp" class="mb-2 block text-sm font-bold text-[#244535]">
                    No. WhatsApp <span class="text-[#963d21]">*</span>
                </label>
                <input id="no_whatsapp" name="no_whatsapp" type="tel" required
                       value="<?php echo e(old('no_whatsapp', $pendaftaran->no_whatsapp)); ?>"
                       class="field-control <?php $__errorArgs = ['no_whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['no_whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="email" class="mb-2 block text-sm font-bold text-[#244535]">
                    Email
                    <?php if (! ($isSuperAdmin)): ?>
                        <span class="ml-1 inline-flex items-center gap-1 rounded-full bg-[#edf1ec] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#42604c]">
                            <i data-lucide="lock" class="h-2.5 w-2.5"></i>
                            Terkunci
                        </span>
                    <?php endif; ?>
                </label>
                <input id="email" name="email" type="email"
                       value="<?php echo e(old('email', $pendaftaran->email)); ?>"
                       <?php if($isSuperAdmin): ?>
                           required
                           class="field-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       <?php else: ?>
                           readonly
                           class="field-control bg-[#f6f8f3] cursor-not-allowed"
                       <?php endif; ?>>
                <?php if($isSuperAdmin): ?>
                    <p class="mt-1 text-xs text-[#963d21]">
                        <i data-lucide="alert-triangle" class="inline h-3 w-3"></i>
                        Email = username login user. Perubahan akan disinkronkan ke akun user.
                    </p>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php else: ?>
                    <p class="mt-1 text-xs text-[#69786e]">
                        Dipakai sebagai username login user. Tidak dapat diubah.
                    </p>
                <?php endif; ?>
            </div>

            <div class="sm:col-span-2">
                <label for="alamat" class="mb-2 block text-sm font-bold text-[#244535]">
                    Alamat Lengkap <span class="text-[#963d21]">*</span>
                </label>
                <textarea id="alamat" name="alamat" rows="4" required
                          class="field-control resize-y <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#f2c1ae] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('alamat', $pendaftaran->alamat)); ?></textarea>
                <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        
        
        
        <div class="mt-8 mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Berkas Pendaftaran
            </h3>
            <p class="mt-2 text-xs text-[#69786e]">
                Berkas hanya bisa dilihat di sini. Untuk verifikasi/hapus, buka halaman detail pendaftar.
            </p>
        </div>

        <?php if($pendaftaran->berkas->isEmpty()): ?>
            <div class="rounded-xl border border-dashed border-[#d6dccf] bg-[#f8faf5] p-6 text-center">
                <i data-lucide="file-x" class="mx-auto h-8 w-8 text-[#d6dccf] mb-2"></i>
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

        
        
        
        <div class="mt-8 mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Status Pendaftaran
            </h3>
            <p class="mt-2 text-xs text-[#69786e]">
                Status hanya bisa diubah dari halaman detail pendaftar.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            
            <div class="rounded-xl border border-[#e1e9da] bg-[#f8faf5] p-3.5">
                <p class="text-xs text-[#617064] mb-1">Verifikasi</p>
                <p class="text-sm font-bold text-[#244535]"><?php echo e($pendaftaran->status_verifikasi); ?></p>
                <?php if($pendaftaran->catatan_verifikasi): ?>
                    <p class="mt-1 text-xs text-[#617064] italic"><?php echo e($pendaftaran->catatan_verifikasi); ?></p>
                <?php endif; ?>
            </div>

            
            <div class="rounded-xl border border-[#e1e9da] bg-[#f8faf5] p-3.5">
                <p class="text-xs text-[#617064] mb-1">Ujian</p>
                <p class="text-sm font-bold text-[#244535]"><?php echo e($pendaftaran->status_ujian); ?></p>
                <?php if($pendaftaran->tanggal_ujian): ?>
                    <p class="mt-1 text-xs text-[#617064]">
                        📅 <?php echo e($pendaftaran->tanggal_ujian->isoFormat('D MMM Y')); ?>

                    </p>
                <?php endif; ?>
                <?php if($pendaftaran->nilai_ujian): ?>
                    <p class="mt-0.5 text-xs font-bold text-[#0d4a36]">Nilai: <?php echo e($pendaftaran->nilai_ujian); ?></p>
                <?php endif; ?>
            </div>

            
            <div class="rounded-xl border border-[#e1e9da] bg-[#f8faf5] p-3.5">
                <p class="text-xs text-[#617064] mb-1">Kelulusan</p>
                <p class="text-sm font-bold text-[#244535]"><?php echo e($pendaftaran->status_kelulusan); ?></p>
            </div>

            
            <div class="rounded-xl border border-[#e1e9da] bg-[#f8faf5] p-3.5">
                <p class="text-xs text-[#617064] mb-1">Daftar Ulang</p>
                <p class="text-sm font-bold text-[#244535]"><?php echo e($pendaftaran->status_daftar_ulang); ?></p>
                <?php if($pendaftaran->tanggal_daftar_ulang): ?>
                    <p class="mt-1 text-xs text-[#617064]">
                        📅 <?php echo e($pendaftaran->tanggal_daftar_ulang->isoFormat('D MMM Y')); ?>

                    </p>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if($pendaftaran->link_daftar_ulang): ?>
            <div class="mt-4 rounded-lg border border-[#dce6d3] bg-[#f4f8ee] p-3.5">
                <p class="text-xs text-[#617064] mb-1">Link Daftar Ulang</p>
                <a href="<?php echo e($pendaftaran->link_daftar_ulang); ?>" target="_blank" rel="noopener noreferrer"
                   class="text-sm font-bold text-[#0d4a36] hover:text-[#5d9f3f] underline break-all">
                    <?php echo e($pendaftaran->link_daftar_ulang); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>

    
    <div class="px-4 sm:px-6 md:px-8 py-4 bg-[#f8faf5] border-t border-[#e1e9da]
                flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center gap-3">
        <a href="<?php echo e(route('admin.pendaftaran.show', $pendaftaran)); ?>"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d6dccf] px-4 py-2.5 text-sm font-semibold text-[#244535] hover:bg-white w-full sm:w-auto">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Batal
        </a>

        <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] w-full sm:w-auto">
            <i data-lucide="save" class="h-4 w-4"></i>
            Simpan Perubahan
        </button>
    </div>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/pendaftaran/edit.blade.php ENDPATH**/ ?>