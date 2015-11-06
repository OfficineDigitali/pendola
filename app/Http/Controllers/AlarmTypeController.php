<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\AlarmType;

class AlarmTypeController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		//
	}

	public function create()
	{
		//
	}

	public function store(Request $request)
	{
		$a = new AlarmType();
		$a->name = $request->input('name');
		$a->entity_type = $request->input('entitytype');
		$a->type = $request->input('type');

		$recurrence = $request->input('recurrence');

		if ($recurrence == 'custom-interval') {
			$a->recurrence = 'custom';
			$a->recurrence_details = sprintf('%d %s', $request->input('recurrence_quantity'), $request->input('recurrence_unit'));
		}
		else {
			$a->recurrence = $recurrence;
		}

		$a->save();
		return $a->id;
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		//
	}

	public function update(Request $request, $id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}
}
