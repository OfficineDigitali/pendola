<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmTypesTable extends Migration
{
	public function up()
	{
		Schema::create('alarm_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('entity_type');
			$table->enum('type', ['date', 'interval']);
			$table->enum('recurrence', ['once', 'daily', 'weekly', 'monthly', 'yearly', 'custom']);
			$table->string('recurrence_details');
			$table->string('color');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('alarm_types');
	}
}
