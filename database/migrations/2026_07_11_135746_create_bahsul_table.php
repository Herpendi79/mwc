<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bahsul', function (Blueprint $table) {
            $table->id('id_bs');
            $table->string('judul');
            $table->string('kategori');
            $table->date('tanggal');
            $table->string('lokasi');
            $table->string('pemohon');
            $table->text('masalah');
            $table->text('putusan');
            $table->text('dasar_hukum');
            $table->enum('status', ['draft', 'publish', 'arsip'])->default('draft');
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahsul');
    }
};
