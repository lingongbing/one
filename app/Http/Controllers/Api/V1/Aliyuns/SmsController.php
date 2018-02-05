<?php

namespace App\Http\Controllers\Api\V1\Aliyuns;

use App\Http\Controllers\Api\Controller;

class SmsController extends Controller
{
	public function show()
	{
		return $this->response->array([
			'sign_name' => env('ALIYUN_SMS_SIGN_NAME'),
			'access_key_id' => env('ALIYUN_SMS_ACCESS_KEY_ID'),
			'access_key_secret' => env('ALIYUN_SMS_ACCESS_KEY_SECRET'),
			'templates' => [
				'send_code' => env('ALIYUN_SMS_TEMPLATES_SEND_CODE')
			]
		]);
    }
}
