<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('offer'); 
            $table->integer('driverId');
            $table->integer('customerId');

            $table->integer('status')->default(0);

            $table->integer('orderId')->unsigned();
            $table->foreign('orderId')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
                
            $table->integer('isDeleted')->default(0);
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
        Schema::dropIfExists('offers');
    }
}
