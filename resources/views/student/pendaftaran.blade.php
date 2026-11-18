@extends('layouts.student')

@section('title', 'Formulir Pendaftaran')

@section('content')

{{-- Header --}}
<div class="rounded-2xl bg-[#0d4a36] text-white p-5 sm:p-6 shadow-lg mb-5">
    <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#d8ae45] text-lg font-bold text-[#073528]">
            <i data-lucide="edit-3" class="h-6 w-6"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-bold uppercase tracking-[.14em] text-[#e9d28b]">Formulir Pendaftaran</p>
            <h1 class="display-font mt-1 text-xl sm:text-2xl font-bold">Lengkapi Data Anda</h1>
            <p class="text-xs text-[#d6e3d0] mt-0.5">Akun: {{ auth()->user()->email }}</p>
        </div>
    </div>
</div>

{{-- Form --}}
<div class="rounded-2xl bg-white border border-[#dce6d3] p-5 sm:p-6 shadow-sm">
    <form id="student-form" class="grid gap-5 md:grid-cols-2" novalidate>
        @csrf

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Nama Lengkap</label>
            <input name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->name) }}" required class="field-control">
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Jenis Kelamin</label>
            <select name="jenis_kelamin" required class="field-control">
                <option value="" disabled selected>Pilih jenis kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">NISN (10 digit)</label>
            <input name="nisn" value="{{ old('nisn', auth()->user()->nisn) }}" inputmode="numeric" maxlength="10" required class="field-control">
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Tempat Lahir</label>
            <input name="tempat_lahir" required class="field-control">
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Tanggal Lahir</label>
            <input name="tanggal_lahir" type="date" required class="field-control">
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Asal Sekolah</label>
            <input name="asal_sekolah" required class="field-control">
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Jenjang</label>
            <select name="jenjang_id" id="jenjang_id" required class="field-control">
                <option value="" disabled selected>Pilih jenjang</option>
                @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Gelombang</label>
            <select name="gelombang_id" id="gelombang_id" required disabled class="field-control">
                <option value="">Pilih jenjang dulu</option>
            </select>
            <p id="gelombang-info" class="mt-1 text-xs text-[#699944]"></p>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Nama Ayah</label>
            <input name="nama_ayah" required class="field-control">
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Nama Ibu</label>
            <input name="nama_ibu" required class="field-control">
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">Nama Wali (opsional)</label>
            <input name="nama_wali" class="field-control">
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-[#244535]">No. WhatsApp</label>
            <input name="no_whatsapp" value="{{ old('no_whatsapp', auth()->user()->no_whatsapp) }}"
                   inputmode="numeric" pattern="[0-9]{11,12}" minlength="11" maxlength="12"
                   required class="field-control" placeholder="08xxxxxxxxxx">
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-bold text-[#244535]">Alamat Lengkap</label>
            <textarea name="alamat" rows="4" required class="field-control resize-y"></textarea>
        </div>

        <div class="md:col-span-2 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 border-t border-[#ebeee6] pt-5">
            <a href="{{ route('student.dashboard') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-[#d6dccf] bg-white px-4 py-2.5 text-sm font-semibold text-[#0d4a36] hover:bg-[#f4f8ee]">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#0d4a36] px-6 py-3 font-bold text-white hover:bg-[#176346] disabled:opacity-70">
                <i data-lucide="send" class="h-4 w-4"></i>
                <span>Kirim Pendaftaran</span>
            </button>
        </div>

        <div id="form-msg" class="md:col-span-2 hidden rounded-lg px-4 py-3 text-sm"></div>
    </form>
</div>

<script>
(function () {
    const csrf = '{{ csrf_token() }}';
    const STORE_URL = '{{ route("student.pendaftaran.store") }}';

    // Load gelombang saat jenjang berubah
    document.getElementById('jenjang_id').addEventListener('change', async function () {
        const g = document.getElementById('gelombang_id');
        const info = document.getElementById('gelombang-info');
        g.disabled = true;
        g.innerHTML = '<option>Memuat...</option>';
        info.textContent = '';

        try {
            const res = await fetch('/gelombang/' + this.value);
            const data = await res.json();
            g.innerHTML = '<option value="">Pilih gelombang</option>';
            data.forEach(d => {
                const o = document.createElement('option');
                o.value = d.id;
                const aktif = d.aktif === true || d.aktif === 1 || d.aktif === '1';
                o.textContent = `${d.nama} — Rp${Number(d.biaya).toLocaleString('id-ID')}${aktif ? '' : ' (TUTUP)'}`;
                if (!aktif) o.disabled = true;
                o.dataset.biaya = d.biaya;
                g.appendChild(o);
            });
            g.disabled = false;
        } catch (e) {
            info.textContent = 'Gagal memuat gelombang.';
        }
    });

    document.getElementById('gelombang_id').addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        const info = document.getElementById('gelombang-info');
        info.textContent = opt?.dataset?.biaya
            ? 'Biaya: Rp' + Number(opt.dataset.biaya).toLocaleString('id-ID')
            : '';
    });

    // Submit
    document.getElementById('student-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!this.checkValidity()) { this.reportValidity(); return; }

        const btn = this.querySelector('button[type=submit]');
        const msg = document.getElementById('form-msg');
        btn.disabled = true;

        try {
            const res = await fetch(STORE_URL, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: new FormData(this),
            });
            const data = await res.json();

            if (data.success) {
                msg.className = 'md:col-span-2 rounded-lg px-4 py-3 text-sm border border-[#b9dca8] bg-[#e8f4df] text-[#175b31]';
                msg.textContent = 'Pendaftaran berhasil! Mengalihkan ke dashboard...';
                setTimeout(() => window.location.href = data.data.redirect, 1200);
            } else {
                const errs = data.errors
                    ? Object.values(data.errors).flat().join(' • ')
                    : (data.message || 'Terjadi kesalahan.');
                msg.className = 'md:col-span-2 rounded-lg px-4 py-3 text-sm border border-[#f2c1ae] bg-[#fff0ea] text-[#963d21]';
                msg.textContent = errs;
            }
        } catch (err) {
            msg.className = 'md:col-span-2 rounded-lg px-4 py-3 text-sm border border-[#f2c1ae] bg-[#fff0ea] text-[#963d21]';
            msg.textContent = 'Kesalahan jaringan. Coba lagi.';
        } finally {
            btn.disabled = false;
        }
    });
})();
</script>

@endsection