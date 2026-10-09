@extends('layouts.admin')

@section('title', 'Jenjang & Gelombang')
@section('page-title', 'Jenjang & Gelombang')
@section('page-subtitle', 'Kelola jenjang pendidikan dan gelombang pendaftaran')

@section('content')

<div class="space-y-6">
    @foreach ($jenjangs as $j)
        <div class="rounded-2xl border border-[#e1e9da] bg-white shadow-sm overflow-hidden">

            {{-- Header Jenjang --}}
            <div class="p-5 border-b border-[#e1e9da] bg-[#f8fbf5]">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        @if ($j->logo_path)
                            <img src="{{ asset('storage/' . $j->logo_path) }}" alt="Logo" class="h-14 w-14 object-contain rounded-lg bg-white border border-[#e1e9da] p-1">
                        @else
                            <div class="h-14 w-14 rounded-lg bg-[#e8f4df] flex items-center justify-center text-[#5d9f3f]">
                                <i data-lucide="graduation-cap" class="h-7 w-7"></i>
                            </div>
                        @endif
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="display-font text-xl font-bold text-[#0d4a36]">{{ $j->nama }}</h3>
                                @if ($j->aktif)
                                    <span class="status-chip status-success">Aktif</span>
                                @else
                                    <span class="status-chip status-neutral">Nonaktif</span>
                                @endif
                            </div>
                            <p class="text-xs text-[#617064]">{{ $j->label }} · {{ $j->pendaftarans_count }} pendaftar</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.jenjang.toggle', $j) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-lg border border-[#d6dccf] px-3 py-2 text-xs font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                                {{ $j->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.jenjang.edit', $j) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-[#0d4a36] px-3 py-2 text-xs font-bold text-white hover:bg-[#176346]">
                            <i data-lucide="edit-3" class="h-3.5 w-3.5"></i>
                            Edit Jenjang
                        </a>
                    </div>
                </div>
            </div>

            {{-- Gelombang List --}}
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-bold text-[#0d4a36] text-sm">Gelombang Pendaftaran</h4>
                    <button type="button" data-toggle-form="form-gelombang-{{ $j->id }}"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0d4a36] hover:underline">
                        <i data-lucide="plus-circle" class="h-4 w-4"></i>
                        Tambah Gelombang
                    </button>
                </div>

                {{-- Form Tambah (Hidden) --}}
                <div id="form-gelombang-{{ $j->id }}" class="hidden mb-4 rounded-xl border border-[#dce6d3] bg-[#f4f8ee] p-4">
                    <form method="POST" action="{{ route('admin.gelombang.store', $j) }}">
                        @csrf
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
                            <button type="button" data-toggle-form="form-gelombang-{{ $j->id }}"
                                    class="rounded-lg border border-[#d6dccf] px-4 py-2 text-xs font-semibold text-[#244535] hover:bg-white">
                                Batal
                            </button>
                            <button type="submit" class="rounded-lg bg-[#0d4a36] px-4 py-2 text-xs font-bold text-white hover:bg-[#176346]">
                                Simpan Gelombang
                            </button>
                        </div>
                    </form>
                </div>

                {{-- List Gelombang --}}
                @if ($j->gelombang->isEmpty())
                    <p class="text-sm text-[#617064] py-3 text-center">Belum ada gelombang.</p>
                @else
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
                                @foreach ($j->gelombang as $g)
                                    <tr>
                                        <td class="font-semibold text-[#0d4a36]">{{ $g->nama }}</td>
                                        <td>
                                            {{ $g->tanggal_mulai->isoFormat('D MMM Y') }}
                                            – {{ $g->tanggal_selesai->isoFormat('D MMM Y') }}
                                        </td>
                                        <td>{{ $g->tanggal_ujian?->isoFormat('D MMM Y') ?? '—' }}</td>
                                        <td class="font-bold">Rp{{ number_format($g->biaya, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($g->aktif)
                                                <span class="status-chip status-success">Aktif</span>
                                            @else
                                                <span class="status-chip status-neutral">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-1">
                                                <form method="POST" action="{{ route('admin.gelombang.toggle', $g) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-xs text-[#244535] hover:underline">
                                                        {{ $g->aktif ? 'Off' : 'On' }}
                                                    </button>
                                                </form>
                                                <span class="text-[#d6dccf]">·</span>
                                                <form method="POST" action="{{ route('admin.gelombang.destroy', $g) }}"
                                                      onsubmit="return confirm('Hapus gelombang {{ $g->nama }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-[#963d21] hover:underline">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-toggle-form]').forEach(btn => {
    btn.addEventListener('click', () => {
        const target = document.getElementById(btn.dataset.toggleForm);
        if (target) target.classList.toggle('hidden');
    });
});
</script>
@endpush