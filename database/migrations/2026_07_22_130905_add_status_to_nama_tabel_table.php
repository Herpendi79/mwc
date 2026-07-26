<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bencana', function (Blueprint $table) {
            // Menambahkan kolom status bertipe enum setelah kolom foto
            $table->enum('status', ['draft', 'publish', 'arsip'])->default('draft')->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('bencana', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
