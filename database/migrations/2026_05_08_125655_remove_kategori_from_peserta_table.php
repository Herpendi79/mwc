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
        // Cek dulu apakah kolom 'kategori' ada sebelum mencoba menghapusnya
        if (Schema::hasColumn('peserta', 'kategori')) {
            Schema::table('peserta', function (Blueprint $table) {
                $table->dropColumn('kategori');
            });
        }
    }

    public function down()
    {
        // Kebalikannya, cek dulu apakah kolom 'kategori' BELUM ada sebelum menambahkannya kembali
        if (!Schema::hasColumn('peserta', 'kategori')) {
            Schema::table('peserta', function (Blueprint $table) {
                $table->string('kategori')->nullable();
            });
        }
    }
};
