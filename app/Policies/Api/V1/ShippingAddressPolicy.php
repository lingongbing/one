<?php

namespace App\Policies\Api\V1;

use App\Models\User;
use App\Models\ShippingAddress;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingAddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the shippingAddress.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ShippingAddress  $shippingAddress
     * @return mixed
     */
    public function view(User $user, ShippingAddress $shippingAddress)
    {
        //
    }

    /**
     * Determine whether the user can create shippingAddresses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the shippingAddress.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ShippingAddress  $shippingAddress
     * @return mixed
     */
    public function update(User $user, ShippingAddress $shippingAddress)
    {
        return $user->hasRole('admin') || $user->id === $shippingAddress->user_id;
    }

    /**
     * Determine whether the user can delete the shippingAddress.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ShippingAddress  $shippingAddress
     * @return mixed
     */
    public function delete(User $user, ShippingAddress $shippingAddress)
    {
        //
    }
}
