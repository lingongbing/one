<?php

namespace App\Policies\Api\V1;

use App\Models\IntegralOrder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IntegralOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	public function update(User $user, IntegralOrder $integralOrder)
	{
		return $user->hasRole('admin') || $user->id === $integralOrder->user_id;
	}
}
