<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BeritaCommentModel;

class BeritaCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $idBeritaList = [1, 2, 3, 4];

        foreach ($idBeritaList as $idBr) {
            for ($i = 1; $i <= 40; $i++) {
                BeritaCommentModel::create([
                    'id_br'  => $idBr,
                    'nama'   => 'Pengguna ' . $i . ' (Berita ' . $idBr . ')',
                    'email'  => 'user' . $i . '_br' . $idBr . '@example.com',
                    'sosmed' => '@user_' . $i . '_br' . $idBr,
                    'isi'    => 'Ini adalah isi komentar ke-' . $i . ' untuk artikel berita dengan ID ' . $idBr . '. Sangat informatif dan bermanfaat!',
                    'reply'  => $i % 3 == 0 ? 'Terima kasih atas tanggapannya pada komentar ke-' . $i . '!' : null,
                ]);
            }
        }
    }
}
