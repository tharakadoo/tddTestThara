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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('website_id');
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('user_websites', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('website_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('user_websites');
    }
};
