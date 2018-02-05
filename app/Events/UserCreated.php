<?php

namespace App\Events;

use App\Models\IntegralRecord;
use App\Models\IntegralRule;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function IncreasedIntegral()
	{
		$integral = IntegralRule::pluck('created_user')->first();
		$this->user->increment('integral',$integral);
		// 创建积分记录
		IntegralRecord::create([
			'event' => '注册账号',
			'action' => 'increase',
			'user_id' => $this->user->id,
			'integral' => $integral,
		]);
	}
}
