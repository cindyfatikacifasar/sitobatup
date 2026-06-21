<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

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