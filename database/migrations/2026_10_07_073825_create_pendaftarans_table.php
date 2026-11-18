<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran', 30)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('jenjang_id')->constrained('jenjangs');
            $table->foreignId('gelombang_id')->constrained('gelombang_pendaftarans');

            // Data santri
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->char('nisn', 10)->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('asal_sekolah');
            $table->string('no_whatsapp', 20);
            $table->text('alamat');

            // Data orang tua
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nama_wali')->nullable();

            // Status verifikasi & ujian
            $table->enum('status_verifikasi', ['Menunggu Verifikasi', 'Terverifikasi', 'Perlu Perbaikan'])->default('Menunggu Verifikasi');
            $table->text('catatan_verifikasi')->nullable();
            $table->enum('status_ujian', ['Belum Dijadwalkan', 'Terjadwal', 'Sudah Ujian'])->default('Belum Dijadwalkan');
            $table->date('tanggal_ujian')->nullable();
            $table->string('nilai_ujian')->nullable();

            // Kelulusan
            $table->enum('status_kelulusan', ['Menunggu Hasil', 'Lulus', 'Tidak Lulus'])->default('Menunggu Hasil');
            $table->enum('status_daftar_ulang', ['Belum Dibuka', 'Sudah Daftar Ulang', 'Belum Daftar Ulang'])->default('Belum Dibuka');
            $table->date('tanggal_daftar_ulang')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};