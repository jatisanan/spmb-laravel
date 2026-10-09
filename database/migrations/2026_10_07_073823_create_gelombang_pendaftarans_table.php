<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gelombang_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenjang_id')->constrained('jenjangs')->cascadeOnDelete();
            $table->string('nama');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_ujian')->nullable();
            $table->decimal('biaya', 12, 2);
            $table->text('catatan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gelombang_pendaftarans');
    }
};