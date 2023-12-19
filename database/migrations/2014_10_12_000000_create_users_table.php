<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role',63);
            $table->string('step', 63)->default('one');
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('email_verified')->default(0);
            $table->tinyInteger('phone_verified')->default(0);
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('setting')->nullable()->default('{"postemail":false,"advsms":true}');
            $table->string('password');
            $table->string('api_token', 100)->nullable()->unique();
            $table->timestamps();
        });

        $query = new User([
            'name' => 'ادمین پنل',
            'role' => 'admin',
            'is_active' => 1,
            'email_verified' => 1,
            'phone_verified' => 1,
            'email' => 'info@iroilb2b.com',
            'phone' => '9809373127367',
            'password' => bcrypt('123456'),
            'api_token' => 'oF3bRS5bDpzwGmibiMrLQMRw9gjUIkkt4kIvPUMuOVvqgniUgSRzESBR1ogP0n6aoKmhT6FeQjn5cal4k1LxKTXEm1ufhlnCbUsA'
        ]);
        $query->save();
        $query = new User([
            'name' => 'کاربر',
            'role' => 'user',
            'is_active' => 0,
            'phone_verified' => 0,
            'email_verified' => 0,
            'email' => 'user@iroilb2b.com',
            'phone' => '9809103250190',
            'password' => bcrypt('09103250190'),
            'api_token' => Str::random(100)
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
        Schema::dropIfExists('app_users');
    }
};
