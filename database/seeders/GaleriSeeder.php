<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['judul' => 'Penanaman Bibit Tanaman Obat 2024', 'tanggal' => '2024-03-15', 'deskripsi' => 'Kegiatan penanaman bibit tanaman obat baru di Taman Koleksi.'],
            ['judul' => 'Kunjungan Mahasiswa Farmasi UNRI', 'tanggal' => '2024-04-20', 'deskripsi' => 'Kunjungan studi dari mahasiswa Fakultas Farmasi Universitas Riau.'],
            ['judul' => 'Workshop Pengolahan Tanaman Obat', 'tanggal' => '2024-05-10', 'deskripsi' => 'Workshop cara pengolahan tanaman obat menjadi jamu tradisional.'],
            ['judul' => 'Penelitian Tanaman Endemik Riau', 'tanggal' => '2024-06-05', 'deskripsi' => 'Kegiatan penelitian identifikasi tanaman endemik dari Riau.'],
            ['judul' => 'Pemasangan QR Code Tanaman', 'tanggal' => '2024-07-12', 'deskripsi' => 'Pemasangan label QR Code pada setiap tanaman koleksi.'],
            ['judul' => 'Kunjungan Pelajar SMA Bangkinang', 'tanggal' => '2024-08-08', 'deskripsi' => 'Kunjungan edukasi siswa-siswi SMA se-Kabupaten Kampar.'],
        ];

        foreach ($data as $item) {
            Galeri::create($item);
        }
    }
}