<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\EntityType;

class ConfigController extends Controller
{
	public function index()
	{
		$data['users'] = User::all();
		$data['entities'] = EntityType::all();
		return view('config.index', $data);
	}

	public function create()
	{
		//
	}

	public function store(Request $request)
	{
		//
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
