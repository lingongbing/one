<?php

namespace App\Transformers;

use App\Models\Level;
use League\Fractal\TransformerAbstract;

class LevelTransformer extends TransformerAbstract
{
	public function transform(Level $level)
	{
		return [
			'id' => $level->id,
			'name' => $level->name
		];
	}
}