<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mangrove', function (Blueprint $table) {
            // Menambahkan kolom bukti_tf bertipe string (menyimpan path file)
            // nullable() digunakan karena donasi tunai mungkin tidak memerlukan bukti tf
            $table->string('bukti_tf')->nullable()->after('jumlah_infaq');
        });
    }

    public function down(): void
    {
        Schema::table('mangrove', function (Blueprint $table) {
            $table->dropColumn('bukti_tf');
        });
    }
};
