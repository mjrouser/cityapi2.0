@layout('layouts.common')

@section('content')
<div id="map"></div>
@endsection

@section('footer')
	@parent

	<script type="text/javascript">
		(function(google) {
		'use strict';

		var map = new google.maps.Map(document.getElementById('map'), {
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: new google.maps.LatLng(0, 0),
			zoom: 0,
			streetViewControl: false,
			mapTypeControl: false
		});

		var bounds = new google.maps.LatLngBounds();

		@foreach($events as $event)
			(function() {

	        var distanceWidget = new DistanceWidget({
	            map: map,
	            position: new google.maps.LatLng({{ $event->lat }}, {{ $event->lng }}),
	            distance: {{ $event->radius }} / 1000,
	            draggable: false,
	            resizable: false,
	            color: CategoryColors['{{ $event->category }}']
	        });

	        bounds.union(distanceWidget.get('bounds'));

			google.maps.event.addListener(distanceWidget, 'click', function() {
				window.location = '{{ URL::to_route('event.view', array($event->facebook_id)) }}';
			});

		    })();
		@endforeach

		map.fitBounds(bounds);

		})(google);
	</script>
@endsection
