<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trade_id');
            $table->unsignedBigInteger('offered_product_id');
            $table->unsignedBigInteger('requested_product_id');
            $table->timestamps();

            $table->foreign('trade_id')->references('id')->on('trades');
            $table->foreign('offered_product_id')->references('id')->on('products');
            $table->foreign('requested_product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_products');
    }
}
