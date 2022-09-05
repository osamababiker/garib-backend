<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('channelId');
            $table->integer('receiverId');
            $table->string('title');
            $table->text('body');

            $table->foreign('channelId')
                ->references('id')
                ->on('channels')
                ->onDelete('cascade');
            $table->foreign('receiverId')
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
        Schema::dropIfExists('notifications');
    }
}
