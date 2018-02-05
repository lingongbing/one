<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\OrdersRequest;
use App\Http\Controllers\Api\Controller;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
	public function index(Request $request)
	{
		$conditions = [];
		if (!$request->user()->hasRole('admin')) {
			$conditions[] = ['creator_user_id', $request->user()->id];
		}
		if ($request->state) {
			$conditions[] = ['state','=',$request->state];
		}
		if ($request->order_no) {
			$conditions[] = ['order_no','=',$request->order_no];
		}
		if ($request->courier_order_no) {
			$conditions[] = ['courier_order_no','=',$request->courier_order_no];
		}
		$orders = Order::with('user','good')->where($conditions)->paginate(8);
		return $this->response->paginator($orders,new OrderTransformer());
	}

	public function update(OrdersRequest $request,$order) // 隐式绑定不生效
	{
		$order = Order::find($order);
		$this->authorize('update',$order);

		$order->update($request->all());
		return $this->response->item($order,new OrderTransformer());
	}

	public function show($order) // 隐式绑定不生效
	{
		$order = Order::find($order);
		return $this->response->item($order,new OrderTransformer());
	}

	public function store(OrdersRequest $request, Order $order)
	{
		$order->order_no          = date('YmdHis') . $request->user()->id;
		$order->user_id           = $request->user_id;
		$order->goods_id          = $request->goods_id;
		$order->creator_user_id   = $request->user()->id;
		$order->goods_number      = $request->goods_number;
		$order->courier_company   = $request->courier_company;
		$order->courier_order_no  = $request->courier_order_no;
		$order->goods_total_price = $request->goods_total_price;
		$order->save();

		return $this->response->created();
	}

	public function destroy($order) // 隐式绑定不生效
	{
		$order = Order::find($order);
		$this->authorize('update',$order);
		$order->delete();

		return $this->response->noContent();
	}
}
