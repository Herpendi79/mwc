<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_monitoring_participants");

        DB::statement("
            CREATE VIEW view_monitoring_participants AS
            SELECT 
                pc.id_pc AS id_global,
                pc.id_ktg,
                pc.qr_code COLLATE utf8mb4_unicode_ci AS qr_code,
                pc.kehadiran COLLATE utf8mb4_unicode_ci AS kehadiran,
                ktg1.id_conf,
                CAST('Non ADAKSI' AS CHAR) COLLATE utf8mb4_unicode_ci AS sumber,
                u.name COLLATE utf8mb4_unicode_ci AS nama_user,
                u.email COLLATE utf8mb4_unicode_ci AS email_user,
                p.no_wa COLLATE utf8mb4_unicode_ci AS no_telp,
                p.negara COLLATE utf8mb4_unicode_ci AS negara,
                pc.payment COLLATE utf8mb4_unicode_ci AS payment,
                pc.created_at AS tanggal_daftar,
                pc.file_bukti_tf COLLATE utf8mb4_unicode_ci AS file_bukti_tf
            FROM peserta_conferences pc
            JOIN users_iciphe u ON pc.user_id = u.id
            LEFT JOIN peserta p ON u.id = p.user_id 
            JOIN kategori ktg1 ON pc.id_ktg = ktg1.id_ktg

            UNION ALL

            SELECT 
                pca.id_pca AS id_global,
                pca.id_ktg,
                pca.qr_code COLLATE utf8mb4_unicode_ci AS qr_code,
                pca.kehadiran COLLATE utf8mb4_unicode_ci AS kehadiran,
                ktg2.id_conf,
                CAST('ADAKSI' AS CHAR) COLLATE utf8mb4_unicode_ci AS sumber,
                ang.nama_anggota COLLATE utf8mb4_unicode_ci AS nama_user,
                ua.email COLLATE utf8mb4_unicode_ci AS email_user,
                ua.no_hp COLLATE utf8mb4_unicode_ci AS no_telp,
                CAST('Indonesia' AS CHAR) COLLATE utf8mb4_unicode_ci AS negara,
                pca.payment COLLATE utf8mb4_unicode_ci AS payment,
                pca.created_at AS tanggal_daftar,
                CAST('Midtrans' AS CHAR) COLLATE utf8mb4_unicode_ci AS file_bukti_tf
            FROM peserta_conferences_adaksi pca
            JOIN users ua ON pca.id_user = ua.id_user
            JOIN anggota ang ON ua.id_user = ang.id_user
            JOIN kategori ktg2 ON pca.id_ktg = ktg2.id_ktg
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_monitoring_participants");
    }
};
