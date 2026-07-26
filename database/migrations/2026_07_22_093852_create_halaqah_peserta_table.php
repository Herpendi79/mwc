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
        Schema::create('halaqah_peserta', function (Blueprint $table) {
            $table->id('id_ph'); // Primary Key kustom id_ph
            $table->string('name');
            $table->text('alamat')->nullable();
            $table->string('email');
            $table->string('telpon')->nullable();

            // Relasi dengan tabel users (kolom id)
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halaqah_peserta');
    }
};
