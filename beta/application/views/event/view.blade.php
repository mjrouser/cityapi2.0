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
                <p><small>Kategori:</small> {{{ $event->category }}}</p>
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
            <div class="span12 aspect-container">
                <div class="aspect-sizer-8-3"></div>
                <div id="map" class="aspect-content"></div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(function($) {
        'use strict'

        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv, {
            center: new google.maps.LatLng({{ $event->lat }}, {{ $event->lng }}),
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            draggable: false,
            disableDoubleClickZoom: true,
            keyboardShortcuts: false,
            scrollwheel: false
        });

        var distanceWidget = new DistanceWidget({
            map: map,
            position: map.getCenter(),
            distance: {{ $event->radius }} / 1000,
            draggable: false,
            resizable: false,
            color: CategoryColors['{{ $event->category }}']
        });

        map.fitBounds(distanceWidget.get('bounds'));

        });
    </script>
@endsection
