@extends('layouts.admin')

@section('title', 'Pengumuman')
@section('page-title', 'Pengumuman')
@section('page-subtitle', 'Kelola pengumuman untuk santri dan admin')

@section('content')

<div class="grid gap-5 lg:grid-cols-3">

    {{-- Form Buat Pengumuman --}}
    <div class="lg:col-span-1">
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm sticky top-24">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Buat Pengumuman</h3>

            <form method="POST" action="{{ route('admin.pengumuman.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="judul" class="mb-1.5 block text-xs font-bold text-[#244535]">Judul</label>
                    <input type="text" id="judul" name="judul" required
                           placeholder="Contoh: Jadwal Ujian Gelombang 1"
                           class="field-control" value="{{ old('judul') }}">
                    @error('judul') <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="isi" class="mb-1.5 block text-xs font-bold text-[#244535]">Isi Pengumuman</label>
                    <textarea id="isi" name="isi" rows="5" required class="field-control"
                              placeholder="Tulis isi pengumuman di sini...">{{ old('isi') }}</textarea>
                    @error('isi') <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="target" class="mb-1.5 block text-xs font-bold text-[#244535]">Target</label>
                    <select id="target" name="target" required class="field-control">
                        <option value="semua" @selected(old('target') === 'semua')>Semua (Admin & Santri)</option>
                        <option value="student" @selected(old('target') === 'student')>Santri</option>
                        <option value="admin" @selected(old('target') === 'admin')>Admin</option>
                    </select>
                </div>

                <div>
                    <label for="published_at" class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Publish</label>
                    <input type="datetime-local" id="published_at" name="published_at"
                           value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                           class="field-control">
                    <p class="mt-1 text-xs text-[#617064]">Kosongkan untuk langsung publish.</p>
                </div>

                <div>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="publish" value="1" @checked(old('publish', true))
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

    {{-- List Pengumuman --}}
    <div class="lg:col-span-2 space-y-4">

        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.pengumuman.index') }}"
              class="rounded-2xl border border-[#e1e9da] bg-white p-4 shadow-sm flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[140px]">
                <label for="filter-target" class="mb-1.5 block text-xs font-bold text-[#244535]">Target</label>
                <select name="target" id="filter-target" class="field-control">
                    <option value="">Semua</option>
                    <option value="semua" @selected(request('target') === 'semua')>Semua</option>
                    <option value="student" @selected(request('target') === 'student')>Santri</option>
                    <option value="admin" @selected(request('target') === 'admin')>Admin</option>
                </select>
            </div>

            <div class="flex-1 min-w-[140px]">
                <label for="filter-status" class="mb-1.5 block text-xs font-bold text-[#244535]">Status</label>
                <select name="status" id="filter-status" class="field-control">
                    <option value="">Semua</option>
                    <option value="publish" @selected(request('status') === 'publish')>Published</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                </select>
            </div>

            <button type="submit" class="rounded-lg bg-[#0d4a36] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                Filter
            </button>

            @if (request()->hasAny(['target', 'status']))
                <a href="{{ route('admin.pengumuman.index') }}"
                   class="rounded-lg border border-[#d6dccf] px-4 py-2.5 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                    Reset
                </a>
            @endif
        </form>

        {{-- List --}}
        @forelse ($pengumumen as $p)
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="display-font text-lg font-bold text-[#0d4a36]">{{ $p->judul }}</h3>
                            @if ($p->publish)
                                <span class="status-chip status-success">Published</span>
                            @else
                                <span class="status-chip status-neutral">Draft</span>
                            @endif
                            <span class="status-chip status-pending">{{ ucfirst($p->target) }}</span>
                        </div>
                        <p class="text-xs text-[#617064] mb-3">
                            <i data-lucide="clock" class="inline h-3 w-3"></i>
                            {{ $p->published_at?->isoFormat('D MMMM Y, HH:mm') ?? $p->created_at->isoFormat('D MMMM Y, HH:mm') }}
                        </p>
                        <p class="text-sm text-[#365143] leading-6 whitespace-pre-line">{{ $p->isi }}</p>
                    </div>

                    <div class="flex flex-col items-end gap-2 shrink-0">
                        <form method="POST" action="{{ route('admin.pengumuman.toggle', $p) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="rounded-lg border border-[#d6dccf] px-3 py-1.5 text-xs font-semibold text-[#244535] hover:bg-[#f4f8ee] whitespace-nowrap">
                                {{ $p->publish ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>

                        <button type="button"
                                onclick="document.getElementById('edit-{{ $p->id }}').classList.toggle('hidden')"
                                class="rounded-lg border border-[#0d4a36] px-3 py-1.5 text-xs font-bold text-[#0d4a36] hover:bg-[#f4f8ee]">
                            <i data-lucide="edit-3" class="inline h-3 w-3"></i>
                            Edit
                        </button>

                        <form method="POST" action="{{ route('admin.pengumuman.destroy', $p) }}"
                              onsubmit="return confirm('Hapus pengumuman {{ $p->judul }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="rounded-lg border border-[#f2c1ae] px-3 py-1.5 text-xs font-bold text-[#963d21] hover:bg-[#fff0ea]">
                                <i data-lucide="trash-2" class="inline h-3 w-3"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Form Edit (Hidden) --}}
                <div id="edit-{{ $p->id }}" class="hidden mt-5 pt-5 border-t border-[#e1e9da]">
                    <form method="POST" action="{{ route('admin.pengumuman.update', $p) }}" class="space-y-3">
                        @csrf
                        @method('PATCH')

                        <input type="text" name="judul" value="{{ $p->judul }}" required class="field-control">

                        <textarea name="isi" rows="4" required class="field-control">{{ $p->isi }}</textarea>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <select name="target" required class="field-control">
                                <option value="semua" @selected($p->target === 'semua')>Semua</option>
                                <option value="student" @selected($p->target === 'student')>Santri</option>
                                <option value="admin" @selected($p->target === 'admin')>Admin</option>
                            </select>

                            <input type="datetime-local" name="published_at"
                                   value="{{ $p->published_at?->format('Y-m-d\TH:i') }}"
                                   class="field-control">
                        </div>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="publish" value="1" @checked($p->publish)
                                   class="rounded border-[#d6dccf] text-[#0d4a36] focus:ring-[#5d9f3f]">
                            <span class="text-sm font-bold text-[#244535]">Publish</span>
                        </label>

                        <div class="flex justify-end gap-2">
                            <button type="button"
                                    onclick="document.getElementById('edit-{{ $p->id }}').classList.add('hidden')"
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
        @empty
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-10 text-center shadow-sm">
                <i data-lucide="megaphone" class="mx-auto h-10 w-10 text-[#d6dccf] mb-3"></i>
                <p class="text-[#617064]">Belum ada pengumuman.</p>
            </div>
        @endforelse

        @if ($pengumumen->hasPages())
            <div>{{ $pengumumen->links() }}</div>
        @endif
    </div>
</div>

@endsection