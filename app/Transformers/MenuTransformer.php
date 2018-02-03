<?php

namespace App\Transformers;

use App\Models\Config;
use App\Models\Menu;
use League\Fractal\TransformerAbstract;

class MenuTransformer extends TransformerAbstract
{
	public function transform(Menu $menu)
	{
		return [
			'id' => $menu->id,
			'key' => $menu->key,
			'name' => $menu->name,
			'icon' => $menu->icon,
			'parent_id' => $menu->parent_id
		];
	}
}