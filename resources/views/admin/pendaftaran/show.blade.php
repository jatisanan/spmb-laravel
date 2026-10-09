@extends('layouts.admin')

@section('title', 'Detail Pendaftar')
@section('page-title', 'Detail Pendaftar')
@section('page-subtitle', $pendaftaran->nomor_pendaftaran)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.pendaftaran.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke daftar
    </a>
</div>

<div class="grid gap-5 lg:grid-cols-3">

    {{-- Kolom Kiri: Data Santri --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Identitas --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Data Santri</h3>
                <span class="status-chip status-neutral">{{ $pendaftaran->jenjang->nama }}</span>
            </div>

            <dl class="grid gap-3 sm:grid-cols-2 text-sm">
                <div>
                    <dt class="text-xs text-[#617064]">Nomor Pendaftaran</dt>
                    <dd class="font-mono font-bold text-[#0d4a36]">{{ $pendaftaran->nomor_pendaftaran }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">NISN</dt>
                    <dd class="font-mono text-[#244535]">{{ $pendaftaran->nisn }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Nama Lengkap</dt>
                    <dd class="font-semibold text-[#244535]">{{ $pendaftaran->nama_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Jenis Kelamin</dt>
                    <dd class="text-[#244535]">{{ $pendaftaran->jenis_kelamin }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Tempat, Tanggal Lahir</dt>
                    <dd class="text-[#244535]">
                        {{ $pendaftaran->tempat_lahir }},
                        {{ $pendaftaran->tanggal_lahir?->isoFormat('D MMMM Y') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Asal Sekolah</dt>
                    <dd class="text-[#244535]">{{ $pendaftaran->asal_sekolah }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Gelombang</dt>
                    <dd class="text-[#244535]">{{ $pendaftaran->gelombang->nama }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Email</dt>
                    <dd class="text-[#244535]">{{ $pendaftaran->email ?? '—' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs text-[#617064]">Alamat</dt>
                    <dd class="text-[#244535]">{{ $pendaftaran->alamat }}</dd>
                </div>
            </dl>
        </div>

        {{-- Orang Tua --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Data Orang Tua / Wali</h3>
            <dl class="grid gap-3 sm:grid-cols-3 text-sm">
                <div>
                    <dt class="text-xs text-[#617064]">Nama Ayah</dt>
                    <dd class="font-semibold text-[#244535]">{{ $pendaftaran->nama_ayah ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Nama Ibu</dt>
                    <dd class="font-semibold text-[#244535]">{{ $pendaftaran->nama_ibu ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-[#617064]">Nama Wali</dt>
                    <dd class="font-semibold text-[#244535]">{{ $pendaftaran->nama_wali ?: '—' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Form Update Verifikasi --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Verifikasi Berkas</h3>
            <form method="POST" action="{{ route('admin.pendaftaran.verifikasi', $pendaftaran) }}">
                @csrf
                @method('PATCH')
                <div class="space-y-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Verifikasi</label>
                        <select name="status_verifikasi" class="field-control">
                            @foreach (['Menunggu Verifikasi', 'Terverifikasi', 'Perlu Perbaikan'] as $s)
                                <option value="{{ $s }}" @selected($pendaftaran->status_verifikasi === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Catatan (opsional)</label>
                        <textarea name="catatan_verifikasi" rows="2" class="field-control">{{ $pendaftaran->catatan_verifikasi }}</textarea>
                    </div>
                    <button type="submit" class="rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                        Simpan Verifikasi
                    </button>
                </div>
            </form>
        </div>

        {{-- Form Update Ujian --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Jadwal & Nilai Ujian</h3>
            <form method="POST" action="{{ route('admin.pendaftaran.ujian', $pendaftaran) }}">
                @csrf
                @method('PATCH')
                <div class="grid gap-3 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Ujian</label>
                        <select name="status_ujian" class="field-control">
                            @foreach (['Belum Dijadwalkan', 'Terjadwal', 'Sudah Ujian'] as $s)
                                <option value="{{ $s }}" @selected($pendaftaran->status_ujian === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Ujian</label>
                        <input type="date" name="tanggal_ujian" value="{{ $pendaftaran->tanggal_ujian?->format('Y-m-d') }}" class="field-control">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nilai Ujian</label>
                        <input type="text" name="nilai_ujian" value="{{ $pendaftaran->nilai_ujian }}" placeholder="85" class="field-control">
                    </div>
                </div>
                <button type="submit" class="mt-3 rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                    Simpan Ujian
                </button>
            </form>
        </div>

    </div>

    {{-- Kolom Kanan: Status & Aksi --}}
    <div class="space-y-5">

        {{-- Status Ringkas --}}
        <div class="rounded-2xl bg-[#0d4a36] text-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-[.14em] text-[#d8ae45]">Status Ringkas</p>
            <div class="mt-3 space-y-3 text-sm">
                <div class="flex justify-between gap-2">
                    <span class="text-[#d6e3d0]">Verifikasi</span>
                    <span class="font-bold">{{ $pendaftaran->status_verifikasi }}</span>
                </div>
                <div class="flex justify-between gap-2">
                    <span class="text-[#d6e3d0]">Ujian</span>
                    <span class="font-bold">{{ $pendaftaran->status_ujian }}</span>
                </div>
                <div class="flex justify-between gap-2">
                    <span class="text-[#d6e3d0]">Kelulusan</span>
                    <span class="font-bold">{{ $pendaftaran->status_kelulusan }}</span>
                </div>
                <div class="flex justify-between gap-2">
                    <span class="text-[#d6e3d0]">Daftar Ulang</span>
                    <span class="font-bold">{{ $pendaftaran->status_daftar_ulang }}</span>
                </div>
            </div>
        </div>

        {{-- Form Kelulusan --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="font-bold text-[#0d4a36] mb-3">Kelulusan</h3>
            <form method="POST" action="{{ route('admin.pendaftaran.kelulusan', $pendaftaran) }}">
                @csrf
                @method('PATCH')
                <select name="status_kelulusan" class="field-control">
                    @foreach (['Menunggu Hasil', 'Lulus', 'Tidak Lulus'] as $s)
                        <option value="{{ $s }}" @selected($pendaftaran->status_kelulusan === $s)>{{ $s }}</option>
                    @endforeach
                </select>
                <button type="submit" class="mt-3 w-full rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                    Update Kelulusan
                </button>
            </form>
        </div>

        {{-- Form Daftar Ulang --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm"
            x-data="{ status: '{{ $pendaftaran->status_daftar_ulang }}' }">
            <h3 class="font-bold text-[#0d4a36] mb-3">Daftar Ulang</h3>

            <form method="POST" action="{{ route('admin.pendaftaran.daftar-ulang', $pendaftaran) }}">
                @csrf
                @method('PATCH')

                <div class="space-y-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Daftar Ulang</label>
                        <select name="status_daftar_ulang" x-model="status" class="field-control">
                            @foreach (['Belum Dibuka', 'Belum Daftar Ulang', 'Sudah Daftar Ulang'] as $s)
                                <option value="{{ $s }}" @selected($pendaftaran->status_daftar_ulang === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Muncul kalau status ≠ Belum Dibuka --}}
                    <template x-if="status !== 'Belum Dibuka'">
                        <div class="space-y-3">
                            <div>
                                <label class="mb-1.5 block text-xs font-bold text-[#244535]">
                                    Link Form Daftar Ulang
                                </label>
                                <input type="url"
                                    name="link_daftar_ulang"
                                    value="{{ $pendaftaran->link_daftar_ulang }}"
                                    placeholder="https://forms.gle/..."
                                    class="field-control">
                                <p class="mt-1 text-xs text-[#69786e]">
                                    Link ini akan muncul di halaman cek status pendaftar.
                                </p>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-xs font-bold text-[#244535]">
                                    Tanggal Daftar Ulang
                                </label>
                                <input type="date"
                                    name="tanggal_daftar_ulang"
                                    value="{{ $pendaftaran->tanggal_daftar_ulang?->format('Y-m-d') }}"
                                    class="field-control">
                            </div>
                        </div>
                    </template>

                    <button type="submit"
                            class="w-full rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                        Update Daftar Ulang
                    </button>
                </div>
            </form>
        </div>

        {{-- Hapus --}}
        <div class="rounded-2xl border border-[#f2c1ae] bg-[#fff8f5] p-5">
            <h3 class="font-bold text-[#963d21] mb-2">Zona Berbahaya</h3>
            <p class="text-xs text-[#963d21] mb-3">Hapus data pendaftaran ini secara permanen.</p>
            <form method="POST" action="{{ route('admin.pendaftaran.destroy', $pendaftaran) }}"
                  onsubmit="return confirm('Yakin hapus pendaftaran {{ $pendaftaran->nomor_pendaftaran }}? Tindakan ini tidak bisa dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full rounded-lg border border-[#963d21] px-4 py-2 text-sm font-bold text-[#963d21] hover:bg-[#963d21] hover:text-white">
                    Hapus Pendaftaran
                </button>
            </form>
        </div>

    </div>
</div>

@endsection