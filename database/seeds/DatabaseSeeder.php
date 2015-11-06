<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\EntityType;
use App\AttributeType;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		Model::unguard();

		DB::table('users')->delete();
		DB::table('password_resets')->delete();
		DB::table('attribute_types')->delete();
		DB::table('attributes')->delete();
		DB::table('entity_types')->delete();
		DB::table('entities')->delete();
		DB::table('alarm_types')->delete();
		DB::table('alarms')->delete();

		$admin = User::create([
			'name' => 'Amministratore',
			'email' => 'admin@pendola.it',
			'password' => Hash::make('cippalippa')
		]);

		$personType = EntityType::create([
			'name' => 'Personale',
			'icon' => 'user'
		]);

		$attrs = ['Indirizzo Mail' => 'mail', 'Telefono' => 'string', 'Data di Nascita' => 'date'];
		foreach($attrs as $n => $t) {
			AttributeType::create([
				'name' => $n,
				'datatype' => $t,
				'entity_type' => $personType->id
			]);
		}

		$vehicleType = EntityType::create([
			'name' => 'Veicoli',
			'icon' => 'car'
		]);

		$attrs = ['Targa' => 'string'];
		foreach($attrs as $n => $t) {
			AttributeType::create([
				'name' => $n,
				'datatype' => $t,
				'entity_type' => $vehicleType->id
			]);
		}

		$placeType = EntityType::create([
			'name' => 'Luoghi',
			'icon' => 'building'
		]);

		$attrs = ['Indirizzo' => 'address'];
		foreach($attrs as $n => $t) {
			AttributeType::create([
				'name' => $n,
				'datatype' => $t,
				'entity_type' => $placeType->id
			]);
		}

		Model::reguard();
	}
}
