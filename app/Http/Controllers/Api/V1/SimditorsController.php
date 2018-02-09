<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Validator;

class SimditorsController extends Controller
{
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'image' => 'image'
		]);

		if ($validator->fails()) {
			return $this->response->array([
				'success' => false,
				'msg' => '只能上传图片'
			]);
		}

		$path = $request->file('image')->store('public');

		return $this->response->array([
			"success" => true,
			"file_path" => url('/storage/' . $path)
		]);
	}
}
