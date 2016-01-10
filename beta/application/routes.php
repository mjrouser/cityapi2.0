<?php

Route::get('/', array('as' => 'home', 'uses' => 'event@index'));

Route::get('login', array('as' => 'login', 'uses' => 'auth@login'));
Route::get('auth/facebook-connect', array('as' => 'auth.facebookConnect', 'uses' => 'auth@facebookConnect'));
Route::get('logout', array('as' => 'logout', 'uses' => 'auth@logout'));

Route::get('events/me', array('as' => 'myEvents', 'before' => 'auth', 'uses' => 'event@me'));
Route::get('events/(:any)/edit', array('as' => 'event.edit', 'before' => 'auth', 'uses' => 'event@edit'));
Route::post('events/(:any)/edit', array('as' => 'event.edit', 'before' => 'auth', 'uses' => 'event@edit'));
Route::get('events/(:any)', array('as' => 'event.view', 'uses' => 'event@view'));

// Error Handlers

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

// Filters

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
    if (!Auth::guest()) {
        return;
    }

    return Redirect::to('login');
});
