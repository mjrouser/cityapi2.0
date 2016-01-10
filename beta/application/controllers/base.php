<?php

class Base_Controller extends Controller {

	// public function __construct() {
	// 	Asset::add('header', 'css/common.css');
	// 	Asset::add('header', 'js/header.js');

	// 	Asset::container('footer')->add('footer', 'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false');
	// 	Asset::container('footer')->add('footer', 'js/header.js');

	// 	parent::__construct();
	// }
	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}