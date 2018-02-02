<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SkinCategory;
use App\Transformers\SkinCategoryTransformer;
use App\Http\Controllers\Api\Controller;

class SkinsCategoriesController extends Controller
{
	public function index()
	{
		return $this->response->collection(SkinCategory::all(),new SkinCategoryTransformer());
    }
}
