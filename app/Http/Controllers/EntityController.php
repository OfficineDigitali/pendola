<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\EntityType;
use App\Entity;
use App\AlarmType;
use App\Alarm;
use App\Attribute;

class EntityController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		//
	}

	public function create(Request $request)
	{
		$type = $request->input('t');
		$e = EntityType::findOrFail($type);
		return view('entities.create', ['master' => $e]);
	}

	public function store(Request $request)
	{
		try {
			$type = $request->input('type');
			$e = EntityType::findOrFail($type);

			$n = new Entity();
			$n->type_id = $e->id;
			$n->name = $request->input('name');
			$n->save();

			foreach($e->attributes as $attribute) {
				$name = $attribute->systemName();
				if ($request->has($name)) {
					$a = new Attribute();
					$a->entity_id = $n->id;
					$a->type_id = $attribute->id;
					$a->value = $request->input($name);
					$a->save();
				}
			}

			Session::flash('message_type', 'success');
			Session::flash('message', 'Nuovo elemento salvato correttamente.');
		}
		catch (\Expection $e) {
			Session::flash('message_type', 'danger');
			Session::flash('message', 'Elemento non salvato correttamente.');
		}

		return redirect('entities/' . $e->id);
	}

	public function show($id)
	{
		//
	}

	public function edit(Request $request, $id)
	{
		if ($request->has('type')) {
			$type = $request->input('type');

			switch($type) {
				case 'selectalarm':
					if ($id == 'no') {
						$available = AlarmType::where('entity_type', '=', 0)->get();
						$existing = Alarm::where('entity_id', '=', 0)->get();
					}
					else {
						$e = Entity::findOrFail($id);
						$available = $e->type->alarms;
						$existing = $e->alarms;
					}

					$structured = array();

					foreach($available as $a) {
						$unit = (object) array(
							'alarm' => $a,
							'pendings' => array()
						);

						foreach($existing as $exist)
							if ($exist->type->id == $a->id)
								$unit->pendings[] = $exist;

						$structured[] = $unit;
					}

					return view('alarms.choosealarmtype', ['structured' => $structured]);
					break;
			}
		}
		else {
			$e = Entity::findOrFail($id);
			return view('entities.edit', ['entity' => $e]);
		}
	}

	public function update(Request $request, $id)
	{
		try {
			if ($request->has('type')) {
				$type = $request->input('type');

				switch($type) {
					case 'restore':
						$entities = Entity::withTrashed()->where('id', $id)->get();
						foreach($entities as $n) {
							$n->restore();
							$n->alarms()->restore();
						}

						break;
				}
			}
			else {
				$n = Entity::findOrFail($id);
				$n->name = $request->input('name');
				$n->save();

				foreach($n->type->attributes as $attribute) {
					$name = $attribute->systemName();
					if ($request->has($name)) {
						$a = $n->attribute($name);
						$a->value = $request->input($name);
						$a->save();
					}
				}
			}

			Session::flash('message_type', 'success');
			Session::flash('message', 'Elemento aggiornato correttamente.');
		}
		catch(\Exception $e) {
			Session::flash('message_type', 'danger');
			Session::flash('message', 'Elemento non aggiornato correttamente: ' . $e->getMessage());
		}

		return redirect('entities/' . $n->type->id);
	}

	public function destroy($id)
	{
		try {
			$n = Entity::findOrFail($id);
			$n->delete();
			Session::flash('message_type', 'success');
			Session::flash('message', 'Elemento rimosso correttamente. <a class="undo-button" href="/entity/' . $id . '">Undo</a>');
		}
		catch(\Exception $e) {
			Session::flash('message_type', 'danger');
			Session::flash('message', 'Elemento non rimosso correttamente.');
		}

		return "";
	}
}
