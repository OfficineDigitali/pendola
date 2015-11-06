<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
	public function alarm()
	{
		return $this->belongsTo('App\Alarm');
	}

	public function time()
	{
		return strtotime($this->expiry);
	}

	public function month()
	{
		return date('n', strtotime($this->expiry));
	}

	public function exportableDate($type)
	{
		$t = strtotime($this->$type);
		return strftime('%Y%m%dT%H%M%SZ', $t);
	}
}
