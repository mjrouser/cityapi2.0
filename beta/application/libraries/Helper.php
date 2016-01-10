<?php

class Helper {
	static private $facebook;

	static function Facebook() {
		if (!self::$facebook) {
			self::$facebook = new Facebook(array(
				'appId' => Config::get('facebook.app_id'),
				'secret' => Config::get('facebook.secret'),
			));
		}

		return self::$facebook;
	}
}
