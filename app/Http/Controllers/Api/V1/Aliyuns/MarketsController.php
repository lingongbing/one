<?php

namespace App\Http\Controllers\Api\V1\Aliyuns;

use App\Models\AliyunMarket;
use App\Transformers\Aliyuns\MarketTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class MarketsController extends Controller
{
	public function show($market)
	{
		$market = AliyunMarket::find($market);
		return $this->response->item($market,new MarketTransformer());
    }

	public function update(Request $request,$market) //隐式绑定不生效
	{
		$market = AliyunMarket::find($market);
		$market->app_code = $request->app_code;
		$market->save();
		return $this->response->item($market,new MarketTransformer());
    }
}
