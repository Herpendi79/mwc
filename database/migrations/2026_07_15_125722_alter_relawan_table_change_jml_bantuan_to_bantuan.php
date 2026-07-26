<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('relawan', function (Blueprint $table) {
            // Mengubah tipe data dan nama kolom
            // Note: Pastikan Anda sudah menginstal doctrine/dbal untuk rename kolom
            $table->renameColumn('jml_bantuan', 'bantuan');
        });

        Schema::table('relawan', function (Blueprint $table) {
            // Mengubah tipe data menjadi text
            $table->text('bantuan')->change();
        });
    }

    public function down(): void
    {
        Schema::table('relawan', function (Blueprint $table) {
            // Rollback: ubah kembali ke integer dan rename ke jml_bantuan
            $table->integer('bantuan')->change();
            $table->renameColumn('bantuan', 'jml_bantuan');
        });
    }
};
