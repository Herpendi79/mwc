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
        // Tambahkan pengecekan Schema::hasColumn
        if (!Schema::hasColumn('kategori', 'keterangan')) {
            Schema::table('kategori', function (Blueprint $table) {
                $table->string('keterangan')->nullable()->after('id_conf');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('kategori', 'keterangan')) {
            Schema::table('kategori', function (Blueprint $table) {
                $table->dropColumn('keterangan');
            });
        }
    }
};
