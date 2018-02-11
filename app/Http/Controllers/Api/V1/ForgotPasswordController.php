<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\ForgotPasswords\CaptchaRequest;
use App\Http\Requests\Api\V1\ForgotPasswords\ResetPasswordRequest;
use App\Http\Requests\Api\V1\VerificationCodeRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Gregwar\Captcha\CaptchaBuilder;
use Overtrue\EasySms\EasySms;

class ForgotPasswordController extends Controller
{
	public function storeCaptcha(CaptchaRequest $request,CaptchaBuilder $captchaBuilder)
	{
		$key = 'captcha-'.str_random(15);
		$mobile = $request->mobile;

		$captchaBuilder->setInterpolation(false);
		$captchaBuilder->setDistortion(true);
		$captchaBuilder->setIgnoreAllEffects(true);
		$captchaBuilder->setBackgroundColor(0,0,0);

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

	public function storeVerificationCodes(VerificationCodeRequest $request, EasySms $easySms)
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
//			return $this->response->errorInternal($exception->results['aliyun']['exception']->getMessage());
			return $this->response->errorInternal('验证码发送失败');
		}

		$key = 'verificationCode_'.str_random(15);
		$expiredAt = now()->addMinutes(10);
		// 缓存验证码 10分钟过期。
		\Cache::put($key, ['mobile' => $mobile, 'code' => $code], $expiredAt);

		return $this->response->array([
			'key' => $key,
			'code' => $code,
			'expired_at' => $expiredAt->toDateTimeString(),
		])->setStatusCode(201);
    }

	public function resetPassword(ResetPasswordRequest $request)
	{
		$verifyData = \Cache::get($request->verification_key);

		if (!$verifyData) {
			return $this->response->error('验证码已失效', 422);
		}

		if (!hash_equals($verifyData['code'], $request->verification_code)) {
			// 返回401
			return $this->response->errorUnauthorized('验证码错误');
		}

		$user = User::where('mobile',$verifyData['mobile'])->first();
		$user->password = bcrypt($request->password);
		$user->save();

		// 清除验证码缓存
		\Cache::forget($request->verification_key);

		return $this->response->item($user, new UserTransformer())
			->setMeta([
				'access_token' => \Auth::guard('api')->fromUser($user),
				'token_type' => 'Bearer',
				'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
			])
			->setStatusCode(201);
    }
}
