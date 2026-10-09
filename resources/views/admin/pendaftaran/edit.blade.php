@extends('layouts.admin')

@section('title', 'Edit Pendaftar')
@section('page-title', 'Edit Data Pendaftar')
@section('page-subtitle', $pendaftaran->nomor_pendaftaran . ' — ' . $pendaftaran->nama_lengkap)

@section('content')

{{-- Info banner --}}
<div class="mb-5 rounded-2xl border border-[#dce6d3] bg-[#f4f8ee] p-4 sm:p-5">
    <div class="flex items-start gap-3">
        <i data-lucide="info" class="h-5 w-5 text-[#0d4a36] shrink-0 mt-0.5"></i>
        <div class="text-sm text-[#315440] leading-6">
            <p class="font-bold text-[#0d4a36]">Perhatian</p>
            <ul class="mt-1 list-disc list-inside space-y-1">
                <li><strong>Nomor Pendaftaran, Tanggal Lahir, dan Email</strong> tidak dapat diubah karena dipakai untuk akun login.</li>
                <li>Kalau salah satu dari field tersebut salah, <strong>hapus pendaftaran ini</strong> dan minta pendaftar mengisi ulang.</li>
            </ul>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.pendaftaran.update', $pendaftaran) }}"
      class="rounded-2xl border border-[#e1e9da] bg-white shadow-sm overflow-hidden">
    @csrf
    @method('PATCH')

    <div class="p-4 sm:p-6 md:p-8">
        {{-- Section: Data Pribadi --}}
        <div class="mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Data Pribadi
            </h3>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="nomor_pendaftaran" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nomor Pendaftaran
                </label>
                <input id="nomor_pendaftaran" type="text" value="{{ $pendaftaran->nomor_pendaftaran }}"
                       readonly
                       class="field-control bg-[#f6f8f3] font-mono cursor-not-allowed">
                <p class="mt-1 text-xs text-[#69786e]">Nomor ini tidak dapat diubah.</p>
            </div>

            <div>
                <label for="nama_lengkap" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nama Lengkap <span class="text-[#963d21]">*</span>
                </label>
                <input id="nama_lengkap" name="nama_lengkap" type="text" required
                       value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap) }}"
                       class="field-control @error('nama_lengkap') border-[#f2c1ae] @enderror">
                @error('nama_lengkap')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jenis_kelamin" class="mb-2 block text-sm font-bold text-[#244535]">
                    Jenis Kelamin <span class="text-[#963d21]">*</span>
                </label>
                <select id="jenis_kelamin" name="jenis_kelamin" required
                        class="field-control @error('jenis_kelamin') border-[#f2c1ae] @enderror">
                    <option value="Laki-laki" @selected(old('jenis_kelamin', $pendaftaran->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
                    <option value="Perempuan" @selected(old('jenis_kelamin', $pendaftaran->jenis_kelamin) === 'Perempuan')>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nisn" class="mb-2 block text-sm font-bold text-[#244535]">
                    NISN (10 digit) <span class="text-[#963d21]">*</span>
                </label>
                <input id="nisn" name="nisn" type="text" required
                       inputmode="numeric" pattern="[0-9]{10}" minlength="10" maxlength="10"
                       value="{{ old('nisn', $pendaftaran->nisn) }}"
                       class="field-control font-mono @error('nisn') border-[#f2c1ae] @enderror">
                @error('nisn')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tempat_lahir" class="mb-2 block text-sm font-bold text-[#244535]">
                    Tempat Lahir <span class="text-[#963d21]">*</span>
                </label>
                <input id="tempat_lahir" name="tempat_lahir" type="text" required
                       value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}"
                       class="field-control @error('tempat_lahir') border-[#f2c1ae] @enderror">
                @error('tempat_lahir')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            {{-- READ ONLY: Tanggal Lahir --}}
            <div>
                <label for="tanggal_lahir" class="mb-2 block text-sm font-bold text-[#244535]">
                    Tanggal Lahir
                    <span class="ml-1 inline-flex items-center gap-1 rounded-full bg-[#edf1ec] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#42604c]">
                        <i data-lucide="lock" class="h-2.5 w-2.5"></i>
                        Terkunci
                    </span>
                </label>
                <input id="tanggal_lahir" type="date"
                       value="{{ $pendaftaran->tanggal_lahir?->format('Y-m-d') }}"
                       readonly
                       class="field-control bg-[#f6f8f3] cursor-not-allowed @error('tanggal_lahir') border-[#f2c1ae] @enderror">
                <p class="mt-1 text-xs text-[#69786e]">
                    Dipakai sebagai password awal user (ddmmyyyy). Tidak dapat diubah.
                </p>
                @error('tanggal_lahir')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="asal_sekolah" class="mb-2 block text-sm font-bold text-[#244535]">
                    Asal Sekolah <span class="text-[#963d21]">*</span>
                </label>
                <input id="asal_sekolah" name="asal_sekolah" type="text" required
                       value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah) }}"
                       class="field-control @error('asal_sekolah') border-[#f2c1ae] @enderror">
                @error('asal_sekolah')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Section: Pendaftaran --}}
        <div class="mt-8 mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Data Pendaftaran
            </h3>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="jenjang_id" class="mb-2 block text-sm font-bold text-[#244535]">
                    Jenjang <span class="text-[#963d21]">*</span>
                </label>
                <select id="jenjang_id" name="jenjang_id" required
                        class="field-control @error('jenjang_id') border-[#f2c1ae] @enderror">
                    @foreach ($jenjangs as $j)
                        <option value="{{ $j->id }}" @selected(old('jenjang_id', $pendaftaran->jenjang_id) == $j->id)>
                            {{ $j->nama }}
                        </option>
                    @endforeach
                </select>
                @error('jenjang_id')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gelombang_id" class="mb-2 block text-sm font-bold text-[#244535]">
                    Gelombang <span class="text-[#963d21]">*</span>
                </label>
                <select id="gelombang_id" name="gelombang_id" required
                        class="field-control @error('gelombang_id') border-[#f2c1ae] @enderror">
                    @foreach ($jenjangs as $j)
                        @foreach ($j->gelombang as $g)
                            <option value="{{ $g->id }}" @selected(old('gelombang_id', $pendaftaran->gelombang_id) == $g->id)>
                                {{ $j->nama }} — {{ $g->nama }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
                @error('gelombang_id')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Section: Data Orang Tua --}}
        <div class="mt-8 mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Data Orang Tua / Wali
            </h3>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="nama_ayah" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nama Ayah <span class="text-[#963d21]">*</span>
                </label>
                <input id="nama_ayah" name="nama_ayah" type="text" required
                       value="{{ old('nama_ayah', $pendaftaran->nama_ayah) }}"
                       class="field-control @error('nama_ayah') border-[#f2c1ae] @enderror">
                @error('nama_ayah')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama_ibu" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nama Ibu <span class="text-[#963d21]">*</span>
                </label>
                <input id="nama_ibu" name="nama_ibu" type="text" required
                       value="{{ old('nama_ibu', $pendaftaran->nama_ibu) }}"
                       class="field-control @error('nama_ibu') border-[#f2c1ae] @enderror">
                @error('nama_ibu')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="nama_wali" class="mb-2 block text-sm font-bold text-[#244535]">
                    Nama Wali (opsional)
                </label>
                <input id="nama_wali" name="nama_wali" type="text"
                       value="{{ old('nama_wali', $pendaftaran->nama_wali) }}"
                       class="field-control @error('nama_wali') border-[#f2c1ae] @enderror">
                @error('nama_wali')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Section: Kontak --}}
        <div class="mt-8 mb-6">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] border-b border-[#ebeee6] pb-2">
                Kontak & Alamat
            </h3>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="no_whatsapp" class="mb-2 block text-sm font-bold text-[#244535]">
                    No. WhatsApp <span class="text-[#963d21]">*</span>
                </label>
                <input id="no_whatsapp" name="no_whatsapp" type="tel" required
                       value="{{ old('no_whatsapp', $pendaftaran->no_whatsapp) }}"
                       class="field-control @error('no_whatsapp') border-[#f2c1ae] @enderror">
                @error('no_whatsapp')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>

            {{-- READ ONLY: Email --}}
            <div>
                <label for="email" class="mb-2 block text-sm font-bold text-[#244535]">
                    Email
                    <span class="ml-1 inline-flex items-center gap-1 rounded-full bg-[#edf1ec] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#42604c]">
                        <i data-lucide="lock" class="h-2.5 w-2.5"></i>
                        Terkunci
                    </span>
                </label>
                <input id="email" type="email"
                       value="{{ $pendaftaran->email }}"
                       readonly
                       class="field-control bg-[#f6f8f3] cursor-not-allowed">
                <p class="mt-1 text-xs text-[#69786e]">
                    Dipakai sebagai username login user. Tidak dapat diubah.
                </p>
            </div>

            <div class="sm:col-span-2">
                <label for="alamat" class="mb-2 block text-sm font-bold text-[#244535]">
                    Alamat Lengkap <span class="text-[#963d21]">*</span>
                </label>
                <textarea id="alamat" name="alamat" rows="4" required
                          class="field-control resize-y @error('alamat') border-[#f2c1ae] @enderror">{{ old('alamat', $pendaftaran->alamat) }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="px-4 sm:px-6 md:px-8 py-4 bg-[#f8faf5] border-t border-[#e1e9da]
                flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center gap-3">
        <a href="{{ route('admin.pendaftaran.show', $pendaftaran) }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d6dccf] px-4 py-2.5 text-sm font-semibold text-[#244535] hover:bg-white w-full sm:w-auto">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Batal
        </a>

        <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346] w-full sm:w-auto">
            <i data-lucide="save" class="h-4 w-4"></i>
            Simpan Perubahan
        </button>
    </div>
</form>

@endsection