<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\App\Models\Menu::create([
    		'name' => '首页',
		    'key' => 'home'
	    ]);

	    $buy_record = \App\Models\Menu::create([
		    'name' => '购买记录',
		    'key' => 'buy_record'
	    ]);

	    \App\Models\Menu::create([
		    'name' => '正在交易',
		    'key' => 'trading',
		    'parent_id' => $buy_record->id
	    ]);

	    \App\Models\Menu::create([
		    'name' => '已经完成',
		    'key' => 'has_been_completed',
		    'parent_id' => $buy_record->id
	    ]);

	    $integral = \App\Models\Menu::create([
		    'name' => '积分',
		    'key' => 'integral'
	    ]);

	    \App\Models\Menu::create([
		    'name' => '积分兑换',
		    'key' => 'integral_exchange',
		    'parent_id' => $integral->id
	    ]);

	    \App\Models\Menu::create([
		    'name' => '积分查询',
		    'key' => 'integral_query',
		    'parent_id' => $integral->id
	    ]);

	    $personal_information = \App\Models\Menu::create([
		    'name' => '个人资料',
		    'key' => 'personal'
	    ]);

	    \App\Models\Menu::create([
		    'name' => '个人资料',
		    'key' => 'personal_info',
		    'parent_id' => $personal_information->id
	    ]);

	    \App\Models\Menu::create([
		    'name' => '皮肤信息',
		    'key' => 'skin_info',
		    'parent_id' => $personal_information->id
	    ]);
    }
}
