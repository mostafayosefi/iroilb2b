<?php

use App\Models\Admin\Page;
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
        Schema::create('app_pages', function (Blueprint $table) {
            $table->id();
            $table->string('type', 63);
            $table->string('title_fa')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug');
            $table->string('status', 63);
            $table->string('images')->nullable();
            $table->text('body_fa')->nullable();
            $table->text('body_en')->nullable();
            $table->text('seo_description_fa')->nullable();
            $table->text('seo_description_en')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
        });

        $query = new Page([
            'type' => 'page',
            'title_fa' => 'صفحه اصلی',
            'title_en' => 'Main page',
            'slug' => 'home',
            'status' => 'publish',
        ]);
        $query->save();
        $query = new Page([
            'type' => 'b2bplus',
            'title_fa' => 'درباره ما',
            'title_en' => 'About us',
            'slug' => 'about',
            'status' => 'publish',
        ]);
        $query->save();
        $query = new Page([
            'type' => 'b2bplus',
            'title_fa' => 'تماس با ما',
            'title_en' => 'Contact us',
            'slug' => 'contact',
            'status' => 'publish',
        ]);
        $query->save();
        $query = new Page([
            'type' => 'b2bplus',
            'title_fa' => 'سوالات متداول',
            'title_en' => 'FAQ',
            'slug' => 'faq',
            'status' => 'publish',
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
        Schema::dropIfExists('app_pages');
    }
};
