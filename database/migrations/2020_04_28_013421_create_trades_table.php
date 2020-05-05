<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offeror_user_id');
            $table->unsignedBigInteger('receiver_user_id');
            $table->integer('status')->unsigned()->default(0); // 0:Pinding | 1:Accepted | 2:Declined | 3:closed            
            $table->double('longtitude', 15, 8)->nullable()->default(30.45);            
            $table->double('latitude', 15, 8)->nullable()->default(30.45);            
            $table->timestamps();

            $table->foreign('offeror_user_id')->references('id')->on('users');
            $table->foreign('receiver_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trades');
    }
}
