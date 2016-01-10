<?php

class Create_Events_Table {

	public function up()
	{
		Schema::table('events', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('facebook_id')->unique();
			$table->integer('owner_id')->unsigned();
			$table->string('name');
			$table->text('description');
			$table->timestamps();

			$table->foreign('owner_id')->references('id')->on('users');
		});
	}

	public function down()
	{
		Schema::drop('events');
	}

}
