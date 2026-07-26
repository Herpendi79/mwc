<?php

namespace Database\Seeders;

use App\Models\DakwahModel;
use Illuminate\Database\Seeder;

class DakwahSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = ['Fiqih', 'Aqidah', 'Akhlaq', 'Sejarah'];
        for ($i = 1; $i <= 10; $i++) {
            DakwahModel::create([
                'judul' => 'Tema Dakwah ' . $i,
                'kategori' => $kategori[array_rand($kategori)],
                'mubaligh' => 'Ustadz ' . chr(65 + $i),
                'isi' => 'Konten dakwah mendalam mengenai topik ' . $i,
                'tgl' => now(),
                'status' => 'draft',
                'poster' => 'default.jpg',
                'link_yt' => 'https://youtube.com/watch?v=' . $i
            ]);
        }
    }
}
