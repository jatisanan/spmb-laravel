<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PengaturanSitus extends Model
{
    protected $table = 'pengaturan_situs';
    protected $fillable = ['key', 'value', 'tipe', 'grup'];

    /**
     * Ambil nilai pengaturan (text).
     */
    public static function get(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Ambil URL gambar pengaturan dengan fallback otomatis.
     * Prioritas:
     *   1. URL lengkap (http/https) → pakai langsung
     *   2. File di storage/app/public/{value} → asset('storage/' . value)
     *   3. File di public/{value} → asset(value)
     *   4. Fallback ke default (public/images/xxx)
     */
    public static function getImage(string $key, string $default = 'images/placeholder.jpg'): string
    {
        $value = static::where('key', $key)->value('value');

        if (!$value) {
            return asset($default);
        }

        // URL lengkap
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        // Cek di storage/app/public
        if (Storage::disk('public')->exists($value)) {
            return asset('storage/' . $value);
        }

        // Cek di public/
        if (file_exists(public_path($value))) {
            return asset($value);
        }

        // Fallback
        return asset($default);
    }

    /**
     * Simpan / update pengaturan.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Ambil banyak pengaturan sekaligus → array key => value
     */
    public static function getGroup(string $grup): array
    {
        return static::where('grup', $grup)
            ->pluck('value', 'key')
            ->toArray();
    }
}