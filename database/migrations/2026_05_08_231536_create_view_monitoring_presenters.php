<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Menghapus view jika sudah ada sebelumnya
        DB::statement("DROP VIEW IF EXISTS view_monitoring_presenters");

        // Membuat View yang menggabungkan kedua tabel
        DB::statement("
    CREATE VIEW view_monitoring_presenters AS
    SELECT 
        pc.id_pc AS id_global,
        pc.id_ktg,
        ktg1.id_conf,
        CAST('Non ADAKSI' AS CHAR) COLLATE utf8mb4_unicode_ci AS sumber,
        u.name COLLATE utf8mb4_unicode_ci AS nama_user,
        u.email COLLATE utf8mb4_unicode_ci AS email_user,
        pc.file_abstract COLLATE utf8mb4_unicode_ci AS file_abstract,
        pc.status_abstract COLLATE utf8mb4_unicode_ci AS status_abstract,
        pc.file_artikel COLLATE utf8mb4_unicode_ci AS file_artikel,
        pc.status_artikel COLLATE utf8mb4_unicode_ci AS status_artikel,
        pc.file_kp COLLATE utf8mb4_unicode_ci AS file_kp,
        pc.payment COLLATE utf8mb4_unicode_ci AS payment,
        pc.created_at
    FROM peserta_conferences pc
    -- JOIN langsung ke users_iciphe menggunakan user_id
    JOIN users_iciphe u ON pc.user_id = u.id 
    JOIN kategori ktg1 ON pc.id_ktg = ktg1.id_ktg

    UNION ALL

    SELECT 
        pca.id_pca AS id_global,
        pca.id_ktg,
        ktg2.id_conf,
        CAST('ADAKSI' AS CHAR) COLLATE utf8mb4_unicode_ci AS sumber,
        ang.nama_anggota COLLATE utf8mb4_unicode_ci AS nama_user,
        ua.email COLLATE utf8mb4_unicode_ci AS email_user,
        pca.file_abstract COLLATE utf8mb4_unicode_ci AS file_abstract,
        pca.status_abstract COLLATE utf8mb4_unicode_ci AS status_abstract,
        pca.file_artikel COLLATE utf8mb4_unicode_ci AS file_artikel,
        pca.status_artikel COLLATE utf8mb4_unicode_ci AS status_artikel,
        CAST(NULL AS CHAR) COLLATE utf8mb4_unicode_ci AS file_kp,
        pca.payment COLLATE utf8mb4_unicode_ci AS payment,
        pca.created_at
    FROM peserta_conferences_adaksi pca
    JOIN users ua ON pca.id_user = ua.id_user
    JOIN anggota ang ON ua.id_user = ang.id_user
    JOIN kategori ktg2 ON pca.id_ktg = ktg2.id_ktg
");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_monitoring_presenters");
    }
};
