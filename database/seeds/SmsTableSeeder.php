<?php

use Illuminate\Database\Seeder;

class SmsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\Models\AliyunSms::create([
			'sign_name' => 'sign_name',
			'access_key_id' => 'access_key_id',
			'access_key_secret' => 'access_key_secret'
		]);
	}
}
