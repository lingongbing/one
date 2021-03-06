<?php

namespace App\Providers;

use App\Models\IntegralOrder;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Policies\Api\V1\IntegralOrderPolicy;
use App\Policies\Api\V1\OrderPolicy;
use App\Policies\Api\V1\ShippingAddressPolicy;
use App\Policies\Api\V1\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
	    Order::class => OrderPolicy::class,
	    User::class => UserPolicy::class,
	    ShippingAddress::class => ShippingAddressPolicy::class,
	    IntegralOrder::class => IntegralOrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
