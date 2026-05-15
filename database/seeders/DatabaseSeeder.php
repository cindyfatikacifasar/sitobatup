<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            TanamanObatSeeder::class,
            GaleriSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}