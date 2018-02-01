<?php

namespace App\Transformers\Aliyuns;

use App\Models\AliyunMarket;
use League\Fractal\TransformerAbstract;

class MarketTransformer extends TransformerAbstract
{
	public function transform(AliyunMarket $market)
	{
		return [
			'id' => $market->id,
			'key' => $market->key,
			'app_code' => $market->app_code,
		];
	}
}