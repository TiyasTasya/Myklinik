<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';

    protected $fillable = [
        'nama_klinik',
        'brand_logo',
        'dark_mode_brand_logo',
        'favicon',
        'brand_logo_height',
    ];

    protected static ?self $instance = null;

    public static function getPengaturan(): self
    {
        if (static::$instance !== null) {
            return static::$instance;
        }

        try {
            static::$instance = self::first() ?? self::create([
                'nama_klinik' => 'Myklinik',
                'brand_logo' => null,
                'dark_mode_brand_logo' => null,
                'favicon' => null,
                'brand_logo_height' => '3rem',
            ]);
        } catch (\Throwable $e) {
            static::$instance = new self([
                'nama_klinik' => 'Myklinik',
                'brand_logo' => null,
                'dark_mode_brand_logo' => null,
                'favicon' => null,
                'brand_logo_height' => '3rem',
            ]);
        }

        return static::$instance;
    }

    public static function clearPengaturanCache(): void
    {
        static::$instance = null;
        try {
            Cache::forget('app_pengaturan');
        } catch (\Throwable $e) {
            // Ignore cache error
        }
    }

    public static function getLogoUrl(): string
    {
        try {
            $pengaturan = self::getPengaturan();
            if ($pengaturan->brand_logo && Storage::disk('public')->exists($pengaturan->brand_logo)) {
                return Storage::url($pengaturan->brand_logo);
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        return asset('logo/logo.png');
    }

    public static function getDarkModeLogoUrl(): string
    {
        try {
            $pengaturan = self::getPengaturan();
            if ($pengaturan->dark_mode_brand_logo && Storage::disk('public')->exists($pengaturan->dark_mode_brand_logo)) {
                return Storage::url($pengaturan->dark_mode_brand_logo);
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        return asset('logo/logo-dark.png');
    }

    public static function getFaviconUrl(): string
    {
        try {
            $pengaturan = self::getPengaturan();
            if ($pengaturan->favicon && Storage::disk('public')->exists($pengaturan->favicon)) {
                return Storage::url($pengaturan->favicon);
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        return asset('logo/favicon.png');
    }

    public static function getLogoHeight(): string
    {
        try {
            $pengaturan = self::getPengaturan();
            if (!empty($pengaturan->brand_logo_height)) {
                return $pengaturan->brand_logo_height;
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        return '3rem';
    }
}
