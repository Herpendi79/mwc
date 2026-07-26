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
        Schema::create('berita_comment', function (Blueprint $table) {
            $table->id('id_com'); // Primary Key
            $table->unsignedBigInteger('id_br'); // Relasi ke tabel berita
            $table->string('nama');
            $table->string('email');
            $table->string('sosmed')->nullable(); // Opsional jika tidak diisi
            $table->text('isi');
            $table->text('reply')->nullable(); // Untuk balasan komentar
            $table->timestamps();

            // Definisi Foreign Key (sesuaikan nama tabel utama berita jika berbeda, misal 'beritas')
            $table->foreign('id_br')
                ->references('id_br')
                ->on('berita')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_comment');
    }
};
