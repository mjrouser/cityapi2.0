<?php

namespace Model;
use Eloquent;

error_log(print_r(debug_backtrace(), true));

class User extends Eloquent {

	public static $timestamps = true;

	public function events()
	{
		return $this->has_many('Model\Event', 'owner_id');
	}
}
