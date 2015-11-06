<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlarmType extends Model
{
	public static function getByTarget($target)
	{
		return AlarmType::where('entity_type', '=', $target->id)->get();
	}
}
