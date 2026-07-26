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
        Schema::table('kajian', function (Blueprint $table) {
            // Mengubah tipe data menjadi text
            $table->text('link_yt')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kajian', function (Blueprint $table) {
            // Mengembalikan ke tipe data sebelumnya (asumsi sebelumnya adalah string)
            $table->string('link_yt')->nullable()->change();
        });
    }
};
