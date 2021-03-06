<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityTypesTable extends Migration
{
	public function up()
	{
		Schema::create('entity_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('icon');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('entity_types');
	}
}
