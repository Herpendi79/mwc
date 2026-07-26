<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relawan_peserta', function (Blueprint $table) {
            $table->id('id_rp');
            $table->string('name');
            $table->text('alamat');
            $table->string('email');
            $table->string('telpon', 20);

            // Foreign Key ke tabel relawan
            $table->unsignedBigInteger('id_re');
            $table->foreign('id_re')->references('id_re')->on('relawan')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relawan_peserta');
    }
};
