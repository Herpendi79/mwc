<?php

namespace Database\Seeders;

use App\Models\RoanModel;
use Illuminate\Database\Seeder;

class RoanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Kerja Bakti Lingkungan A',
                'tema' => 'Bersih Sungai',
                'tgl' => '2026-07-01',
                'lokasi' => 'Jl. Melati No 1',
                'pj' => 'Budi Santoso',
                'vol_sampah' => 50.5,
                'deskripsi' => 'Pembersihan rutin area pinggiran sungai.',
                'foto' => 'sungai1.jpg;sungai2.jpg;sungai3.jpg'
            ],
            [
                'judul' => 'Grebek Sampah Taman',
                'tema' => 'Go Green',
                'tgl' => '2026-07-05',
                'lokasi' => 'Taman Kota',
                'pj' => 'Siti Aminah',
                'vol_sampah' => 30.0,
                'deskripsi' => 'Pembersihan area bermain anak.',
                'foto' => 'taman1.jpg;taman2.jpg;taman3.jpg'
            ],
            [
                'judul' => 'Pembersihan Saluran Air',
                'tema' => 'Drainase Sehat',
                'tgl' => '2026-07-10',
                'lokasi' => 'RW 05',
                'pj' => 'Andi Wijaya',
                'vol_sampah' => 120.75,
                'deskripsi' => 'Mencegah banjir di musim penghujan.',
                'foto' => 'drainase1.jpg;drainase2.jpg;drainase3.jpg'
            ],
        ];

        foreach ($data as $item) {
            RoanModel::create($item);
        }
    }
}
