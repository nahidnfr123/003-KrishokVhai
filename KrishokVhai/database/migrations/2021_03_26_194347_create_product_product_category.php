<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_product_category', function (Blueprint $table) {
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->primary(['product_id', 'product_category_id']);
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
