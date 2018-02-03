<?php

namespace App\Providers;

use App\Events\UserStore;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],

	    'App\Events\UserStore' => [
	    	'App\Listeners\UserStore',
	    ],

	    'App\Events\UserPatch' => [
	    	'App\Listeners\UserPatch',
	    ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
