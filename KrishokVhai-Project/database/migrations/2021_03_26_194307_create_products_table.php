<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 255);
            $table->string('product_slug', 255)->default('slug')->nullable();
            $table->foreignId('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->references('id')->on('brands')->onDelete('restrict');
            $table->boolean('status')->default(1);
            $table->integer('total_stock')->default(0);
            $table->string('stock_type')->default('kg');
            $table->integer('regular_price')->default(0);
            $table->integer('retail_price')->default(0);
            $table->integer('minimum_order_amount')->default(1);
            $table->string('currency')->default('TK');
            $table->boolean('can_bid')->default(0);
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
