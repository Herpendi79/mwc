<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roan_peserta', function (Blueprint $table) {
            $table->id('id_rp'); // Primary Key
            $table->string('name');
            $table->text('alamat');
            $table->string('email');
            $table->string('telpon', 20);

            // Foreign Key ke tabel roan (asumsi nama tabel 'roan' dengan primary key 'id_ro')
            $table->unsignedBigInteger('id_ro');
            $table->foreign('id_ro')->references('id_ro')->on('roans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roan_peserta');
    }
};
