<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RelawanPesertaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $relawanIds = [1, 2, 3, 4, 5];

        foreach ($relawanIds as $id) {
            // Masing-masing id_re mendapat 10 data (5 * 10 = 50 total)
            for ($i = 0; $i < 10; $i++) {
                DB::table('relawan_peserta')->insert([
                    'name'    => $faker->name,
                    'alamat'  => $faker->address,
                    'email'   => $faker->unique()->safeEmail,
                    'telpon'  => $faker->phoneNumber,
                    'id_re'   => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
