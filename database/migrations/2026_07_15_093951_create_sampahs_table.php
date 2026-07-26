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
        Schema::create('sampahs', function (Blueprint $table) {
            $table->id('id_sm'); // Menggunakan id_sm sebagai Primary Key
            $table->string('penyetor');
            $table->string('jenis');
            $table->double('berat'); // Menggunakan double untuk angka desimal
            $table->decimal('nilai', 15, 2); // Menggunakan decimal untuk nominal uang
            $table->date('tgl');
            $table->string('petugas');
            $table->text('ket')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampahs');
    }
};
