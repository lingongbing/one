<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\VerificationCodeRequest;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
	public function store(VerificationCodeRequest $request, EasySms $easySms)
	{
		$captchaData = \Cache::get($request->captcha_key);

		if (!$captchaData) {
			return $this->response->error('图片验证码已失效',422);
		}

		if (!hash_equals($captchaData['code'],$request->captcha_code)) {
			// 验证码错误就清除缓存
			\Cache::forget($request->captcha_key);
			return $this->response->errorUnauthorized('验证码错误');
		}

		$mobile = $captchaData['mobile'];

		// 生成4位随机数，左侧补0
		$code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

		try {
			$easySms->send($mobile, [
				'template' => env('ALIYUN_SMS_TEMPLATES_SEND_CODE'),
				'data' => [
					'code' => $code
				],
			]);
		} catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
			return $this->response->errorInternal('验证码发送失败');
		}

		$key = 'verificationCode_'.str_random(15);
		$expiredAt = now()->addMinutes(10);
		// 缓存验证码 10分钟过期。
		\Cache::put($key, ['mobile' => $mobile, 'code' => $code], $expiredAt);

		return $this->response->array([
			'key' => $key,
			'expired_at' => $expiredAt->toDateTimeString(),
		])->setStatusCode(201);
	}
}
