<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserStore implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	/**
	 * @param \App\Events\UserStore $event
	 */
    public function handle(\App\Events\UserStore $event)
    {
		$event->IncreasedIntegral();
    }
}
