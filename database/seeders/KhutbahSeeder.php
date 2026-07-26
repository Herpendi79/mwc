<?php

namespace Database\Seeders;

use App\Models\Khutbah;
use App\Models\KhutbahModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class KhutbahSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Menjaga Lisan di Era Digital',
                'tema' => 'Akhlak',
                'khatib' => 'Ust. Budi Santoso',
                'masjid' => 'Masjid Al-Ikhlas',
                'tgl' => Carbon::now()->subDays(7),
                'ringkasan' => 'Bahaya lisan di media sosial dan pentingnya tabayyun.',
                'isi' => '<p>Di zaman fitnah ini, lisan kita seringkali lebih tajam dari pedang...</p>',
                'lampiran' => null,
                'poster' => 'khutbah1.jpg'
            ],
            [
                'judul' => 'Pentingnya Shalat Berjamaah',
                'tema' => 'Ibadah',
                'khatib' => 'Dr. H. Ahmad Fauzi',
                'masjid' => 'Masjid Raya Jakarta',
                'tgl' => Carbon::now()->subDays(14),
                'ringkasan' => 'Keutamaan shalat berjamaah dibandingkan shalat sendirian.',
                'isi' => '<p>Shalat berjamaah memiliki 27 derajat keutamaan...</p>',
                'lampiran' => 'materi_shalat.pdf',
                'poster' => 'khutbah2.jpg'
            ],
            [
                'judul' => 'Memaknai Sabar dalam Ujian',
                'tema' => 'Tazkiyatun Nafs',
                'khatib' => 'Ust. Zulkifli, Lc',
                'masjid' => 'Masjid Nurul Iman',
                'tgl' => Carbon::now()->subDays(21),
                'ringkasan' => 'Sabar bukan berarti diam, tapi ikhtiar disertai ridha.',
                'isi' => '<p>Sabar adalah pilar kekuatan seorang mukmin...</p>',
                'lampiran' => null,
                'poster' => 'khutbah3.jpg'
            ],
            [
                'judul' => 'Peran Pemuda dalam Dakwah',
                'tema' => 'Dakwah',
                'khatib' => 'Ust. Yusuf Mansur',
                'masjid' => 'Masjid Istiqlal',
                'tgl' => Carbon::now()->subDays(28),
                'ringkasan' => 'Pemuda adalah aset bangsa dan agama.',
                'isi' => '<p>Sejarah mencatat pemuda selalu menjadi agen perubahan...</p>',
                'lampiran' => null,
                'poster' => 'khutbah4.jpg'
            ],
            [
                'judul' => 'Bahaya Sifat Kikir',
                'tema' => 'Muamalah',
                'khatib' => 'Ust. Khalid Basalamah',
                'masjid' => 'Masjid Agung Al-Azhar',
                'tgl' => Carbon::now()->subDays(35),
                'ringkasan' => 'Harta adalah titipan, jangan sampai menjadi penghalang ke surga.',
                'isi' => '<p>Kikir adalah penyakit hati yang merusak tali persaudaraan...</p>',
                'lampiran' => 'tabel_zakat.pdf',
                'poster' => 'khutbah5.jpg'
            ],
        ];

        foreach ($data as $item) {
            KhutbahModel::create($item);
        }
    }
}
