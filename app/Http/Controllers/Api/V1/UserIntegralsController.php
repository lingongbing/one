<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\IntegralRecord;
use App\Transformers\IntegralRecordTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class UserIntegralsController extends Controller
{
	public function index(Request $request)
	{
		return $this->response->collection($request->user()->integralRecord,new IntegralRecordTransformer());
    }
}
