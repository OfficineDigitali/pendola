<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration
{
	public function up()
	{
		Schema::create('entities', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('type_id');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('entities');
	}
}
