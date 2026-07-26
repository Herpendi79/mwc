<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesertaHalaqahModel;

class HalaqahPesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $validUserIds = [1, 2, 4]; // Daftar ID user yang tersedia di database

        for ($i = 1; $i <= 30; $i++) {
            // Membagi id_halaqah secara merata ke angka 1, 2, dan 3
            $idHalaqah = (($i - 1) % 3) + 1;

            // Mengambil ID user secara bergiliran dari array [1, 2, 4]
            $userId = $validUserIds[($i - 1) % count($validUserIds)];

            $data[] = [
                'name'        => 'Peserta Halaqah ' . $i,
                'alamat'      => 'Jl. Contoh Alamat No. ' . $i . ', Tugu, Semarang',
                'email'       => 'pesertahalaqah' . $i . '@example.com',
                'telpon'      => '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'id'          => $userId,    // Menggunakan ID 1, 2, atau 4 secara bergiliran
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        PesertaHalaqahModel::insert($data);
    }
}
