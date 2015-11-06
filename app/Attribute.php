<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
	public function entity()
	{
		return $this->belongsTo('App\Entity');
	}

	public function type()
	{
		return $this->belongsTo('App\AttributeType', 'type_id');
	}

	public function displayMarkup()
	{
		return $this->type->displayMarkup($this->value);
	}

	public function editMarkup()
	{
		return $this->type->editMarkup($this->value);
	}
}
