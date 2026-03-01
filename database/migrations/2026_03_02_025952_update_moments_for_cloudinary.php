<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('moments', function (Blueprint $table) {

            // Hapus kolom lama
            $table->dropColumn('image');

            // Tambah kolom cloudinary
            $table->string('image_public_id')->nullable();
            $table->string('image_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('moments', function (Blueprint $table) {

            $table->dropColumn(['image_public_id','image_url']);

            $table->string('image')->nullable();
        });
    }
};