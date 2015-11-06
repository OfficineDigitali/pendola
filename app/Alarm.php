<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

class Alarm extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function type()
	{
		return $this->belongsTo('App\AlarmType');
	}

	public function entity()
	{
		return $this->belongsTo('App\Entity');
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'author_id');
	}

	public function owner()
	{
		return $this->belongsTo('App\User', 'owner_id');
	}

	public function history()
	{
		return $this->hasMany('App\Reminder');
	}

	public static function getByTarget($target)
	{
		return Alarm::where('entity_id', '=', $target->id)->get();
	}

	public static function getByOwner($user)
	{
		return Alarm::where('owner_id', '=', $user->id)->get();
	}

	public function printableFullDate()
	{
		$t = strtotime($this->date1) + 10;
		return strftime('%A %d %B %G', $t);
	}

	public function exportableDate($type)
	{
		$t = strtotime($this->$type);
		return strftime('%Y%m%dT%H%M%SZ', $t);
	}

	public function time()
	{
		return strtotime($this->date1);
	}

	public function month()
	{
		return date('n', strtotime($this->date1));
	}

	public function icon()
	{
		if ($this->entity != null)
			return $this->entity->type->icon;
		else
			return 'asterisk';
	}

	public function simpleName()
	{
		if ($this->entity != null)
			return sprintf('%s | %s', $this->entity->name, $this->type->name);
		else
			return $this->type->name;
	}

	public function reIterate()
	{
		if ($this->type->recurrence == 'once')
			return;

		$a = new Alarm();
		$a->type_id = $this->type_id;
		$a->entity_id = $this->entity_id;
		$a->author_id = Auth::user()->id;
		$a->owner_id = $this->owner_id;
		$a->notes = '';
		$a->closed = false;
		$a->closer_id = -1;
		$a->prev_id = $this->id;

		switch($this->type->recurrence) {
			case 'daily':
				$future = '+1 day';
				break;

			case 'weekly':
				$future = '+1 week';
				break;

			case 'monthly':
				$future = '+1 month';
				break;

			case 'yearly':
				$future = '+1 year';
				break;

			case 'custom':
				$future = sprintf('+%s', $this->type->recurrence_details);
				break;
		}

		$a->date1 = date('Y-m-d', strtotime($this->date1 . $future));
		if ($this->type->type == 'interval')
			$a->date2 = date('Y-m-d', strtotime($this->date2 . $future));

		$a->save();
	}
}
