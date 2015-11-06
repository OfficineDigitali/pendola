<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeTypesTable extends Migration
{
	public function up()
	{
		Schema::create('attribute_types', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('entity_type');
			$table->string('name');
			$table->string('slug');
			$table->string('datatype');
			$table->integer('order');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('attribute_types');
	}
}
