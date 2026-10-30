@extends('layouts.admin')

@section('title', 'Pengguna')
@section('page-title', 'Pengguna')
@section('page-subtitle', 'Kelola akun admin dan santri')

@section('content')

{{-- ============================================ --}}
{{-- STATISTIK --}}
{{-- ============================================ --}}
<div class="grid gap-4 sm:grid-cols-3 mb-5">

    {{-- Total Pengguna --}}
    <div class="rounded-2xl bg-white border border-[#e1e9da] p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Total Pengguna</p>
            <i data-lucide="users-round" class="h-5 w-5 text-[#0d4a36]"></i>
        </div>
        <p class="display-font mt-2 text-3xl font-bold text-[#0d4a36]">{{ $stats->total }}</p>
        <p class="mt-1 text-[11px] text-[#617064]">
            {{ $stats->admin }} admin · {{ $stats->santri }} santri
        </p>
    </div>

    {{-- Akun Aktif --}}
    <div class="rounded-2xl bg-white border border-[#e1e9da] p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Akun Aktif</p>
            <i data-lucide="user-check" class="h-5 w-5 text-[#5d9f3f]"></i>
        </div>
        <p class="display-font mt-2 text-3xl font-bold text-[#175b31]">{{ $stats->aktif }}</p>
        <p class="mt-1 text-[11px] text-[#617064]">
            {{ $stats->admin_aktif }} admin · {{ $stats->santri_aktif }} santri
        </p>
    </div>

    {{-- Akun Nonaktif --}}
    <div class="rounded-2xl bg-white border border-[#e1e9da] p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Akun Nonaktif</p>
            <i data-lucide="user-x" class="h-5 w-5 text-[#963d21]"></i>
        </div>
        <p class="display-font mt-2 text-3xl font-bold text-[#963d21]">{{ $stats->nonaktif }}</p>
        <p class="mt-1 text-[11px] text-[#617064]">
            {{ $stats->admin_nonaktif }} admin · {{ $stats->santri_nonaktif }} santri
        </p>
    </div>
</div>

{{-- ============================================ --}}
{{-- HEADER + TOMBOL TAMBAH --}}
{{-- ============================================ --}}
<div class="mb-4 flex items-center justify-between gap-3">
    <div>
        <h2 class="display-font text-lg font-bold text-[#0d4a36]">Daftar Pengguna</h2>
        <p class="text-xs text-[#617064]">Kelola akun admin & santri</p>
    </div>
    <button type="button" onclick="openCreateModal()"
            class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346] shadow-sm">
        <i data-lucide="user-plus" class="h-4 w-4"></i>
        Tambah Pengguna
    </button>
</div>

