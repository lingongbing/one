<?php

use Illuminate\Database\Seeder;

class IntegralGoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    factory(App\Models\IntegralGood::class,100)->create();
    }
}
