<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\EntityType;
use App\Entity;
use App\Attribute;
use App\AttributeType;

class EntityTypeController extends Controller
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
		return view('entitytypes.create');
	}

	public function store(Request $request)
	{
		$e = new EntityType();
		$e->name = $request->input('name');
		$icon = $request->input('icon');
		$e->icon = substr($icon, strpos($icon, '-') + 1);
		$e->save();

		$attributes = $request->input('attribute_name');
		$types = $request->input('attribute_type');

		for ($i = 0; $i < count($attributes); $i++) {
			$a = new AttributeType();
			$a->name = $attributes[$i];
			$a->datatype = $types[$i];
			$a->entity_type = $e->id;
			$a->order = $i;
			$a->save();
		}

		return redirect(url('/config'));
	}

	public function show($id)
	{
		$e = EntityType::findOrFail($id);
		return view('entitytypes.show', ['master' => $e]);
	}

	public function edit($id)
	{
		$e = EntityType::findOrFail($id);
		return view('entitytypes.edit', ['entity' => $e]);
	}

	public function update(Request $request, $id)
	{
		$e = EntityType::findOrFail($id);
		$e->name = $request->input('name');
		$icon = $request->input('icon');
		$e->icon = substr($icon, strpos($icon, '-') + 1);
		$e->save();

		$ids = $request->input('attribute_id');
		$names = $request->input('attribute_name');
		$types = $request->input('attribute_type');
		$saved = array();

		for ($i = 0; $i < count($ids); $i++) {
			$aid = $ids[$i];
			if ($aid == '' || $ids == -1)
				$a = new AttributeType();
			else
				$a = AttributeType::findOrFail($aid);

			$a->name = $names[$i];
			$a->datatype = $types[$i];
			$a->entity_type = $e->id;
			$a->order = $i;
			$a->save();
			$saved[] = $a->id;
		}

		AttributeType::where('entity_type', '=', $e->id)->whereNotIn('id', $saved)->delete();
		return redirect(url('/config'));
	}

	public function destroy($id)
	{
		$e = EntityType::findOrFail($id);
		$e->delete();
		return redirect(url('/config'));
	}
}
