<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use App\Events\UserStore;
use App\Models\User;
use App\Transformers\UserTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
	public function index(Request $request)
	{
		$conditions = [];
		if ($request->parent_id) {
			$conditions[] = ['parent_id','=',$request->parent_id];
		}
		if ($request->username) {
			$conditions[] = ['username', 'like', '%' . $request->username . '%'];
		}
		return $this->response->paginator(User::where($conditions)->paginate(10),new UserTransformer());
	}

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
			'username' => $request->username,
			'mobile' => $verifyData['mobile'],
			'password' => bcrypt($request->password)
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

	public function update(UserRequest $request)
	{
		$user = $this->user();

		if ($request->verification_key && $request->verification_code) {
			$verifyData = \Cache::get($request->verification_key);

			if (!$verifyData) {
				return $this->response->error('验证码已失效', 422);
			}

			if (!hash_equals($verifyData['code'], $request->verification_code)) {
				// 返回401
				return $this->response->errorUnauthorized('验证码错误');
			}

			$user->mobile = $verifyData['mobile'];
		}

		if ($request->password) {
			$user->password = bcrypt($request->password);
		}

		if ($request->name) {
			$user->name = $request->name;
		}

		if ($request->avatar) {
			$user->avatar = $request->avatar;
		}

		if ($request->wechat) {
			$user->wechat = $request->wechat;
		}

		if ($request->address) {
			$user->address = $request->address;
		}

		$user->save();

		return $this->response->item($user,new UserTransformer());
	}

	public function me(Request $request)
	{
		return $this->response->item($request->user(), new UserTransformer());
	}
}
