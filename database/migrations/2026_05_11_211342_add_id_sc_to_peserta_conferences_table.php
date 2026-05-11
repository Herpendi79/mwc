<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            // 1. Hanya buat kolom jika belum ada
            if (!Schema::hasColumn('peserta_conferences', 'id_sc')) {
                $table->unsignedBigInteger('id_sc')->nullable()->after('payment');
            }
        });

        // 2. Tambahkan Foreign Key di luar closure di atas atau closure terpisah 
        // agar tidak bentrok jika kolom sudah ada tapi FK belum ada
        Schema::table('peserta_conferences', function (Blueprint $table) {
            // Cek apakah FK sudah ada (opsional, tapi aman)
            // Kita langsung coba tambahkan FK-nya saja
            try {
                $table->foreign('id_sc')
                    ->references('id_sc')
                    ->on('scope')
                    ->onDelete('set null');
            } catch (\Exception $e) {
                // Jika FK sudah ada, biarkan saja agar tidak error
            }
        });
    }

    public function down()
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            // Gunakan array untuk drop foreign
            $table->dropForeign(['id_sc']);
            $table->dropColumn('id_sc');
        });
    }
};
