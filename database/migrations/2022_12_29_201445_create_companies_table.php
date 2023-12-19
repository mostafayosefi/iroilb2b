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
        Schema::create('app_companies', function (Blueprint $table) {
            $table->id();
            $table->string('users_management',255);
            $table->string('slug',127)->nullable();
            $table->string('status',127)->default('draft');
            $table->string('verified',127)->default('normal');
            $table->text('body_fa')->nullable();
            $table->text('body_en')->nullable();
            $table->text('data')->nullable();
            $table->text('logo')->nullable();
            $table->text('document_one')->nullable();
            $table->text('document_tow')->nullable();
            $table->text('document_three')->nullable();
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
        Schema::dropIfExists('app_companies');
    }
};
