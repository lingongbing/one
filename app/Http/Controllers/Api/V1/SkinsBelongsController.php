<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SkinBelong;
use App\Transformers\SkinBelongTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class SkinsBelongsController extends Controller
{
	public function index()
	{
		return $this->response->collection(SkinBelong::all(),new SkinBelongTransformer());
    }
}
