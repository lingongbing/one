<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegralOrder extends Model
{
    protected $fillable = [
    	'user_id','integral_good_id','consignee','courier_order_no','city','address','area','phone','state','province','number','integral'
    ];
}
