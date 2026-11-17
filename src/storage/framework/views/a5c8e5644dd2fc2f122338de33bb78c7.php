

<?php $__env->startSection('title', 'Detail Pengguna'); ?>
<?php $__env->startSection('page-title', 'Detail Pengguna'); ?>
<?php $__env->startSection('page-subtitle', $pengguna->name); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-5">
    <a href="<?php echo e(route('admin.pengguna.index')); ?>"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke daftar
    </a>
</div>

<div class="grid gap-5 lg:grid-cols-3">

    
    <div class="lg:col-span-2 space-y-5">

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Informasi Akun</h3>

            <form method="POST" action="<?php echo e(route('admin.pengguna.update', $pengguna)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-bold text-[#244535]">Nama</label>
                        <input type="text" id="name" name="name" value="<?php echo e(old('name', $pengguna->name)); ?>" required class="field-control">
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-bold text-[#244535]">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email', $pengguna->email)); ?>" required class="field-control">
                    </div>
                    <div>
                        <label for="role" class="mb-1.5 block text-xs font-bold text-[#244535]">Role</label>
                        <select id="role" name="role" class="field-control">
                            <option value="student" <?php if(old('role', $pengguna->role) === 'student'): echo 'selected'; endif; ?>>Santri</option>
                            <option value="admin" <?php if(old('role', $pengguna->role) === 'admin'): echo 'selected'; endif; ?>>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label for="nisn" class="mb-1.5 block text-xs font-bold text-[#244535]">NISN (opsional)</label>
                        <input type="text" id="nisn" name="nisn" value="<?php echo e(old('nisn', $pengguna->nisn)); ?>" maxlength="10" class="field-control">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="no_whatsapp" class="mb-1.5 block text-xs font-bold text-[#244535]">No. WhatsApp</label>
                        <input type="text" id="no_whatsapp" name="no_whatsapp" value="<?php echo e(old('no_whatsapp', $pengguna->no_whatsapp)); ?>" class="field-control">
                    </div>
                </div>

                <button type="submit" class="mt-4 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-1">Reset Password</h3>
            <p class="text-xs text-[#617064] mb-4">Ganti password pengguna ini secara langsung.</p>

            <form method="POST" action="<?php echo e(route('admin.pengguna.reset-password', $pengguna)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-bold text-[#244535]">Password Baru</label>
                        <input type="password" id="password" name="password" required minlength="6" class="field-control">
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-xs font-bold text-[#244535]">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6" class="field-control">
                    </div>
                </div>

                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-xs text-[#963d21]"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <button type="submit" class="mt-4 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                    Reset Password
                </button>
            </form>
        </div>

        
        <?php if($pengguna->isStudent() && $pengguna->pendaftaran): ?>
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
                <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Data Pendaftaran Terkait</h3>
                <dl class="grid gap-3 sm:grid-cols-2 text-sm">
                    <div>
                        <dt class="text-xs text-[#617064]">Nomor Pendaftaran</dt>
                        <dd class="font-mono font-bold text-[#0d4a36]"><?php echo e($pengguna->pendaftaran->nomor_pendaftaran); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#617064]">Jenjang</dt>
                        <dd class="text-[#244535]"><?php echo e($pengguna->pendaftaran->jenjang->nama); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#617064]">Status Verifikasi</dt>
                        <dd class="text-[#244535]"><?php echo e($pengguna->pendaftaran->status_verifikasi); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#617064]">Status Kelulusan</dt>
                        <dd class="text-[#244535]"><?php echo e($pengguna->pendaftaran->status_kelulusan); ?></dd>
                    </div>
                </dl>
                <a href="<?php echo e(route('admin.pendaftaran.show', $pengguna->pendaftaran)); ?>"
                   class="mt-4 inline-flex items-center gap-1 text-sm font-bold text-[#0d4a36] hover:underline">
                    Lihat Detail Pendaftaran
                    <i data-lucide="arrow-right" class="h-3 w-3"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>

    
    <div class="space-y-5">

        
        <div class="rounded-2xl bg-[#0d4a36] text-white p-5 shadow-sm text-center">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#d8ae45] text-3xl font-bold text-[#073528]">
                <?php echo e(strtoupper(substr($pengguna->name, 0, 1))); ?>

            </div>
            <h3 class="display-font mt-3 text-xl font-bold"><?php echo e($pengguna->name); ?></h3>
            <p class="text-sm text-[#d6e3d0]"><?php echo e($pengguna->email); ?></p>
            <div class="mt-3 flex justify-center">
                <?php if($pengguna->isAdmin()): ?>
                    <span class="rounded-full bg-[#d8ae45] px-3 py-1 text-xs font-bold text-[#073528]">Admin</span>
                <?php else: ?>
                    <span class="rounded-full bg-[#5d9f3f] px-3 py-1 text-xs font-bold text-white">Santri</span>
                <?php endif; ?>
            </div>
            <p class="mt-3 text-xs text-[#d6e3d0]">
                Terdaftar: <?php echo e($pengguna->created_at->isoFormat('D MMMM Y')); ?>

            </p>
        </div>

        
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="font-bold text-[#0d4a36] mb-3">Aksi Cepat</h3>

            <?php if($pengguna->id === auth()->id()): ?>
                <p class="text-xs text-[#617064] italic">Anda tidak dapat mengubah status atau menghapus akun sendiri.</p>
            <?php else: ?>
                <form method="POST" action="<?php echo e(route('admin.pengguna.toggle', $pengguna)); ?>" class="mb-2">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="w-full rounded-lg border border-[#0d4a36] px-4 py-2 text-sm font-bold text-[#0d4a36] hover:bg-[#f4f8ee]">
                        <?php echo e($pengguna->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun'); ?>

                    </button>
                </form>

                <form method="POST" action="<?php echo e(route('admin.pengguna.destroy', $pengguna)); ?>"
                      onsubmit="return confirm('Hapus akun <?php echo e($pengguna->name); ?>? Tindakan ini tidak bisa dibatalkan.')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full rounded-lg border border-[#963d21] px-4 py-2 text-sm font-bold text-[#963d21] hover:bg-[#963d21] hover:text-white">
                        Hapus Akun
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/pengguna/show.blade.php ENDPATH**/ ?>