<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RoanPesertaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan lokalitas Indonesia

        // Kita ingin total 40 data, dengan id_ro 1, 2, 3, dan 4
        // Berarti masing-masing id_ro mendapatkan 10 data (40 / 4 = 10)
        $roanIds = [1, 2, 3, 4];

        foreach ($roanIds as $id) {
            for ($i = 0; $i < 10; $i++) {
                DB::table('roan_peserta')->insert([
                    'name'    => $faker->name,
                    'alamat'  => $faker->address,
                    'email'   => $faker->unique()->safeEmail,
                    'telpon'  => $faker->phoneNumber,
                    'id_ro'   => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
