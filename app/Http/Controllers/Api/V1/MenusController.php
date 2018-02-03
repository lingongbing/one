<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Config;
use App\Http\Controllers\Api\Controller;
use App\Models\Menu;
use App\Transformers\MenuTransformer;
use Dingo\Api\Http\Request;

class MenusController extends Controller
{
	public function index()
	{
		return $this->response->collection(Menu::all(),new MenuTransformer());
    }

	public function update(Request $request,$menu)
	{
		$menu = Menu::find($menu);
		$menu->update($request->all());

		return $this->response->item($menu,new MenuTransformer());
    }
}
