<?php

namespace App\Events;

use App\Models\IntegralRecord;
use App\Models\IntegralRule;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $order;

	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	public function IncreasedIntegral()
	{
		$integral = IntegralRule::pluck('complete_order')->first();
		$this->order->user->increment('integral',$integral);
		// 创建积分记录
		IntegralRecord::create([
			'event' => '完成订单',
			'action' => 'increase',
			'user_id' => $this->order->user->id,
			'integral' => $integral,
		]);
	}
}
