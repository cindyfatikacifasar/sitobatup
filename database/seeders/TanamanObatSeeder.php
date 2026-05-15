<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TanamanObat;
use Illuminate\Support\Str;

class TanamanObatSeeder extends Seeder
{
    public function run(): void
    {
        $tanaman = [
            [
                'kategori_id'          => 1,
                'nama'                 => 'Jahe',
                'nama_ilmiah'          => 'Zingiber officinale',
                'deskripsi'            => 'Jahe adalah tanaman rimpang yang sangat populer sebagai bumbu dapur dan bahan obat tradisional. Tanaman ini tumbuh tegak mencapai 30-100 cm dengan batang semu yang terbentuk dari pelepah daun.',
                'khasiat'              => 'Meredakan mual, mengatasi peradangan, meningkatkan imunitas, meredakan nyeri sendi, melancarkan peredaran darah, dan menghangatkan tubuh.',
                'cara_pengolahan'      => 'Rebus 3-5 gram jahe segar yang sudah dikupas dalam 2 gelas air, tambahkan madu dan konsumsi 2 kali sehari. Bisa juga diparut dan diperas untuk diambil sarinya.',
                'bagian_digunakan'     => 'rimpang',
                'asal_usul'            => 'Asia Tenggara',
                'lokasi_etalase'       => 'Blok A - Etalase 1',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 150,
            ],
            [
                'kategori_id'          => 2,
                'nama'                 => 'Sirih',
                'nama_ilmiah'          => 'Piper betle',
                'deskripsi'            => 'Sirih adalah tanaman merambat dengan daun berbentuk jantung. Dikenal sebagai tanaman obat tradisional yang telah digunakan sejak ratusan tahun lalu di Asia Tenggara.',
                'khasiat'              => 'Antibakteri, antiseptik alami, mengobati batuk, meredakan keputihan, mengatasi bau mulut, dan mempercepat penyembuhan luka.',
                'cara_pengolahan'      => 'Rebus 5-10 lembar daun sirih dalam 2 gelas air hingga tersisa 1 gelas. Saring dan minum, atau gunakan air rebusan untuk berkumur.',
                'bagian_digunakan'     => 'daun',
                'asal_usul'            => 'Asia Selatan dan Tenggara',
                'lokasi_etalase'       => 'Blok A - Etalase 2',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 120,
            ],
            [
                'kategori_id'          => 3,
                'nama'                 => 'Sambiloto',
                'nama_ilmiah'          => 'Andrographis paniculata',
                'deskripsi'            => 'Sambiloto adalah tanaman herbal yang dikenal dengan rasa pahitnya. Tanaman ini tegak dengan tinggi 40-90 cm dan banyak ditemukan di daerah tropis Asia.',
                'khasiat'              => 'Menurunkan kadar gula darah, antiinflamasi, antivirus, meningkatkan daya tahan tubuh, dan membantu meredakan demam.',
                'cara_pengolahan'      => 'Rebus 10-20 gram daun sambiloto kering dalam 3 gelas air hingga tersisa 1 gelas. Minum 2 kali sehari setelah makan.',
                'bagian_digunakan'     => 'daun',
                'asal_usul'            => 'India dan Asia Tenggara',
                'lokasi_etalase'       => 'Blok A - Etalase 3',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 95,
            ],
            [
                'kategori_id'          => 4,
                'nama'                 => 'Seledri',
                'nama_ilmiah'          => 'Apium graveolens',
                'deskripsi'            => 'Seledri adalah tanaman herbal berbatang tegak dengan aroma khas. Selain digunakan sebagai bumbu masakan, seledri juga memiliki khasiat medis yang sangat bermanfaat.',
                'khasiat'              => 'Membantu menurunkan tekanan darah tinggi, diuretik alami, antioksidan, mengurangi kadar kolesterol, dan menyehatkan ginjal.',
                'cara_pengolahan'      => 'Cuci bersih 3-4 batang seledri beserta daunnya, blender dengan segelas air, saring dan minum setiap pagi hari.',
                'bagian_digunakan'     => 'daun',
                'asal_usul'            => 'Mediterania',
                'lokasi_etalase'       => 'Blok A - Etalase 4',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 87,
            ],
            [
                'kategori_id'          => 5,
                'nama'                 => 'Temulawak',
                'nama_ilmiah'          => 'Curcuma xanthorrhiza',
                'deskripsi'            => 'Temulawak adalah tanaman rimpang asli Indonesia yang telah lama digunakan sebagai obat tradisional. Memiliki kandungan kurkuminoid yang tinggi.',
                'khasiat'              => 'Meningkatkan nafsu makan, melindungi hati, anti-inflamasi, meningkatkan daya tahan tubuh, dan membantu mengatasi gangguan pencernaan.',
                'cara_pengolahan'      => 'Iris tipis 2-3 iris rimpang temulawak, rebus dalam 2 gelas air hingga tersisa 1 gelas. Tambahkan madu dan minum 2 kali sehari.',
                'bagian_digunakan'     => 'rimpang',
                'asal_usul'            => 'Indonesia (Jawa)',
                'lokasi_etalase'       => 'Blok B - Etalase 1',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 210,
            ],
            [
                'kategori_id'          => 6,
                'nama'                 => 'Kunyit',
                'nama_ilmiah'          => 'Curcuma longa',
                'deskripsi'            => 'Kunyit adalah tanaman rimpang berwarna kuning-oranye yang sangat terkenal sebagai bumbu masakan dan obat tradisional di seluruh dunia.',
                'khasiat'              => 'Anti-inflamasi kuat, antioksidan, membantu pencernaan, melindungi hati dari kerusakan, dan memiliki sifat antikanker.',
                'cara_pengolahan'      => 'Parut 1 ruas kunyit, peras dan ambil airnya, campurkan dengan segelas air hangat dan madu. Konsumsi setiap pagi.',
                'bagian_digunakan'     => 'rimpang',
                'asal_usul'            => 'Asia Selatan',
                'lokasi_etalase'       => 'Blok B - Etalase 2',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 195,
            ],
            [
                'kategori_id'          => 7,
                'nama'                 => 'Lidah Buaya',
                'nama_ilmiah'          => 'Aloe vera',
                'deskripsi'            => 'Lidah buaya adalah tanaman sukulen dengan daun tebal berisi gel bening. Telah digunakan selama ribuan tahun untuk keperluan kesehatan dan kecantikan.',
                'khasiat'              => 'Melembapkan kulit, mengobati luka bakar, meredakan iritasi kulit, melancarkan pencernaan, dan membantu penyembuhan luka.',
                'cara_pengolahan'      => 'Ambil gel dari dalam daun lidah buaya, oleskan langsung pada kulit yang bermasalah. Untuk dikonsumsi, blender gel dengan air dan tambahkan madu.',
                'bagian_digunakan'     => 'daun',
                'asal_usul'            => 'Afrika Utara',
                'lokasi_etalase'       => 'Blok B - Etalase 3',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 175,
            ],
            [
                'kategori_id'          => 8,
                'nama'                 => 'Kayu Manis',
                'nama_ilmiah'          => 'Cinnamomum verum',
                'deskripsi'            => 'Kayu manis adalah tanaman penghasil rempah yang berasal dari kulit batangnya. Memiliki aroma yang khas dan manis, sering digunakan dalam masakan dan pengobatan.',
                'khasiat'              => 'Kaya antioksidan, anti-inflamasi, membantu mengontrol gula darah, menurunkan kolesterol, dan memiliki sifat antibakteri.',
                'cara_pengolahan'      => 'Seduh 1-2 batang kayu manis dalam segelas air panas selama 10 menit seperti membuat teh. Tambahkan madu dan konsumsi 1-2 kali sehari.',
                'bagian_digunakan'     => 'batang',
                'asal_usul'            => 'Sri Lanka',
                'lokasi_etalase'       => 'Blok C - Etalase 1',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 132,
            ],
            [
                'kategori_id'          => 1,
                'nama'                 => 'Lengkuas',
                'nama_ilmiah'          => 'Alpinia galanga',
                'deskripsi'            => 'Lengkuas adalah tanaman rimpang aromatik yang banyak digunakan dalam masakan Asia Tenggara. Memiliki kandungan bioaktif yang bermanfaat untuk kesehatan.',
                'khasiat'              => 'Anti-jamur, antibakteri, anti-inflamasi, meredakan nyeri sendi, membantu mengatasi masalah kulit, dan meningkatkan nafsu makan.',
                'cara_pengolahan'      => 'Parut lengkuas, campur dengan minyak kelapa hangat untuk dioles pada kulit yang gatal atau berjamur. Untuk diminum, rebus bersama rempah lain.',
                'bagian_digunakan'     => 'rimpang',
                'asal_usul'            => 'Asia Tenggara',
                'lokasi_etalase'       => 'Blok C - Etalase 2',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 89,
            ],
            [
                'kategori_id'          => 2,
                'nama'                 => 'Daun Mint',
                'nama_ilmiah'          => 'Mentha piperita',
                'deskripsi'            => 'Daun mint adalah tanaman herbal beraroma segar yang banyak digunakan dalam pengobatan tradisional maupun produk modern seperti obat batuk dan pasta gigi.',
                'khasiat'              => 'Meredakan sakit kepala, mengatasi mual, memperlancar pencernaan, melegakan pernapasan, antiseptik alami, dan menyegarkan napas.',
                'cara_pengolahan'      => 'Seduh 5-10 lembar daun mint segar dalam segelas air panas. Diamkan 5 menit, saring dan minum. Bisa ditambahkan madu untuk rasa yang lebih enak.',
                'bagian_digunakan'     => 'daun',
                'asal_usul'            => 'Eropa dan Asia',
                'lokasi_etalase'       => 'Blok C - Etalase 3',
                'status_ketersediaan'  => 'tersedia',
                'views'                => 103,
            ],
        ];

        foreach ($tanaman as $t) {
            TanamanObat::create(array_merge($t, [
                'slug' => Str::slug($t['nama']),
            ]));
        }
    }
}