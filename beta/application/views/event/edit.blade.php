@layout('layouts/common')

@section('content')
    <div class="container container-root">
        <div class="row">
            <div class="picture-container span3">
                <img class="picture" src="{{ $event->picture }}">
            </div>
            <div class="span9">
                <h1>{{{ $event->name }}}</h1>
                <p>av <a target="_blank" href="https://facebook.com/{{ $event->owner->facebook_id }}">{{{ $event->owner->name }}}</a>
                <p><small>Börjar:</small> {{ date("Y-m-d H:i", strtotime($event->start_time)) }}</p>
                <p><small>Slutar:</small> {{ date("Y-m-d H:i", strtotime($event->end_time)) }}</p>
            </div>
        </div>

        <div class="row">
            <div class="span12">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="span12">
                <p>{{ nl2br(e($event->description)) }}</p>
            </div>
        </div>

        <div class="row">
            <div class="span12">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="span6 aspect-container">
                <div class="aspect-sizer-4-3"></div>
                <div id="map" class="aspect-content"></div>
            </div>
            <div class="span6">
                {{ Form::open(); }}
                    {{ Form::token() }}
                    <label for="lat">Latitude</label>
                    <input type="text" name="lat" value="{{ $event->lat }}">

                    <label for="lng">Longitude</label>
                    <input type="text" name="lng" value="{{ $event->lng }}">

                    <label for="radius">Radie</label>
                    <input type="text" name="radius" placeholder="Radie" value="{{ $event->radius }}">

                    <label for="category">Kategori</label>
                    {{ Form::select('category', array('festival' => 'Festival', 'cultural' => 'Kultur', 'family' => 'Familj', 'sports' => 'Sport', 'market' => 'Marknad')); }}


                    <div>
                    @if ($event->exists)
                        {{ Form::submit('Ta bort', array('name' => 'delete', 'class' => 'btn btn-danger')) }}
                    @endif
                    {{ Form::submit('Spara', array('class' => 'btn btn-success')); }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection


@section('footer')
    <script type="text/javascript">
        $(function($) {
        'use strict'

        var $latInput = $('input[name="lat"]');
        var $lngInput = $('input[name="lng"]');
        var $radiusInput = $('input[name="radius"]');

        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv, {
            center: new google.maps.LatLng({{ $event->lat }}, {{ $event->lng }}),
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
            mapTypeControl: false
        });

        var distanceWidget = new DistanceWidget({
            map: map,
            position: map.getCenter(),
            distance: {{ $event->radius }} / 1000,
            maxDistance: 2000 / 1000,
            color: '#000000',
            icon: {
                url: '/img/MapWidget-drag.png',
                anchor: new google.maps.Point(8, 8)
            },
            sizerIcon: {
                url: '/img/MapWidget-resize.png',
                anchor: new google.maps.Point(8, 8)
            },
            draggable: true,
            resizable: true
        });

        google.maps.event.addListener(distanceWidget, 'distance_changed', function() {
            $radiusInput.val(distanceWidget.get('distance') * 1000);
        });

        google.maps.event.addListener(distanceWidget, 'position_changed', function() {
            $latInput.val(distanceWidget.get('position').lat());
            $lngInput.val(distanceWidget.get('position').lng());
        });

        map.fitBounds(distanceWidget.get('bounds'));

        });
    </script>
@endsection
