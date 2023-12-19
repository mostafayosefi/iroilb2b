<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_product')->insert([
            'name_en'=>"oil",
            'name_fa'=>"نفت",
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
