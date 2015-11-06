<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Alarm;
use App\Reminder;

class ExportController extends Controller
{
	public function getIcs()
	{
		$alarms = Alarm::where('closed', '=', false)->orderBy('date1', 'asc')->get();
		$reminders = Reminder::where('active', '=', true)->orderBy('expiry', 'asc')->get();
		return view('export.ics', ['alarms' => $alarms, 'reminders' => $reminders]);
	}
}
