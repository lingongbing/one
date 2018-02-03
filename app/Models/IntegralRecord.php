<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegralRecord extends Model
{
    protected $fillable = [
    	'user_id','action','event','integral'
    ];
}
