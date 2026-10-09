@extends('layouts.admin')

@section('title', 'Pengguna')
@section('page-title', 'Pengguna')
@section('page-subtitle', 'Kelola akun admin dan santri')

@section('content')

{{-- Stats --}}
<div class="grid gap-4 sm:grid-cols-3 mb-5">
    <div class="rounded-2xl bg-white border border-[#e1e9da] p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Total Admin</p>
            <i data-lucide="shield" class="h-5 w-5 text-[#d8ae45]"></i>
        </div>
        <p class="display-font mt-2 text-3xl font-bold text-[#0d4a36]">{{ $totalAdmin }}</p>
    </div>

    <div class="rounded-2xl bg-white border border-[#e1e9da] p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Total Santri</p>
            <i data-lucide="users" class="h-5 w-5 text-[#5d9f3f]"></i>
        </div>
        <p class="display-font mt-2 text-3xl font-bold text-[#0d4a36]">{{ $totalSantri }}</p>
    </div>

    <div class="rounded-2xl bg-white border border-[#e1e9da] p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-[.12em] text-[#63806d]">Akun Aktif</p>
            <i data-lucide="user-check" class="h-5 w-5 text-[#5d9f3f]"></i>
        </div>
        <p class="display-font mt-2 text-3xl font-bold text-[#0d4a36]">{{ $totalAktif }}</p>
    </div>
</div>

{{-- Filter --}}
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

{{-- Table --}}
<div class="rounded-2xl border border-[#e1e9da] bg-white shadow-sm overflow-hidden">
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
                @forelse ($penggunas as $p)
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
                            @if ($p->isAdmin())
                                <span class="status-chip status-pending">Admin</span>
                            @else
                                <span class="status-chip status-neutral">Santri</span>
                            @endif
                        </td>
                        <td class="font-mono text-sm">{{ $p->nisn ?? '—' }}</td>
                        <td>
                            @if ($p->is_active)
                                <span class="status-chip status-success">Aktif</span>
                            @else
                                <span class="status-chip status-danger">Nonaktif</span>
                            @endif
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
                            Tidak ada pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($penggunas->hasPages())
        <div class="px-5 py-4 border-t border-[#e1e9da]">
            {{ $penggunas->links() }}
        </div>
    @endif
</div>

<p class="mt-3 text-xs text-[#617064]">
    Menampilkan {{ $penggunas->firstItem() ?? 0 }}–{{ $penggunas->lastItem() ?? 0 }}
    dari {{ $penggunas->total() }} pengguna
</p>

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

            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Nama Lengkap</label>
                <input type="text" name="name" id="edit-name" required class="field-control">
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">Email</label>
                <input type="email" name="email" id="edit-email" required class="field-control">
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">Role</label>
                    <select name="role" id="edit-role" class="field-control">
                        <option value="student">Santri</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-[#244535]">NISN (opsional)</label>
                    <input type="text" name="nisn" id="edit-nisn" maxlength="10" class="field-control">
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold text-[#244535]">No. WhatsApp (opsional)</label>
                <input type="text" name="no_whatsapp" id="edit-wa" class="field-control">
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
// Data user dari server (untuk diisi ke modal edit)
const USERS_DATA = @json($penggunas->items());

function openEditModal(userId) {
    const user = USERS_DATA.find(u => u.id === userId);
    if (!user) return;

    document.getElementById('edit-name').value = user.name || '';
    document.getElementById('edit-email').value = user.email || '';
    document.getElementById('edit-role').value = user.role || 'student';
    document.getElementById('edit-nisn').value = user.nisn || '';
    document.getElementById('edit-wa').value = user.no_whatsapp || '';
    document.getElementById('edit-password').value = '';

    // Set action URL
    document.getElementById('edit-form').action = `/admin/pengguna/${userId}`;

    const modal = document.getElementById('edit-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    if (window.lucide) lucide.createIcons();
}

function closeEditModal() {
    const modal = document.getElementById('edit-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function confirmDelete(userId, userName) {
    document.getElementById('delete-name').textContent = userName;
    document.getElementById('delete-form').action = `/admin/pengguna/${userId}`;

    const modal = document.getElementById('delete-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    if (window.lucide) lucide.createIcons();
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Klik area luar modal → tutup
document.getElementById('edit-modal')?.addEventListener('click', function (e) {
    if (e.target === this) closeEditModal();
});
document.getElementById('delete-modal')?.addEventListener('click', function (e) {
    if (e.target === this) closeDeleteModal();
});

// ESC untuk tutup modal
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeEditModal();
        closeDeleteModal();
    }
});
</script>
@endpush