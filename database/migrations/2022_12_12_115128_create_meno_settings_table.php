<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin\MenoSetting;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_meno_settings', function (Blueprint $table) {
            $table->id();
            $table->text('meno');
            $table->timestamps();
        });

        $query = new MenoSetting([
            'id' => 1,
            'meno' => '[{"text":{"fa":"\u0628\u0644\u0627\u06af","en":"Blog"},"link":"blog","id":2},{"text":{"fa":"B2B \u067e\u0644\u0627\u0633","en":"B2B plus"},"link":"b2bplus","id":3}]
',
        ]);
        $query->save();
        $query = new MenoSetting([
            'id' => 2,
            'meno' => '{"one":{"fa":"\u0641\u0648\u062a\u0631 1","en":"Footer 1","lists":[{"text":{"fa":"\u0644\u06cc\u0646\u06a9 1","en":"link 1"},"link":null,"id":1},{"text":{"fa":"\u0644\u06cc\u0646\u06a9 2","en":"link 2"},"link":null,"id":2}]},"tow":{"fa":"\u0641\u0648\u062a\u0631 2","en":"Footer 2","lists":[{"text":{"fa":"\u0644\u06cc\u0646\u06a9 1","en":"link 1"},"link":null,"id":1}]},"three":{"fa":"\u0641\u0648\u062a\u0631 3","en":"Footer 3","lists":[{"text":{"fa":"\u0644\u06cc\u0646\u06a9 1","en":"link 1"},"link":null,"id":1}]}}',
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
        Schema::dropIfExists('app_meno_settings');
    }
};
