<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with('pendaftaran');

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($x) use ($q) {
                $x->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('nisn', 'like', "%{$q}%");
            });
        }

        $penggunas = $query->latest()->paginate(15)->withQueryString();

        // Statistik
        $totalAdmin = User::where('role', 'admin')->count();
        $totalSantri = User::where('role', 'student')->count();
        $totalAktif = User::where('is_active', true)->count();

        return view('admin.pengguna.index', compact(
            'penggunas', 'totalAdmin', 'totalSantri', 'totalAktif'
        ));
    }

    public function show(User $pengguna)
    {
        $pengguna->load('pendaftaran.jenjang', 'pendaftaran.gelombang');

        return view('admin.pengguna.show', compact('pengguna'));
    }

    public function update(Request $request, User $pengguna)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($pengguna->id)],
            'role' => 'required|in:admin,student',
            'nisn' => ['nullable', 'digits:10', Rule::unique('users', 'nisn')->ignore($pengguna->id)],
            'no_whatsapp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        // Kalau password diisi, hash dan update
        if (!empty($validated['password'])) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pengguna->update($validated);

        return back()->with('success', 'Data pengguna berhasil diupdate.');
    }

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

    public function toggle(User $pengguna)
    {
        // Jangan biarkan admin menonaktifkan dirinya sendiri
        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menonaktifkan akun sendiri.');
        }

        $pengguna->update(['is_active' => !$pengguna->is_active]);

        $status = $pengguna->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$pengguna->name} berhasil {$status}.");
    }

    public function destroy(User $pengguna)
    {
        // Proteksi
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