{{-- ============================================ --}}
{{-- FILTER --}}
{{-- ============================================ --}}
<form method="GET" action="{{ route('admin.pengguna.index') }}"
      class="rounded-2xl border border-[#e1e9da] bg-white p-5 shadow-sm mb-5">
    <div class="grid gap-3 md:grid-cols-4">
        <div class="md:col-span-2">
            <label for="q" class="mb-1.5 block text-xs font-bold text-[#244535]">Cari</label>
            <input type="search" name="q" id="q" value="{{ request('q') }}"
                   placeholder="Nama, email, NISN..." class="field-control">
        </div>

        <div>
            <label for="role" class="mb-1.5 block text-xs font-bold text-[#244535]">Role</label>
            <select name="role" id="role" class="field-control">
                <option value="">Semua</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                <option value="student" @selected(request('role') === 'student')>Santri</option>
            </select>
        </div>

        <div>
            <label for="status" class="mb-1.5 block text-xs font-bold text-[#244535]">Status</label>
            <select name="status" id="status" class="field-control">
                <option value="">Semua</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
            </select>
        </div>
    </div>

    <div class="mt-4 flex flex-wrap items-center gap-3">
        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-4 py-2 text-sm font-bold text-white hover:bg-[#176346]">
            <i data-lucide="search" class="h-4 w-4"></i>
            Filter
        </button>

        @if (request()->hasAny(['q', 'role', 'status']))
            <a href="{{ route('admin.pengguna.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-[#f4f8ee]">
                <i data-lucide="x" class="h-4 w-4"></i>
                Reset
            </a>
        @endif
    </div>
</form>

{{-- ============================================ --}}
{{-- TABEL --}}
{{-- ============================================ --}}
@forelse ($paginated as $groupKey => $group)
    @php
        $items = $group['items'];

        if ($groupKey === 'admin') {
            $bgHeader   = 'bg-[#e3e6de]';
            $borderCard = 'border-[#d6dccf]';
            $chipColor  = 'bg-[#4b5347] text-white';
            $headerIcon = 'shield';
        } else {
            $bgHeader   = 'bg-[#d9e9f5]';
            $borderCard = 'border-[#c5d9e8]';
            $chipColor  = 'bg-[#1e4d75] text-white';
            $headerIcon = 'users';
        }
    @endphp

    <div class="rounded-2xl border {{ $borderCard }} bg-white shadow-sm overflow-hidden mb-5">
        {{-- Header Grup --}}
        <div class="{{ $bgHeader }} px-5 py-3 border-b {{ $borderCard }} flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <i data-lucide="{{ $headerIcon }}" class="h-4 w-4 text-[#0d4a36]"></i>
                <h3 class="display-font text-base font-bold text-[#0d4a36]">{{ $group['label'] }}</h3>
                <span class="inline-flex items-center rounded-full {{ $chipColor }} px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide">
                    {{ $items->total() }} akun
                </span>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="admin-table" style="min-width: 900px;">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>NISN</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $p)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#0d4a36] text-sm font-bold text-white">
                                        {{ strtoupper(substr($p->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-[#0d4a36]">{{ $p->name }}</p>
                                        @if ($p->id === auth()->id())
                                            <p class="text-xs text-[#617064]">(Anda)</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-sm">{{ $p->email }}</td>
                            <td>
                                @if ($p->isSuperAdmin())
                                    <span class="status-chip status-pending">Super Admin</span>
                                @elseif ($p->isAdmin())
                                    <span class="status-chip status-pending">Admin</span>
                                @else
                                    <span class="status-chip status-neutral">Santri</span>
                                @endif
                            </td>
                            <td class="font-mono text-sm">{{ $p->nisn ?? '—' }}</td>
                            <td data-cell="status">
                                <div class="inline-block status-dropdown-wrapper"
                                     data-user-id="{{ $p->id }}"
                                     data-is-active="{{ $p->is_active ? '1' : '0' }}"
                                     data-is-self="{{ $p->id === auth()->id() ? '1' : '0' }}">

                                    @if ($p->id === auth()->id())
                                        <span class="status-chip status-success cursor-not-allowed"
                                              title="Tidak bisa mengubah status akun sendiri">
                                            <i data-lucide="lock" class="h-3 w-3 mr-1"></i>
                                            Aktif (Anda)
                                        </span>
                                    @else
                                        <button type="button"
                                                class="status-dropdown-btn inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold transition hover:ring-2 hover:ring-[#0d4a36]/30
                                                    {{ $p->is_active
                                                        ? 'bg-[#e8f4df] text-[#175b31]'
                                                        : 'bg-[#fff0ea] text-[#963d21]' }}"
                                                data-status="{{ $p->is_active ? '1' : '0' }}"
                                                title="Klik untuk ubah status">
                                            <span class="status-dropdown-label">{{ $p->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                            <i data-lucide="chevron-down" class="h-3 w-3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.pengguna.show', $p) }}"
                                       class="inline-flex items-center gap-1 rounded-lg bg-[#0d4a36] px-2.5 py-1.5 text-xs font-bold text-white hover:bg-[#176346]"
                                       title="Detail">
                                        <i data-lucide="eye" class="h-3 w-3"></i>
                                    </a>

                                    <button type="button"
                                            onclick="openEditModal({{ $p->id }})"
                                            class="inline-flex items-center gap-1 rounded-lg border border-[#0d4a36] px-2.5 py-1.5 text-xs font-bold text-[#0d4a36] hover:bg-[#f4f8ee]"
                                            title="Edit">
                                        <i data-lucide="edit-3" class="h-3 w-3"></i>
                                    </button>

                                    @if ($p->id !== auth()->id())
                                        <button type="button"
                                                onclick="confirmDelete({{ $p->id }}, '{{ addslashes($p->name) }}')"
                                                class="inline-flex items-center gap-1 rounded-lg border border-[#f2c1ae] px-2.5 py-1.5 text-xs font-bold text-[#963d21] hover:bg-[#fff0ea]"
                                                title="Hapus">
                                            <i data-lucide="trash-2" class="h-3 w-3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-[#617064]">
                                <i data-lucide="users" class="mx-auto h-10 w-10 mb-2"></i>
                                Tidak ada {{ $group['label'] }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination PER grup --}}
        @if ($items->hasPages())
            <div class="px-5 py-4 border-t {{ $borderCard }}">
                {{ $items->links() }}
            </div>
        @endif

        {{-- Footer count PER grup --}}
        <div class="px-5 py-2 text-[10px] text-[#617064] border-t {{ $borderCard }}">
            Menampilkan {{ $items->firstItem() ?? 0 }}–{{ $items->lastItem() ?? 0 }}
            dari {{ $items->total() }} {{ strtolower($group['label']) }}
        </div>
    </div>
@empty
    <div class="rounded-2xl border border-dashed border-[#d6dccf] bg-white p-8 text-center">
        <i data-lucide="inbox" class="mx-auto h-10 w-10 text-[#d6dccf] mb-2"></i>
        <p class="text-sm text-[#617064]">Belum ada pengguna.</p>
    </div>
@endforelse

{{-- ============================================ --}}
{{-- MODAL TAMBAH PENGGUNA --}}
{{-- ============================================ --}}
<div id="create-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">
        <div class="bg-[#0d4a36] px-6 py-4 text-white flex items-center justify-between">
            <div>
                <h3 class="display-font text-xl font-bold">Tambah Pengguna</h3>
                <p class="text-xs text-[#d6e3d0] mt-0.5">Buat akun admin atau santri baru</p>
            </div>
            <button type="button" onclick="closeCreateModal()"
                    class="rounded-lg p-1 hover:bg-white/10">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <form id="create-form" method="POST" action="{{ route('admin.pengguna.store') }}"
              class="px-6 py-5 overflow-y-auto space-y-4">
            @csrf
            <input type="hidden" name="_form" value="create">

            @if ($errors->any() && old('_form') === 'create')
                <div class="rounded-lg bg-[#fff0ea] border border-[#f2c1ae] p-3 text-xs text-[#963d21]">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pilihan Tipe User --}}
            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Tipe Pengguna</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="student" class="peer sr-only"
                               @checked(old('_form') === 'create' ? old('role', 'student') === 'student' : true)>
                        <div class="rounded-xl border-2 border-[#e1e9da] p-3 text-center transition
                                    peer-checked:border-[#0d4a36] peer-checked:bg-[#f4f8ee]">
                            <i data-lucide="users" class="mx-auto h-6 w-6 text-[#5d9f3f]"></i>
                            <p class="mt-1 text-sm font-bold text-[#0d4a36]">Santri</p>
                            <p class="text-[11px] text-[#617064]">Calon siswa / peserta didik</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="admin" class="peer sr-only"
                               @checked(old('_form') === 'create' && old('role') === 'admin')>
                        <div class="rounded-xl border-2 border-[#e1e9da] p-3 text-center transition
                                    peer-checked:border-[#0d4a36] peer-checked:bg-[#f4f8ee]">
                            <i data-lucide="shield" class="mx-auto h-6 w-6 text-[#d8ae45]"></i>
                            <p class="mt-1 text-sm font-bold text-[#0d4a36]">Admin</p>
                            <p class="text-[11px] text-[#617064]">Pengelola sistem</p>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nama Lengkap <span class="text-[#963d21]">*</span></label>
                <input type="text" name="name" required class="field-control"
                       placeholder="Contoh: Ahmad Fauzi"
                       value="{{ old('_form') === 'create' ? old('name') : '' }}">
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Email <span class="text-[#963d21]">*</span></label>
                <input type="email" name="email" required class="field-control"
                       placeholder="nama@email.com"
                       value="{{ old('_form') === 'create' ? old('email') : '' }}">
            </div>

            {{-- Field khusus Santri (NISN & WA) --}}
            <div id="create-student-fields" class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">NISN (opsional)</label>
                    <input type="text" name="nisn" maxlength="10" class="field-control"
                           placeholder="10 digit angka"
                           value="{{ old('_form') === 'create' ? old('nisn') : '' }}">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">No. WhatsApp (opsional)</label>
                    <input type="text" name="no_whatsapp" class="field-control"
                           placeholder="08xxxxxxxxxx"
                           value="{{ old('_form') === 'create' ? old('no_whatsapp') : '' }}">
                </div>
            </div>

            <div class="border-t border-[#e1e9da] pt-4">
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Password Awal <span class="text-[#963d21]">*</span></label>
                <input type="text" name="password" required minlength="6" class="field-control"
                       placeholder="Minimal 6 karakter">
                <p class="mt-1 text-xs text-[#617064]">Beritahu pengguna untuk segera mengganti password setelah login pertama.</p>
            </div>
        </form>

        <div class="px-6 py-4 bg-[#f8faf5] border-t border-[#e1e9da] flex justify-end gap-2">
            <button type="button" onclick="closeCreateModal()"
                    class="rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-white">
                Batal
            </button>
            <button type="submit" form="create-form"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                <i data-lucide="user-plus" class="h-4 w-4"></i>
                Buat Akun
            </button>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- MODAL EDIT --}}
{{-- ============================================ --}}
<div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">
        <div class="bg-[#0d4a36] px-6 py-4 text-white flex items-center justify-between">
            <div>
                <h3 class="display-font text-xl font-bold">Edit Pengguna</h3>
                <p class="text-xs text-[#d6e3d0] mt-0.5">Ubah data akun</p>
            </div>
            <button type="button" onclick="closeEditModal()"
                    class="rounded-lg p-1 hover:bg-white/10">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <form id="edit-form" method="POST" class="px-6 py-5 overflow-y-auto space-y-4">
            @csrf
            @method('PATCH')
            <input type="hidden" name="_form" value="edit">

            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nama Lengkap</label>
                <input type="text" name="name" id="edit-name" required class="field-control">
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Email</label>
                <input type="email" name="email" id="edit-email" required class="field-control">
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Role</label>
                <select name="role" id="edit-role" class="field-control">
                    <option value="student">Santri</option>
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>

            {{-- Field khusus Santri (NISN & WA) --}}
            <div id="edit-student-fields" class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">NISN (opsional)</label>
                    <input type="text" name="nisn" id="edit-nisn" maxlength="10" class="field-control">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">No. WhatsApp (opsional)</label>
                    <input type="text" name="no_whatsapp" id="edit-wa" class="field-control">
                </div>
            </div>

            <div class="border-t border-[#e1e9da] pt-4">
                <label class="mb-1.5 block text-xs font-bold text-[#963d21]">Reset Password (opsional)</label>
                <input type="text" name="password" id="edit-password" placeholder="Kosongkan jika tidak ingin ganti"
                       class="field-control">
                <p class="mt-1 text-xs text-[#617064]">Isi hanya jika ingin reset password pengguna.</p>
            </div>
        </form>

        <div class="px-6 py-4 bg-[#f8faf5] border-t border-[#e1e9da] flex justify-end gap-2">
            <button type="button" onclick="closeEditModal()"
                    class="rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-white">
                Batal
            </button>
            <button type="submit" form="edit-form"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#0d4a36] px-5 py-2 text-sm font-bold text-white hover:bg-[#176346]">
                <i data-lucide="save" class="h-4 w-4"></i>
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- MODAL HAPUS --}}
{{-- ============================================ --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">
        <div class="px-6 py-5 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0ea] mb-3">
                <i data-lucide="alert-triangle" class="h-7 w-7 text-[#963d21]"></i>
            </div>
            <h3 class="display-font text-xl font-bold text-[#0d4a36]">Hapus Pengguna?</h3>
            <p class="mt-2 text-sm text-[#617064]">
                Anda akan menghapus akun <strong id="delete-name" class="text-[#963d21]"></strong>.
                Tindakan ini tidak bisa dibatalkan.
            </p>
        </div>

        <form id="delete-form" method="POST" class="px-6 py-4 bg-[#f8faf5] border-t border-[#e1e9da] flex justify-end gap-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()"
                    class="rounded-lg border border-[#d6dccf] px-4 py-2 text-sm font-semibold text-[#244535] hover:bg-white">
                Batal
            </button>
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#963d21] px-5 py-2 text-sm font-bold text-white hover:bg-[#7a2f1a]">
                <i data-lucide="trash-2" class="h-4 w-4"></i>
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
/* =========================================================
 |  DATA USER
 * ========================================================= */
const USERS_DATA = @json(
    collect($paginated)->flatMap(fn ($g) => $g['items']->items())->values()
);

const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

/* =========================================================
 |  HELPER — Buka / Tutup Modal
 * ========================================================= */
function showModal(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('hidden');
    el.classList.add('flex');
    if (window.lucide) lucide.createIcons();
}

function hideModal(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.add('hidden');
    el.classList.remove('flex');
}

/* =========================================================
 |  MODAL TAMBAH PENGGUNA
 * ========================================================= */
function toggleCreateStudentFields() {
    const form = document.getElementById('create-form');
    if (!form) return;

    const wrapper = document.getElementById('create-student-fields');
    const selectedRole = form.querySelector('input[name="role"]:checked')?.value || 'student';
    const isStudent = selectedRole === 'student';

    wrapper.classList.toggle('hidden', !isStudent);

    wrapper.querySelectorAll('input').forEach(input => {
        input.disabled = !isStudent;
        if (!isStudent) input.value = '';
    });
}

function openCreateModal() {
    const form = document.getElementById('create-form');
    const hasOld = @json(old('_form') === 'create');

    if (!hasOld) {
        form.reset();
        const santriRadio = form.querySelector('input[name="role"][value="student"]');
        if (santriRadio) santriRadio.checked = true;
    }

    toggleCreateStudentFields();
    showModal('create-modal');
}

function closeCreateModal() {
    hideModal('create-modal');
}

/* =========================================================
 |  MODAL EDIT
 * ========================================================= */
function toggleEditStudentFields() {
    const select = document.getElementById('edit-role');
    const wrapper = document.getElementById('edit-student-fields');
    if (!select || !wrapper) return;

    const isStudent = select.value === 'student';
    wrapper.classList.toggle('hidden', !isStudent);

    wrapper.querySelectorAll('input').forEach(input => {
        input.disabled = !isStudent;
        if (!isStudent) input.value = '';
    });
}

function openEditModal(userId) {
    const user = USERS_DATA.find(u => u.id === userId);
    if (!user) return;

    document.getElementById('edit-name').value = user.name || '';
    document.getElementById('edit-email').value = user.email || '';
    document.getElementById('edit-role').value = user.role || 'student';
    document.getElementById('edit-nisn').value = user.nisn || '';
    document.getElementById('edit-wa').value = user.no_whatsapp || '';
    document.getElementById('edit-password').value = '';

    toggleEditStudentFields();

    document.getElementById('edit-form').action = `/admin/pengguna/${userId}`;
    showModal('edit-modal');
}

function closeEditModal() {
    hideModal('edit-modal');
}

/* =========================================================
 |  MODAL HAPUS
 * ========================================================= */
function confirmDelete(userId, userName) {
    document.getElementById('delete-name').textContent = userName;
    document.getElementById('delete-form').action = `/admin/pengguna/${userId}`;
    showModal('delete-modal');
}

function closeDeleteModal() {
    hideModal('delete-modal');
}

/* =========================================================
 |  EVENT LISTENERS
 * ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
    const createForm = document.getElementById('create-form');
    if (createForm) {
        createForm.querySelectorAll('input[name="role"]').forEach(r => {
            r.addEventListener('change', toggleCreateStudentFields);
        });
        toggleCreateStudentFields();
    }

    const editRole = document.getElementById('edit-role');
    if (editRole) editRole.addEventListener('change', toggleEditStudentFields);
});

// Klik area luar modal → tutup
document.getElementById('create-modal')?.addEventListener('click', function (e) {
    if (e.target === this) closeCreateModal();
});
document.getElementById('edit-modal')?.addEventListener('click', function (e) {
    if (e.target === this) closeEditModal();
});
document.getElementById('delete-modal')?.addEventListener('click', function (e) {
    if (e.target === this) closeDeleteModal();
});

// ESC untuk tutup semua modal
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
        closeDeleteModal();
    }
});

/* =========================================================
 |  AUTO-OPEN MODAL SESUAI FORM ASAL ERROR
 * ========================================================= */
@if ($errors->any() && old('_form') === 'create')
    document.addEventListener('DOMContentLoaded', () => {
        toggleCreateStudentFields();
        showModal('create-modal');
    });
@endif

/* =========================================================
 |  Tutup semua modal saat halaman di-restore dari bfcache
 * ========================================================= */
window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
        closeCreateModal();
        closeEditModal();
        closeDeleteModal();
    }
});

/* =========================================================
 |  STATUS DROPDOWN — Popover dinamis (anti clipping)
 * ========================================================= */
let activeDropdown = null;
let activeWrapper  = null;

// ---- Tutup dropdown aktif ----
function closeStatusDropdown() {
    if (activeDropdown) {
        activeDropdown.remove();
        activeDropdown = null;
    }
    if (activeWrapper) {
        activeWrapper.querySelector('.status-dropdown-btn')?.classList.remove('ring-2', 'ring-[#0d4a36]/30');
        activeWrapper = null;
    }
}

// ---- Buka dropdown untuk button ----
function openStatusDropdown(btn) {
    const wrapper = btn.closest('.status-dropdown-wrapper');
    if (!wrapper) return;

    closeStatusDropdown();

    const isActive = wrapper.dataset.isActive === '1';

    const menu = document.createElement('div');
    menu.className = 'status-dropdown-menu fixed z-[9999] w-40 rounded-lg border border-[#e1e9da] bg-white shadow-xl overflow-hidden';
    menu.innerHTML = `
        <button type="button"
                class="status-option w-full flex items-center gap-2 px-3 py-2 text-xs font-semibold text-left hover:bg-[#f4f8ee] ${isActive ? 'bg-[#f4f8ee]' : ''}"
                data-status="1">
            <i data-lucide="check-circle" class="h-3.5 w-3.5 text-[#5d9f3f]"></i>
            <span>Aktif</span>
        </button>
        <button type="button"
                class="status-option w-full flex items-center gap-2 px-3 py-2 text-xs font-semibold text-left hover:bg-[#fff0ea] ${!isActive ? 'bg-[#fff0ea]' : ''}"
                data-status="0">
            <i data-lucide="x-circle" class="h-3.5 w-3.5 text-[#963d21]"></i>
            <span>Nonaktif</span>
        </button>
    `;

    document.body.appendChild(menu);

    const rect = btn.getBoundingClientRect();
    const menuWidth = 160;
    const menuHeight = menu.offsetHeight || 72;

    let top  = rect.bottom + 4;
    let left = rect.right - menuWidth;

    if (top + menuHeight > window.innerHeight - 8) {
        top = rect.top - menuHeight - 4;
    }
    if (left < 8) left = 8;

    menu.style.top  = `${top}px`;
    menu.style.left = `${left}px`;

    if (window.lucide) lucide.createIcons({ nodes: [menu] });

    activeDropdown = menu;
    activeWrapper  = wrapper;
    btn.classList.add('ring-2', 'ring-[#0d4a36]/30');
}

// ---- Klik tombol dropdown: toggle ----
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.status-dropdown-btn');

    if (btn) {
        const wrapper = btn.closest('.status-dropdown-wrapper');

        if (activeWrapper === wrapper) {
            closeStatusDropdown();
        } else {
            openStatusDropdown(btn);
        }
        e.stopPropagation();
        return;
    }

    if (activeDropdown && !e.target.closest('.status-dropdown-menu')) {
        closeStatusDropdown();
    }
});

