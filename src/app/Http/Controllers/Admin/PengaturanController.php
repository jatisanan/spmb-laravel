<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSitus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    protected function fields(): array
    {
        return [
            'header' => [
                'label' => 'Header',
                'icon' => 'layout-top',
                'fields' => [
                    'header_kicker' => ['label' => 'Kicker Header', 'type' => 'text'],
                    'header_name' => ['label' => 'Nama Pesantren', 'type' => 'text'],
                    'header_logo' => ['label' => 'Logo Header', 'type' => 'image'],
                ],
            ],
            'hero' => [
                'label' => 'Hero (Bagian Atas)',
                'icon' => 'image',
                'fields' => [
                    'hero_badge' => ['label' => 'Badge', 'type' => 'text'],
                    'hero_title' => ['label' => 'Judul Utama', 'type' => 'textarea'],
                    'hero_description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
                    'hero_cta_text' => ['label' => 'Teks Tombol CTA', 'type' => 'text'],
                    'hero_info_text' => ['label' => 'Teks Tombol Info', 'type' => 'text'],
                    'hero_image' => ['label' => 'Gambar Hero', 'type' => 'image'],
                ],
            ],
            'about' => [
                'label' => 'Tentang Kami',
                'icon' => 'info',
                'fields' => [
                    'about_eyebrow' => ['label' => 'Eyebrow', 'type' => 'text'],
                    'about_title' => ['label' => 'Judul', 'type' => 'textarea'],
                    'about_description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
                    'about_experience_number' => ['label' => 'Angka Pengalaman', 'type' => 'text'],
                    'about_experience_text' => ['label' => 'Teks Pengalaman', 'type' => 'text'],
                    'about_image' => ['label' => 'Gambar Gedung', 'type' => 'image'],
                ],
            ],
            'value' => [
                'label' => 'Nilai-Nilai',
                'icon' => 'heart',
                'fields' => [
                    'value_faith_title' => ['label' => 'Judul - Iman', 'type' => 'text'],
                    'value_faith_text' => ['label' => 'Deskripsi - Iman', 'type' => 'textarea'],
                    'value_character_title' => ['label' => 'Judul - Karakter', 'type' => 'text'],
                    'value_character_text' => ['label' => 'Deskripsi - Karakter', 'type' => 'textarea'],
                    'value_achievement_title' => ['label' => 'Judul - Prestasi', 'type' => 'text'],
                    'value_achievement_text' => ['label' => 'Deskripsi - Prestasi', 'type' => 'textarea'],
                ],
            ],
            'program' => [
                'label' => 'Program & Jenjang',
                'icon' => 'graduation-cap',
                'fields' => [
                    'program_eyebrow' => ['label' => 'Eyebrow', 'type' => 'text'],
                    'program_title' => ['label' => 'Judul', 'type' => 'textarea'],
                    'program_description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
                    'jenjang_smp_logo' => ['label' => 'Logo SMP Al Jumhuri', 'type' => 'image'],
                    'jenjang_sma_logo' => ['label' => 'Logo SMA Al Jumhuri', 'type' => 'image'],
                ],
            ],
            'form' => [
                'label' => 'Form Pendaftaran',
                'icon' => 'clipboard-list',
                'fields' => [
                    'form_eyebrow' => ['label' => 'Eyebrow', 'type' => 'text'],
                    'form_title' => ['label' => 'Judul', 'type' => 'textarea'],
                    'form_description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
                    'form_note' => ['label' => 'Catatan', 'type' => 'textarea'],
                ],
            ],
            'footer' => [
                'label' => 'Footer',
                'icon' => 'layout-bottom',
                'fields' => [
                    'footer_title' => ['label' => 'Judul Footer', 'type' => 'text'],
                    'footer_text' => ['label' => 'Teks Footer', 'type' => 'textarea'],
                    'footer_copyright' => ['label' => 'Copyright', 'type' => 'text'],
                    'footer_logo' => ['label' => 'Logo Footer', 'type' => 'image'],
                ],
            ],
        ];
    }

    public function index()
    {
        $fields = $this->fields();
        $settings = PengaturanSitus::pluck('value', 'key')->toArray();

        return view('admin.pengaturan.index', compact('fields', 'settings'));
    }

    public function update(Request $request)
    {
        $fields = $this->fields();

        // Kumpulkan semua key valid
        $validKeys = [];
        foreach ($fields as $group) {
            foreach ($group['fields'] as $key => $meta) {
                $validKeys[$key] = $meta;
            }
        }

        foreach ($request->all() as $key => $value) {
            if (!isset($validKeys[$key]) || $key === '_token' || $key === '_method') {
                continue;
            }

            $meta = $validKeys[$key];

            // Handle upload gambar
            if ($meta['type'] === 'image' && $request->hasFile($key)) {
                $file = $request->file($key);

                $request->validate([
                    $key => 'image|mimes:jpeg,png,jpg,webp,svg|max:3072',
                ]);

                // Hapus file lama (kalau ada & bukan default)
                $old = PengaturanSitus::get($key);
                if ($old && !str_starts_with($old, 'images/default') && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }

                $path = $file->store('images', 'public');
                PengaturanSitus::set($key, $path);
                continue;
            }

            // Handle text/textarea
            if ($meta['type'] !== 'image' && $request->has($key)) {
                PengaturanSitus::set($key, $value);
            }
        }

        return back()->with('success', 'Pengaturan situs berhasil disimpan.');
    }
}