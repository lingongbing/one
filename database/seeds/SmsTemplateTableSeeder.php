<?php

use Illuminate\Database\Seeder;

class SmsTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AliyunSmsTemplate::create([
        	'key' => 'send_code',
	        'code' => 'XXXXXXXX'
        ]);
    }
}
