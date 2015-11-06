<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityType extends Model
{
	public function entities()
	{
		return $this->hasMany('App\Entity', 'type_id');
	}

	public function attributes()
	{
		return $this->hasMany('App\AttributeType', 'entity_type')->orderBy('order', 'asc');
	}

	public function attribute($type)
	{
		if (is_string($type))
			$name = $type;
		else
			$name = $type->slug;

		return AttributeType::where('entity_type', '=', $this->id)->where('slug', '=', $name)->first();
	}

	public function alarms()
	{
		return $this->hasMany('App\AlarmType', 'entity_type');
	}
}
