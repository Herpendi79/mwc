<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->id('id_conf'); // Primary Key
            $table->string('nama_conf');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->date('deadline_subm');
            $table->string('link_zoom')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
