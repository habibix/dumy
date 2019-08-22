<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCameraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('camera', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('wilayah', 100);
			$table->string('lokasi', 200);
			$table->string('ip_camera', 20);
			$table->string('status', 20)->default('connected');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('camera');
	}

}
