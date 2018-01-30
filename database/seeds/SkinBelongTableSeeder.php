<?php

use Illuminate\Database\Seeder;

class SkinBelongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    \App\Models\SkinBelong::create(['name' => '白皙']);
	    \App\Models\SkinBelong::create(['name' => '中等']);
	    \App\Models\SkinBelong::create(['name' => '略黑']);
    }
}
