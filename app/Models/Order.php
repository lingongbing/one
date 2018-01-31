<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['state'];

	public function user()
	{
		return $this->belongsTo('App\Models\User','user_id');
	}

	public function good()
	{
		return $this->belongsTo('App\Models\Good','goods_id');
	}
}
