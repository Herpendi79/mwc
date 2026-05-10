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
        Schema::table('peserta', function (Blueprint $table) {
            // Menghapus kolom kategori
            $table->dropColumn('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            // Mengembalikan kolom jika migrasi dibatalkan (rollback)
            // Sesuaikan tipe datanya dengan tipe data sebelumnya (misal: string)
            $table->string('kategori')->nullable();
        });
    }
};
