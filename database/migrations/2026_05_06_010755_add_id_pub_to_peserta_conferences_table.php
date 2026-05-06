<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            // Tambahkan nullable agar pendaftar lama tidak error, 
            // karena tidak semua peserta (misal: Participant) butuh publikasi.
            $table->unsignedBigInteger('id_pub')->nullable()->after('status_abstract');

            // Definisikan relasi (opsional namun disarankan untuk integritas database)
            $table->foreign('id_pub')->references('id_pub')->on('publikasi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            $table->dropForeign(['id_pub']);
            $table->dropColumn('id_pub');
        });
    }
};
