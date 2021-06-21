<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->default(0);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('address_id')->nullable()->references('id')->on('addresses');
            $table->integer('total_price')->default(0);
            $table->string('payment_method')->default('cashOnDelivery'); // onlinePayment
            $table->enum("order_status", ["confirmed", "pending", "canceled", 'processing'])->default('pending');
            $table->string('payment_status')->default('pending');  //paid , pending , not paid,
            $table->boolean('pinned')->default(0);
            $table->string('currency')->nullable()->default('BDT');
            $table->timestamps();
            $table->softDeletes();
        });

        // php artisan make:migration create_order_product_table --create=order_product
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
