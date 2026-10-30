<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_pembayaran', function (Blueprint $table) {
            $table->id();

            // 1 record per gelombang
            $table->foreignId('gelombang_id')
                  ->unique()
                  ->constrained('gelombang_pendaftarans')
                  ->cascadeOnDelete();

            // ============ OFFLINE ============
            $table->string('offline_alamat')->nullable();
            $table->string('offline_cp_nama')->nullable();
            $table->string('offline_cp_hp')->nullable();
            $table->string('offline_jam')->nullable();
            $table->text('offline_catatan')->nullable();

            // ============ TRANSFER ============
            $table->string('transfer_bank')->nullable();
            $table->string('transfer_norek')->nullable();
            $table->string('transfer_atas_nama')->nullable();
            $table->string('transfer_cabang')->nullable();

            // ============ QRIS ============
            $table->string('qris_image_path')->nullable();

            // ============ UMUM ============
            $table->text('catatan_umum')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_pembayaran');
    }
};