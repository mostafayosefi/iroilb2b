<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id_sender')->unsigned();
            $table->bigInteger('user_id_receiver')->unsigned();
            $table->string('status',63);
            $table->text('message');
            $table->foreign('user_id_receiver')->references('id')->on('app_users')->onDelete('cascade');
            $table->foreign('user_id_sender')->references('id')->on('app_users')->onDelete('cascade');
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
        Schema::dropIfExists('app_user_notifications');
    }
};
