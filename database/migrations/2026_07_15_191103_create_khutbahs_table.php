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
        Schema::create('khutbahs', function (Blueprint $table) {
            $table->id('id_kj'); // Primary Key kustom
            $table->string('judul');
            $table->string('tema');
            $table->string('khatib');
            $table->string('masjid');
            $table->date('tgl');
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('lampiran')->nullable(); // misal untuk file PDF
            $table->string('poster')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khutbahs');
    }
};
