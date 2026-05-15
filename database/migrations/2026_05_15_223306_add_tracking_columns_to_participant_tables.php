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
        // Tabel peserta_conferences
        Schema::table('peserta_conferences', function (Blueprint $table) {
            $table->string('qr_code')->nullable()->after('id_sc');
            $table->enum('kehadiran', ['hadir', 'absen'])->nullable()->default(null)->after('qr_code');
            $table->string('link_video')->nullable()->after('kehadiran');
        });

        // Tabel peserta_conferences_adaksi
        Schema::table('peserta_conferences_adaksi', function (Blueprint $table) {
            $table->string('qr_code')->nullable()->after('id_sc');
            $table->enum('kehadiran', ['hadir', 'absen'])->nullable()->default(null)->after('qr_code');
            $table->string('link_video')->nullable()->after('kehadiran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_conferences', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'kehadiran', 'link_video']);
        });

        Schema::table('peserta_conferences_adaksi', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'kehadiran', 'link_video']);
        });
    }
};
