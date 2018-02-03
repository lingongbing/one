<?php

namespace App\Transformers;

use App\Models\IntegralRecord;
use League\Fractal\TransformerAbstract;

class IntegralRecordTransformer extends TransformerAbstract
{
	public function transform(IntegralRecord $record)
	{
		return [
			'event' => $record->event,
			'action' => $record->action,
			'order_id' =>$record->order_id,
			'integral' => $record->integral,
			'created_at' =>$record->created_at->toDateTimeString()
		];
	}
}