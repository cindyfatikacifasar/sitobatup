<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul'    => 'Kebun Raya UP Tambah 10 Koleksi Tanaman Obat Baru',
                'kategori' => 'Informasi',
                'penulis'  => 'Admin SITOBAT',
                'isi'      => 'Taman Koleksi Tanaman Obat Kebun Raya Universitas Pahlawan kembali memperkaya koleksinya dengan menambahkan 10 jenis tanaman obat baru yang berasal dari berbagai daerah di Indonesia. Penambahan koleksi ini merupakan bagian dari program pengembangan taman yang bertujuan untuk memperluas keanekaragaman hayati tanaman berkhasiat obat di kawasan konservasi ini. Beberapa tanaman baru yang ditambahkan di antaranya adalah tanaman endemik dari Kalimantan dan Sumatera yang memiliki khasiat medis tinggi namun belum banyak dikenal masyarakat umum.',
                'views'    => 45,
            ],
            [
                'judul'    => 'Manfaat Jahe untuk Kesehatan yang Sudah Terbukti Secara Ilmiah',
                'kategori' => 'Edukasi',
                'penulis'  => 'Tim Edukasi SITOBAT',
                'isi'      => 'Jahe (Zingiber officinale) telah lama dikenal sebagai tanaman obat dengan segudang manfaat. Berbagai penelitian ilmiah telah membuktikan bahwa kandungan gingerol dalam jahe memiliki efek anti-inflamasi dan antioksidan yang kuat. Bagi penderita mual, baik akibat kehamilan maupun kemoterapi, jahe terbukti dapat membantu meredakan gejala tersebut secara signifikan. Selain itu, konsumsi jahe secara rutin juga dikaitkan dengan penurunan risiko penyakit jantung karena kemampuannya menurunkan kadar kolesterol dan gula darah.',
                'views'    => 78,
            ],
            [
                'judul'    => 'Workshop Pembuatan Jamu Tradisional di Kebun Raya UP',
                'kategori' => 'Kegiatan',
                'penulis'  => 'Admin SITOBAT',
                'isi'      => 'Kebun Raya Universitas Pahlawan mengadakan workshop pembuatan jamu tradisional yang dihadiri oleh 50 peserta dari berbagai kalangan. Kegiatan yang berlangsung selama satu hari penuh ini memberikan pelatihan langsung cara mengolah berbagai tanaman obat koleksi taman menjadi minuman kesehatan tradisional. Para peserta mendapat kesempatan untuk mempraktikkan pembuatan jamu dari tanaman seperti temulawak, kunyit, jahe, dan kayu manis. Pelatihan ini dipandu langsung oleh Penanggung Jawab Taman Koleksi Tanaman Obat, Ners Riani, S.Kep., M.Kes.',
                'views'    => 112,
            ],
        ];

        foreach ($data as $item) {
            Berita::create(array_merge($item, [
                'slug'         => Str::slug($item['judul']),
                'is_published' => true,
            ]));
        }
    }
}