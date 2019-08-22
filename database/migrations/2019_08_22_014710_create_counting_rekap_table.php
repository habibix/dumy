<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountingRekapTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('counting_rekap', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('total');
			$table->integer('camera_id');
			$table->string('vehicle', 100);
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
		Schema::drop('counting_rekap');
	}

}
