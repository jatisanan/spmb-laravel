<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pendaftaran_id')
                  ->unique()
                  ->constrained('pendaftarans')
                  ->cascadeOnDelete();

            // Snapshot nominal biaya dari gelombang
            $table->decimal('jumlah', 12, 2);

            // Metode & status
            $table->string('metode')->nullable();           // offline | transfer | qris
            $table->string('status')->default('Belum Bayar');
            // Belum Bayar | Menunggu Verifikasi | Terverifikasi | Gagal

            // Bukti bayar
            $table->string('bukti_path')->nullable();
            $table->string('bukti_nama_asli')->nullable();
            $table->timestamp('uploaded_at')->nullable();

            // Deadline (opsional, untuk masa depan)
            $table->timestamp('deadline_at')->nullable();

            // Verifikasi
            $table->text('catatan_admin')->nullable();
            $table->foreignId('verified_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            // Index untuk filter cepat di admin
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};