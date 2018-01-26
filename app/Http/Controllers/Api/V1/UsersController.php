<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use App\Transformers\UserTransformer;

class UsersController extends Controller
{
	public function store(UserRequest $request)
	{
		$verifyData = \Cache::get($request->verification_key);

		if (!$verifyData) {
			return $this->response->error('验证码已失效', 422);
		}

		if (!hash_equals($verifyData['code'], $request->verification_code)) {
			// 返回401
			return $this->response->errorUnauthorized('验证码错误');
		}

		$user = User::create([
			'name' => $request->username,
			'username' => $request->username,
			'mobile' => $verifyData['mobile'],
			'password' => bcrypt($request->password),
		]);

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

	public function me()
	{
		return $this->response->item($this->user(), new UserTransformer());
	}
}
