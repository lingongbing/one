<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;

class CaptchasController extends Controller
{
	public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
	{
		$key = 'captcha-'.str_random(15);
		$mobile = $request->mobile;

		$captcha = $captchaBuilder->build();
		$expiredAt = now()->addMinutes(2);
		\Cache::put($key, ['mobile' => $mobile, 'code' => $captcha->getPhrase()], $expiredAt);

		$result = [
			'captcha_key' => $key,
			'expired_at' => $expiredAt->toDateTimeString(),
			'captcha_image_content' => $captcha->inline()
		];

		return $this->response->array($result)->setStatusCode(201);
	}
}
