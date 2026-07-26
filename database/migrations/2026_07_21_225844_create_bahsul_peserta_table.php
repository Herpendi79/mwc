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
        Schema::create('bahsul_peserta', function (Blueprint $table) {
            $table->id('id_bsp');
            $table->string('name');
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('telpon')->nullable();

            // Sesuaikan tipe data dengan primary key tabel bahsul.
            // Contoh jika primary key tabel bahsul adalah 'id_bsp':
            $table->unsignedBigInteger('id_bs');
            $table->foreign('id_bs')->references('id_bs')->on('bahsul')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahsul_peserta');
    }
};
