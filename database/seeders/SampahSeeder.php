<?php

namespace Database\Seeders;

use App\Models\SampahModel;
use Illuminate\Database\Seeder;

class SampahSeeder extends Seeder
{
    public function run()
    {
        SampahModel::create([
            'penyetor' => 'Budi Santoso',
            'jenis'    => 'Plastik',
            'berat'    => 5.5,
            'nilai'    => 15000,
            'tgl'      => now(),
            'petugas'  => 'Admin Tugu',
            'ket'      => 'Sampah rumah tangga',
            'foto'     => null
        ]);
    }
}
