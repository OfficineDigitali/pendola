<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Attribute;

class Entity extends Model implements AlarmTarget
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function type()
	{
		return $this->belongsTo('App\EntityType', 'type_id');
	}

	public function attributes()
	{
		return $this->hasMany('App\Attribute');
	}

	public function attribute($type)
	{
		if (is_string($type))
			$name = $type;
		else
			$name = $type->slug;

		$a = Attribute::where('entity_id', '=', $this->id)->whereHas('type', function($query) use ($name) { $query->where('slug', '=', $name); })->first();
		if ($a == null) {
			$a = new Attribute();
			$a->entity_id = $this->id;
			$a->type_id = $this->type->attribute($name)->id;
			$a->value = '';
			$a->save();
		}

		return $a;
	}

	public function alarms()
	{
		return $this->hasMany('App\Alarm')->where('closed', '=', false)->orderBy('date1', 'asc');
	}
}
