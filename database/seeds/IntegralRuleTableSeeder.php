<?php

use Illuminate\Database\Seeder;

class IntegralRuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\IntegralRule::create([
        	'created_user' => 100,
        	'complete_order' => 100,
        ]);
    }
}
