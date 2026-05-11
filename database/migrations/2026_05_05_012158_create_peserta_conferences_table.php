<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_conferences', function (Blueprint $table) {
            $table->id('id_pc'); // Primary Key

            // Relasi LANGSUNG ke tabel users_iciphe
            $table->foreignId('user_id')
                ->constrained('users_iciphe')
                ->onDelete('cascade');

            // Relasi One to Many: id_ktg (Kategori) -> id_ktg (Peserta Conferences)
            // Relasi ke id_conf tidak diperlukan lagi secara langsung
            $table->foreignId('id_ktg')
                ->constrained('kategori', 'id_ktg')
                ->onDelete('cascade');

            $table->string('no_sertifikat')->nullable();
            $table->string('file_kp')->nullable();
            $table->string('file_abstract')->nullable();
            $table->string('status_abstract')->nullable();
            $table->string('file_artikel')->nullable();
            $table->string('status_artikel')->nullable();
            $table->enum('payment', ['pending', 'expired', 'success'])->default('pending');
            $table->unsignedBigInteger('id_sc')->nullable();
            $table->string('snap')->nullable();
            $table->string('order_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_conferences');
    }
};
