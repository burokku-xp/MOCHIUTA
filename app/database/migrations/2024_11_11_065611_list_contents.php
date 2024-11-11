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
        Schema::create('list_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('points');
            $table->string('comment', '500')->nullable();
            $table->string('music_data_path', '500')->nullable()->comment('ストレージパスを格納');
            $table->integer('list_id');
            $table->integer('songs_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_contents');
    }
};
