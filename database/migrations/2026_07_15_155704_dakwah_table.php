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
        Schema::create('dakwah', function (Blueprint $table) {
            $table->id('id_pd');
            $table->string('judul');
            $table->string('kategori');
            $table->string('mubaligh');
            $table->text('isi');
            $table->timestamp('tgl')->useCurrent();
            $table->enum('status', ['draft', 'publish', 'arsip'])->default('draft');
            $table->string('poster');
            $table->string('link_yt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
