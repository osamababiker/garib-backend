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
            $table->bigIncrements('id');
            $table->integer('userId')->unsigned();
            $table->integer('storeId')->unsigned();
            $table->text('order');

            $table->string('storeLat');
            $table->string('storeLng');
            $table->string('customerLng');
            $table->string('customerLat');
            $table->string('max_price');
            $table->string('min_price');
            $table->integer('status')->default(0);

            $table->foreign('storeId')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');
            $table->foreign('userId')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('orders');
    }
}
