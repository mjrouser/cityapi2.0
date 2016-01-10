<?php

class Add_Columns_To_Events_Table {

	public function up()
	{
		Schema::table('events', function($table)
		{
			$table->string('picture');
			$table->date('start_time');
			$table->date('end_time');
			$table->string('category');
			$table->string('location');
			$table->float('lat');
			$table->float('lng');
			$table->float('radius');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('events', function($table)
		{
			$table->drop_column('picture');
			$table->drop_column('start_time');
			$table->drop_column('end_time');
			$table->drop_column('category');
			$table->drop_column('location');
			$table->drop_column('lat');
			$table->drop_column('lng');
			$table->drop_column('radius');
		});
	}

}