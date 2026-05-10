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
        if (!Schema::hasTable('kategori')) {
            Schema::create('kategori', function (Blueprint $table) {
                $table->id('id_ktg');
                $table->string('nama_ktg');
                $table->enum('jenis', ['offline', 'online']);
                $table->enum('domisili', ['domestic', 'international']);
                $table->integer('fee');

                // Menggunakan foreignId agar tipe data otomatis sinkron (Unsigned Big Integer)
                // constrained() akan mencari tabel 'conference' dan kolom 'id_conf'
                $table->foreignId('id_conf')
                    ->constrained('conferences', 'id_conf')
                    ->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
