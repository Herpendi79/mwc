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
        Schema::table('halaqah', function (Blueprint $table) {
            // Mengubah kolom foto menjadi text
            $table->text('foto')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('halaqah', function (Blueprint $table) {
            // Mengembalikan ke string (varchar 255) jika rollback
            $table->string('foto', 255)->nullable()->change();
        });
    }
};
