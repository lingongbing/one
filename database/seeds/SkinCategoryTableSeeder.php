<?php

use Illuminate\Database\Seeder;

class SkinCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    \App\Models\SkinCategory::create(['name' => '干性皮肤']);
	    \App\Models\SkinCategory::create(['name' => '中性皮肤']);
	    \App\Models\SkinCategory::create(['name' => '油性皮肤']);
	    \App\Models\SkinCategory::create(['name' => '混合性皮肤']);
	    \App\Models\SkinCategory::create(['name' => '敏感性皮肤']);
    }
}
