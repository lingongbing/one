<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
    	'user_id','name','phone','province','city','area','address'
    ];
}
