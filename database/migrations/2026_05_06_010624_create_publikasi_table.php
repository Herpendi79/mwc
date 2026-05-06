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
        Schema::create('publikasi', function (Blueprint $table) {
            $table->id('id_pub'); // Auto Increment (AI)
            $table->string('nama_pub');
            $table->string('index')->nullable(); // Misal: Scopus, Sinta 2, Google Scholar
            $table->integer('apc')->default(0); // Article Processing Charge (Biaya Publikasi)
            $table->string('template')->nullable(); // Link atau nama file template (PDF/Word)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi');
    }
};
