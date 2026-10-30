@extends('layouts.admin')

@section('title', 'Edit Info Pembayaran')
@section('page-title', 'Edit Info Pembayaran')
@section('page-subtitle', $gelombang->nama . ' — ' . $gelombang->jenjang->nama)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.info-pembayaran.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#0d4a36] hover:underline">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.info-pembayaran.update', $gelombang) }}"
      enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PATCH')

    {{-- Info Gelombang --}}
    <div class="rounded-2xl bg-[#0d4a36] text-white p-5 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-[.14em] text-[#d8ae45]">Gelombang</p>
        <p class="display-font mt-2 text-xl font-bold">{{ $gelombang->nama }}</p>
        <p class="text-sm text-[#d6e3d0] mt-1">
            {{ $gelombang->jenjang->nama }} · Biaya: <strong>Rp{{ number_format($gelombang->biaya, 0, ',', '.') }}</strong>
        </p>
    </div>

    {{-- OFFLINE --}}
    <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f4f8ee]">
                <i data-lucide="building-2" class="h-5 w-5 text-[#0d4a36]"></i>
            </div>
            <div>
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Pembayaran Offline</h3>
                <p class="text-xs text-[#617064]">Bayar langsung ke kantor</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Alamat Kantor</label>
                <input type="text" name="offline_alamat" value="{{ old('offline_alamat', $info->offline_alamat) }}"
                       placeholder="Jl. Contoh No. 123, Kota..."
                       class="field-control">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nama CP (Contact Person)</label>
                <input type="text" name="offline_cp_nama" value="{{ old('offline_cp_nama', $info->offline_cp_nama) }}"
                       placeholder="Ustadz Ahmad"
                       class="field-control">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">No. HP CP</label>
                <input type="text" name="offline_cp_hp" value="{{ old('offline_cp_hp', $info->offline_cp_hp) }}"
                       placeholder="08123456789"
                       class="field-control">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Jam Operasional</label>
                <input type="text" name="offline_jam" value="{{ old('offline_jam', $info->offline_jam) }}"
                       placeholder="Senin–Jumat, 08.00–15.00 WIB"
                       class="field-control">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Catatan Tambahan (opsional)</label>
                <textarea name="offline_catatan" rows="2" class="field-control"
                          placeholder="Contoh: Bawa fotokopi identitas...">{{ old('offline_catatan', $info->offline_catatan) }}</textarea>
            </div>
        </div>
    </div>

    {{-- TRANSFER --}}
    <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f4f8ee]">
                <i data-lucide="credit-card" class="h-5 w-5 text-[#0d4a36]"></i>
            </div>
            <div>
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">Pembayaran Transfer Bank</h3>
                <p class="text-xs text-[#617064]">Transfer ke rekening resmi</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nama Bank</label>
                <input type="text" name="transfer_bank" value="{{ old('transfer_bank', $info->transfer_bank) }}"
                       placeholder="BSI / Mandiri / BCA"
                       class="field-control">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">No. Rekening</label>
                <input type="text" name="transfer_norek" value="{{ old('transfer_norek', $info->transfer_norek) }}"
                       placeholder="1234567890"
                       class="field-control">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Atas Nama</label>
                <input type="text" name="transfer_atas_nama" value="{{ old('transfer_atas_nama', $info->transfer_atas_nama) }}"
                       placeholder="Yayasan Jati Sanan"
                       class="field-control">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Cabang (opsional)</label>
                <input type="text" name="transfer_cabang" value="{{ old('transfer_cabang', $info->transfer_cabang) }}"
                       placeholder="Cabang Kota..."
                       class="field-control">
            </div>
        </div>
    </div>

    {{-- QRIS --}}
    <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f4f8ee]">
                <i data-lucide="qr-code" class="h-5 w-5 text-[#0d4a36]"></i>
            </div>
            <div>
                <h3 class="display-font text-lg font-bold text-[#0d4a36]">QRIS</h3>
                <p class="text-xs text-[#617064]">Upload gambar QR code</p>
            </div>
        </div>

        @if ($info->qris_image_path)
            <div class="mb-3 rounded-xl border border-[#e1e9da] bg-[#f8faf5] p-4 flex items-center gap-4">
                <img src="{{ $info->qris_image_url }}" alt="QRIS"
                     class="h-32 w-32 object-contain rounded-lg border border-[#e1e9da] bg-white p-1">
                <div class="flex-1">
                    <p class="text-sm font-bold text-[#244535]">QRIS sudah diupload</p>
                    <label class="mt-2 inline-flex items-center gap-1.5 text-xs text-[#963d21] font-semibold cursor-pointer">
                        <input type="checkbox" name="hapus_qris" value="1" class="rounded">
                        Hapus QRIS ini
                    </label>
                </div>
            </div>
        @endif

        <div>
            <label class="mb-1.5 block text-xs font-bold text-[#244535]">
                {{ $info->qris_image_path ? 'Ganti QRIS (opsional)' : 'Upload QRIS' }}
            </label>
            <input type="file" name="qris_image" accept=".jpg,.jpeg,.png" class="field-control text-xs">
            <p class="mt-1 text-xs text-[#617064]">JPG, PNG. Maks 2MB.</p>
            @error('qris_image') <p class="text-xs text-[#963d21] mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- UMUM --}}
    <div class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm">
        <h3 class="display-font text-lg font-bold text-[#0d4a36] mb-3">Catatan Umum</h3>
        <textarea name="catatan_umum" rows="3" class="field-control"
                  placeholder="Contoh: Pembayaran hanya dianggap sah setelah upload bukti...">{{ old('catatan_umum', $info->catatan_umum) }}</textarea>
    </div>

    {{-- Submit --}}
    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
        <a href="{{ route('admin.info-pembayaran.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d6dccf] px-5 py-2.5 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
            Batal
        </a>
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#176346]">
            <i data-lucide="save" class="h-4 w-4"></i>
            Simpan Info Pembayaran
        </button>
    </div>
</form>

@endsection