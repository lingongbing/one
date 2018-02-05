<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderUpdated implements ShouldQueue
{
	/**
	 * @param \App\Events\OrderUpdated $event
	 */
	public function handle(\App\Events\OrderUpdated $event)
	{
		if ($event->order->isDirty('state') && $event->order->state === 2) {
			$event->IncreasedIntegral();
		}
	}
}
