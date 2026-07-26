<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mangrove', function (Blueprint $table) {
            $table->id();
            $table->string('donatur');
            $table->string('email');
            $table->decimal('jumlah_infaq', 15, 2); // Menggunakan decimal untuk uang
            $table->integer('jumlah_pohon');
            $table->enum('pembayaran', ['tunai', 'transfer']);
            $table->date('tanggal');
            $table->string('no_sertifikat')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mangrove');
    }
};