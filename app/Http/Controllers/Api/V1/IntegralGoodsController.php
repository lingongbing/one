<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\IntegralGoodRequest;
use App\Models\IntegralGood;
use App\Transformers\IntegralGoodTransformer;
use App\Http\Controllers\Api\Controller;

class IntegralGoodsController extends Controller
{
	public function index()
	{
		return $this->response->paginator(IntegralGood::with('image')->paginate(10),new IntegralGoodTransformer());
    }

	public function store(IntegralGoodRequest $request,IntegralGood $good)
	{
		$good->create($request->all());
		return $this->response->item($good,new IntegralGoodTransformer());
    }

	public function destroy($integral_good)
	{
		$integral_good = IntegralGood::find($integral_good);
		$integral_good->delete();
		return $this->response->noContent();
    }

	public function show($integral_good)
	{
		$integral_good = IntegralGood::find($integral_good);
		return $this->response->item($integral_good,new IntegralGoodTransformer());
    }

	public function update(IntegralGoodRequest $request,$integral_good)
	{
		$integral_good = IntegralGood::find($integral_good);
		$integral_good->update($request->all());
		return $this->response->item($integral_good,new IntegralGoodTransformer());
    }
}
