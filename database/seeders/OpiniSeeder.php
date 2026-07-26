<?php

namespace Database\Seeders;

use App\Models\OpiniModel;
use Illuminate\Database\Seeder;

class OpiniSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            OpiniModel::create([
                'judul' => 'Judul Opini Ke-' . $i,
                'kategori' => 'Sosial',
                'penulis' => 'Penulis ' . $i,
                'ringkasan' => 'Ringkasan singkat untuk opini ke ' . $i,
                'isi' => 'Ini adalah isi lengkap dari opini ke ' . $i . '. Berisi gagasan mendalam.',
                'status' => 'publish'
            ]);
        }
    }
}
