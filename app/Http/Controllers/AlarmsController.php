<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Session;
use DB;
use Mail;

use App\EntityType;
use App\AttributeType;
use App\Attribute;
use App\Alarm;
use App\Reminder;
use App\AlarmType;
use App\User;

class AlarmsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	private function getIterableMails()
	{
		$mails = array();

		$users = User::all();
		foreach($users as $u)
			$mails[] = $u->email;

		$attributes = Attribute::whereHas('type', function($query) { $query->where('datatype', '=', 'mail'); })->get();
		foreach($attributes as $a)
			$mails[] = $a->value;

		return $mails;
	}

	private function alarmSetStatus(&$a)
	{
		$now = time();

		$t = $a->time();
		if ($now > $t)
			$a->status = 'danger';
		else if ($now > ($t + 60 * 60 * 24))
			$a->status = 'warning';
		else
			$a->status = 'success';
	}

	public function index(Request $request)
	{
		Reminder::where('active', '=', true)->where('expiry', '<', DB::raw('NOW()'))->update(['active' => false]);

		$sequence = array();
		$month_offset = 3;

		$alarms = Alarm::where('closed', '=', false)->where('date1', '<', DB::raw('NOW() + INTERVAL ' . $month_offset . ' MONTH'))->orderBy('date1', 'asc')->get();
		$reminders = Reminder::where('active', '=', true)->where('expiry', '<', DB::raw('NOW() + INTERVAL ' . $month_offset . ' MONTH'))->orderBy('expiry', 'asc')->get();
		$alarms = $alarms->merge($reminders)->sort(function ($first, $second) {
			return $first->time() - $second->time();
		});

		$m = $start = date('n');

		if (count($alarms) != 0) {
			$first = $alarms->first();
			$m = min($first->month(), $m);
		}

		while ($m < ($start + $month_offset)) {
			$name = strftime('%B', mktime(0, 0, 0, $m, 1));
			$sequence[$name] = array();
			$m++;
		}

		$managed = array();

		foreach($alarms as $a) {
			$this->alarmSetStatus($a);
			$name = strftime('%B', mktime(0, 0, 0, $a->month(), 1));
			$sequence[$name][] = $a;
			$managed[] = $a->id;
		}

		if ($request->has('target')) {
			$target = $request->input('target');
			$data['focus'] = $target;

			if (array_search($target, $managed) === false) {
				$a = Alarm::find($target);
				$this->alarmSetStatus($a);
				$name = strftime('... %B %Y', mktime(0, 0, 0, $a->month(), 1, $a->year()));
				$sequence[$name] = [$a];
			}
		}
		else {
			$data['focus'] = -1;
		}

		$data['alarms'] = $sequence;
		$data['iterable_mails'] = $this->getIterableMails();
		return view('alarms.index', $data);
	}

	public function create(Request $request)
	{
		if ($request->has('action')) {
			$type = $request->input('action');

			switch($type) {
				case 'details':
					$data['type'] = AlarmType::findOrFail($request->input('type'));
					return view('alarms.createdetails', $data);
					break;
			}
		}
		else {
			$data['entitytype'] = EntityType::all();
			return view('alarms.create', $data);
		}
	}

	public function store(Request $request)
	{
		$a = new Alarm();
		$a->type_id = $request->input('alarmtype');
		$a->entity_id = $request->input('entity');
		$a->author_id = Auth::user()->id;
		$a->owner_id = $request->input('owner_id');
		$a->date1 = $request->input('date1');
		$a->date2 = $request->input('date2', '');
		$a->notes = $request->input('notes');
		$a->closed = false;
		$a->closer_id = -1;
		$a->save();

		Session::flash('message', 'Nuova scadenza salvata correttamente');
		Session::flash('message_type', 'success');
		return redirect(url('/alarms'));
	}

	public function show($id)
	{
		return redirect(url('alarms/?target=' . $id));
	}

	public function edit($id)
	{
		//
	}

	public function update(Request $request, $id)
	{
		$a = Alarm::findOrFail($id);
		$action = $request->input('action', 'update');

		switch($action) {
			case 'mail':
				$recipients = $request->input('recipient');
				$message = $request->input('message');
				Mail::send('emails.reminder', ['alarm' => $a, 'mailmessage' => $message], function ($m) use ($recipients, $a) {
					foreach($recipients as $r)
						$m->to($r);
					$m->subject('Avviso: ' . $a->simpleName());
				});

				break;

			case 'remind':
				$r = new Reminder();
				$r->alarm_id = $a->id;
				$r->active = true;
				$r->notes = $request->input('notes', '');

				$interval = $request->input('reminder-offset');
				$r->expiry = date('Y-m-d', strtotime('+1 ' . $interval));

				$r->save();
				break;

			case 'close':
				$a->closed = true;
				$a->closer_id = Auth::user()->id;
				$a->save();

				$a->history()->update(['active' => false]);
				$a->reIterate();

				break;

			case 'update':
				$a->date1 = $request->input('date1');
				$a->notes = $request->input('notes', '');
				$a->save();

				$path = $a->filesPath();

				if ($request->has('existing_attachments')) {
					$existing = array_diff(scandir($path), ['.', '..']);
					$saved = $request->input('existing_attachments');
					foreach($existing as $e) {
						if (array_search($e, $saved) === false)
							unlink($path . '/' . $e);
					}
				}

				if ($request->hasFile('attachments')) {
					foreach ($request->file('attachments') as $file)
						$file->move($path, $file->getClientOriginalName());
				}

				break;
		}

		return redirect(url('/alarms'));
	}

	public function destroy($id)
	{
		$a = Alarm::findOrFail($id);
		$a->delete();
	}

	public function fetch($id, $filename)
	{
		$a = Alarm::findOrFail($id);
		$filepath = $a->filesPath() . '/' . $filename;
		return response()->download($filepath);
	}
}
