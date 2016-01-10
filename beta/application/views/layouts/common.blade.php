<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>@yield('title')</title>

        <meta name="viewport" content="width=device-width">

        {{ HTML::style('css/common.css'); }}
        {{ Asset::styles() }}

        {{ HTML::script('js/header.js'); }}
        {{ Asset::scripts() }}

        @yield('head')
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="/">CityAPI</a>

                    @yield('navigation')

                    <ul class="nav pull-right">
                        @if ( Auth::guest() )
                            <li><a href="{{ URL::to_route('login') }}">Logga in</a></li>
                        @else
                            <li><a href="{{ URL::to_route('myEvents') }}">Mina events</a></li>
                            <li><a href="{{ URL::to_route('logout') }}">Logga ut</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div id="main" role="main">
            @yield('content')
        </div>

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
        {{ HTML::script('js/footer.js'); }}

        @yield('footer')
    </body>
</html>
