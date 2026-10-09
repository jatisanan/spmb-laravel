@extends('layouts.admin')

@section('title', 'Data Pendaftaran')
@section('page-title', 'Data Pendaftaran')
@section('page-subtitle', 'Kelola semua pendaftar SPMB Jati Sanan')

@section('content')

{{-- Filter --}}
<form method="GET" action="{{ route('admin.pendaftaran.index') }}"
      class="rounded-2xl border border-[#e1e9da] bg-white p-4 sm:p-5 shadow-sm mb-5">
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
        <div class="sm:col-span-2">
            <label for="q" class="mb-1.5 block text-xs font-bold text-[#244535]">Cari</label>
            <input type="search" name="q" id="q" value="{{ request('q') }}"
                   placeholder="Nama, nomor, NISN, atau WA..."
                   class="field-control">
        </div>

        <div>
            <label for="jenjang_id" class="mb-1.5 block text-xs font-bold text-[#244535]">Jenjang</label>
            <select name="jenjang_id" id="jenjang_id" class="field-control">
                <option value="">Semua</option>
                @foreach ($jenjangs as $j)
                    <option value="{{ $j->id }}" @selected(request('jenjang_id') == $j->id)>{{ $j->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status_verifikasi" class="mb-1.5 block text-xs font-bold text-[#244535]">Verifikasi</label>
            <select name="status_verifikasi" id="status_verifikasi" class="field-control">
                <option value="">Semua</option>
                @foreach (['Menunggu Verifikasi', 'Terverifikasi', 'Perlu Perbaikan'] as $s)
                    <option value="{{ $s }}" @selected(request('status_verifikasi') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status_kelulusan" class="mb-1.5 block text-xs font-bold text-[#244535]">Kelulusan</label>
            <select name="status_kelulusan" id="status_kelulusan" class="field-control">
                <option value="">Semua</option>
                @foreach (['Menunggu Hasil', 'Lulus', 'Tidak Lulus'] as $s)
                    <option value="{{ $s }}" @selected(request('status_kelulusan') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-4 flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-2 sm:gap-3">
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] w-full sm:w-auto">
            <i data-lucide="search" class="h-4 w-4"></i>
            Terapkan Filter
        </button>

        @if (request()->hasAny(['q', 'jenjang_id', 'status_verifikasi', 'status_kelulusan']))
            <a href="{{ route('admin.pendaftaran.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee] w-full sm:w-auto">
                <i data-lucide="x" class="h-4 w-4"></i>
                Reset
            </a>
        @endif

        <a href="{{ route('admin.pendaftaran.export', request()->query()) }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#0d4a36] px-4 py-2 text-sm font-bold text-[#0d4a36] hover:bg-[#f4f8ee] w-full sm:w-auto sm:ml-auto">
            <i data-lucide="download" class="h-4 w-4"></i>
            Export CSV
        </a>
    </div>
</form>

{{-- Table --}}
<div class="rounded-2xl border border-[#e1e9da] bg-white shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table" style="min-width: 1100px;">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>Jenjang</th>
                    <th>Verifikasi</th>
                    <th>Ujian</th>
                    <th>Kelulusan</th>
                    <th>Daftar Ulang</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendaftarans as $p)
                    <tr>
                        <td class="font-mono font-bold text-[#0d4a36]">{{ $p->nomor_pendaftaran }}</td>
                        <td>
                            <p class="font-semibold text-[#0d4a36]">{{ $p->nama_lengkap }}</p>
                            <p class="text-xs text-[#617064]">{{ $p->jenis_kelamin }}</p>
                        </td>
                        <td class="font-mono">{{ $p->nisn }}</td>
                        <td>{{ $p->jenjang->nama }}</td>
                        <td>
                            @php
                                $cls = match($p->status_verifikasi) {
                                    'Terverifikasi' => 'status-success',
                                    'Perlu Perbaikan' => 'status-danger',
                                    default => 'status-pending',
                                };
                            @endphp
                            <span class="status-chip {{ $cls }}">{{ $p->status_verifikasi }}</span>
                        </td>
                        <td>
                            @if ($p->nilai_ujian)
                                <span class="font-bold text-[#0d4a36]">{{ $p->nilai_ujian }}</span>
                            @else
                                <span class="text-xs text-[#617064]">{{ $p->status_ujian }}</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $cls = match($p->status_kelulusan) {
                                    'Lulus' => 'status-success',
                                    'Tidak Lulus' => 'status-danger',
                                    default => 'status-pending',
                                };
                            @endphp
                            <span class="status-chip {{ $cls }}">{{ $p->status_kelulusan }}</span>
                        </td>
                        <td>
                            @php
                                $cls = match($p->status_daftar_ulang) {
                                    'Sudah Daftar Ulang' => 'status-success',
                                    'Belum Daftar Ulang' => 'status-danger',
                                    default => 'status-neutral',
                                };
                            @endphp
                            <span class="status-chip {{ $cls }}">{{ $p->status_daftar_ulang }}</span>
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.pendaftaran.show', $p) }}"
                                class="inline-flex items-center gap-1 rounded-lg bg-[#0d4a36] px-3 py-1.5 text-xs font-bold text-white hover:bg-[#176346]"
                                title="Detail">
                                    Detail
                                    <i data-lucide="arrow-right" class="h-3 w-3"></i>
                                </a>

                                <a href="{{ route('admin.pendaftaran.edit', $p) }}"
                                class="inline-flex items-center justify-center rounded-lg border border-[#d6dccf] p-1.5 text-[#0d4a36] hover:bg-[#f4f8ee]"
                                title="Edit">
                                    <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                </a>

                                <button type="button"
                                        class="btn-delete inline-flex items-center justify-center rounded-lg border border-[#f2c1ae] bg-[#fff0ea] p-1.5 text-[#963d21] hover:bg-[#ffe0d1]"
                                        title="Hapus"
                                        data-id="{{ $p->id }}"
                                        data-nomor="{{ $p->nomor_pendaftaran }}"
                                        data-nama="{{ $p->nama_lengkap }}">
                                    <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-10 text-[#617064]">
                            <i data-lucide="inbox" class="mx-auto h-10 w-10 mb-2"></i>
                            Belum ada data pendaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($pendaftarans->hasPages())
        <div class="px-4 sm:px-5 py-4 border-t border-[#e1e9da]">
            {{ $pendaftarans->links() }}
        </div>
    @endif
</div>

<p class="mt-3 text-xs text-[#617064]">
    Menampilkan {{ $pendaftarans->firstItem() ?? 0 }}–{{ $pendaftarans->lastItem() ?? 0 }}
    dari {{ $pendaftarans->total() }} pendaftar
</p>

{{-- ============================================ --}}
{{-- MODAL KONFIRMASI HAPUS --}}
{{-- ============================================ --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">

        <div class="bg-[#fff0ea] px-6 py-5 text-center border-b border-[#f2c1ae]">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#963d21] mb-3">
                <i data-lucide="alert-triangle" class="h-7 w-7 text-white"></i>
            </div>
            <h3 class="display-font text-xl font-bold text-[#963d21]">Hapus Pendaftar?</h3>
            <p class="text-sm text-[#617064] mt-1">Tindakan ini tidak bisa dibatalkan.</p>
        </div>

        <div class="px-6 py-5">
            <div class="rounded-xl bg-[#f8faf5] border border-[#e1e9da] p-4 space-y-2 text-sm">
                <div class="flex justify-between gap-3">
                    <span class="text-[#617064]">Nomor</span>
                    <span id="del-nomor" class="font-mono font-bold text-[#0d4a36] text-right"></span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-[#617064]">Nama</span>
                    <span id="del-nama" class="font-semibold text-[#0d4a36] text-right"></span>
                </div>
            </div>

            <form id="delete-form" method="POST" class="mt-5 flex flex-wrap gap-2 justify-end">
                @csrf
                @method('DELETE')
                <button type="button" data-close-delete
                        class="rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                    Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#963d21] px-4 py-2 text-sm font-bold text-white hover:bg-[#7a2f19]">
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    const delNomor = document.getElementById('del-nomor');
    const delNama = document.getElementById('del-nama');

    // Template route — ganti placeholder __ID__ dengan id pendaftaran
    const deleteUrl = '{{ route("admin.pendaftaran.destroy", ":id") }}';

    function openModal(id, nomor, nama) {
        form.action = deleteUrl.replace(':id', id);
        delNomor.textContent = nomor;
        delNama.textContent = nama;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        if (window.lucide) lucide.createIcons();
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Delegated click: tombol hapus
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete');
        if (btn) {
            openModal(btn.dataset.id, btn.dataset.nomor, btn.dataset.nama);
            return;
        }

        if (e.target.closest('[data-close-delete]')) {
            closeModal();
            return;
        }

        // Klik backdrop
        if (e.target.id === 'delete-modal') {
            closeModal();
        }
    });

    // ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
})();
</script>
@endpush