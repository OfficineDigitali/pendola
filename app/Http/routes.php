<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	'export' => 'ExportController'
]);

Route::get('/', function () {
	return Redirect::to('/alarms');
});

Route::get('/home', function () {
	return Redirect::to('/alarms');
});

Route::resource('users', 'UsersController');
Route::resource('config', 'ConfigController');
Route::resource('alarmtype', 'AlarmTypeController');
Route::resource('alarms', 'AlarmsController');
Route::resource('entities', 'EntityTypeController');
Route::resource('entity', 'EntityController');

Route::post('alarms/{id}', 'AlarmsController@update');
Route::post('entity/{id}', 'EntityController@update');
Route::post('entities/{id}', 'EntityTypeController@update');

Route::get('alarms/{id}/{filename}', 'AlarmsController@fetch');
