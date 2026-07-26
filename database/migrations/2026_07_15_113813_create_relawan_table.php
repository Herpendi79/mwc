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
        Schema::create('relawan', function (Blueprint $table) {
            $table->id('id_re');
            $table->string('judul');
            $table->string('lokasi');
            $table->date('tgl');
            $table->string('koordinator');
            $table->integer('jml_korban');
            $table->integer('jml_bantuan');
            $table->text('deskripsi');
            $table->text('foto'); // Disimpan sebagai string, dipisah dengan ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relawan');
    }
};
