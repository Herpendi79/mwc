<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 5; $i++) {
            \App\Models\RelawanModel::create([
                'judul' => 'Aksi ' . $faker->sentence(2),
                'lokasi' => $faker->city,
                'tgl' => $faker->date,
                'koordinator' => $faker->name,
                'jml_korban' => rand(10, 100),
                'jml_bantuan' => rand(100, 500),
                'deskripsi' => $faker->paragraph,
                'foto' => 'default.jpg'
            ]);
        }
    }
}
