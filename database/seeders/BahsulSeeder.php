<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BahsulSeeder extends Seeder
{
    public function run()
    {
        DB::table('bahsul')->insert([
            [
                'judul' => 'Hukum Menggunakan Kripto',
                'kategori' => 'Ekonomi Syariah',
                'tanggal' => Carbon::now()->subDays(5),
                'lokasi' => 'Aula MWC Tugu',
                'pemohon' => 'Pengurus Ranting A',
                'masalah' => 'Apakah jual beli mata uang digital diperbolehkan dalam Islam?',
                'putusan' => 'Haram karena mengandung unsur gharar dan maisir.',
                'dasar_hukum' => 'QS. Al-Baqarah: 275',
                'status' => 'draft',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Shalat di Atas Kendaraan Umum',
                'kategori' => 'Ibadah',
                'tanggal' => Carbon::now()->subDays(2),
                'lokasi' => 'Masjid Jami',
                'pemohon' => 'Warga Umum',
                'masalah' => 'Bagaimana tata cara shalat jika tidak memungkinkan turun dari bus?',
                'putusan' => 'Diperbolehkan dengan syarat tertentu sesuai kondisi darurat.',
                'dasar_hukum' => 'Hadits Riwayat Bukhari',
                'status' => 'arsip',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
