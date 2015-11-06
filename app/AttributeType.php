<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeType extends Model
{
	public function entity()
	{
		return $this->belongsTo('App\EntityType', 'entity_type');
	}

	public function displayMarkup($value = '')
	{
		return view('attributes.view.' . $this->datatype, ['value' => $value]);
	}

	public function systemName()
	{
		return str_slug($this->name);
	}

	public function editMarkup($value = '')
	{
		return view('attributes.edit.' . $this->datatype, ['name' => $this->systemName(), 'value' => $value]);
	}
}
