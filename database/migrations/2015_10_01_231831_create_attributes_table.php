<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
	public function up()
	{
		Schema::create('attributes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('entity_id');
			$table->integer('type_id');
			$table->string('value');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('attributes');
	}
}
