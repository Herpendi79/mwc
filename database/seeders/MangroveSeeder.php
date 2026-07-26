<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MangroveModel;
use Carbon\Carbon;

class MangroveSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'donatur'       => 'Budi Santoso',
                'email'         => 'budi@example.com',
                'jumlah_infaq'  => 500000,
                'jumlah_pohon'  => 10,
                'pembayaran'    => 'transfer',
                'tanggal'       => Carbon::now()->subDays(2),
                'no_sertifikat' => 'MNG-20260712-001',
            ],
            [
                'donatur'       => 'Siti Aminah',
                'email'         => 'siti@example.com',
                'jumlah_infaq'  => 250000,
                'jumlah_pohon'  => 5,
                'pembayaran'    => 'tunai',
                'tanggal'       => Carbon::now()->subDays(1),
                'no_sertifikat' => 'MNG-20260712-002',
            ],
            [
                'donatur'       => 'Ahmad Fauzi',
                'email'         => 'ahmad@example.com',
                'jumlah_infaq'  => 1000000,
                'jumlah_pohon'  => 20,
                'pembayaran'    => 'transfer',
                'tanggal'       => Carbon::now(),
                'no_sertifikat' => 'MNG-20260712-003',
            ],
        ];

        foreach ($data as $item) {
            MangroveModel::create($item);
        }
    }
}
