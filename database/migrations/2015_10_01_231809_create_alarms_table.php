<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmsTable extends Migration
{
	public function up()
	{
		Schema::create('alarms', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('type_id');
			$table->integer('entity_id');
			$table->integer('author_id');
			$table->integer('owner_id');
			$table->date('date1');
			$table->date('date2');
			$table->text('notes');
			$table->boolean('closed');
			$table->integer('closer_id');
			$table->integer('prev_id');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('alarms');
	}
}
