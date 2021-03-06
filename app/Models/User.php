<?php

namespace App\Models;

use App\Events\UserCreated;
use App\Events\UserStore;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'email', 'password','username','level','avatar','mobile','introduction','wechat','address'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function order()
	{
		return $this->hasMany('App\Models\Order');
    }

	// Rest omitted for brevity

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

	public function skin()
	{
		return $this->hasOne(UserSkin::class);
	}

	public function integralRecord()
	{
		return $this->hasMany(IntegralRecord::class);
	}

	public function shippingAddresses()
	{
		return $this->hasMany(ShippingAddress::class);
	}

	protected $dispatchesEvents = [
		'created' => UserCreated::class,
	];
}
