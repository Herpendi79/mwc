<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KajianModel;
use Illuminate\Support\Facades\DB;

class KajianSeeder extends Seeder
{
    public function run()
    {
        // Opsional: Kosongkan tabel sebelum diisi agar data tidak menumpuk
        DB::table('kajian')->truncate();

        KajianModel::create([
            'judul'     => 'Fiqih Shalat Berjamaah',
            'tema'      => 'Memahami Keutamaan Shalat Berjamaah',
            'tanggal'   => '2026-07-15',
            'pemateri'  => 'Ustadz Ahmad Fauzi, Lc.',
            'lokasi'    => 'Masjid Agung Jakarta',
            'deskripsi' => 'Kajian rutin membahas tata cara dan keutamaan shalat berjamaah sesuai sunnah.',
            'materi'    => 'materi_shalat.pdf',
            'poster'    => 'poster_shalat.jpg',
            'foto'      => 'foto1.jpg;foto2.jpg',
            'link_yt'   => 'https://youtube.com/watch?v=contoh',
            'status'    => 'draft',
        ]);

        KajianModel::create([
            'judul'     => 'Kajian Tafsir Juz Amma',
            'tema'      => 'Meneladani Akhlak Nabi',
            'tanggal'   => '2026-07-20',
            'pemateri'  => 'KH. Abdullah Syahid',
            'lokasi'    => 'Aula Pondok Pesantren',
            'deskripsi' => 'Kajian pendalaman tafsir Juz Amma dengan pendekatan kontekstual.',
            'materi'    => null,
            'poster'    => 'poster_tafsir.jpg',
            'foto'      => 'kajian1.jpg',
            'link_yt'   => null,
            'status'    => 'draft',
        ]);
    }
}
