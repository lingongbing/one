<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class CountsController extends Controller
{
	public function orders(Request $request)
	{
		$conditions = [];
		if (!$request->user()->hasRole('admin')) {
			$conditions[] = ['creator_user_id', $request->user()->id];
		}
		if ($request->state) {
			$conditions[] = ['state','=',$request->state];
		}
		return $this->response->array([
			'count' => Order::where($conditions)->count()
		]);
    }
}
