

<?php $__env->startSection('title', 'Pengumuman'); ?>
<?php $__env->startSection('page-title', 'Pengumuman'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola pengumuman untuk santri dan admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="grid gap-5 lg:grid-cols-3">

    
    <div class="lg:col-span-1">
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm sticky top-24">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Buat Pengumuman</h3>

            <form method="POST" action="<?php echo e(route('admin.pengumuman.store')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="judul" class="mb-1.5 block text-xs font-bold text-[#244535]">Judul</label>
                    <input type="text" id="judul" name="judul" required
                           placeholder="Contoh: Jadwal Ujian Gelombang 1"
                           class="field-control" value="<?php echo e(old('judul')); ?>">
                    <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="isi" class="mb-1.5 block text-xs font-bold text-[#244535]">Isi Pengumuman</label>
                    <textarea id="isi" name="isi" rows="5" required class="field-control"
                              placeholder="Tulis isi pengumuman di sini..."><?php echo e(old('isi')); ?></textarea>
                    <?php $__errorArgs = ['isi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-[#963d21]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="target" class="mb-1.5 block text-xs font-bold text-[#244535]">Target</label>
                    <select id="target" name="target" required class="field-control">
                        <option value="semua" <?php if(old('target') === 'semua'): echo 'selected'; endif; ?>>Semua (Admin & Santri)</option>
                        <option value="student" <?php if(old('target') === 'student'): echo 'selected'; endif; ?>>Santri</option>
                        <option value="admin" <?php if(old('target') === 'admin'): echo 'selected'; endif; ?>>Admin</option>
                    </select>
                </div>

                <div>
                    <label for="published_at" class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Publish</label>
                    <input type="datetime-local" id="published_at" name="published_at"
                           value="<?php echo e(old('published_at', now()->format('Y-m-d\TH:i'))); ?>"
                           class="field-control">
                    <p class="mt-1 text-xs text-[#617064]">Kosongkan untuk langsung publish.</p>
                </div>

                <div>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="publish" value="1" <?php if(old('publish', true)): echo 'checked'; endif; ?>
                               class="rounded border-[#d6dccf] text-[#0d4a36] focus:ring-[#5d9f3f]">
                        <span class="text-sm font-bold text-[#244535]">Langsung publish</span>
                    </label>
                </div>

                <button type="submit" class="w-full rounded-lg bg-[#0d4a36] px-5 py-3 text-sm font-bold text-white hover:bg-[#176346]">
                    <i data-lucide="send" class="inline h-4 w-4"></i>
                    Publikasikan
                </button>
            </form>
        </div>
    </div>

    
    <div class="lg:col-span-2 space-y-4">

        
        <form method="GET" action="<?php echo e(route('admin.pengumuman.index')); ?>"
              class="rounded-2xl border border-[#e1e9da] bg-white p-4 shadow-sm flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[140px]">
                <label for="filter-target" class="mb-1.5 block text-xs font-bold text-[#244535]">Target</label>
                <select name="target" id="filter-target" class="field-control">
                    <option value="">Semua</option>
                    <option value="semua" <?php if(request('target') === 'semua'): echo 'selected'; endif; ?>>Semua</option>
                    <option value="student" <?php if(request('target') === 'student'): echo 'selected'; endif; ?>>Santri</option>
                    <option value="admin" <?php if(request('target') === 'admin'): echo 'selected'; endif; ?>>Admin</option>
                </select>
            </div>

            <div class="flex-1 min-w-[140px]">
                <label for="filter-status" class="mb-1.5 block text-xs font-bold text-[#244535]">Status</label>
                <select name="status" id="filter-status" class="field-control">
                    <option value="">Semua</option>
                    <option value="publish" <?php if(request('status') === 'publish'): echo 'selected'; endif; ?>>Published</option>
                    <option value="draft" <?php if(request('status') === 'draft'): echo 'selected'; endif; ?>>Draft</option>
                </select>
            </div>

            <button type="submit" class="rounded-lg bg-[#0d4a36] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                Filter
            </button>

            <?php if(request()->hasAny(['target', 'status'])): ?>
                <a href="<?php echo e(route('admin.pengumuman.index')); ?>"
                   class="rounded-lg border border-[#d6dccf] px-4 py-2.5 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                    Reset
                </a>
            <?php endif; ?>
        </form>

        
        <?php $__empty_1 = true; $__currentLoopData = $pengumumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="display-font text-lg font-bold text-[#0d4a36]"><?php echo e($p->judul); ?></h3>
                            <?php if($p->publish): ?>
                                <span class="status-chip status-success">Published</span>
                            <?php else: ?>
                                <span class="status-chip status-neutral">Draft</span>
                            <?php endif; ?>
                            <span class="status-chip status-pending"><?php echo e(ucfirst($p->target)); ?></span>
                        </div>
                        <p class="text-xs text-[#617064] mb-3">
                            <i data-lucide="clock" class="inline h-3 w-3"></i>
                            <?php echo e($p->published_at?->isoFormat('D MMMM Y, HH:mm') ?? $p->created_at->isoFormat('D MMMM Y, HH:mm')); ?>

                        </p>
                        <p class="text-sm text-[#365143] leading-6 whitespace-pre-line"><?php echo e($p->isi); ?></p>
                    </div>

                    <div class="flex flex-col items-end gap-2 shrink-0">
                        <form method="POST" action="<?php echo e(route('admin.pengumuman.toggle', $p)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="rounded-lg border border-[#d6dccf] px-3 py-1.5 text-xs font-semibold text-[#244535] hover:bg-[#f4f8ee] whitespace-nowrap">
                                <?php echo e($p->publish ? 'Unpublish' : 'Publish'); ?>

                            </button>
                        </form>

                        <button type="button"
                                onclick="document.getElementById('edit-<?php echo e($p->id); ?>').classList.toggle('hidden')"
                                class="rounded-lg border border-[#0d4a36] px-3 py-1.5 text-xs font-bold text-[#0d4a36] hover:bg-[#f4f8ee]">
                            <i data-lucide="edit-3" class="inline h-3 w-3"></i>
                            Edit
                        </button>

                        <form method="POST" action="<?php echo e(route('admin.pengumuman.destroy', $p)); ?>"
                              onsubmit="return confirm('Hapus pengumuman <?php echo e($p->judul); ?>?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="rounded-lg border border-[#f2c1ae] px-3 py-1.5 text-xs font-bold text-[#963d21] hover:bg-[#fff0ea]">
                                <i data-lucide="trash-2" class="inline h-3 w-3"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                
                <div id="edit-<?php echo e($p->id); ?>" class="hidden mt-5 pt-5 border-t border-[#e1e9da]">
                    <form method="POST" action="<?php echo e(route('admin.pengumuman.update', $p)); ?>" class="space-y-3">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <input type="text" name="judul" value="<?php echo e($p->judul); ?>" required class="field-control">

                        <textarea name="isi" rows="4" required class="field-control"><?php echo e($p->isi); ?></textarea>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <select name="target" required class="field-control">
                                <option value="semua" <?php if($p->target === 'semua'): echo 'selected'; endif; ?>>Semua</option>
                                <option value="student" <?php if($p->target === 'student'): echo 'selected'; endif; ?>>Santri</option>
                                <option value="admin" <?php if($p->target === 'admin'): echo 'selected'; endif; ?>>Admin</option>
                            </select>

                            <input type="datetime-local" name="published_at"
                                   value="<?php echo e($p->published_at?->format('Y-m-d\TH:i')); ?>"
                                   class="field-control">
                        </div>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="publish" value="1" <?php if($p->publish): echo 'checked'; endif; ?>
                                   class="rounded border-[#d6dccf] text-[#0d4a36] focus:ring-[#5d9f3f]">
                            <span class="text-sm font-bold text-[#244535]">Publish</span>
                        </label>

                        <div class="flex justify-end gap-2">
                            <button type="button"
                                    onclick="document.getElementById('edit-<?php echo e($p->id); ?>').classList.add('hidden')"
                                    class="rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535]">
                                Batal
                            </button>
                            <button type="submit"
                                    class="rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-10 text-center shadow-sm">
                <i data-lucide="megaphone" class="mx-auto h-10 w-10 text-[#d6dccf] mb-3"></i>
                <p class="text-[#617064]">Belum ada pengumuman.</p>
            </div>
        <?php endif; ?>

        <?php if($pengumumen->hasPages()): ?>
            <div><?php echo e($pengumumen->links()); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/pengumuman/index.blade.php ENDPATH**/ ?>