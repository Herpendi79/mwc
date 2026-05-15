<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta_conferences_adaksi', function (Blueprint $table) {
            $table->string('judul')->nullable()->after('no_sertifikat');
        });
    }

    public function down(): void
    {
        Schema::table('peserta_conferences_adaksi', function (Blueprint $table) {
            $table->dropColumn('judul');
        });
    }
};
