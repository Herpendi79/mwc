<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('relawan', function (Blueprint $table) {
            // Menambahkan kolom poster setelah kolom yang ada (misal setelah 'id' atau 'nama')
            // Menggunakan nullable agar data lama tidak error
            $table->string('poster')->nullable()->after('deskripsi');
        });
    }

    public function down()
    {
        Schema::table('relawan', function (Blueprint $table) {
            $table->dropColumn('poster');
        });
    }
};
