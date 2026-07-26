<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesertaBahsulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar id_bs yang ingin diisi
        $idBsList = [1, 2, 7];

        // Data dummy untuk nama peserta (menggunakan Faker bawaan Laravel)
        $faker = \Faker\Factory::create('id_ID'); // Menggunakan format lokal Indonesia

        $dataPeserta = [];

        for ($i = 1; $i <= 30; $i++) {
            $dataPeserta[] = [
                'id_bs'      => $faker->randomElement($idBsList), // Memilih secara acak antara 1, 2, atau 7
                'name'       => $faker->name(),
                'email'      => $faker->unique()->safeEmail(),
                'telpon'     => $faker->phoneNumber(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan data ke database secara massal (bulk insert)
        DB::table('bahsul_peserta')->insert($dataPeserta);
    }
}
