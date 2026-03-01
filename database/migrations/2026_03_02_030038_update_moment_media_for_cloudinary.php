<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('moment_media', function (Blueprint $table) {

            $table->dropColumn('file_path');

            $table->string('public_id');
            $table->string('secure_url');
            $table->string('resource_type'); // image / video
            $table->string('format')->nullable();
            $table->integer('bytes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('moment_media', function (Blueprint $table) {

            $table->dropColumn([
                'public_id',
                'secure_url',
                'resource_type',
                'format',
                'bytes'
            ]);

            $table->string('file_path');
        });
    }
};