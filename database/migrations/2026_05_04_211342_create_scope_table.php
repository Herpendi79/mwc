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
        if (!Schema::hasTable('scope')) {
            Schema::create('scope', function (Blueprint $table) {
                $table->id('id_sc');
                $table->string('nama_sc');

                // Membuat kolom biasa tanpa foreign key constraint ke database
                $table->unsignedBigInteger('id_conf');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scope');
    }
};
