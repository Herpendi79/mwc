<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HalaqahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('halaqah')->insert([
            [
                'judul' => 'Kajian Rutin Ahad Pagi',
                'tema' => 'Keutamaan Menuntut Ilmu',
                'tanggal' => Carbon::now()->addDays(2),
                'narsum' => 'Ust. Ahmad Fauzi',
                'moderator' => 'Budi Santoso',
                'lokasi' => 'Masjid Agung Al-Falah',
                'deskripsi' => 'Kajian ini membahas tentang pentingnya ilmu dalam kehidupan seorang muslim.',
                'hasil' => 'Peserta memahami bahwa menuntut ilmu adalah wajib bagi setiap muslim.',
                'status' => 'publish',
                'thumbnail' => 'assets/file/default_thumb.jpg',
                'foto' => 'assets/file/default_foto.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Diskusi Panel Pemuda',
                'tema' => 'Peran Pemuda di Era Digital',
                'tanggal' => Carbon::now()->addDays(7),
                'narsum' => 'Dr. Chairul Anwar',
                'moderator' => 'Siti Aminah',
                'lokasi' => 'Aula Serbaguna',
                'deskripsi' => 'Diskusi mengenai tantangan dan peluang pemuda dalam menghadapi era disrupsi.',
                'hasil' => null,
                'status' => 'draft',
                'thumbnail' => null,
                'foto' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
