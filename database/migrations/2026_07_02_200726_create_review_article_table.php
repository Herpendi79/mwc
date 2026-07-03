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
        Schema::create('review_article', function (Blueprint $table) {
            $table->id('id_rev'); // Primary Key, Auto Increment
            $table->integer('id_global'); // Kolom integer
            $table->string('nama_file'); // Kolom string (varchar)
            $table->string('ket'); // Kolom string
            $table->timestamps(); // Menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_article');
    }
};
