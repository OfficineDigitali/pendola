<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Hash;
use Session;

use App\User;

class UsersController extends Controller
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
		return view('users.create');
	}

	public function store(Request $request)
	{
		try {
			$u = new User();
			$u->name = $request->get('name');
			$u->email = $request->get('mail');
			$u->password = Hash::make($request->get('password'));
			$u->save();

			Session::flash('message_type', 'success');
			Session::flash('message', 'Nuovo utente salvato correttamente.');
		}
		catch (\Exception $e) {
			Session::flash('message_type', 'danger');
			Session::flash('message', 'Errore nel salvataggio del nuovo utente.');
		}

		return redirect(url('/config'));
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$data['user'] = User::find($id);
		return view('users.edit', $data);
	}

	public function update(Request $request, $id)
	{
		try {
			$u = User::findOrFail($id);
			$u->name = $request->get('name');
			$u->email = $request->get('mail');

			if ($request->get('password') != '')
				$u->password = Hash::make($request->get('password'));

			$u->save();

			Session::flash('message_type', 'success');
			Session::flash('message', 'Utente salvato correttamente.');
		}
		catch (\Exception $e) {
			Session::flash('message_type', 'danger');
			Session::flash('message', 'Errore nel salvataggio dell\'utente.');
		}

		return redirect(url('/config'));
	}

	public function destroy($id)
	{
		try {
			$u = User::find($id);
			$u->delete();

			Session::flash('message_type', 'success');
			Session::flash('message', 'Utente rimosso correttamente.');
		}
		catch(\Exception $e) {
			Session::flash('message_type', 'danger');
			Session::flash('message', 'Errore nella cancellazione dell\'utente.');
		}

		return "";
	}
}