// ---- Scroll / resize → tutup (biar tidak salah posisi) ----
window.addEventListener('scroll', () => { if (activeDropdown) closeStatusDropdown(); }, true);
window.addEventListener('resize', () => { if (activeDropdown) closeStatusDropdown(); });

// ---- Klik opsi status: kirim AJAX ----
document.addEventListener('click', async function (e) {
    const option = e.target.closest('.status-option');
    if (!option) return;

    const wrapper = activeWrapper;
    if (!wrapper) return;

    const userId   = wrapper.dataset.userId;
    const newValue = option.dataset.status;
    const isActive = wrapper.dataset.isActive;

    if (newValue === isActive) {
        closeStatusDropdown();
        return;
    }

    const btn   = wrapper.querySelector('.status-dropdown-btn');
    const label = wrapper.querySelector('.status-dropdown-label');

    btn.disabled = true;
    const originalLabel = label?.textContent || '';
    if (label) label.textContent = '...';

    closeStatusDropdown();

    try {
        const res = await fetch(`/admin/pengguna/${userId}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            const newActive = data.data.is_active;
            wrapper.dataset.isActive = newActive ? '1' : '0';

            if (label) label.textContent = newActive ? 'Aktif' : 'Nonaktif';

            btn.className = 'status-dropdown-btn inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold transition hover:ring-2 hover:ring-[#0d4a36]/30 ' +
                (newActive ? 'bg-[#e8f4df] text-[#175b31]' : 'bg-[#fff0ea] text-[#963d21]');

            if (window.lucide) lucide.createIcons();
            showStatusToast(data.message || 'Status berhasil diubah', 'success');
        } else {
            if (label) label.textContent = originalLabel;
            showStatusToast(data.message || 'Gagal mengubah status', 'error');
        }
    } catch (err) {
        console.error(err);
        if (label) label.textContent = originalLabel;
        showStatusToast('Terjadi kesalahan. Coba lagi.', 'error');
    } finally {
        btn.disabled = false;
    }
});

// ---- ESC untuk tutup dropdown ----
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && activeDropdown) {
        closeStatusDropdown();
    }
});

/* =========================================================
 |  TOAST SEDERHANA
 * ========================================================= */
function showStatusToast(message, type = 'success') {
    let container = document.getElementById('status-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'status-toast-container';
        container.className = 'fixed bottom-5 right-5 z-[200] flex flex-col gap-2 pointer-events-none';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    const isSuccess = type === 'success';
    toast.className = `pointer-events-auto flex items-start gap-2 rounded-xl px-4 py-3 text-sm shadow-lg border transform translate-x-4 opacity-0 transition-all duration-300 ${
        isSuccess
            ? 'bg-[#e8f4df] border-[#b9dca8] text-[#175b31]'
            : 'bg-[#fff0ea] border-[#f2c1ae] text-[#963d21]'
    }`;

    toast.innerHTML = `
        <i data-lucide="${isSuccess ? 'check-circle' : 'alert-circle'}" class="h-4 w-4 shrink-0 mt-0.5"></i>
        <span class="flex-1">${message}</span>
    `;

    container.appendChild(toast);
    if (window.lucide) lucide.createIcons();

    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-4', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');
    });

    setTimeout(() => {
        toast.classList.add('translate-x-4', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endpush