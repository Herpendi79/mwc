<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakerData = [
            [
                'judul' => 'Kunjungan Kerja Pimpinan Pondok ke Lembaga Pendidikan Mitra',
                'kategori' => 'Kegiatan',
                'penulis' => 'Admin Utama',
                'ringkasan' => 'Pimpinan pondok beserta jajaran pengurus melakukan kunjungan kerja untuk memperkuat silaturahmi dan kerja sama pendidikan.',
                'isi' => '<p>Pimpinan pondok pesantren melakukan kunjungan kerja strategis ke beberapa lembaga pendidikan mitra di luar kota. Kunjungan ini bertujuan untuk mempererat tali silaturahmi serta merumuskan kurikulum bersama yang lebih adaptif dengan perkembangan zaman.</p><p>Acara ini diakhiri dengan penandatanganan nota kesepahaman (MoU) terkait pertukaran pelajar dan pengajar.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'publish',
            ],
            [
                'judul' => 'Pelatihan Jurnalistik dan Penulisan Kreatif bagi Santri',
                'kategori' => 'Pendidikan',
                'penulis' => 'Tim Media',
                'ringkasan' => 'Mengasah bakat literasi santri, pondok pesantren menggelar pelatihan jurnalistik dasar bersama praktisi media nasional.',
                'isi' => '<p>Dunia literasi di lingkungan pesantren kembali menggeliat melalui kegiatan pelatihan jurnalistik dan penulisan kreatif. Diikuti oleh puluhan santri berbakat, acara ini menghadirkan narasumber profesional dari media nasional.</p><p>Para santri diajarkan cara meliput berita yang baik, teknik wawancara, hingga cara menulis opini yang bernas dan sesuai dengan kaidah jurnalistik.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'publish',
            ],
            [
                'judul' => 'Pendaftaran Santri Baru Tahun Ajaran 2026/2027 Resmi Dibuka',
                'kategori' => 'Pengumuman',
                'penulis' => 'Panitia PSB',
                'ringkasan' => 'Informasi lengkap mengenai jadwal, syarat pendaftaran, dan alur seleksi penerimaan santri baru tahun ajaran mendatang.',
                'isi' => '<p>Panitia Penerimaan Santri Baru (PSB) resmi membuka pendaftaran gelombang pertama untuk tahun ajaran 2026/2027. Pendaftaran dapat dilakukan secara online melalui website resmi maupun datang langsung ke sekretariat pondok.</p><p>Tersedia berbagai program unggulan dan fasilitas modern guna menunjang proses pembelajaran para santri selama menimba ilmu.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'publish',
            ],
            [
                'judul' => 'Peringatan Hari Santri Nasional Diwarnai Berbagai Lomba Kreatif',
                'kategori' => 'Kegiatan',
                'penulis' => 'Admin Utama',
                'ringkasan' => 'Semarak Hari Santri Nasional di lingkungan pondok diisi dengan lomba pidato bahasa Arab/Inggris, musabaqah tilawatil quran, dan bazar.',
                'isi' => '<p>Dalam rangka memperingati Hari Santri Nasional, seluruh santri dan dewan guru antusias mengikuti rangkaian perlombaan yang diselenggarakan oleh panitia internal.</p><p>Kegiatan ini tidak hanya sekadar ajang kompetisi, melainkan sarana untuk mempererat ukhuwah islamiyah dan menumbuhkan rasa percaya diri para santri di muka umum.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'publish',
            ],
            [
                'judul' => 'Kajian Kitab Kuning Rutin Bersama Ulama Tamu',
                'kategori' => 'Akademik',
                'penulis' => 'Bagian Kurikulum',
                'ringkasan' => 'Kajian kitab klasik Fathul Qarib dan Al-Hikam menghadirkan ulama terkemuka untuk memperdalam khazanah keislaman.',
                'isi' => '<p>Tradisi keilmuan klasik tetap dijaga ketat melalui program kajian kitab kuning rutin yang dibimbing langsung oleh ulama tamu terkemuka.</p><p>Para santri tingkat lanjut tampak antusias menyimak penjelasan mendalam mengenai bab-bab fikih muamalah kontemporer yang relevan dengan kehidupan modern saat ini.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'draft',
            ],
            [
                'judul' => 'Prestasi Membanggakan: Santri Raih Juara 1 MTQ Tingkat Provinsi',
                'kategori' => 'Prestasi',
                'penulis' => 'Tim Media',
                'ringkasan' => 'Perwakilan santri berhasil menyabet medali emas dalam ajang Musabaqah Tilawatil Quran tingkat provinsi tahun ini.',
                'isi' => '<p>Kabar gembira datang dari ajang Musabaqah Tilawatil Quran (MTQ) tingkat provinsi. Salah satu santri terbaik pondok berhasil keluar sebagai juara pertama setelah menyisihkan puluhan peserta berbakat lainnya.</p><p>Pihak pondok memberikan apresiasi setinggi-tingginya atas kerja keras santri serta bimbingan intensif dari para ustadz pengampu.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'publish',
            ],
            [
                'judul' => 'Sosialisasi Kesehatan Lingkungan dan Pencegahan Penyakit Menular',
                'kategori' => 'Kesehatan',
                'penulis' => 'Tim Kesehatan',
                'ringkasan' => 'Puskesmas setempat bekerja sama dengan pengurus asrama mengadakan penyuluhan pola hidup bersih dan sehat (PHBS).',
                'isi' => '<p>Menjaga kebersihan lingkungan asrama merupakan prioritas utama demi kesehatan bersama. Tim medis dari puskesmas kecamatan memberikan penyuluhan mendalam terkait penerapan Pola Hidup Bersih dan Sehat (PHBS).</p><p>Para santri diajak untuk aktif menjaga kebersihan kamar, kamar mandi, serta memperhatikan asupan gizi seimbang sehari-hari.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'arsip',
            ],
            [
                'judul' => 'Laporan Pertanggungjawaban Pengurus Organisasi Santri Masa Bakti',
                'kategori' => 'Organisasi',
                'penulis' => 'Kesantrian',
                'ringkasan' => 'Sidang pleno laporan pertanggungjawaban pengurus organisasi santri periode berjalan resmi dilaksanakan di aula utama.',
                'isi' => '<p>Akhir masa kepengurusan organisasi santri ditandai dengan pelaksanaan sidang pleno laporan pertanggungjawaban (LPJ). Acara ini mengevaluasi seluruh program kerja yang telah dijalankan selama satu tahun terakhir.</p><p>Proses regenerasi kepengurusan baru dijadwalkan akan berlangsung pekan depan melalui pemilihan raya secara demokratis.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'arsip',
            ],
            [
                'judul' => 'Workshop Pertanian Modern Berbasis Hidroponik di Lingkungan Pesantren',
                'kategori' => 'Keterampilan',
                'penulis' => 'Bagian Kemandirian',
                'ringkasan' => 'Membekali santri keterampilan wirausaha mandiri melalui pelatihan teknik budidaya tanaman hidroponik praktis.',
                'isi' => '<p>Program kemandirian santri terus dikembangkan melalui pelatihan praktis pertanian modern berbasis sistem hidroponik di area pekarangan pondok.</p><p>Selain ramah lingkungan, teknik ini dinilai efektif menghasilkan sayuran organik segar yang dapat memenuhi kebutuhan konsumsi harian dapur umum pesantren.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'publish',
            ],
            [
                'judul' => 'Jadwal Ujian Akhir Semester Ganjil Tahun Akademik Berjalan',
                'kategori' => 'Akademik',
                'penulis' => 'Bagian Akademik',
                'ringkasan' => 'Pengumuman resmi mengenai jadwal pelaksanaan ujian tulis dan lisan akhir semester ganjil bagi seluruh santri.',
                'isi' => '<p>Bagian Akademik merilis jadwal resmi pelaksanaan Ujian Akhir Semester (UAS) ganjil yang akan dimulai serentak awal bulan depan.</p><p>Seluruh santri diimbau untuk mempersiapkan diri dengan mengulang kembali materi pelajaran dan menjaga kesehatan fisik maupun mental menjelang ujian.</p>',
                'foto' => null,
                'lampiran' => null,
                'status' => 'draft',
            ],
        ];

        foreach ($fakerData as $data) {
            DB::table('berita')->insert([
                'judul' => $data['judul'],
                'kategori' => $data['kategori'],
                'penulis' => $data['penulis'],
                'ringkasan' => $data['ringkasan'],
                'isi' => $data['isi'],
                'foto' => $data['foto'],
                'lampiran' => $data['lampiran'],
                'status' => $data['status'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
