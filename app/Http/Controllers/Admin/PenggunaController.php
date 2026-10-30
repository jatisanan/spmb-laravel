<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    /**
     * Cek: hanya super_admin yang boleh akses modul pengguna.
     */
    private function authorizeSuperAdmin(): void
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Halaman ini hanya untuk Super Admin.');
        }
    }


    /* =========================================================
     |  INDEX
     * ========================================================= */
    public function index(Request $request)
    {
        $baseQuery = User::query()->with('pendaftaran');

        if ($request->filled('status')) {
            $baseQuery->where('is_active', $request->status === 'aktif');
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $baseQuery->where(function ($x) use ($q) {
                $x->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhere('nisn', 'like', "%{$q}%");
            });
        }

        // Grup: admin (termasuk super_admin) & student
        $groups = [
            'admin' => [
                'label' => 'Admin',
                'roles' => ['admin', 'super_admin'],
                'page'  => 'page_admin',
            ],
            'student' => [
                'label' => 'Santri',
                'roles' => ['student'],
                'page'  => 'page_student',
            ],
        ];

        $targetGroups = $request->filled('role')
            ? array_intersect_key($groups, [$request->role => true])
            : $groups;

        $paginated = [];
        foreach ($targetGroups as $key => $g) {
            $paginated[$key] = [
                'label' => $g['label'],
                'items' => (clone $baseQuery)
                    ->whereIn('role', $g['roles'])
                    ->latest()
                    ->paginate(10, ['*'], $g['page'])
                    ->withQueryString(),
            ];
        }

        // ============================================
        // STATISTIK — 1 query agregat
        // ============================================
        $stats = User::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as aktif,
            SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as nonaktif,
            SUM(CASE WHEN role IN ('admin','super_admin') THEN 1 ELSE 0 END) as admin,
            SUM(CASE WHEN role = 'student' THEN 1 ELSE 0 END) as santri,
            SUM(CASE WHEN role IN ('admin','super_admin') AND is_active = 1 THEN 1 ELSE 0 END) as admin_aktif,
            SUM(CASE WHEN role IN ('admin','super_admin') AND is_active = 0 THEN 1 ELSE 0 END) as admin_nonaktif,
            SUM(CASE WHEN role = 'student' AND is_active = 1 THEN 1 ELSE 0 END) as santri_aktif,
            SUM(CASE WHEN role = 'student' AND is_active = 0 THEN 1 ELSE 0 END) as santri_nonaktif
        ")->first();

        return view('admin.pengguna.index', compact('paginated', 'stats'));
    }

    /* =========================================================
     |  SHOW
     * ========================================================= */
    public function show(User $pengguna)
    {
        $pengguna->load('pendaftaran.jenjang', 'pendaftaran.gelombang');

        return view('admin.pengguna.show', compact('pengguna'));
    }

    /* =========================================================
     |  STORE — Tambah pengguna baru
     * ========================================================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => ['required', 'email', Rule::unique('users', 'email')],
            'role'        => 'required|in:admin,student',
            'nisn'        => ['nullable', 'digits:10', Rule::unique('users', 'nisn')],
            'no_whatsapp' => 'nullable|string|max:20',
            'password'    => 'required|string|min:6',
        ], [
            'nisn.digits' => 'NISN harus 10 digit angka.',
        ]);

        // Admin tidak butuh NISN & WA
        if ($validated['role'] === 'admin') {
            $validated['nisn'] = null;
            $validated['no_whatsapp'] = null;
        }

        $validated['password']  = Hash::make($validated['password']);
        $validated['is_active'] = true;

        User::create($validated);

        return back()->with('success', "Pengguna {$validated['name']} berhasil ditambahkan.");
    }

    /* =========================================================
     |  UPDATE
     * ========================================================= */
    public function update(Request $request, User $pengguna)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => ['required', 'email', Rule::unique('users', 'email')->ignore($pengguna->id)],
            'role'        => 'required|in:admin,student',
            'nisn'        => ['nullable', 'digits:10', Rule::unique('users', 'nisn')->ignore($pengguna->id)],
            'no_whatsapp' => 'nullable|string|max:20',
            'password'    => 'nullable|string|min:6',
        ], [
            'nisn.digits' => 'NISN harus 10 digit angka.',
        ]);

        // Admin → kosongkan NISN & WA
        if ($validated['role'] === 'admin') {
            $validated['nisn'] = null;
            $validated['no_whatsapp'] = null;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pengguna->update($validated);

        return back()->with('success', 'Data pengguna berhasil diupdate.');
    }

    /* =========================================================
     |  RESET PASSWORD
     * ========================================================= */
    public function resetPassword(Request $request, User $pengguna)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $pengguna->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', "Password {$pengguna->name} berhasil direset.");
    }

    /* =========================================================
     |  TOGGLE STATUS AKTIF
     * ========================================================= */
    public function toggle(User $pengguna)
    {
        // Proteksi: tidak bisa nonaktifkan diri sendiri
        if ($pengguna->id === auth()->id()) {
            $msg = 'Anda tidak bisa menonaktifkan akun sendiri.';

            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }

            return back()->with('error', $msg);
        }

        $pengguna->update(['is_active' => !$pengguna->is_active]);

        $status = $pengguna->is_active ? 'diaktifkan' : 'dinonaktifkan';

        if (request()->expectsJson()) {
            return response()->json([
                'success'    => true,
                'message'    => "Akun {$pengguna->name} berhasil {$status}.",
                'data'       => [
                    'id'        => $pengguna->id,
                    'is_active' => $pengguna->is_active,
                    'label'     => $pengguna->is_active ? 'Aktif' : 'Nonaktif',
                ],
            ]);
        }

        return back()->with('success', "Akun {$pengguna->name} berhasil {$status}.");
    }

    /* =========================================================
     |  DESTROY
     * ========================================================= */
    public function destroy(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        if ($pengguna->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak bisa hapus admin terakhir.');
        }

        $nama = $pengguna->name;
        $pengguna->delete();

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', "Akun {$nama} berhasil dihapus.");
    }
}