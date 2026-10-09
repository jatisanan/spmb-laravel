<?php

namespace Database\Seeders;

use App\Models\PengaturanSitus;
use Illuminate\Database\Seeder;

class PengaturanSitusSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Header
            ['header_kicker', 'Pondok Pesantren', 'text', 'header'],
            ['header_name', 'Jati Sanan', 'text', 'header'],
            ['header_logo', null, 'image', 'header'],

            // Hero
            ['hero_badge', 'Penerimaan Santri Baru', 'text', 'hero'],
            ['hero_title', 'Tumbuh Berilmu, Beradab, dan Berakhlak Mulia', 'textarea', 'hero'],
            ['hero_description', 'Mari bergabung bersama keluarga besar Pondok Pesantren Jati Sanan. Siapkan putra-putri Anda untuk masa depan yang berilmu, mandiri, dan berlandaskan nilai-nilai Islam.', 'textarea', 'hero'],
            ['hero_cta_text', 'Isi Formulir Pendaftaran', 'text', 'hero'],
            ['hero_info_text', 'Kenali Pesantren Kami', 'text', 'hero'],
            ['hero_image', 'images/hero-gate.jpg', 'image', 'hero'],

            // Tentang
            ['about_eyebrow', 'Tentang Kami', 'text', 'about'],
            ['about_title', 'Ruang Belajar dan Pembinaan untuk Generasi Berprestasi', 'textarea', 'about'],
            ['about_description', 'Pondok Pesantren Jati Sanan hadir sebagai rumah bagi santri untuk menimba ilmu agama, membentuk karakter, dan mengembangkan potensi diri dalam lingkungan yang islami dan kondusif.', 'textarea', 'about'],
            ['about_experience_number', '25+', 'text', 'about'],
            ['about_experience_text', 'Tahun mendidik generasi berakhlak mulia', 'text', 'about'],
            ['about_image', 'images/building.jpg', 'image', 'about'],

            // Value cards
            ['value_faith_title', 'Beriman & Bertaqwa', 'text', 'value'],
            ['value_faith_text', 'Menanamkan aqidah yang kuat dan ibadah yang benar sesuai tuntunan Al-Qur\'an dan Sunnah.', 'textarea', 'value'],
            ['value_character_title', 'Berakhlak Mulia', 'text', 'value'],
            ['value_character_text', 'Membentuk pribadi santri yang santun, jujur, dan menghormati orang tua serta guru.', 'textarea', 'value'],
            ['value_achievement_title', 'Berprestasi', 'text', 'value'],
            ['value_achievement_text', 'Mendorong santri untuk berprestasi di bidang akademik maupun non-akademik.', 'textarea', 'value'],

            // Program
            ['program_eyebrow', 'Pilihan Jenjang', 'text', 'program'],
            ['jenjang_smp_logo', null, 'image', 'program'],
            ['jenjang_sma_logo', null, 'image', 'program'],

            ['program_title', 'Mulai Perjalanan Pendidikan Terbaik', 'textarea', 'program'],
            ['program_description', 'Pilih jenjang pendidikan sesuai tahap belajar calon santri dan tumbuh bersama lingkungan pesantren yang suportif.', 'textarea', 'program'],

            // Form
            ['form_eyebrow', 'Formulir Pendaftaran', 'text', 'form'],
            ['form_title', 'Daftarkan Putra-Putri Anda', 'textarea', 'form'],
            ['form_description', 'Lengkapi data di bawah ini dengan benar. Nomor pendaftaran akan muncul setelah formulir berhasil dikirim.', 'textarea', 'form'],
            ['form_note', 'Data Anda akan kami jaga kerahasiaannya dan hanya digunakan untuk keperluan pendaftaran santri baru.', 'textarea', 'form'],

            // Footer
            ['footer_title', 'Pondok Pesantren Jati Sanan', 'text', 'footer'],
            ['footer_logo', null, 'image', 'footer'],

            ['footer_text', 'Mendidik generasi berilmu, beradab, dan berakhlak mulia.', 'textarea', 'footer'],
            ['footer_copyright', 'Hak Cipta © 2026 Pondok Pesantren Jati Sanan', 'text', 'footer'],
        ];

        foreach ($data as [$key, $value, $tipe, $grup]) {
            PengaturanSitus::updateOrCreate(['key' => $key], [
                'value' => $value,
                'tipe' => $tipe,
                'grup' => $grup,
            ]);
        }
    }
}