<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kajian', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('tema');
            $table->date('tanggal');
            $table->string('pemateri');
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->text('materi')->nullable(); // Disimpan sebagai path file/link
            $table->string('poster')->nullable(); // Thumbnail/Poster
            $table->text('foto')->nullable();     // Disimpan sebagai string dipisah ;
            $table->string('link_yt')->nullable();
            $table->enum('status', ['draft', 'publish', 'arsip'])->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kajian');
    }
};
