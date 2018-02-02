<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkin extends Model
{
	protected $fillable = [
		'user_id', 'condition', 'check_time', 'commonly_products' , 'makeup_habits', 'nursing_advice', 'characteristics', 'skin_belong_id', 'skin_category_id'
	];
}
