<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            $this->rebuildSqliteRoleColumn();
        } else {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'super_admin', 'student') NOT NULL DEFAULT 'student'");
        }
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'super_admin')->update(['role' => 'admin']);

        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'student') NOT NULL DEFAULT 'student'");
        }
    }

    private function rebuildSqliteRoleColumn(): void
    {
        $tableSql = DB::selectOne("SELECT sql FROM sqlite_master WHERE type='table' AND name='users'")->sql ?? '';

        if (stripos($tableSql, 'check') === false || stripos($tableSql, "'admin'") === false) {
            return;
        }

        DB::statement('PRAGMA foreign_keys = OFF');

        // 1. Rename tabel lama
        Schema::rename('users', 'users_old_backup');

        // 2. DROP index lama (nama masih menempel)
        $indexes = DB::select("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name='users_old_backup' AND name NOT LIKE 'sqlite_%'");
        foreach ($indexes as $idx) {
            DB::statement('DROP INDEX IF EXISTS "' . $idx->name . '"');
        }

        // 3. Create tabel baru
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('student');
            $table->string('nisn', 10)->nullable()->unique();
            $table->string('no_whatsapp', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        // 4. Copy data dengan KOLOM EKSPLISIT — urutan tabel lama:
        //    id, name, email, email_verified_at, password, remember_token,
        //    created_at, updated_at, role, nisn, no_whatsapp, is_active
        DB::statement('
            INSERT INTO users (
                id, name, email, email_verified_at, password,
                role, nisn, no_whatsapp, is_active,
                remember_token, created_at, updated_at
            )
            SELECT
                id, name, email, email_verified_at, password,
                COALESCE(role, \'student\'),
                nisn, no_whatsapp,
                COALESCE(is_active, 1),
                remember_token, created_at, updated_at
            FROM users_old_backup
        ');

        // 5. Hapus tabel backup
        Schema::drop('users_old_backup');

        DB::statement('PRAGMA foreign_keys = ON');
    }
};