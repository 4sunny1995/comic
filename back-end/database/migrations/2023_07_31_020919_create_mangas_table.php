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
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->string('manga_id');
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('status')->nullable();
            $table->text('thumb')->nullable();
            $table->text('summary')->nullable();
            $table->tinyInteger('nsfw')->default(false);
            $table->tinyInteger('active')->default(false);
            $table->string('type')->nullable();
            $table->string('genres')->nullable();
            $table->string('authors')->nullable();
            $table->string('create_at')->comment('This is create at date from api');
            $table->string('update_at')->comment('This is update at date from api');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};
