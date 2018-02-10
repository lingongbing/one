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
			->name('api.authorizations.update')->middleware();
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
		$api->get('levels', 'LevelsController@index')
			->name('api.levels.index');
		$api->get('homes', 'HomesController@index')
			->name('api.homes.index');
		$api->get('skins-belongs', 'SkinsBelongsController@index')
			->name('api.skins.belongs.index');
		$api->get('skins-categories', 'SkinsCategoriesController@index')
			->name('api.skins.categories.index');
		$api->get('sites', 'SitesController@index')
			->name('api.sites.index');
		$api->post('simditors', 'SimditorsController@store')
			->name('api.simditors.store');
		$api->get('integral-goods','IntegralGoodsController@index')
			->name('api.integral.goods.index');
		$api->get('integral-goods/{integral_good}/images','IntegralGoodImagesController@index')
			->name('api.integral.goods.index');
		// 需要 token 验证的接口
		$api->group(['middleware' => ['api.auth']], function($api) {
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
			// 更新订单
			$api->patch('orders/{order}', 'OrdersController@update')
				->name('api.orders.update');
			// 删除订单
			$api->delete('orders/{order}', 'OrdersController@destroy')
				->name('api.orders.destroy');
			// 统计订单
			$api->get('counts/orders', 'CountsController@orders')
				->name('api.counts.order');
			// 显示订单
			$api->get('orders/{order}','OrdersController@show')
				->name('api.orders.show');
			// 快递查询
			$api->get('couriers/{courier}','CouriersController@show')
				->name('api.couriers.show');
			// 更新用户
			$api->patch('user','UsersController@update')
				->name('api.user.update');
			// 当前登陆用户的皮肤信息
			$api->get('skin','UsersSkinsController@me')
				->name('api.skins.me');
			// 客户列表
			$api->get('clients','ClientsController@index')
				->name('api.clients.index');
			// 创建客户
			$api->post('clients','ClientsController@store')
				->name('api.clients.store');
			// 客户信息
			$api->get('clients/{client}','ClientsController@show')
				->name('api.clients.show');
			// 更新客户
			$api->patch('clients/{client}','ClientsController@update')
				->name('api.clients.update');
			// 创建客户皮肤信息
			$api->post('users/{user}/skins','UsersSkinsController@store')
				->name('api.users.skins.store');
			// 更新客户皮肤信息
			$api->patch('users/{user}/skins/{skin}','UsersSkinsController@update')
				->name('api.users.skins.update'); // 需要修改的路由
			// 获取客户皮肤信息
			$api->get('users/{user}/skins','UsersSkinsController@index')
				->name('api.users.skins.index'); // 需要修改的路由
			// 获取客户皮肤信息
			$api->get('user/skin','UsersSkinsController@show')
				->name('api.user.skin.show');
			// 更新客户皮肤信息
			$api->post('user/skin','UserSkinsController@store')
				->name('api.user.skin.store');
			// 更新客户皮肤信息
			$api->patch('user/skin','UserSkinsController@update')
				->name('api.user.skin.update');
			// 积分查询
			$api->get('user/integral','UserIntegralsController@index')
				->name('api.user.integral.index');
			// 收货地址列表
			$api->get('shipping-addresses','ShippingAddressesController@index')
				->name('api.shipping.addresses.index');
			// 创建收货地址
			$api->post('shipping-addresses','ShippingAddressesController@store')
				->name('api.shipping.addresses.store');
			// 删除收货地址
			$api->delete('shipping-addresses/{shippingAddress}','ShippingAddressesController@destroy')
				->name('api.shipping.addresses.destroy');
		});
		// 首页管理权限接口
		$api->group(['middleware' => ['auth:api','role:admin|role:home_management']], function($api) {
			// 创建轮播图
			$api->post('carousels', 'CarouselsController@store')
				->name('api.carousels.store');
			// 删除轮播图
			$api->delete('carousels/{carousel}', 'CarouselsController@destroy')
				->name('api.carousels.destroy');
			// 创建首页内容
			$api->post('homes','HomesController@store')
				->name('api.homes.store');
			// 删除首页内容
			$api->delete('homes/{home}','HomesController@destroy')
				->name('api.homes.destroy');
		});
		// 管理员可以访问的接口
		$api->group(['middleware' => ['auth:api','role:admin']], function($api) {
			// 添加商品
			$api->post('goods', 'GoodsController@store')
				->name('api.goods.store');
			// 删除商品
			$api->delete('goods/{good}', 'GoodsController@destroy')
				->name('api.goods.destroy');
			// 创建代理级别
			$api->post('levels','LevelsController@store')
				->name('api.levels.store');
			// 删除代理级别
			$api->delete('levels/{level}', 'LevelsController@destroy')
				->name('api.levels.destroy');
			// 创建代理
			$api->post('agents', 'AgentsController@store')
				->name('api.agents.store');
			// 代理列表
			$api->get('agents', 'AgentsController@index')
				->name('api.agents.index');
			// 显示代理
			$api->get('agents/{agent}', 'AgentsController@show')
				->name('api.agents.show');
			// 更新代理
			$api->patch('agents/{agent}','AgentsController@update')
				->name('api.agents.update');
			// 阿里云市场列表
			$api->get('aliyuns/markets/{market}','Aliyuns\MarketsController@show')
				->name('api.aliyuns.markets.show');
			// 阿里云市场更新
			$api->patch('aliyuns/markets/{market}','Aliyuns\MarketsController@update')
				->name('api.aliyuns.markets.patch');
			// 更新logo
			$api->patch('sites','SitesController@update')
				->name('api.sites.patch');
			// 积分规则列表
			$api->get('integral-rules','IntegralRulesController@index')
				->name('api.integral.rules.index');
			// 更新积分规则
			$api->patch('integral-rules','IntegralRulesController@update')
				->name('api.integral.rules.patch');
			// 更新菜单
			$api->patch('menus/{menu}','MenusController@update')
				->name('api.menus.patch');
			// 系统信息
			$api->get('system','SystemController@index')
				->name('api.system.index');
			// 阿里云短信
			$api->get('sms','Aliyuns\SmsController@show')
				->name('api.aliyuns.sms.show');
			$api->patch('sms','Aliyuns\SmsController@update')
				->name('api.aliyuns.sms.update');
			// 添加积分商品
			$api->post('integral-goods','IntegralGoodsController@store')
				->name('api.integral.goods.store');
			// 删除积分商品
			$api->delete('integral-goods/{integral_good}','IntegralGoodsController@destroy')
				->name('api.integral.goods.destroy');
			// 积分商品信息
			$api->get('integral-goods/{integral_good}','IntegralGoodsController@show')
				->name('api.integral.goods.show');
			// 更新积分商品
			$api->patch('integral-goods/{integral_good}','IntegralGoodsController@update')
				->name('api.integral.goods.patch');
			// 更新商品图片
			$api->patch('integral-goods/{integral_good}/images/{image}','IntegralGoodImagesController@update')
				->name('api.integral.goods.image.update');
			// 创建商品图片
			$api->post('integral-goods/{integral_good}/images','IntegralGoodImagesController@store')
				->name('api.integral.goods.image.store');
		});
	});
});
