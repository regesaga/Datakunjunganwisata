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
        Schema::create('youtubes', function (Blueprint $table) {
            $table->id();
            $table->string('e_tag');
            $table->string('vidio_id');
            $table->string('channel_id');
            $table->string('title');
            $table->longText('description');
            $table->json('thumbnails');
            $table->string('channelTitle');
            $table->dateTime('publishedAt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtubes');
    }
};
