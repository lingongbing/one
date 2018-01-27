<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Config;
use App\Http\Controllers\Api\Controller;
use App\Models\Menu;
use App\Transformers\MenuTransformer;

class MenusController extends Controller
{
	public function index()
	{
		return $this->response->collection(Menu::all(),new MenuTransformer());
    }
}
