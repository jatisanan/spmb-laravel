@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('page-subtitle', $pengguna->name)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.pengguna.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke daftar
    </a>
</div>

<div class="grid gap-5 lg:grid-cols-3">

    {{-- Kolom Kiri --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Info Dasar --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Informasi Akun</h3>

            <form method="POST" action="{{ route('admin.pengguna.update', $pengguna) }}">
                @csrf
                @method('PATCH')

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-bold text-[#244535]">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $pengguna->name) }}" required class="field-control">
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-bold text-[#244535]">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $pengguna->email) }}" required class="field-control">
                    </div>
                    <div>
                        <label for="role" class="mb-1.5 block text-xs font-bold text-[#244535]">Role</label>
                        <select id="role" name="role" class="field-control">
                            <option value="student" @selected(old('role', $pengguna->role) === 'student')>Santri</option>
                            <option value="admin" @selected(old('role', $pengguna->role) === 'admin')>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label for="nisn" class="mb-1.5 block text-xs font-bold text-[#244535]">NISN (opsional)</label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $pengguna->nisn) }}" maxlength="10" class="field-control">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="no_whatsapp" class="mb-1.5 block text-xs font-bold text-[#244535]">No. WhatsApp</label>
                        <input type="text" id="no_whatsapp" name="no_whatsapp" value="{{ old('no_whatsapp', $pengguna->no_whatsapp) }}" class="field-control">
                    </div>
                </div>

                <button type="submit" class="mt-4 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- Reset Password --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-1">Reset Password</h3>
            <p class="text-xs text-[#617064] mb-4">Ganti password pengguna ini secara langsung.</p>

            <form method="POST" action="{{ route('admin.pengguna.reset-password', $pengguna) }}">
                @csrf
                @method('PATCH')

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-bold text-[#244535]">Password Baru</label>
                        <input type="password" id="password" name="password" required minlength="6" class="field-control">
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-xs font-bold text-[#244535]">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6" class="field-control">
                    </div>
                </div>

                @error('password')
                    <p class="mt-2 text-xs text-[#963d21]">{{ $message }}</p>
                @enderror

                <button type="submit" class="mt-4 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
                    Reset Password
                </button>
            </form>
        </div>

        {{-- Info Pendaftaran (kalau santri) --}}
        @if ($pengguna->isStudent() && $pengguna->pendaftaran)
            <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
                <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Data Pendaftaran Terkait</h3>
                <dl class="grid gap-3 sm:grid-cols-2 text-sm">
                    <div>
                        <dt class="text-xs text-[#617064]">Nomor Pendaftaran</dt>
                        <dd class="font-mono font-bold text-[#0d4a36]">{{ $pengguna->pendaftaran->nomor_pendaftaran }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#617064]">Jenjang</dt>
                        <dd class="text-[#244535]">{{ $pengguna->pendaftaran->jenjang->nama }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#617064]">Status Verifikasi</dt>
                        <dd class="text-[#244535]">{{ $pengguna->pendaftaran->status_verifikasi }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#617064]">Status Kelulusan</dt>
                        <dd class="text-[#244535]">{{ $pengguna->pendaftaran->status_kelulusan }}</dd>
                    </div>
                </dl>
                <a href="{{ route('admin.pendaftaran.show', $pengguna->pendaftaran) }}"
                   class="mt-4 inline-flex items-center gap-1 text-sm font-bold text-[#0d4a36] hover:underline">
                    Lihat Detail Pendaftaran
                    <i data-lucide="arrow-right" class="h-3 w-3"></i>
                </a>
            </div>
        @endif
    </div>

    {{-- Kolom Kanan --}}
    <div class="space-y-5">

        {{-- Kartu User --}}
        <div class="rounded-2xl bg-[#0d4a36] text-white p-5 shadow-sm text-center">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#d8ae45] text-3xl font-bold text-[#073528]">
                {{ strtoupper(substr($pengguna->name, 0, 1)) }}
            </div>
            <h3 class="display-font mt-3 text-xl font-bold">{{ $pengguna->name }}</h3>
            <p class="text-sm text-[#d6e3d0]">{{ $pengguna->email }}</p>
            <div class="mt-3 flex justify-center">
                @if ($pengguna->isAdmin())
                    <span class="rounded-full bg-[#d8ae45] px-3 py-1 text-xs font-bold text-[#073528]">Admin</span>
                @else
                    <span class="rounded-full bg-[#5d9f3f] px-3 py-1 text-xs font-bold text-white">Santri</span>
                @endif
            </div>
            <p class="mt-3 text-xs text-[#d6e3d0]">
                Terdaftar: {{ $pengguna->created_at->isoFormat('D MMMM Y') }}
            </p>
        </div>

        {{-- Aksi Cepat --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="font-bold text-[#0d4a36] mb-3">Aksi Cepat</h3>

            @if ($pengguna->id === auth()->id())
                <p class="text-xs text-[#617064] italic">Anda tidak dapat mengubah status atau menghapus akun sendiri.</p>
            @else
                <form method="POST" action="{{ route('admin.pengguna.toggle', $pengguna) }}" class="mb-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full rounded-lg border border-[#0d4a36] px-4 py-2 text-sm font-bold text-[#0d4a36] hover:bg-[#f4f8ee]">
                        {{ $pengguna->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.pengguna.destroy', $pengguna) }}"
                      onsubmit="return confirm('Hapus akun {{ $pengguna->name }}? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full rounded-lg border border-[#963d21] px-4 py-2 text-sm font-bold text-[#963d21] hover:bg-[#963d21] hover:text-white">
                        Hapus Akun
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection