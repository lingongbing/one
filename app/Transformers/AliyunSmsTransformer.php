<?php

namespace App\Transformers;

use App\Models\AliyunSms;
use League\Fractal\TransformerAbstract;

class AliyunSmsTransformer extends TransformerAbstract
{
	public function transform(AliyunSms $sms)
	{
		return [
			'sign_name' => $sms->sign_name,
			'access_key_id' => $sms->access_key_id,
			'access_key_secret' => $sms->access_key_secret
		];
	}
}