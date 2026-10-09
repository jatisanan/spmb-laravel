@extends('layouts.admin')

@section('title', 'Edit Jenjang')
@section('page-title', 'Edit Jenjang')
@section('page-subtitle', $jenjang->nama)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.jenjang.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke daftar jenjang
    </a>
</div>

<div class="mx-auto max-w-3xl rounded-2xl border border-[#e1e9da] bg-white p-6 shadow-sm md:p-8">
    <form method="POST" action="{{ route('admin.jenjang.update', $jenjang) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="space-y-5">
            <div>
                <label for="nama" class="mb-2 block text-sm font-bold text-[#244535]">Nama Jenjang</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $jenjang->nama) }}" required class="field-control">
                @error('nama') <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="label" class="mb-2 block text-sm font-bold text-[#244535]">Label</label>
                <input type="text" id="label" name="label" value="{{ old('label', $jenjang->label) }}" placeholder="Contoh: Jenjang Menengah Pertama" class="field-control">
            </div>

            <div>
                <label for="deskripsi" class="mb-2 block text-sm font-bold text-[#244535]">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="field-control">{{ old('deskripsi', $jenjang->deskripsi) }}</textarea>
            </div>

            <div>
                <label for="logo" class="mb-2 block text-sm font-bold text-[#244535]">Logo Jenjang</label>
                @if ($jenjang->logo_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $jenjang->logo_path) }}" alt="Logo" class="h-20 w-20 object-contain rounded-lg border border-[#e1e9da] bg-white p-1">
                    </div>
                @endif
                <input type="file" id="logo" name="logo" accept="image/*"
                       class="block w-full text-sm text-[#244535]
                              file:mr-3 file:rounded-lg file:border-0
                              file:bg-[#0d4a36] file:px-4 file:py-2
                              file:text-sm file:font-bold file:text-white
                              hover:file:bg-[#176346]">
                <p class="mt-1 text-xs text-[#617064]">Format: JPG, PNG, WEBP, SVG. Maks 2MB.</p>
                @error('logo') <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $jenjang->aktif))
                           class="rounded border-[#d6dccf] text-[#0d4a36] focus:ring-[#5d9f3f]">
                    <span class="text-sm font-bold text-[#244535]">Aktifkan jenjang ini</span>
                </label>
            </div>
        </div>

        <div class="mt-7 flex justify-end gap-3 border-t border-[#e1e9da] pt-5">
            <a href="{{ route('admin.jenjang.index') }}" class="rounded-lg border border-[#d6dccf] px-5 py-2.5 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                <i data-lucide="save" class="h-4 w-4"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection