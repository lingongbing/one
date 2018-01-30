<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\OrdersRequest;
use App\Http\Controllers\Api\Controller;
use App\Models\Order;
use App\Models\User;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
	public function index(Request $request)
	{
		$user = User::find(1);
		$user = $user->order;
		return $this->response->array([
			'order' => $user
		]);
//		$orders = Order::with('user','good')->paginate(10);

//		return $this->response->paginator($orders,new OrderTransformer());
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
}
