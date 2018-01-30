<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\AuthorizationRequest;

class AuthorizationsController extends Controller
{
	public function store(AuthorizationRequest $request)
	{
		$credentials['username'] = $request->username;
		$credentials['password'] = $request->password;

		if (!$token = Auth::guard('api')->attempt($credentials)) {
			return $this->response->errorUnauthorized('用户名或密码错误');
		}

		return $this->respondWithToken($token)->setStatusCode(201);
    }

	public function update()
	{
		$token = Auth::guard('api')->refresh();
		return $this->respondWithToken($token);
	}

	public function destroy()
	{
		Auth::logout();
		return $this->response->noContent();
	}

	protected function respondWithToken($token)
	{
		return $this->response->array([
			'access_token' => $token,
			'token_type' => 'Bearer',
			'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
		]);
	}
}
