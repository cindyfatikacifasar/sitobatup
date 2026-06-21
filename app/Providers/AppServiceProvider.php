<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use App\Mail\BrevoApiTransport;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gunakan Bootstrap 5 untuk pagination
        Paginator::useBootstrapFive();

        // Fix untuk MySQL versi lama yang tidak mendukung panjang string default
        Schema::defaultStringLength(191);

        // Registrasi driver custom Brevo HTTP API
        Mail::extend('brevo-api', function (array $config) {
            return new BrevoApiTransport($config['key'] ?? env('BREVO_API_KEY'));
        });

        // Force HTTPS jika diakses melalui HTTPS (reverse proxy seperti Railway/Cloudflare)
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Jalankan migrasi secara otomatis jika ada tabel/kolom yang belum sinkron di production (cache 7 hari untuk efisiensi)
        try {
            if (!\Illuminate\Support\Facades\Cache::has('migrations_checked_v3')) {
                if (Schema::hasTable('ulasans') && (!Schema::hasColumn('ulasans', 'is_displayed') || !Schema::hasColumn('pengunjungs', 'kode_negara'))) {
                    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                }
                \Illuminate\Support\Facades\Cache::put('migrations_checked_v3', true, now()->addDays(7));
            }
        } catch (\Exception $e) {
            // Abaikan error agar tidak menghalangi booting aplikasi saat build atau setup awal
        }

        // Auto-copy assets from backup to mounted volume if empty
        $backupDir = base_path('storage_backup');
        $publicStorageDir = storage_path('app/public');
        
        if (is_dir($backupDir) && !is_dir($publicStorageDir . '/tanaman')) {
            $this->copyDirectory($backupDir, $publicStorageDir);
        }
    }

    private function copyDirectory(string $src, string $dst): void
    {
        if (!is_dir($src)) {
            return;
        }
        $dir = opendir($src);
        @mkdir($dst, 0755, true);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->copyDirectory($src . '/' . $file, $dst . '/' . $file);
                } else {
                    @copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}