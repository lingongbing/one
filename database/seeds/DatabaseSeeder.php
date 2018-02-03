<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(MenuTableSeeder::class);
    	$this->call(PermissionTableSeeder::class);
    	$this->call(SkinBelongTableSeeder::class);
    	$this->call(SkinCategoryTableSeeder::class);
    	$this->call(UserTableSeeder::class);
    	$this->call(MarketTableSeeder::class);
    	$this->call(SiteTableSeeder::class);
    	$this->call(IntegralRuleTableSeeder::class);
    }
}
