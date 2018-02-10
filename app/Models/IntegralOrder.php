<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegralOrder extends Model
{
    protected $fillable = [
    	'user_id','integral_good_id','consignee','courier_order_no','city','address','area','phone','state','province','number','integral'
    ];

	public function user()
	{
		return $this->belongsTo(User::class);
    }

	public function good()
	{
		return $this->belongsTo(IntegralGood::class,'integral_good_id','id');
    }
}
