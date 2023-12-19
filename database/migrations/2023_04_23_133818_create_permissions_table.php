<?php

use App\Models\Admin\Permissions;
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
        Schema::create('app_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->text('access')->nullable();
            $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');
            $table->timestamps();
        });

        $query = new Permissions([
            'user_id' => 1,
            'access' => '{"dashboard":{"show":true},"post":{"show":true,"add":true,"edit":true,"delete":true},"category":{"show":true,"add":true,"edit":true,"delete":true},"label":{"show":true,"add":true,"edit":true,"delete":true},"page":{"show":true,"add":true,"edit":true,"delete":true},"operator":{"show":true},"table":{"show":true,"add":true,"edit":true,"delete":true},"forms":{"show":true,"delete":true},"settings":{"site":true,"header":true,"sidebar":true,"footer":true},"redirect":{"show":true,"add":true,"delete":true},"users":{"show":true,"add":true,"edit":true,"delete":true},"notificate":{"show":true,"add":true,"edit":true,"delete":true},"product":{"show":true,"add":true,"edit":true,"delete":true},"tag":{"show":true,"add":true,"edit":true,"delete":true},"company":{"show":true,"edit":true},"ads":{"show":true,"edit":true,"delete":true},"support":{"show":true,"edit":true}}',
        ]);
        $query->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_permissions');
    }
};
