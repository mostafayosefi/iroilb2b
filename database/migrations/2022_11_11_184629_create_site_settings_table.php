<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin\SiteSetting;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_site_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_title_fa', 127)->nullable();
            $table->string('site_title_en', 127)->nullable();
            $table->string('logo_light', 255)->nullable();
            $table->string('logo_dark', 255)->nullable();
            $table->string('fav_icon', 255)->nullable();
            $table->text('menu')->nullable();
            $table->timestamps();
        });

        $query = new SiteSetting([
            'id' => 1,
            'site_title_fa' => 'بازار نفت و گاز',
            'site_title_en' => 'IR Oil B2B',
            'logo_light' => 'iroilb2b-trans.png',
            'logo_dark' => 'iroilb2b.png',
            'fav_icon' => 'favicon.png',
            'menu'=>''
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
        Schema::dropIfExists('app_site_settings');
    }
};
