<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('status_pembayaran')
                  ->default('Belum Bayar')
                  ->after('status_daftar_ulang');

            $table->index('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropIndex(['status_pembayaran']);
            $table->dropColumn('status_pembayaran');
        });
    }
};