<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'student'])->default('student')->after('email');
            $table->string('nisn', 10)->nullable()->unique()->after('role');
            $table->string('no_whatsapp', 20)->nullable()->after('nisn');
            $table->boolean('is_active')->default(true)->after('no_whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nisn', 'no_whatsapp', 'is_active']);
        });
    }
};