<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindersTable extends Migration
{
	public function up()
	{
		Schema::create('reminders', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('alarm_id');
			$table->date('expiry');
			$table->boolean('active');
			$table->text('notes');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('reminders');
	}
}
