<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_ticket_conversations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_id')->unsigned();
            $table->bigInteger('answer_id')->unsigned();
            $table->text('text')->nullable();
            $table->text('file')->nullable();
            $table->timestamps();
            $table->foreign('ticket_id')->references('id')->on('app_tickets')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('app_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_ticket_conversations');
    }
};
