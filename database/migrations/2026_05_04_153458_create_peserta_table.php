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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users_iciphe
            $table->foreignId('user_id')
                ->constrained('users_iciphe')
                ->onDelete('cascade');

            $table->string('nama');
            $table->string('negara');
            $table->string('no_wa');
            $table->string('kategori'); // e.g., Presenter, Participant, Student

            // Status: waiting (default), valid, nonvalid
            $table->enum('status', ['waiting', 'valid', 'nonvalid'])->default('waiting');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
