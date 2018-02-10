<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\IntegralOrderRequest;
use App\Models\IntegralGood;
use App\Models\IntegralOrder;
use App\Models\IntegralRecord;
use App\Transformers\IntegralOrderTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\DB;

class IntegralOrdersController extends Controller
{
	public function index(Request $request)
	{
		$conditions   = [];
		if (!$request->user()->hasRole('admin')) {
			$conditions[] = ['user_id',$request->user()->id];
		}

		return $this->response->paginator(IntegralOrder::where($conditions)->with('user','good')->orderBy('id','desc')->paginate(10),new IntegralOrderTransformer());
	}

	public function show(Request $request,$integral_order)
	{
		$integral_order = IntegralOrder::find($integral_order);
		$this->authorize('update',$integral_order);
		return $this->response->item($integral_order,new IntegralOrderTransformer());
	}

	public function update(IntegralOrderRequest $request,$integral_order)
	{
		$integral_order = IntegralOrder::find($integral_order);
		$this->authorize('update',$integral_order);
		$integral_order->update([
			'state' => 2,
			'courier_order_no' => $request->courier_order_no
		]);

		return $this->response->item($integral_order,new IntegralOrderTransformer());
	}

	public function store(IntegralOrderRequest $request,IntegralOrder $integralOrder)
	{
		$integral_good = IntegralGood::find($request->integral_good_id);
		if ((int)$request->user()->integral < (int)$integral_good->integral*$request->number) {
			return $this->response->errorForbidden('积分不足');
		}

		DB::transaction(function () use ($integral_good,$request,$integralOrder) {
			$integralOrder->create([
				'user_id' => $request->user()->id,
				'integral_good_id' => $request->integral_good_id,
				'consignee' => $request->consignee,
				'phone' => $request->phone,
				'province' => $request->province,
				'city' => $request->city,
				'area' => $request->area,
				'address' => $request->address,
				'integral' => $integral_good->integral*$request->number,
				'number' => $request->number
			]);

			$request->user()->decrement('integral',$integral_good->integral*$request->number);

			// 创建积分记录
			IntegralRecord::create([
				'event' => '兑换积分商品',
				'action' => 'decrement',
				'user_id' => $this->user()->id,
				'integral' => $integral_good->integral*$request->number,
			]);
		});

		return $this->response->created();
    }
}
