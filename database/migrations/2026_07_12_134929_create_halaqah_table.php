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
        Schema::create('halaqah', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('tema');
            $table->date('tanggal'); // Gunakan dateTime('tanggal') jika butuh jam pelaksanaannya
            $table->string('narsum');
            $table->string('moderator');
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->text('hasil')->nullable(); // Dibuat nullable karena hasil biasanya diisi setelah acara selesai
            $table->enum('status', ['draft', 'publish', 'arsip'])->default('draft');
            $table->string('thumbnail')->nullable(); // Dibuat nullable agar form bisa disimpan tanpa gambar
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halaqah');
    }
};
