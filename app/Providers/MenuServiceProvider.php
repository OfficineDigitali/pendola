<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;

use App\User;
use App\EntityType;

class MenuServiceProvider extends ServiceProvider
{
	public function boot()
	{
		view()->composer('*', function ($view) {
			$view->with('users', User::all());
			$view->with('menu_dynamic_entities', EntityType::orderBy('name', 'asc')->get());

			if (Auth::check())
				$view->with('current_user_id', Auth::user()->id);
		});

		setlocale(LC_TIME, 'it_IT.UTF-8');
	}

	public function register()
	{
		//
	}
}
