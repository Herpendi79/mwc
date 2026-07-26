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
        Schema::table('roans', function (Blueprint $table) {
            // Menambahkan kolom poster setelah kolom deskripsi (opsional)
            // Gunakan nullable() jika gambar tidak wajib diisi
            $table->string('poster')->nullable()->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('roans', function (Blueprint $table) {
            $table->dropColumn('poster');
        });
    }
};
