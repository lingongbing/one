<?php

use Illuminate\Database\Seeder;

class MarketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AliyunMarket::create([
        	'key' => 'kdi' // 快递查询
        ]);
    }
}
