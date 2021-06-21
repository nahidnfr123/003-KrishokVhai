<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostPostCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('post_post_category', function (Blueprint $table) {
            $table->foreignId('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreignId('post_category_id')->references('id')->on('post_categories')->onDelete('cascade');
            $table->primary(['post_id', 'post_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('post_post_category');
    }
}
