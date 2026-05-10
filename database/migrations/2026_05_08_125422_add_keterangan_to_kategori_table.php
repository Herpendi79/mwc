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
        Schema::table('kategori', function (Blueprint $table) {
            // Menambahkan kolom keterangan setelah id_conf
            // nullable() agar data lama yang sudah ada tidak error
            $table->string('keterangan')->nullable()->after('id_conf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn('keterangan');
        });
    }
};
