<?php

namespace Database\Seeders;

use App\Models\BencanaModel;
use Illuminate\Database\Seeder;

class BencanaSeeder extends Seeder
{
    public function run(): void
    {
        $jenis = ['Banjir', 'Gempa Bumi', 'Tanah Longsor', 'Kebakaran'];
        for ($i = 1; $i <= 10; $i++) {
            BencanaModel::create([
                'pelapor' => 'Warga ' . $i,
                'jenis_bencana' => $jenis[array_rand($jenis)],
                'lokasi' => 'Desa ' . chr(64 + $i),
                'tgl' => now(),
                'deskripsi' => 'Deskripsi bencana ke-' . $i,
                'kebutuhan' => 'Makanan, Selimut, Air Bersih',
                'jml_korban' => rand(10, 100),
                'foto' => 'default.jpg'
            ]);
        }
    }
}
