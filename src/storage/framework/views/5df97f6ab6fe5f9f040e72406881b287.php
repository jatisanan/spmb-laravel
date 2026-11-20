

<?php $__env->startSection('title', 'Dashboard Santri'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $fotoSiswa = $pendaftaran?->berkas->firstWhere('jenis', 'foto');
    $butuhFoto = $pendaftaran && !$fotoSiswa;
?>




<?php if($butuhFoto): ?>
    <div x-data="{ show: true }" x-show="show" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden">
            <div class="bg-[#d8ae45] px-6 py-5 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white mb-3">
                    <i data-lucide="camera" class="h-8 w-8 text-[#0d4a36]"></i>
                </div>
                <h3 class="display-font text-xl font-bold text-[#073528]">Foto Siswa Belum Diupload</h3>
                <p class="mt-1 text-sm text-[#5c4818]">Diperlukan untuk melengkapi data pendaftaran</p>
            </div>
            <div class="px-6 py-5">
                <p class="text-sm text-[#244535] leading-6">
                    Anda sudah terdaftar, tetapi <strong>foto siswa belum diupload</strong>.
                    Foto ini diperlukan untuk kartu ujian dan berkas pendaftaran.
                </p>
                <p class="mt-2 text-sm text-[#244535] leading-6">
                    Silakan upload foto formal terbaru (JPG/PNG, maks 2MB).
                </p>
            </div>
            <div class="px-6 py-4 bg-[#f8faf5] border-t border-[#e1e9da]">
                <a href="#upload-foto"
                   @click="show = false; setTimeout(() => document.getElementById('upload-foto')?.scrollIntoView({behavior: 'smooth'}), 100)"
                   class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-3 font-bold text-white hover:bg-[#176346] transition">
                    <i data-lucide="upload" class="h-4 w-4"></i>
                    Upload Foto Sekarang
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>




<div class="rounded-2xl bg-[#0d4a36] text-white p-5 sm:p-6 shadow-lg mb-5">
    <div class="flex items-center gap-4">
        <?php if($fotoSiswa): ?>
            <img src="<?php echo e(asset('storage/' . $fotoSiswa->file_path)); ?>"
                 alt="Foto <?php echo e($user->name); ?>"
                 class="h-14 w-14 sm:h-16 sm:w-16 shrink-0 rounded-full object-cover border-2 border-[#d8ae45] bg-white">
        <?php else: ?>
            <div class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-full bg-[#d8ae45] text-xl sm:text-2xl font-bold text-[#073528]">
                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

            </div>
        <?php endif; ?>
        <div class="min-w-0">
            <p class="text-xs font-bold uppercase tracking-[.14em] text-[#e9d28b]">Selamat datang,</p>
            <h1 class="display-font mt-1 text-xl sm:text-2xl font-bold truncate"><?php echo e($user->name); ?></h1>
            <p class="text-xs text-[#d6e3d0] mt-0.5 truncate"><?php echo e($user->email); ?></p>
        </div>
    </div>
</div>

<?php if($pendaftaran): ?>

    
    
    
    <div class="rounded-2xl bg-white border border-[#dce6d3] p-5 sm:p-6 shadow-sm mb-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#699944]">Nomor Pendaftaran</p>
                <p class="display-font mt-1 text-2xl sm:text-3xl font-bold text-[#0d4a36] tracking-wide break-all">
                    <?php echo e($pendaftaran->nomor_pendaftaran); ?>

                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="status-chip status-neutral"><?php echo e($pendaftaran->jenjang->nama); ?></span>
                <span class="status-chip status-neutral"><?php echo e($pendaftaran->gelombang?->nama ?? '—'); ?></span>
            </div>
        </div>
    </div>

    
    
    
    <?php
        $pembayaran = $pendaftaran->pembayaran;
        $statusBayar = $pembayaran?->status ?? 'Belum Bayar';
        $jumlahBayar = $pembayaran?->jumlah ?? $pendaftaran->gelombang?->biaya ?? 0;

        $cardConfig = match($statusBayar) {
            'Terverifikasi' => [
                'bg'        => 'bg-green-100',
                'border'    => 'border-green-400',
                'icon_bg'   => 'bg-green-600',
                'icon'      => 'check-circle-2',
                'icon_fg'   => 'text-white',
                'eyebrow'   => 'text-green-700',
                'title'     => 'text-green-900',
                'desc'      => 'text-green-800',
                'chip_bg'   => 'bg-green-600',
                'chip_text' => 'text-white',
                'cta_bg'    => 'bg-green-700',
                'cta_hover' => 'hover:bg-green-800',
                'cta_text'  => 'Lihat Detail Pembayaran',
                'cta_icon'  => 'arrow-right',
                'headline'  => 'Pembayaran Berhasil',
                'message'   => 'Pembayaran Anda sudah diverifikasi. Lanjutkan proses berikutnya.',
            ],
            'Menunggu Verifikasi' => [
                'bg'        => 'bg-amber-100',
                'border'    => 'border-amber-400',
                'icon_bg'   => 'bg-amber-500',
                'icon'      => 'clock',
                'icon_fg'   => 'text-white',
                'eyebrow'   => 'text-amber-700',
                'title'     => 'text-amber-900',
                'desc'      => 'text-amber-800',
                'chip_bg'   => 'bg-amber-500',
                'chip_text' => 'text-white',
                'cta_bg'    => 'bg-amber-600',
                'cta_hover' => 'hover:bg-amber-700',
                'cta_text'  => 'Lihat Status',
                'cta_icon'  => 'arrow-right',
                'headline'  => 'Menunggu Verifikasi',
                'message'   => 'Bukti bayar Anda sedang diverifikasi admin. Tunggu maks 1×24 jam.',
            ],
            'Gagal' => [
                'bg'        => 'bg-red-100',
                'border'    => 'border-red-400',
                'icon_bg'   => 'bg-red-600',
                'icon'      => 'alert-circle',
                'icon_fg'   => 'text-white',
                'eyebrow'   => 'text-red-700',
                'title'     => 'text-red-900',
                'desc'      => 'text-red-800',
                'chip_bg'   => 'bg-red-600',
                'chip_text' => 'text-white',
                'cta_bg'    => 'bg-red-600',
                'cta_hover' => 'hover:bg-red-700',
                'cta_text'  => 'Upload Ulang Bukti',
                'cta_icon'  => 'upload',
                'headline'  => 'Pembayaran Ditolak',
                'message'   => 'Bukti bayar ditolak admin. Silakan periksa dan upload ulang.',
            ],
            default => [
                'bg'        => 'bg-slate-100',
                'border'    => 'border-slate-300',
                'icon_bg'   => 'bg-slate-500',
                'icon'      => 'wallet',
                'icon_fg'   => 'text-white',
                'eyebrow'   => 'text-slate-600',
                'title'     => 'text-slate-900',
                'desc'      => 'text-slate-700',
                'chip_bg'   => 'bg-slate-500',
                'chip_text' => 'text-white',
                'cta_bg'    => 'bg-[#0d4a36]',
                'cta_hover' => 'hover:bg-[#176346]',
                'cta_text'  => 'Bayar Sekarang',
                'cta_icon'  => 'arrow-right',
                'headline'  => 'Segera Lakukan Pembayaran',
                'message'   => 'Selesaikan pembayaran biaya pendaftaran untuk melanjutkan proses.',
            ],
        };
    ?>

    <a href="<?php echo e(route('student.pembayaran.index')); ?>"
       class="block rounded-2xl <?php echo e($cardConfig['bg']); ?> border <?php echo e($cardConfig['border']); ?> p-5 sm:p-6 shadow-sm mb-5 hover:shadow-md hover:-translate-y-0.5 transition-all">
        <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full <?php echo e($cardConfig['icon_bg']); ?>">
                    <i data-lucide="<?php echo e($cardConfig['icon']); ?>" class="h-6 w-6 <?php echo e($cardConfig['icon_fg']); ?>"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-[.14em] <?php echo e($cardConfig['eyebrow']); ?>">
                        Pembayaran Pendaftaran
                    </p>
                    <p class="display-font mt-0.5 text-lg sm:text-xl font-bold <?php echo e($cardConfig['title']); ?>">
                        <?php echo e($cardConfig['headline']); ?>

                    </p>
                </div>
            </div>
            <span class="inline-flex items-center rounded-full bg-white/70 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide <?php echo e($cardConfig['eyebrow']); ?>">
                <?php echo e($statusBayar); ?>

            </span>
        </div>

        <p class="text-sm leading-6 <?php echo e($cardConfig['desc']); ?> mb-4">
            <?php echo e($cardConfig['message']); ?>

        </p>

        <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t <?php echo e($cardConfig['border']); ?>">
            <div>
                <p class="text-[10px] uppercase tracking-wide <?php echo e($cardConfig['eyebrow']); ?>">Total Tagihan</p>
                <p class="display-font text-xl font-bold <?php echo e($cardConfig['title']); ?>">
                    Rp<?php echo e(number_format($jumlahBayar, 0, ',', '.')); ?>

                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-lg <?php echo e($cardConfig['cta_bg']); ?> <?php echo e($cardConfig['cta_hover']); ?> px-4 py-2 text-xs font-bold text-white shadow-md transition">
                <?php echo e($cardConfig['cta_text']); ?>

                <i data-lucide="<?php echo e($cardConfig['cta_icon']); ?>" class="h-3.5 w-3.5"></i>
            </span>
        </div>
    </a>

    
    
    
    <?php
        $pembayaranLunas     = $statusBayar === 'Terverifikasi';
        $verifikasiSelesai   = $pendaftaran->status_verifikasi === 'Terverifikasi';
        $ujianSelesai        = $pendaftaran->status_ujian === 'Sudah Ujian';
        $kelulusanLulus      = $pendaftaran->status_kelulusan === 'Lulus';

        $verifikasiAktif  = $pembayaranLunas;
        $ujianAktif       = $verifikasiSelesai;
        $kelulusanAktif   = $ujianSelesai;
        $daftarUlangAktif = $kelulusanLulus;
    ?>

    <h2 class="display-font text-lg sm:text-xl font-bold text-[#0d4a36] mb-3">Status Pendaftaran</h2>

    <div class="grid gap-4 grid-cols-2 lg:grid-cols-4 mb-5">
        
        <?php if($verifikasiAktif): ?>
            <?php
                $clsVerif = match($pendaftaran->status_verifikasi) {
                    'Terverifikasi'   => 'status-success',
                    'Perlu Perbaikan' => 'status-danger',
                    default           => 'status-pending',
                };
            ?>
            <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Verifikasi</p>
                    <i data-lucide="file-check" class="h-4 w-4 text-[#5d9f3f]"></i>
                </div>
                <span class="status-chip <?php echo e($clsVerif); ?>"><?php echo e($pendaftaran->status_verifikasi); ?></span>
                <?php if($pendaftaran->catatan_verifikasi): ?>
                    <p class="mt-2 text-xs text-[#963d21] leading-5"><?php echo e($pendaftaran->catatan_verifikasi); ?></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="rounded-2xl bg-[#f8fafc] border border-dashed border-[#cbd5e1] p-4 sm:p-5 opacity-60">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-[.1em] text-[#94a3b8]">Verifikasi</p>
                    <i data-lucide="lock" class="h-4 w-4 text-[#94a3b8]"></i>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-[#e2e8f0] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#64748b]">
                    Terkunci
                </span>
                <p class="mt-2 text-xs text-[#94a3b8] leading-5">Menunggu pembayaran terverifikasi</p>
            </div>
        <?php endif; ?>

        
        <?php if($ujianAktif): ?>
            <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Ujian</p>
                    <i data-lucide="clipboard-list" class="h-4 w-4 text-[#5d9f3f]"></i>
                </div>
                <span class="status-chip status-neutral"><?php echo e($pendaftaran->status_ujian); ?></span>
                <?php if($pendaftaran->tanggal_ujian): ?>
                    <p class="mt-2 text-xs text-[#617064]">
                        <i data-lucide="calendar" class="inline h-3 w-3"></i>
                        <?php echo e($pendaftaran->tanggal_ujian->isoFormat('D MMMM Y')); ?>

                    </p>
                <?php endif; ?>
                <?php if($pendaftaran->nilai_ujian): ?>
                    <p class="mt-2 text-xs font-bold text-[#0d4a36]">Nilai: <?php echo e($pendaftaran->nilai_ujian); ?></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="rounded-2xl bg-[#f8fafc] border border-dashed border-[#cbd5e1] p-4 sm:p-5 opacity-60">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-[.1em] text-[#94a3b8]">Ujian</p>
                    <i data-lucide="lock" class="h-4 w-4 text-[#94a3b8]"></i>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-[#e2e8f0] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#64748b]">
                    Terkunci
                </span>
                <p class="mt-2 text-xs text-[#94a3b8] leading-5">Menunggu verifikasi berkas</p>
            </div>
        <?php endif; ?>

        
        <?php if($kelulusanAktif): ?>
            <?php
                $clsLulus = match($pendaftaran->status_kelulusan) {
                    'Lulus'       => 'status-success',
                    'Tidak Lulus' => 'status-danger',
                    default       => 'status-pending',
                };
            ?>
            <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Kelulusan</p>
                    <i data-lucide="award" class="h-4 w-4 text-[#d8ae45]"></i>
                </div>
                <span class="status-chip <?php echo e($clsLulus); ?>"><?php echo e($pendaftaran->status_kelulusan); ?></span>
            </div>
        <?php else: ?>
            <div class="rounded-2xl bg-[#f8fafc] border border-dashed border-[#cbd5e1] p-4 sm:p-5 opacity-60">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-[.1em] text-[#94a3b8]">Kelulusan</p>
                    <i data-lucide="lock" class="h-4 w-4 text-[#94a3b8]"></i>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-[#e2e8f0] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#64748b]">
                    Terkunci
                </span>
                <p class="mt-2 text-xs text-[#94a3b8] leading-5">Menunggu ujian selesai</p>
            </div>
        <?php endif; ?>

        
        <?php if($daftarUlangAktif): ?>
            <?php
                $clsDaftar = match($pendaftaran->status_daftar_ulang) {
                    'Sudah Daftar Ulang' => 'status-success',
                    'Belum Daftar Ulang' => 'status-danger',
                    default              => 'status-neutral',
                };
            ?>
            <div class="rounded-2xl bg-white border border-[#dce6d3] p-4 sm:p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-[.1em] text-[#617064]">Daftar Ulang</p>
                    <i data-lucide="user-check" class="h-4 w-4 text-[#5d9f3f]"></i>
                </div>
                <span class="status-chip <?php echo e($clsDaftar); ?>"><?php echo e($pendaftaran->status_daftar_ulang); ?></span>
                <?php if($pendaftaran->tanggal_daftar_ulang): ?>
                    <p class="mt-2 text-xs text-[#617064]">
                        <i data-lucide="calendar" class="inline h-3 w-3"></i>
                        <?php echo e($pendaftaran->tanggal_daftar_ulang->isoFormat('D MMMM Y')); ?>

                    </p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="rounded-2xl bg-[#f8fafc] border border-dashed border-[#cbd5e1] p-4 sm:p-5 opacity-60">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase tracking-[.1em] text-[#94a3b8]">Daftar Ulang</p>
                    <i data-lucide="lock" class="h-4 w-4 text-[#94a3b8]"></i>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-[#e2e8f0] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#64748b]">
                    Terkunci
                </span>
                <p class="mt-2 text-xs text-[#94a3b8] leading-5">Menunggu kelulusan</p>
            </div>
        <?php endif; ?>
    </div>

    
    
    
    <?php if(in_array($pendaftaran->status_ujian, ['Terjadwal', 'Sudah Ujian'])): ?>
        <div class="rounded-2xl border border-[#d8ae45] bg-[#fff8dd] p-5 sm:p-6 mb-5">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#d8ae45]">
                    <i data-lucide="file-text" class="h-6 w-6 text-[#073528]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="display-font text-lg font-bold text-[#0d4a36]">Kartu Ujian Tersedia</p>
                    <p class="mt-1 text-sm text-[#617064] leading-6">
                        <?php if($pendaftaran->tanggal_ujian): ?>
                            Jadwal ujian Anda: <strong><?php echo e($pendaftaran->tanggal_ujian->isoFormat('dddd, D MMMM Y')); ?></strong>.
                        <?php endif; ?>
                        Silakan download kartu ujian dan bawa saat ujian seleksi.
                    </p>
                </div>
                <a href="<?php echo e(route('student.kartu.download')); ?>"
                   class="inline-flex w-full sm:w-auto justify-center items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] transition shrink-0">
                    <i data-lucide="download" class="h-4 w-4"></i>
                    Download Kartu Ujian
                </a>
            </div>
        </div>
    <?php endif; ?>

    
    
    
    <?php if($pendaftaran->status_kelulusan === 'Lulus'
         && $pendaftaran->status_daftar_ulang === 'Belum Daftar Ulang'
         && $pendaftaran->link_daftar_ulang): ?>
        <div class="rounded-2xl border-2 border-dashed border-[#b9dca8] bg-[#e8f4df] p-5 sm:p-6 mb-5">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#0d4a36]">
                    <i data-lucide="clipboard-check" class="h-6 w-6 text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="display-font text-lg sm:text-xl font-bold text-[#175b31]">
                        Selamat! Anda dinyatakan <span class="text-[#0d4a36]">LULUS</span>
                    </p>
                    <p class="mt-1 text-sm text-[#175b31] leading-6">
                        Silakan lanjutkan proses daftar ulang dengan mengklik tombol di bawah.
                    </p>
                    <a href="<?php echo e($pendaftaran->link_daftar_ulang); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="mt-3 inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] transition">
                        <span>Lanjut Daftar Ulang</span>
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    
    
    <h2 class="display-font text-lg sm:text-xl font-bold text-[#0d4a36] mb-3">Data Pendaftaran</h2>

    <div class="rounded-2xl bg-white border border-[#dce6d3] p-5 sm:p-6 shadow-sm mb-5">

        
        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-[#e1e9da]">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0d4a36]">
                <i data-lucide="id-card" class="h-5 w-5 text-[#d8ae45]"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-[.14em] text-[#699944]">Kartu Identitas</p>
                <p class="display-font text-base sm:text-lg font-bold text-[#0d4a36]">Data Pendaftaran Santri</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-5 sm:gap-6">

            
            <div class="shrink-0 mx-auto md:mx-0">
                <?php if($fotoSiswa): ?>
                    <a href="<?php echo e(asset('storage/' . $fotoSiswa->file_path)); ?>"
                    target="_blank"
                    class="block group">
                        <div class="relative rounded-xl border-2 border-[#dce6d3] bg-[#f8faf5] p-1.5 group-hover:border-[#5d9f3f] group-hover:shadow-md transition">
                            <img src="<?php echo e(asset('storage/' . $fotoSiswa->file_path)); ?>"
                                alt="Foto <?php echo e($pendaftaran->nama_lengkap); ?>"
                                class="h-40 w-32 sm:h-44 sm:w-36 rounded-lg object-cover">
                            <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full px-2 py-0.5 text-[9px] font-bold uppercase tracking-wide shadow-sm
                                <?php echo e($fotoSiswa->verified
                                    ? 'bg-green-600 text-white'
                                    : 'bg-[#fff2ca] text-[#805500] border border-[#f0e0a8]'); ?>">
                                <?php echo e($fotoSiswa->verified ? '✓ Terverifikasi' : 'Belum Verifikasi'); ?>

                            </span>
                        </div>
                    </a>
                    <p class="mt-3 text-center text-[10px] text-[#617064] truncate max-w-[130px] mx-auto"
                    title="<?php echo e($fotoSiswa->nama_asli); ?>">
                        <?php echo e(Str::limit($fotoSiswa->nama_asli, 20)); ?>

                    </p>
                <?php else: ?>
                    <div class="flex h-44 w-36 flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#d6dccf] bg-[#f8faf5]">
                        <i data-lucide="user" class="h-8 w-8 text-[#d6dccf]"></i>
                        <p class="mt-1 text-[10px] text-[#94a3b8]">Belum ada foto</p>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="flex-1 min-w-0 space-y-2">

                
                <div class="rounded-lg bg-[#0d4a36] p-3 shadow-sm">
                    <div class="flex items-center gap-1.5 mb-0.5">
                        <i data-lucide="user" class="h-3 w-3 text-[#e9d28b]"></i>
                        <p class="text-[9px] font-bold uppercase tracking-[.14em] text-[#e9d28b]">Nama Lengkap</p>
                    </div>
                    <p class="display-font text-base sm:text-lg font-bold text-white break-words"><?php echo e($pendaftaran->nama_lengkap); ?></p>
                </div>

                
                <div class="grid gap-2 sm:grid-cols-2">

                    
                    <div class="rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="id-card" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">NISN</p>
                        </div>
                        <p class="font-mono text-xs font-bold text-[#0d4a36] break-all"><?php echo e($pendaftaran->nisn); ?></p>
                    </div>

                    
                    <div class="rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="users" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">Jenis Kelamin</p>
                        </div>
                        <p class="text-xs font-semibold text-[#244535]"><?php echo e($pendaftaran->jenis_kelamin); ?></p>
                    </div>

                    
                    <div class="sm:col-span-2 rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="calendar" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">Tempat, Tanggal Lahir</p>
                        </div>
                        <p class="text-xs font-semibold text-[#244535]">
                            <?php echo e($pendaftaran->tempat_lahir); ?>,
                            <span class="text-[#0d4a36]"><?php echo e($pendaftaran->tanggal_lahir?->isoFormat('D MMMM Y')); ?></span>
                        </p>
                    </div>

                    
                    <div class="rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="graduation-cap" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">Asal Sekolah</p>
                        </div>
                        <p class="text-xs font-semibold text-[#244535]"><?php echo e($pendaftaran->asal_sekolah); ?></p>
                    </div>

                    
                    <div class="rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="user-check" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">Nama Ayah</p>
                        </div>
                        <p class="text-xs font-semibold text-[#244535]"><?php echo e($pendaftaran->nama_ayah ?: '—'); ?></p>
                    </div>

                    
                    <div class="rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="heart" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">Nama Ibu</p>
                        </div>
                        <p class="text-xs font-semibold text-[#244535]"><?php echo e($pendaftaran->nama_ibu ?: '—'); ?></p>
                    </div>

                    
                    <div class="rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="phone" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">No. WhatsApp</p>
                        </div>
                        <p class="font-mono text-xs font-semibold text-[#244535]"><?php echo e($pendaftaran->no_whatsapp); ?></p>
                    </div>

                    
                    <div class="sm:col-span-2 rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="mail" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">Email</p>
                        </div>
                        <p class="font-mono text-xs font-semibold text-[#244535] break-all"><?php echo e($pendaftaran->email ?? '—'); ?></p>
                    </div>

                    
                    <div class="sm:col-span-2 rounded-lg bg-[#f8faf5] border border-[#e1e9da] p-2.5 hover:border-[#5d9f3f] hover:shadow-sm transition group">
                        <div class="flex items-center gap-1 mb-0.5">
                            <i data-lucide="map-pin" class="h-3 w-3 text-[#699944] group-hover:text-[#0d4a36] transition"></i>
                            <p class="text-[9px] font-bold uppercase tracking-[.1em] text-[#617064]">Alamat Lengkap</p>
                        </div>
                        <p class="text-xs font-semibold text-[#244535] leading-5"><?php echo e($pendaftaran->alamat); ?></p>
                    </div>

                </div>
            </div>
        </div>

        
        
        
        <div id="upload-foto" class="mt-6 pt-6 border-t border-[#e1e9da]">
            <div class="flex items-center gap-2 mb-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0d4a36]">
                    <i data-lucide="camera" class="h-4 w-4 text-white"></i>
                </div>
                <h3 class="display-font text-base font-bold text-[#0d4a36]">
                    <?php echo e($fotoSiswa ? 'Ganti Foto Siswa' : 'Upload Foto Siswa'); ?>

                </h3>
            </div>

            <?php if(session('success')): ?>
                <div class="mb-3 rounded-lg bg-green-50 border border-green-300 px-4 py-3 text-sm text-green-800">
                    <i data-lucide="check-circle-2" class="inline h-4 w-4 mr-1"></i>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-3 rounded-lg bg-red-50 border border-red-300 px-4 py-3 text-sm text-red-800">
                    <i data-lucide="alert-circle" class="inline h-4 w-4 mr-1"></i>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-3 rounded-lg bg-red-50 border border-red-300 px-4 py-3 text-sm text-red-800">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p>• <?php echo e($err); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <div x-data="{
                previewUrl: null,
                fileName: '',
                handleFile(e) {
                    const file = e.target.files[0];
                    if (!file) { this.previewUrl = null; this.fileName = ''; return; }
                    this.fileName = file.name;
                    const reader = new FileReader();
                    reader.onload = (ev) => { this.previewUrl = ev.target.result; };
                    reader.readAsDataURL(file);
                },
                resetFile() {
                    this.previewUrl = null;
                    this.fileName = '';
                    this.$refs.fotoInput.value = '';
                }
            }">
                <form method="POST" action="<?php echo e(route('student.dashboard.upload-foto')); ?>"
                    enctype="multipart/form-data" class="space-y-3">
                    <?php echo csrf_field(); ?>

                    <input type="file" name="foto" required
                        accept=".jpg,.jpeg,.png"
                        x-ref="fotoInput"
                        @change="handleFile($event)"
                        class="field-control text-sm">

                    <p class="text-xs text-[#69786e]">
                        Format JPG / JPEG / PNG. Maks 2MB. Gunakan foto formal terbaru.
                    </p>

                    <div x-show="previewUrl" x-cloak x-transition class="mt-2">
                        <p class="text-xs font-bold text-[#244535] mb-1">Preview:</p>
                        <div class="relative inline-block rounded-lg border-2 border-[#dce6d3] bg-[#f8faf5] p-1.5">
                            <img :src="previewUrl" alt="Preview foto"
                                class="max-h-48 w-auto rounded object-contain">
                            <button type="button" @click="resetFile()"
                                    class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-600 text-white shadow-md hover:bg-red-700">
                                <i data-lucide="x" class="h-3.5 w-3.5"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-[#617064]" x-text="fileName"></p>
                    </div>

                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] transition">
                        <i data-lucide="upload" class="h-4 w-4"></i>
                        <?php echo e($fotoSiswa ? 'Ganti Foto' : 'Upload Foto'); ?>

                    </button>
                </form>
            </div>
        </div>

    </div>

<?php else: ?>

    
    
    
    <div class="rounded-2xl border-2 border-dashed border-[#d6dccf] bg-white p-8 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#fff2ca] mb-4">
            <i data-lucide="alert-circle" class="h-8 w-8 text-[#805500]"></i>
        </div>
        <h2 class="display-font text-xl font-bold text-[#0d4a36]">Anda Belum Mendaftar</h2>
        <p class="mt-2 text-sm text-[#617064] max-w-md mx-auto">
            Akun Anda belum terhubung dengan data pendaftaran. Silakan isi formulir SPMB terlebih dahulu.
        </p>
        <a href="<?php echo e(route('student.pendaftaran.create')); ?>"
        class="mt-5 inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-3 font-bold text-white hover:bg-[#176346]">
            <i data-lucide="edit-3" class="h-4 w-4"></i>
            Isi Formulir Pendaftaran
        </a>
    </div>

<?php endif; ?>




<?php if($pengumuman->isNotEmpty()): ?>
    <h2 class="display-font text-lg sm:text-xl font-bold text-[#0d4a36] mb-3 mt-8">
        <i data-lucide="megaphone" class="inline h-5 w-5"></i>
        Pengumuman
    </h2>

    <div class="space-y-3">
        <?php $__currentLoopData = $pengumuman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="rounded-2xl bg-white border border-[#dce6d3] p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <h3 class="font-bold text-[#0d4a36]"><?php echo e($p->judul); ?></h3>
                    <span class="text-xs text-[#617064] whitespace-nowrap shrink-0">
                        <?php echo e($p->published_at?->isoFormat('D MMM Y')); ?>

                    </span>
                </div>
                <p class="text-sm text-[#536057] leading-6 whitespace-pre-line"><?php echo e($p->isi); ?></p>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/student/dashboard.blade.php ENDPATH**/ ?>