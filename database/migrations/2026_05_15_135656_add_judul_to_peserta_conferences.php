<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            // Menambah kolom judul setelah kolom no_wa (atau sesuaikan posisinya)
            $table->string('judul')->nullable()->after('file_kp');
        });
    }

    public function down(): void
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            $table->dropColumn('judul');
        });
    }
};
