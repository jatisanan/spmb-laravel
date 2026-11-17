

<?php $__env->startSection('title', 'Edit Jenjang'); ?>
<?php $__env->startSection('page-title', 'Edit Jenjang'); ?>
<?php $__env->startSection('page-subtitle', $jenjang->nama); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-5">
    <a href="<?php echo e(route('admin.jenjang.index')); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke daftar jenjang
    </a>
</div>

<div class="mx-auto max-w-3xl rounded-2xl border border-[#e1e9da] bg-white p-6 shadow-sm md:p-8">
    <form method="POST" action="<?php echo e(route('admin.jenjang.update', $jenjang)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="space-y-5">
            <div>
                <label for="nama" class="mb-2 block text-sm font-bold text-[#244535]">Nama Jenjang</label>
                <input type="text" id="nama" name="nama" value="<?php echo e(old('nama', $jenjang->nama)); ?>" required class="field-control">
                <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="label" class="mb-2 block text-sm font-bold text-[#244535]">Label</label>
                <input type="text" id="label" name="label" value="<?php echo e(old('label', $jenjang->label)); ?>" placeholder="Contoh: Jenjang Menengah Pertama" class="field-control">
            </div>

            <div>
                <label for="deskripsi" class="mb-2 block text-sm font-bold text-[#244535]">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="field-control"><?php echo e(old('deskripsi', $jenjang->deskripsi)); ?></textarea>
            </div>

            <div>
                <label for="logo" class="mb-2 block text-sm font-bold text-[#244535]">Logo Jenjang</label>
                <?php if($jenjang->logo_path): ?>
                    <div class="mb-2">
                        <img src="<?php echo e(asset('storage/' . $jenjang->logo_path)); ?>" alt="Logo" class="h-20 w-20 object-contain rounded-lg border border-[#e1e9da] bg-white p-1">
                    </div>
                <?php endif; ?>
                <input type="file" id="logo" name="logo" accept="image/*"
                       class="block w-full text-sm text-[#244535]
                              file:mr-3 file:rounded-lg file:border-0
                              file:bg-[#0d4a36] file:px-4 file:py-2
                              file:text-sm file:font-bold file:text-white
                              hover:file:bg-[#176346]">
                <p class="mt-1 text-xs text-[#617064]">Format: JPG, PNG, WEBP, SVG. Maks 2MB.</p>
                <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="aktif" value="1" <?php if(old('aktif', $jenjang->aktif)): echo 'checked'; endif; ?>
                           class="rounded border-[#d6dccf] text-[#0d4a36] focus:ring-[#5d9f3f]">
                    <span class="text-sm font-bold text-[#244535]">Aktifkan jenjang ini</span>
                </label>
            </div>
        </div>

        <div class="mt-7 flex justify-end gap-3 border-t border-[#e1e9da] pt-5">
            <a href="<?php echo e(route('admin.jenjang.index')); ?>" class="rounded-lg border border-[#d6dccf] px-5 py-2.5 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                <i data-lucide="save" class="h-4 w-4"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/jenjang/edit.blade.php ENDPATH**/ ?>