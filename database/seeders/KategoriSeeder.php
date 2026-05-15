<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Antiinflamasi',    'deskripsi' => 'Tanaman obat yang memiliki khasiat sebagai anti-peradangan.'],
            ['nama' => 'Antiseptik',       'deskripsi' => 'Tanaman obat yang berfungsi membunuh atau mencegah pertumbuhan mikroorganisme.'],
            ['nama' => 'Antidiabetes',     'deskripsi' => 'Tanaman obat yang membantu mengontrol kadar gula darah.'],
            ['nama' => 'Antihipertensi',   'deskripsi' => 'Tanaman obat yang membantu menurunkan tekanan darah tinggi.'],
            ['nama' => 'Imunostimulan',    'deskripsi' => 'Tanaman obat yang berfungsi meningkatkan sistem kekebalan tubuh.'],
            ['nama' => 'Pencernaan',       'deskripsi' => 'Tanaman obat yang berguna untuk mengatasi masalah pencernaan.'],
            ['nama' => 'Analgetik',        'deskripsi' => 'Tanaman obat yang memiliki khasiat pereda nyeri.'],
            ['nama' => 'Antioksidan',      'deskripsi' => 'Tanaman obat kaya antioksidan untuk menangkal radikal bebas.'],
        ];

        foreach ($kategoris as $k) {
            Kategori::create([
                'nama'      => $k['nama'],
                'slug'      => Str::slug($k['nama']),
                'deskripsi' => $k['deskripsi'],
            ]);
        }
    }
}