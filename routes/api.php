<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
	'namespace' => 'App\Http\Controllers\Api\V1',
	'middleware' => 'serializer:array'
],function ($api) {
	$api->group([
		'middleware' => 'api.throttle',
		'limit' => config('api.rete_limits.sign.limit'),
		'expires' => config('api.rete_limits.sign.expires'),
	],function ($api) {
		// 短信验证码
		$api->post('verificationCodes', 'VerificationCodesController@store')
			->name('api.verificationCodes.store');
		// 图片验证码
		$api->post('captchas', 'CaptchasController@store')
			->name('api.captchas.store');
		// 用户注册
		$api->post('users','UsersController@store')
			->name('api.users.store');
		// 登录
		$api->post('authorizations', 'AuthorizationsController@store')
			->name('api.authorizations.store');
		// 刷新token
		$api->put('authorizations/current', 'AuthorizationsController@update')
			->name('api.authorizations.update');
		// 删除token
		$api->delete('authorizations/current', 'AuthorizationsController@destroy')
			->name('api.authorizations.destroy');
	});

	$api->group([
		'middleware' => 'api.throttle',
		'limit' => config('api.rate_limits.access.limit'),
		'expires' => config('api.rate_limits.access.expires'),
	], function ($api) {
		// 游客可以访问的接口
		$api->get('menus', 'MenusController@index')
			->name('api.menus.index');
		$api->get('carousels', 'CarouselsController@index')
			->name('api.carousels.index');
		$api->get('confirmed', 'ConfirmedController@index')
			->name('api.confirmed.index');
		$api->get('goods', 'GoodsController@index')
			->name('api.goods.index');
		// 需要 token 验证的接口
		$api->group(['middleware' => 'api.auth'], function($api) {
			// 当前登录用户信息
			$api->get('user', 'UsersController@me')
				->name('api.user.show');
			// 上传图片
			$api->post('upload', 'UploadsController@store')
				->name('api.upload.store');
			// 用户列表
			$api->get('users', 'UsersController@index')
				->name('api.users.index');
			// 订单列表
			$api->get('orders', 'OrdersController@index')
				->name('api.orders.index');
			// 创建订单
			$api->post('orders', 'OrdersController@store')
				->name('api.orders.store');
		});
		// 管理员可以访问的接口
		$api->group(['middleware' => ['api.auth','role:admin']], function($api) {
			// 添加商品
			$api->post('goods', 'GoodsController@store')
				->name('api.goods.store');
			// 删除商品
			$api->delete('goods/{good}', 'GoodsController@destroy')
				->name('api.goods.delete');
		});
	});
});
