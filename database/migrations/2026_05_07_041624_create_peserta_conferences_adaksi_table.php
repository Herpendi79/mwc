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
        if (!Schema::hasTable('peserta_conferences_adaksi')) {
            Schema::create('peserta_conferences_adaksi', function (Blueprint $table) {
                // id_pca sebagai Primary Key dan Auto Increment
                $table->integer('id_pca')->autoIncrement();

                $table->integer('id_user');
                $table->integer('id_ktg');

                // Kolom Varchar (255) dengan Nullable (Yes pada gambar)
                $table->string('no_sertifikat', 255)->nullable();
                $table->string('file_abstract', 255)->nullable();
                $table->string('status_abstract', 255)->nullable();

                $table->integer('id_pub')->nullable();

                $table->string('file_artikel', 255)->nullable();
                $table->string('status_artikel', 255)->nullable();

                // Kolom Enum (pending, expired, success) default pending
                $table->enum('payment', ['pending', 'expired', 'success'])->default('pending');

                $table->string('snap', 255)->nullable();
                $table->string('order_id', 255)->nullable();

                // Kolom Timestamps (created_at & updated_at)
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_conferences_adaksi');
    }
};
