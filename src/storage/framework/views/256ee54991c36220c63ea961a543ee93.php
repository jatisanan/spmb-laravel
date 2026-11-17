

<?php $__env->startSection('title', 'Pengaturan Situs'); ?>
<?php $__env->startSection('page-title', 'Pengaturan Situs'); ?>
<?php $__env->startSection('page-subtitle', 'Edit konten landing page & upload gambar'); ?>

<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('admin.pengaturan.update')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    
    <div class="mb-5 flex flex-wrap gap-2">
        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button type="button" data-tab-btn="<?php echo e($groupKey); ?>"
                    class="tab-btn inline-flex items-center gap-2 rounded-lg border border-[#d6dccf] bg-white px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee] transition">
                <i data-lucide="<?php echo e($group['icon']); ?>" class="h-4 w-4"></i>
                <?php echo e($group['label']); ?>

            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div data-tab-content="<?php echo e($groupKey); ?>" class="tab-content hidden">
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-6 shadow-sm">
                <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-1"><?php echo e($group['label']); ?></h3>
                <p class="text-xs text-[#617064] mb-5">Edit konten untuk bagian <?php echo e(strtolower($group['label'])); ?> pada landing page.</p>

                <div class="space-y-4">
                    <?php $__currentLoopData = $group['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $value = $settings[$key] ?? '';
                        ?>

                        <div>
                            <label for="<?php echo e($key); ?>" class="mb-1.5 block text-sm font-bold text-[#244535]">
                                <?php echo e($meta['label']); ?>

                            </label>

                            <?php if($meta['type'] === 'textarea'): ?>
                                <textarea id="<?php echo e($key); ?>" name="<?php echo e($key); ?>" rows="3" class="field-control"><?php echo e($value); ?></textarea>

                            <?php elseif($meta['type'] === 'image'): ?>
                                <div class="space-y-2">
                                    
                                    <?php if($value): ?>
                                        <?php
                                            $previewUrl = str_starts_with($value, 'http') ? $value : asset('storage/' . $value);
                                            // Fallback ke public/images kalau file belum ada di storage
                                            if (!str_starts_with($value, 'http') && !file_exists(storage_path('app/public/' . $value))) {
                                                $previewUrl = asset($value);
                                            }
                                        ?>
                                        <div class="relative inline-block">
                                            <img src="<?php echo e($previewUrl); ?>" alt="Preview"
                                                 class="h-32 w-auto rounded-lg border border-[#d6dccf] object-cover bg-[#f4f8ee]">
                                            <p class="mt-1 text-xs text-[#617064] break-all"><?php echo e($value); ?></p>
                                        </div>
                                    <?php else: ?>
                                        <div class="h-32 w-48 rounded-lg border-2 border-dashed border-[#d6dccf] bg-[#f4f8ee] flex items-center justify-center">
                                            <p class="text-xs text-[#617064]">Belum ada gambar</p>
                                        </div>
                                    <?php endif; ?>

                                    <input type="file" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                           accept="image/*"
                                           class="block w-full text-sm text-[#244535]
                                                  file:mr-3 file:rounded-lg file:border-0
                                                  file:bg-[#0d4a36] file:px-4 file:py-2
                                                  file:text-sm file:font-bold file:text-white
                                                  hover:file:bg-[#176346]">
                                    <p class="text-xs text-[#617064]">Format: JPG, PNG, WEBP, SVG. Maks 3MB.</p>
                                </div>

                            <?php else: ?>
                                <input type="text" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>" class="field-control">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <div class="mt-5 flex justify-end gap-3">
        <a href="<?php echo e(route('landing')); ?>"
           class="rounded-lg border border-[#d6dccf] px-5 py-3 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
            Preview Landing
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-6 py-3 text-sm font-bold text-white hover:bg-[#176346]">
            <i data-lucide="save" class="h-4 w-4"></i>
            Simpan Pengaturan
        </button>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const btns = document.querySelectorAll('[data-tab-btn]');
    const contents = document.querySelectorAll('[data-tab-content]');

    function activate(tabKey) {
        btns.forEach(b => {
            const active = b.dataset.tabBtn === tabKey;
            b.classList.toggle('bg-[#0d4a36]', active);
            b.classList.toggle('text-white', active);
            b.classList.toggle('border-[#0d4a36]', active);
            b.classList.toggle('bg-white', !active);
            b.classList.toggle('text-[#244535]', !active);
            b.classList.toggle('border-[#d6dccf]', !active);
        });

        contents.forEach(c => {
            c.classList.toggle('hidden', c.dataset.tabContent !== tabKey);
        });

        if (window.lucide) lucide.createIcons();
    }

    btns.forEach(btn => {
        btn.addEventListener('click', () => activate(btn.dataset.tabBtn));
    });

    // Aktifkan tab pertama
    if (btns.length) activate(btns[0].dataset.tabBtn);
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/pengaturan/index.blade.php ENDPATH**/ ?>