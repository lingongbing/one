<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegralGood extends Model
{
	protected $fillable = [
		'name','integral','description','introduction','reference_price'
	];

	public function image()
	{
		return $this->hasMany(IntegralGoodImage::class);
    }
}
