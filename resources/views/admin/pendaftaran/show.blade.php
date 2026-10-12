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

                {{-- No WhatsApp --}}
                <div>
                    <dt class="text-xs text-[#617064]">No. WhatsApp</dt>
                    <dd class="text-[#244535]">
                        @if ($pendaftaran->no_whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pendaftaran->no_whatsapp)) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="text-[#0d4a36] font-semibold hover:underline inline-flex items-center gap-1">
                                <i data-lucide="message-circle" class="h-3.5 w-3.5"></i>
                                {{ $pendaftaran->no_whatsapp }}
                            </a>
                        @else
                            —
                        @endif
                    </dd>
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

        {{-- Berkas Pendaftaran --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Berkas Pendaftaran</h3>

            @if ($pendaftaran->berkas->isEmpty())
                <div class="rounded-xl border border-dashed border-[#d6dccf] bg-[#f8faf5] p-5 text-center">
                    <i data-lucide="file-x" class="mx-auto h-7 w-7 text-[#d6dccf] mb-2"></i>
                    <p class="text-sm text-[#617064]">Belum ada berkas yang diunggah.</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach ($pendaftaran->berkas as $b)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-lg border border-[#e1e9da] bg-[#f8faf5] px-4 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#0d4a36]">
                                    <i data-lucide="file-text" class="h-5 w-5 text-white"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-[#244535]">{{ $b->label }}</p>
                                    <p class="text-xs text-[#617064] truncate">{{ $b->nama_asli }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                @if ($b->verified)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-[#e8f4df] px-2.5 py-1 text-xs font-bold text-[#175b31]">
                                        <i data-lucide="check-circle" class="h-3 w-3"></i>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-[#fff2ca] px-2.5 py-1 text-xs font-bold text-[#805500]">
                                        <i data-lucide="clock" class="h-3 w-3"></i>
                                        Belum Diverifikasi
                                    </span>
                                @endif
                                <a href="{{ asset('storage/' . $b->file_path) }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 rounded-lg border border-[#d6dccf] px-3 py-1.5 text-xs font-semibold text-[#244535] hover:bg-white">
                                    <i data-lucide="eye" class="h-3 w-3"></i>
                                    Lihat
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Form Update Verifikasi --}}
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
            <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-4">Verifikasi Berkas</h3>

            @if ($pendaftaran->catatan_verifikasi)
                <div class="mb-4 rounded-lg border border-[#dce6d3] bg-[#f4f8ee] p-3">
                    <p class="text-xs font-bold text-[#0d4a36] mb-1">Catatan Verifikasi Saat Ini:</p>
                    <p class="text-sm text-[#315440]">{{ $pendaftaran->catatan_verifikasi }}</p>
                </div>
            @endif

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
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm
            {{ $pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'opacity-60' : '' }}">
            <div class="flex items-center justify-between mb-4">
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Jadwal & Nilai Ujian</h3>
                @if ($pendaftaran->status_verifikasi !== 'Terverifikasi')
                    <span class="status-chip status-pending">
                        <i data-lucide="lock" class="inline h-3 w-3 mr-1"></i>
                        Terkunci
                    </span>
                @endif
            </div>

            @if ($pendaftaran->status_verifikasi !== 'Terverifikasi')
                <p class="mb-3 text-xs text-[#963d21] bg-[#fff0ea] rounded-lg p-3 border border-[#f2c1ae]">
                    <i data-lucide="info" class="inline h-3 w-3"></i>
                    Verifikasi berkas terlebih dahulu sebelum menjadwalkan ujian.
                </p>
            @endif

            <form method="POST" action="{{ route('admin.pendaftaran.ujian', $pendaftaran) }}">
                @csrf
                @method('PATCH')
                <div class="grid gap-3 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Ujian</label>
                        <select name="status_ujian" class="field-control"
                            {{ $pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'disabled' : '' }}>
                            @foreach (['Belum Dijadwalkan', 'Terjadwal', 'Sudah Ujian'] as $s)
                                <option value="{{ $s }}" @selected($pendaftaran->status_ujian === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Ujian</label>
                        <input type="date" name="tanggal_ujian" value="{{ $pendaftaran->tanggal_ujian?->format('Y-m-d') }}"
                            class="field-control"
                            {{ $pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'disabled' : '' }}>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nilai Ujian</label>
                        <input type="text" name="nilai_ujian" value="{{ $pendaftaran->nilai_ujian }}" placeholder="85"
                            class="field-control"
                            {{ $pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'disabled' : '' }}>
                    </div>
                </div>
                <button type="submit"
                    class="mt-3 rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ $pendaftaran->status_verifikasi !== 'Terverifikasi' ? 'disabled' : '' }}>
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

                {{-- Verifikasi --}}
                <div class="flex justify-between gap-2">
                    <span class="text-[#d6e3d0]">Verifikasi</span>
                    <span class="font-bold">{{ $pendaftaran->status_verifikasi }}</span>
                </div>

                {{-- Ujian --}}
                <div class="flex justify-between gap-2">
                    <span class="text-[#d6e3d0]">Ujian</span>
                    <span class="font-bold">{{ $pendaftaran->status_ujian }}</span>
                </div>
                @if ($pendaftaran->tanggal_ujian)
                    <div class="flex justify-between gap-2 text-xs">
                        <span class="text-[#d6e3d0]">Tgl Ujian</span>
                        <span class="font-bold">{{ $pendaftaran->tanggal_ujian->isoFormat('D MMM Y') }}</span>
                    </div>
                @endif
                @if ($pendaftaran->nilai_ujian)
                    <div class="flex justify-between gap-2 text-xs">
                        <span class="text-[#d6e3d0]">Nilai</span>
                        <span class="font-bold text-[#f0cf6f]">{{ $pendaftaran->nilai_ujian }}</span>
                    </div>
                @endif

                {{-- Kelulusan --}}
                <div class="flex justify-between gap-2">
                    <span class="text-[#d6e3d0]">Kelulusan</span>
                    <span class="font-bold">{{ $pendaftaran->status_kelulusan }}</span>
                </div>

                {{-- Daftar Ulang --}}
                <div class="flex justify-between gap-2">
                    <span class="text-[#d6e3d0]">Daftar Ulang</span>
                    <span class="font-bold">{{ $pendaftaran->status_daftar_ulang }}</span>
                </div>
                @if ($pendaftaran->tanggal_daftar_ulang)
                    <div class="flex justify-between gap-2 text-xs">
                        <span class="text-[#d6e3d0]">Tgl Daftar Ulang</span>
                        <span class="font-bold">{{ $pendaftaran->tanggal_daftar_ulang->isoFormat('D MMM Y') }}</span>
                    </div>
                @endif
                @if ($pendaftaran->link_daftar_ulang)
                    <div class="pt-2 border-t border-white/10">
                        <a href="{{ $pendaftaran->link_daftar_ulang }}" target="_blank" rel="noopener noreferrer"
                           class="text-xs font-bold text-[#f0cf6f] hover:underline inline-flex items-center gap-1">
                            <i data-lucide="external-link" class="h-3 w-3"></i>
                            Link Daftar Ulang
                        </a>
                    </div>
                @endif
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
        <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm
            {{ $pendaftaran->status_kelulusan !== 'Lulus' ? 'opacity-60' : '' }}"
            x-data="{ status: '{{ $pendaftaran->status_daftar_ulang }}' }">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[#0d4a36]">Daftar Ulang</h3>
                @if ($pendaftaran->status_kelulusan !== 'Lulus')
                    <span class="status-chip status-pending">
                        <i data-lucide="lock" class="inline h-3 w-3 mr-1"></i>
                        Terkunci
                    </span>
                @endif
            </div>

            @if ($pendaftaran->status_kelulusan !== 'Lulus')
                <p class="mb-3 text-xs text-[#963d21] bg-[#fff0ea] rounded-lg p-2.5 border border-[#f2c1ae]">
                    <i data-lucide="info" class="inline h-3 w-3"></i>
                    Pendaftar harus dinyatakan LULUS terlebih dahulu.
                </p>
            @endif

            <form method="POST" action="{{ route('admin.pendaftaran.daftar-ulang', $pendaftaran) }}">
                @csrf
                @method('PATCH')

                <div class="space-y-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-[#244535]">Status Daftar Ulang</label>
                        <select name="status_daftar_ulang" x-model="status" class="field-control"
                            {{ $pendaftaran->status_kelulusan !== 'Lulus' ? 'disabled' : '' }}>
                            @foreach (['Belum Dibuka', 'Belum Daftar Ulang', 'Sudah Daftar Ulang'] as $s)
                                <option value="{{ $s }}" @selected($pendaftaran->status_daftar_ulang === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($pendaftaran->status_kelulusan === 'Lulus')
                        <template x-if="status !== 'Belum Dibuka'">
                            <div class="space-y-3">
                                <div>
                                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">Link Form Daftar Ulang</label>
                                    <input type="url" name="link_daftar_ulang" value="{{ $pendaftaran->link_daftar_ulang }}"
                                        placeholder="https://forms.gle/..." class="field-control">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tanggal Daftar Ulang</label>
                                    <input type="date" name="tanggal_daftar_ulang"
                                        value="{{ $pendaftaran->tanggal_daftar_ulang?->format('Y-m-d') }}"
                                        class="field-control">
                                </div>
                            </div>
                        </template>
                    @endif

                    <button type="submit"
                        class="w-full rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ $pendaftaran->status_kelulusan !== 'Lulus' ? 'disabled' : '' }}>
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