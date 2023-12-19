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
        Schema::create('app_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('language', 63);
            $table->string('status', 63);
            $table->string('images')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('app_users')->onDelete('restrict');
            $table->string('categories')->nullable();
            $table->string('labels')->nullable();
            $table->text('body')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_kaywords')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
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
        Schema::dropIfExists('app_posts');
    }
};
