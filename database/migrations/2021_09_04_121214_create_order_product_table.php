<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            // $table->integer('product_id')->unsigned();
            // $table->integer('order_id')->unsigned();
            $table->integer('quantity')->default(1);
   
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_order');
    }
}
