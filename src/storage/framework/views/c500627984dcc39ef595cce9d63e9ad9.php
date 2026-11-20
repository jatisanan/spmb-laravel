

<?php $__env->startSection('title', 'Jenjang & Gelombang'); ?>
<?php $__env->startSection('page-title', 'Jenjang & Gelombang'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola jenjang pendidikan dan gelombang pendaftaran'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">
    <?php $__currentLoopData = $jenjangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-2xl border border-[#e1e9da] bg-white shadow-sm overflow-hidden">

            
            <div class="p-5 border-b border-[#e1e9da] bg-[#f8fbf5]">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <?php if($j->logo_path): ?>
                            <img src="<?php echo e(asset('storage/' . $j->logo_path)); ?>" alt="Logo" class="h-14 w-14 object-contain rounded-lg bg-white border border-[#e1e9da] p-1">
                        <?php else: ?>
                            <div class="h-14 w-14 rounded-lg bg-[#e8f4df] flex items-center justify-center text-[#5d9f3f]">
                                <i data-lucide="graduation-cap" class="h-7 w-7"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="display-font text-xl font-bold text-[#0d4a36]"><?php echo e($j->nama); ?></h3>
                                <?php if($j->aktif): ?>
                                    <span class="status-chip status-success">Aktif</span>
                                <?php else: ?>
                                    <span class="status-chip status-neutral">Nonaktif</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-xs text-[#617064]"><?php echo e($j->label); ?> · <?php echo e($j->pendaftarans_count); ?> pendaftar</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <form method="POST" action="<?php echo e(route('admin.jenjang.toggle', $j)); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="rounded-lg border border-[#d6dccf] px-3 py-2 text-xs font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                                <?php echo e($j->aktif ? 'Nonaktifkan' : 'Aktifkan'); ?>

                            </button>
                        </form>
                        <a href="<?php echo e(route('admin.jenjang.edit', $j)); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-[#0d4a36] px-3 py-2 text-xs font-bold text-white hover:bg-[#176346]">
                            <i data-lucide="edit-3" class="h-3.5 w-3.5"></i>
                            Edit Jenjang
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-bold text-[#0d4a36] text-sm">Gelombang Pendaftaran</h4>
                    <button type="button" data-toggle-form="form-gelombang-<?php echo e($j->id); ?>"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0d4a36] hover:underline">
                        <i data-lucide="plus-circle" class="h-4 w-4"></i>
                        Tambah Gelombang
                    </button>
                </div>

                
                <div id="form-gelombang-<?php echo e($j->id); ?>" class="hidden mb-4 rounded-xl border border-[#dce6d3] bg-[#f4f8ee] p-4">
                    <form method="POST" action="<?php echo e(route('admin.gelombang.store', $j)); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="grid gap-3 md:grid-cols-5">
                            <div class="md:col-span-2">
                                <label class="mb-1 block text-xs font-bold text-[#244535]">Nama Gelombang</label>
                                <input type="text" name="nama" required placeholder="Indent / Gelombang 1" class="field-control">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-bold text-[#244535]">Mulai</label>
                                <input type="date" name="tanggal_mulai" required class="field-control">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-bold text-[#244535]">Selesai</label>
                                <input type="date" name="tanggal_selesai" required class="field-control">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-bold text-[#244535]">Biaya (Rp)</label>
                                <input type="number" name="biaya" required min="0" step="1000" placeholder="100000" class="field-control">
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-1 block text-xs font-bold text-[#244535]">Tanggal Ujian (opsional)</label>
                                <input type="date" name="tanggal_ujian" class="field-control">
                            </div>
                            <div class="md:col-span-3">
                                <label class="mb-1 block text-xs font-bold text-[#244535]">Catatan (opsional)</label>
                                <input type="text" name="catatan" placeholder="Info tambahan..." class="field-control">
                            </div>
                        </div>
                        <div class="mt-3 flex justify-end gap-2">
                            <button type="button" data-toggle-form="form-gelombang-<?php echo e($j->id); ?>"
                                    class="rounded-lg border border-[#d6dccf] px-4 py-2 text-xs font-semibold text-[#244535] hover:bg-white">
                                Batal
                            </button>
                            <button type="submit" class="rounded-lg bg-[#0d4a36] px-4 py-2 text-xs font-bold text-white hover:bg-[#176346]">
                                Simpan Gelombang
                            </button>
                        </div>
                    </form>
                </div>

                
                <?php if($j->gelombang->isEmpty()): ?>
                    <p class="text-sm text-[#617064] py-3 text-center">Belum ada gelombang.</p>
                <?php else: ?>
                    <div class="overflow-x-auto rounded-xl border border-[#edf0e9]">
                        <table class="admin-table" style="min-width: 800px;">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Periode</th>
                                    <th>Ujian</th>
                                    <th>Biaya</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $j->gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="font-semibold text-[#0d4a36]"><?php echo e($g->nama); ?></td>
                                        <td>
                                            <?php echo e($g->tanggal_mulai->isoFormat('D MMM Y')); ?>

                                            – <?php echo e($g->tanggal_selesai->isoFormat('D MMM Y')); ?>

                                        </td>
                                        <td><?php echo e($g->tanggal_ujian?->isoFormat('D MMM Y') ?? '—'); ?></td>
                                        <td class="font-bold">Rp<?php echo e(number_format($g->biaya, 0, ',', '.')); ?></td>
                                        <td>
                                            <?php if($g->aktif): ?>
                                                <span class="status-chip status-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="status-chip status-neutral">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                
                                                <button type="button"
                                                        class="btn-edit-gelombang inline-flex items-center gap-1 rounded-lg border border-[#d6dccf] px-2.5 py-1.5 text-xs font-semibold text-[#0d4a36] hover:bg-[#f4f8ee]"
                                                        data-id="<?php echo e($g->id); ?>"
                                                        data-nama="<?php echo e($g->nama); ?>"
                                                        data-tanggal-mulai="<?php echo e($g->tanggal_mulai->format('Y-m-d')); ?>"
                                                        data-tanggal-selesai="<?php echo e($g->tanggal_selesai->format('Y-m-d')); ?>"
                                                        data-tanggal-ujian="<?php echo e($g->tanggal_ujian?->format('Y-m-d')); ?>"
                                                        data-biaya="<?php echo e($g->biaya); ?>"
                                                        data-catatan="<?php echo e($g->catatan); ?>"
                                                        data-aktif="<?php echo e($g->aktif ? '1' : '0'); ?>"
                                                        data-jenjang="<?php echo e($j->nama); ?>"
                                                        title="Edit Gelombang">
                                                    <i data-lucide="edit-3" class="h-3 w-3"></i>
                                                    Edit
                                                </button>

                                                
                                                <form method="POST" action="<?php echo e(route('admin.gelombang.toggle', $g)); ?>" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" class="text-xs text-[#244535] hover:underline">
                                                        <?php echo e($g->aktif ? 'Off' : 'On'); ?>

                                                    </button>
                                                </form>

                                                <span class="text-[#d6dccf]">·</span>

                                                
                                                <form method="POST" action="<?php echo e(route('admin.gelombang.destroy', $g)); ?>" class="inline"
                                                      onsubmit="return confirm('Hapus gelombang <?php echo e($g->nama); ?>?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-xs text-[#963d21] hover:underline">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>




<div id="edit-gelombang-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden max-h-[92vh] flex flex-col">

        
        <div class="bg-[#0d4a36] px-5 sm:px-6 py-4 sm:py-5 text-white shrink-0 flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#e9d28b]">Edit Gelombang</p>
                <p id="modal-jenjang-nama" class="text-sm font-bold mt-0.5 truncate"></p>
            </div>
            <button type="button" data-close-edit class="p-1.5 rounded-lg hover:bg-white/10 shrink-0">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        
        <form id="edit-gelombang-form" method="POST" class="flex-1 overflow-y-auto">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>

            <div class="px-5 sm:px-6 py-4 sm:py-5 space-y-4">

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nama Gelombang</label>
                    <input type="text" name="nama" id="edit-nama" required
                           placeholder="Indent / Gelombang 1"
                           class="field-control">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="edit-tanggal-mulai" required
                               class="field-control">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="edit-tanggal-selesai" required
                               class="field-control">
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Ujian (opsional)</label>
                        <input type="date" name="tanggal_ujian" id="edit-tanggal-ujian"
                               class="field-control">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Biaya (Rp)</label>
                        <input type="number" name="biaya" id="edit-biaya" required min="0" step="1000"
                               placeholder="100000"
                               class="field-control">
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">Catatan (opsional)</label>
                    <textarea name="catatan" id="edit-catatan" rows="2"
                              placeholder="Info tambahan..."
                              class="field-control"></textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="aktif" id="edit-aktif" value="1"
                               class="rounded border-[#d6dccf] text-[#0d4a36] focus:ring-[#5d9f3f]">
                        <span class="text-sm font-semibold text-[#244535]">Gelombang Aktif</span>
                    </label>
                    <p class="mt-1 text-xs text-[#617064]">
                        Hanya gelombang aktif yang tampil di landing page &amp; form pendaftaran.
                    </p>
                </div>

            </div>

            
            <div class="px-5 sm:px-6 py-4 bg-[#f8faf5] border-t border-[#e1e9da] flex flex-col-reverse sm:flex-row sm:justify-end gap-2 shrink-0">
                <button type="button" data-close-edit
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d6dccf] px-4 py-2.5 text-sm font-semibold text-[#244535] hover:bg-white w-full sm:w-auto">
                    Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] w-full sm:w-auto">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';

    // ============================================
    // TOGGLE FORM TAMBAH GELOMBANG
    // ============================================
    document.querySelectorAll('[data-toggle-form]').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.getElementById(btn.dataset.toggleForm);
            if (target) target.classList.toggle('hidden');
        });
    });

    // ============================================
    // MODAL EDIT GELOMBANG
    // ============================================
    const modal = document.getElementById('edit-gelombang-modal');
    const form = document.getElementById('edit-gelombang-form');
    const modalJenjang = document.getElementById('modal-jenjang-nama');

    // URL template — pakai placeholder :id
    const updateUrlTemplate = '<?php echo e(route("admin.gelombang.update", ":id")); ?>';

    function openEditModal(data) {
        // Set form action
        form.action = updateUrlTemplate.replace(':id', data.id);

        // Set judul modal
        modalJenjang.textContent = data.jenjang + ' — ' + data.nama;

        // Isi field
        document.getElementById('edit-nama').value            = data.nama || '';
        document.getElementById('edit-tanggal-mulai').value   = data.tanggalMulai || '';
        document.getElementById('edit-tanggal-selesai').value = data.tanggalSelesai || '';
        document.getElementById('edit-tanggal-ujian').value   = data.tanggalUjian || '';
        document.getElementById('edit-biaya').value           = data.biaya || '';
        document.getElementById('edit-catatan').value         = data.catatan || '';
        document.getElementById('edit-aktif').checked         = data.aktif === '1';

        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        if (window.lucide) lucide.createIcons();
    }

    function closeEditModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Delegated click
    document.addEventListener('click', function (e) {
        const editBtn = e.target.closest('.btn-edit-gelombang');
        if (editBtn) {
            openEditModal({
                id:             editBtn.dataset.id,
                nama:           editBtn.dataset.nama,
                tanggalMulai:   editBtn.dataset.tanggalMulai,
                tanggalSelesai: editBtn.dataset.tanggalSelesai,
                tanggalUjian:   editBtn.dataset.tanggalUjian,
                biaya:          editBtn.dataset.biaya,
                catatan:        editBtn.dataset.catatan,
                aktif:          editBtn.dataset.aktif,
                jenjang:        editBtn.dataset.jenjang,
            });
            return;
        }

        if (e.target.closest('[data-close-edit]')) {
            closeEditModal();
            return;
        }

        if (e.target.id === 'edit-gelombang-modal') {
            closeEditModal();
        }
    });

    // ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeEditModal();
        }
    });

})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/jenjang/index.blade.php ENDPATH**/ ?>