<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roans', function (Blueprint $table) {
            $table->id('id_ro');
            $table->string('judul');
            $table->string('tema');
            $table->date('tgl');
            $table->string('lokasi');
            $table->string('pj'); // Penanggung Jawab
            $table->decimal('vol_sampah', 8, 2); // Volume dalam m3 atau kg
            $table->text('deskripsi');
            $table->string('foto'); // Disimpan dengan pemisah ;
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roans');
    }
};
