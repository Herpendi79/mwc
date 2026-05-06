<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            // 1. Hapus Foreign Key constraint terlebih dahulu
            // Laravel secara default memberi nama: namaTabel_namaKolom_foreign
            $table->dropForeign(['id_conf']);

            // 2. Baru hapus kolomnya
            $table->dropColumn('id_conf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            // Untuk rollback: tambahkan kembali kolom dan relasinya
            $table->unsignedBigInteger('id_conf')->after('id');
            $table->foreign('id_conf')->references('id_conf')->on('conferences')->onDelete('cascade');
        });
    }
};
