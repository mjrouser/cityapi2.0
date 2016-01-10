<?php

class Event_Controller extends Base_Controller {
	public $restful = true;

	public function get_index()
	{
		$events = Model\Event::all();

		return View::make('event.index')
			->with('events', $events);
	}

	public function get_me()
	{
		$userId = Auth::user()->facebook_id;

		$query = "SELECT
			eid,
			name,
			description,
			start_time,
			end_time,
			location,
			venue,
			pic,
			creator
		FROM event
		WHERE
			creator = $userId
		ORDER BY start_time ASC";

		// $query = "SELECT
		// 	eid,
		// 	name,
		// 	description,
		// 	start_time,
		// 	end_time,
		// 	location,
		// 	venue,
		// 	pic,
		// 	creator
		// FROM event
		// WHERE
		// 	creator = $userId
		// AND (
		// 	end_time >= " . time() . '
		// 	OR
		// 	NOT end_time
		// )
		// ORDER BY start_time ASC';

		$facebook_events = Helper::facebook()->api(array(
			'method' => 'fql.query',
			'query' => $query,
		));

		$events = array();

		foreach ($facebook_events as $facebook_event) {
			Log::debug(print_r($facebook_event, true));
			$event = Model\Event::where_facebook_id($facebook_event['eid'])->first();

			if (!$event) {
				$event = new Model\Event();
				$event->facebook_id = $facebook_event['eid'];
			}

			$event->name = $facebook_event['name'];
			$event->location = $facebook_event['location'];
			$event->owner_id = Auth::user()->id;
			$event->start_time = $facebook_event['start_time'];
			$event->end_time = $facebook_event['end_time'];
			$event->description = $facebook_event['description'];
			$event->picture = $facebook_event['pic'];

			$events[] = $event;
		}

		return View::make('event.me')
			->with('events', $events);
	}

	public function get_view($eid)
	{
		$event = Model\Event::where_facebook_id($eid)->first();

		if (!$event) {
			return Response::error('404');
		}

		// $facebook_event = Helper::facebook()->api($eid, array('fields' => 'id,owner,name,location,description,start_time,end_time,picture.type(large)'));

		// if (!$facebook_event) {
		// 	return Response::error('404');
		// }

		// $event->name = $facebook_event['name'];
		// $event->location = $facebook_event['location'];
		// $event->start_time = $facebook_event['start_time'];
		// $event->end_time = $facebook_event['end_time'];
		// $event->description = $facebook_event['description'];
		// $event->picture = $facebook_event['picture']['data']['url'];

		return View::make('event.view')
			->with('event', $event);
	}

	public function get_edit($eid)
	{
		$facebook_event = Helper::facebook()->api($eid, array('fields' => 'id,owner,name,location,description,start_time,end_time,picture.type(large)'));

		if (!$facebook_event) {
			return Response::error('404');
		}

		if ($facebook_event['owner']['id'] !== Auth::user()->facebook_id) {
			return Response::error('401');
		}

		$event = Model\Event::where_facebook_id($facebook_event['id'])->first();

		if (!$event) {
			$event = new Model\Event();
			$event->facebook_id = $facebook_event['id'];
			$event->lat = 55.604981;
			$event->lng = 13.003822;
			$event->radius = 500;
		}

		$event->name = $facebook_event['name'];
		$event->location = $facebook_event['location'];
		$event->owner_id = Auth::user()->id;
		$event->start_time = $facebook_event['start_time'];
		$event->end_time = $facebook_event['end_time'];
		$event->description = $facebook_event['description'];
		$event->picture = $facebook_event['picture']['data']['url'];

		return View::make('event.edit')
			->with('event', $event);
	}

	public function post_edit($eid) {
		$facebook_event = Helper::facebook()->api($eid, array('fields' => 'id,owner,name,location,description,start_time,end_time,picture.type(large)'));

		if (!$facebook_event) {
			return Response::error('404');
		}

		if ($facebook_event['owner']['id'] !== Auth::user()->facebook_id) {
			return Response::error('401');
		}

		$event = Model\Event::where_facebook_id($facebook_event['id'])->first();

		if (Input::has('delete')) {
			if (!$event) {
				return Response::error('404');
			}

			$event->delete();

			return Redirect::to_action('event@index');
		}

		if (!$event) {
			$event = new Model\Event();
			$event->facebook_id = $facebook_event['id'];
		}

		$event->name = $facebook_event['name'];
		$event->category = Input::get('category');
		$event->location = $facebook_event['location'];
		$event->lat = Input::get('lat');;
		$event->lng = Input::get('lng');;
		$event->radius = Input::get('radius');;
		$event->owner_id = Auth::user()->id;
		$event->start_time = $facebook_event['start_time'];
		$event->end_time = $facebook_event['end_time'];
		$event->description = $facebook_event['description'];
		$event->picture = $facebook_event['picture']['data']['url'];

		$event->save();

		return Redirect::to_action('event@view', array('eid' => $eid));
	}
}
