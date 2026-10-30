@extends('layouts.admin')

@section('title', 'Pembayaran')
@section('page-title', 'Data Pembayaran')
@section('page-subtitle', 'Kelola verifikasi pembayaran pendaftar')

@section('content')

{{-- ============================================ --}}
{{-- STATS CARDS --}}
{{-- ============================================ --}}
<div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5 mb-5">
    @php
        $cards = [
            ['label' => 'Total Pendaftar',    'value' => $stats['total'],         'color' => 'bg-[#edf1ec] text-[#42604c]', 'icon' => 'users'],
            ['label' => 'Belum Bayar',        'value' => $stats['belum_bayar'],   'color' => 'bg-[#edf1ec] text-[#42604c]', 'icon' => 'circle-dashed'],
            ['label' => 'Menunggu Verifikasi','value' => $stats['menunggu'],      'color' => 'bg-[#fff2ca] text-[#805500]', 'icon' => 'clock'],
            ['label' => 'Terverifikasi',      'value' => $stats['terverifikasi'], 'color' => 'bg-[#e8f4df] text-[#175b31]', 'icon' => 'check-circle'],
            ['label' => 'Gagal',              'value' => $stats['gagal'],         'color' => 'bg-[#fff0ea] text-[#963d21]', 'icon' => 'x-circle'],
        ];
    @endphp

    @foreach ($cards as $c)
        <div class="rounded-xl border border-[#e1e9da] bg-white p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $c['color'] }}">
                    <i data-lucide="{{ $c['icon'] }}" class="h-4 w-4"></i>
                </div>
                <div>
                    <p class="text-xs text-[#617064]">{{ $c['label'] }}</p>
                    <p class="text-lg font-bold text-[#0d4a36]">{{ $c['value'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ============================================ --}}
{{-- FILTER --}}
{{-- ============================================ --}}
<form method="GET" action="{{ route('admin.pembayaran.index') }}"
      class="rounded-2xl border border-[#e1e9da] bg-white p-4 sm:p-5 shadow-sm mb-5">
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label class="mb-1.5 block text-xs font-bold text-[#244535]">Cari</label>
            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Nama, nomor, atau NISN..."
                   class="field-control">
        </div>
        <div>
            <label class="mb-1.5 block text-xs font-bold text-[#244535]">Jenjang</label>
            <select name="jenjang_id" class="field-control">
                <option value="">Semua</option>
                @foreach ($jenjangs as $j)
                    <option value="{{ $j->id }}" @selected(request('jenjang_id') == $j->id)>{{ $j->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status</label>
            <select name="status" class="field-control">
                <option value="">Semua</option>
                @foreach (['Belum Bayar', 'Menunggu Verifikasi', 'Terverifikasi', 'Gagal'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                <i data-lucide="search" class="h-4 w-4"></i>
                Filter
            </button>
            @if (request()->hasAny(['q', 'jenjang_id', 'status']))
                <a href="{{ route('admin.pembayaran.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                    Reset
                </a>
            @endif
        </div>
    </div>
</form>

{{-- ============================================ --}}
{{-- TABLE (DIPISAH PER JENJANG, PAGINATE TERPISAH) --}}
{{-- ============================================ --}}
@forelse ($paginated as $jenjangId => $group)
    @php
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
    @endphp

    <div class="rounded-2xl border {{ $borderCard }} bg-white shadow-sm overflow-hidden mb-5">
        {{-- Header Jenjang --}}
        <div class="{{ $bgHeader }} px-5 py-3 border-b {{ $borderCard }} flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <h3 class="display-font text-base font-bold text-[#0d4a36]">{{ $j->nama }}</h3>
                <span class="inline-flex items-center rounded-full {{ $chipColor }} px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide">
                    {{ $items->total() }} pendaftar
                </span>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="admin-table" style="min-width: 1000px;">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Nomor</th>
                        <th class="whitespace-nowrap">Nama</th>
                        <th class="whitespace-nowrap">Gelombang</th>
                        <th class="whitespace-nowrap">Biaya</th>
                        <th class="whitespace-nowrap">Metode</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $p)
                        @php
                            $pembayaran  = $p->pembayaran;
                            $statusBayar = $pembayaran?->status ?? 'Belum Bayar';

                            $jumlah = $pembayaran?->jumlah ?? $p->gelombang?->biaya ?? 0;

                            $buktiPath = $pembayaran?->bukti_path;
                            $ext = $buktiPath ? strtolower(pathinfo($buktiPath, PATHINFO_EXTENSION)) : null;
                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png']);
                            $isPdf = $ext === 'pdf';

                            $bisaDiverifikasi = $pembayaran
                                && in_array($statusBayar, ['Menunggu Verifikasi', 'Gagal'])
                                && $pembayaran->bukti_path;
                        @endphp
                        <tr data-pendaftaran-id="{{ $p->id }}">
                            <td class="font-mono font-bold text-[#0d4a36] whitespace-nowrap">
                                {{ $p->nomor_pendaftaran }}
                            </td>
                            <td class="whitespace-nowrap">
                                <p class="font-semibold text-[#0d4a36]">{{ $p->nama_lengkap }}</p>
                                <p class="text-xs text-[#617064]">{{ $p->jenis_kelamin }}</p>
                            </td>
                            <td class="whitespace-nowrap">
                                <p class="text-sm text-[#244535]">{{ $p->gelombang?->nama ?? '—' }}</p>
                            </td>
                            <td class="font-bold text-[#0d4a36] whitespace-nowrap">
                                Rp{{ number_format($jumlah, 0, ',', '.') }}
                            </td>
                            <td class="whitespace-nowrap">
                                <span class="text-xs text-[#617064]">
                                    {{ $pembayaran?->metode_label ?? '—' }}
                                </span>
                            </td>

                            {{-- KOLOM STATUS --}}
                            <td class="whitespace-nowrap" data-cell="status">
                                @if ($bisaDiverifikasi)
                                    <button type="button"
                                            class="btn-verify inline-flex items-center gap-1.5 rounded-lg bg-[#d8ae45] border-2 border-[#b8902f] px-3 py-1.5 text-xs font-bold text-[#3a2a00] shadow-md hover:bg-[#efd175] hover:shadow-lg hover:-translate-y-0.5 transition-all"
                                            title="{{ $statusBayar === 'Gagal' ? 'Klik untuk verifikasi ulang' : 'Klik untuk verifikasi' }}"
                                            data-id="{{ $p->id }}"
                                            data-nomor="{{ $p->nomor_pendaftaran }}"
                                            data-nama="{{ $p->nama_lengkap }}"
                                            data-jenjang="{{ $p->jenjang->nama }}"
                                            data-gelombang="{{ $p->gelombang?->nama ?? '—' }}"
                                            data-jumlah="{{ number_format($jumlah, 0, ',', '.') }}"
                                            data-metode="{{ $pembayaran?->metode_label ?? '—' }}"
                                            data-status="{{ $statusBayar }}"
                                            data-catatan="{{ $pembayaran?->catatan_admin }}"
                                            data-bukti-url="{{ asset('storage/' . $pembayaran->bukti_path) }}"
                                            data-bukti-nama="{{ $pembayaran->bukti_nama_asli }}"
                                            data-bukti-type="{{ $isImage ? 'image' : ($isPdf ? 'pdf' : 'none') }}"
                                            data-uploaded-at="{{ $pembayaran->uploaded_at?->isoFormat('D MMM Y, HH:mm') }}"
                                            data-verifikasi-url="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}">
                                        <i data-lucide="{{ $statusBayar === 'Gagal' ? 'refresh-cw' : 'shield-check' }}" class="h-3.5 w-3.5"></i>
                                        {{ $statusBayar === 'Gagal' ? 'Verifikasi Ulang' : 'Verifikasi' }}
                                    </button>

                                @elseif ($statusBayar === 'Terverifikasi')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#e8f4df] border-2 border-[#b9dca8] px-3 py-1.5 text-xs font-bold text-[#175b31] cursor-not-allowed"
                                        title="Pembayaran sudah terverifikasi">
                                        <i data-lucide="check-circle" class="h-3.5 w-3.5"></i>
                                        Terverifikasi
                                    </span>

                                @elseif ($statusBayar === 'Belum Bayar')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#edf1ec] border-2 border-[#d6dccf] px-3 py-1.5 text-xs font-bold text-[#617064] cursor-not-allowed"
                                        title="Pendaftar belum upload bukti bayar">
                                        <i data-lucide="clock" class="h-3.5 w-3.5"></i>
                                        Belum Bayar
                                    </span>

                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#fff2ca] border-2 border-[#f0e0a8] px-3 py-1.5 text-xs font-bold text-[#805500] cursor-not-allowed"
                                        title="Menunggu bukti bayar dari pendaftar">
                                        <i data-lucide="clock" class="h-3.5 w-3.5"></i>
                                        Tunggu Upload
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="whitespace-nowrap">
                                <div class="flex items-center justify-end">
                                    <a href="{{ route('admin.pembayaran.show', $p) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-[#0d4a36] border-2 border-[#0d4a36] px-3 py-1.5 text-xs font-bold text-white shadow-md hover:bg-[#176346] hover:border-[#176346] hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                        Detail
                                        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-[#617064]">
                                Tidak ada pendaftar {{ $j->nama }} pada halaman ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination PER jenjang --}}
        @if ($items->hasPages())
            <div class="px-5 py-3 border-t {{ $borderCard }} bg-[#fafcf8]">
                {{ $items->links() }}
            </div>
        @endif

        {{-- Footer count PER jenjang --}}
        <div class="px-5 py-2 text-[10px] text-[#617064] border-t {{ $borderCard }}">
            Menampilkan {{ $items->firstItem() ?? 0 }}–{{ $items->lastItem() ?? 0 }}
            dari {{ $items->total() }} pendaftar {{ $j->nama }}
        </div>
    </div>
@empty
    <div class="rounded-2xl border border-dashed border-[#d6dccf] bg-white p-8 text-center">
        <i data-lucide="inbox" class="mx-auto h-10 w-10 text-[#d6dccf] mb-2"></i>
        <p class="text-sm text-[#617064]">Belum ada data pendaftar.</p>
    </div>
@endforelse

{{-- Keterangan --}}
<p class="mt-3 text-[10px] text-[#617064]">
    <i data-lucide="info" class="inline h-3 w-3"></i>
    Klik status <strong>Menunggu Verifikasi</strong> atau <strong>Gagal</strong> untuk verifikasi cepat.
</p>

{{-- ============================================ --}}
{{-- MODAL VERIFIKASI PEMBAYARAN --}}
{{-- ============================================ --}}
<div id="verify-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-4">
    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl overflow-hidden max-h-[92vh] flex flex-col">

        {{-- Header --}}
        <div class="bg-[#0d4a36] px-5 py-4 text-white flex items-center justify-between shrink-0">
            <div class="min-w-0">
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#e9d28b]">Verifikasi Pembayaran</p>
                <p id="verify-title" class="text-sm font-bold mt-0.5 truncate"></p>
            </div>
            <button type="button" data-close-verify class="p-1.5 rounded-lg hover:bg-white/10 shrink-0">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="flex-1 overflow-y-auto p-5 space-y-5">

            {{-- Info Pendaftar --}}
            <div class="rounded-xl bg-[#f8faf5] border border-[#e1e9da] p-4">
                <p class="text-[10px] font-bold uppercase tracking-wide text-[#617064] mb-2">Info Pendaftar</p>
                <div class="grid gap-2 sm:grid-cols-2 text-sm">
                    <div>
                        <p class="text-xs text-[#617064]">Nomor</p>
                        <p id="verify-nomor" class="font-mono font-bold text-[#0d4a36]"></p>
                    </div>
                    <div>
                        <p class="text-xs text-[#617064]">Nama</p>
                        <p id="verify-nama" class="font-semibold text-[#0d4a36]"></p>
                    </div>
                    <div>
                        <p class="text-xs text-[#617064]">Jenjang</p>
                        <p id="verify-jenjang" class="text-[#244535]"></p>
                    </div>
                    <div>
                        <p class="text-xs text-[#617064]">Gelombang</p>
                        <p id="verify-gelombang" class="text-[#244535]"></p>
                    </div>
                    <div>
                        <p class="text-xs text-[#617064]">Jumlah Tagihan</p>
                        <p class="font-bold text-[#0d4a36]">Rp<span id="verify-jumlah"></span></p>
                    </div>
                    <div>
                        <p class="text-xs text-[#617064]">Metode</p>
                        <p id="verify-metode" class="text-[#244535]"></p>
                    </div>
                </div>
            </div>

            {{-- Bukti Bayar --}}
            <div class="rounded-xl border border-[#e1e9da] p-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10px] font-bold uppercase tracking-wide text-[#617064]">Bukti Bayar</p>
                    <p id="verify-uploaded-at" class="text-[10px] text-[#617064]"></p>
                </div>

                {{-- Container bukti: gambar / pdf / kosong --}}
                <div id="verify-bukti-container"></div>
            </div>

            {{-- Form Verifikasi --}}
            <form id="verify-form" method="POST">
                @csrf
                @method('PATCH')

                <div class="space-y-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Pembayaran</label>
                        <select name="status" id="verify-status" required class="field-control">
                            @foreach (['Belum Bayar', 'Menunggu Verifikasi', 'Terverifikasi', 'Gagal'] as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Catatan (opsional)</label>
                        <textarea name="catatan_admin" id="verify-catatan" rows="2" class="field-control"
                                  placeholder="Contoh: Bukti tidak jelas, mohon upload ulang..."></textarea>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-5 flex flex-col sm:flex-row gap-2 justify-end">
                    <button type="button" data-close-verify
                            class="rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                        <i data-lucide="check" class="h-4 w-4"></i>
                        Simpan Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- TOAST --}}
{{-- ============================================ --}}
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

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    // ============================================
    // TOAST
    // ============================================
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

    // ============================================
    // MODAL VERIFIKASI
    // ============================================
    const verifyModal = document.getElementById('verify-modal');
    const verifyForm = document.getElementById('verify-form');
    const verifyBuktiContainer = document.getElementById('verify-bukti-container');
    let currentRow = null;

    function clsBayar(s) {
        return s === 'Terverifikasi' ? 'status-success'
             : s === 'Gagal' ? 'status-danger'
             : s === 'Menunggu Verifikasi' ? 'status-pending'
             : 'status-neutral';
    }

    function openVerifyModal(btn) {
        currentRow = btn.closest('tr');

        // Isi info
        document.getElementById('verify-title').textContent = btn.dataset.nama + ' — ' + btn.dataset.nomor;
        document.getElementById('verify-nomor').textContent = btn.dataset.nomor;
        document.getElementById('verify-nama').textContent = btn.dataset.nama;
        document.getElementById('verify-jenjang').textContent = btn.dataset.jenjang;
        document.getElementById('verify-gelombang').textContent = btn.dataset.gelombang;
        document.getElementById('verify-jumlah').textContent = btn.dataset.jumlah;
        document.getElementById('verify-metode').textContent = btn.dataset.metode;
        document.getElementById('verify-status').value = btn.dataset.status;
        document.getElementById('verify-catatan').value = btn.dataset.catatan || '';
        document.getElementById('verify-uploaded-at').textContent = btn.dataset.uploadedAt || '';

        // Set action form
        verifyForm.action = btn.dataset.verifikasiUrl;

        // Render bukti bayar
        verifyBuktiContainer.innerHTML = '';
        const tipe = btn.dataset.buktiType;
        const url = btn.dataset.buktiUrl;
        const nama = btn.dataset.buktiNama || 'Bukti';

        if (tipe === 'image' && url) {
            verifyBuktiContainer.innerHTML = `
                <a href="${url}" target="_blank" rel="noopener noreferrer" class="block">
                    <img src="${url}" alt="Bukti Bayar"
                         class="max-w-full max-h-72 mx-auto rounded-lg border border-[#e1e9da] object-contain bg-[#f8faf5] p-1">
                </a>
                <p class="mt-2 text-center text-[10px] text-[#617064]">
                    Klik gambar untuk buka di tab baru
                </p>
            `;
        } else if (tipe === 'pdf' && url) {
            verifyBuktiContainer.innerHTML = `
                <div class="rounded-lg border border-[#e1e9da] bg-[#f8faf5] p-4 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#963d21]">
                        <i data-lucide="file-text" class="h-5 w-5 text-white"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-[#244535] truncate">${nama}</p>
                        <p class="text-xs text-[#617064]">File PDF</p>
                    </div>
                    <a href="${url}" target="_blank" rel="noopener noreferrer"
                       class="rounded-lg bg-[#0d4a36] px-3 py-1.5 text-xs font-bold text-white hover:bg-[#176346] inline-flex items-center gap-1">
                        <i data-lucide="external-link" class="h-3 w-3"></i>
                        Buka PDF
                    </a>
                </div>
            `;
        } else {
            verifyBuktiContainer.innerHTML = `
                <div class="rounded-lg border border-dashed border-[#d6dccf] bg-[#f8faf5] p-5 text-center">
                    <i data-lucide="file-x" class="mx-auto h-7 w-7 text-[#d6dccf] mb-2"></i>
                    <p class="text-sm text-[#617064]">Belum ada bukti bayar.</p>
                </div>
            `;
        }

        verifyModal.classList.remove('hidden');
        verifyModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        if (window.lucide) lucide.createIcons();
    }

    function closeVerifyModal() {
        verifyModal.classList.add('hidden');
        verifyModal.classList.remove('flex');
        document.body.style.overflow = '';
        currentRow = null;
    }

    // ============================================
    // FORM SUBMIT — AJAX
    // ============================================
    verifyForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const submitBtn = verifyForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Menyimpan...';

        try {
            const formData = new FormData(verifyForm);

            const res = await fetch(verifyForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json();

            if (data.success) {
                // Update chip status di row
                if (currentRow) {
                    const newStatus = data.data.status_pembayaran || data.data.status;
                    const statusCell = currentRow.querySelector('[data-cell="status"]');

                    if (statusCell) {
                        // Cek apakah chip baru bisa diverifikasi lagi
                        const bisaDiverifikasiBaru = ['Menunggu Verifikasi', 'Gagal'].includes(newStatus);

                        if (bisaDiverifikasiBaru && statusCell.querySelector('.btn-verify')) {
                            // Chip sudah button, tinggal update class & text
                            const btn = statusCell.querySelector('.btn-verify');
                            btn.className = 'btn-verify status-chip ' + clsBayar(newStatus) + ' hover:shadow-md hover:scale-105 transition cursor-pointer inline-flex items-center gap-1';
                            btn.innerHTML = `<i data-lucide="${newStatus === 'Gagal' ? 'refresh-cw' : 'shield-check'}" class="h-3 w-3"></i> ${newStatus}`;
                            btn.dataset.status = newStatus;
                        } else {
                            // Ganti chip jadi span non-klik
                            const iconName = newStatus === 'Terverifikasi' ? 'check-circle' : 'clock';
                            const title = newStatus === 'Terverifikasi' ? 'Sudah terverifikasi' : 'Menunggu pendaftar upload bukti';

                            statusCell.innerHTML = `
                                <span class="status-chip ${clsBayar(newStatus)} cursor-default inline-flex items-center gap-1" title="${title}">
                                    <i data-lucide="${iconName}" class="h-3 w-3"></i>
                                    ${newStatus}
                                </span>
                            `;
                        }

                        if (window.lucide) lucide.createIcons();
                    }
                }

                showToast(data.message || 'Verifikasi berhasil disimpan', 'success');
                closeVerifyModal();
            } else {
                showToast(data.message || 'Gagal menyimpan', 'error');
            }
        } catch (err) {
            console.error(err);
            showToast('Terjadi kesalahan. Coba lagi.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            if (window.lucide) lucide.createIcons();
        }
    });

    // ============================================
    // DELEGATED CLICKS
    // ============================================
    document.addEventListener('click', function (e) {
        const verifyBtn = e.target.closest('.btn-verify');
        if (verifyBtn) {
            if (!verifyBtn.dataset.verifikasiUrl) {
                // Fallback: redirect ke detail
                window.location.href = verifyBtn.closest('tr').querySelector('a[href*="/pembayaran/"]').href;
                return;
            }
            openVerifyModal(verifyBtn);
            return;
        }

        if (e.target.closest('[data-close-verify]')) { closeVerifyModal(); return; }
        if (e.target.id === 'verify-modal') { closeVerifyModal(); }
    });

    // ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !verifyModal.classList.contains('hidden')) {
            closeVerifyModal();
        }
    });

})();
</script>
@endpush