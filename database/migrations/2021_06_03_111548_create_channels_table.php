<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->integer('storeId');
            $table->integer('orderId');
            $table->integer('customerId');
            $table->integer('driverId');
            $table->integer('hasBill')->default(0);
            $table->integer('hasCompleted')->default(0);
            $table->integer('confirmCompleted')->default(0);

            $table->foreign('storeId')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');

            $table->foreign('orderId')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            $table->foreign('customerId')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('driverId')
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
        Schema::dropIfExists('channels');
    }
}
