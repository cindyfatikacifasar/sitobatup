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
    }
}