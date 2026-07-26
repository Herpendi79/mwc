<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opinis', function (Blueprint $table) {
            $table->id('id_op');
            $table->string('judul');
            $table->string('kategori');
            $table->string('penulis');
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('foto')->nullable();
            $table->string('lampiran')->nullable();
            $table->enum('status', ['draft', 'publish', 'arsip'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opinis');
    }
};
