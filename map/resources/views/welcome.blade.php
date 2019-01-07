<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Twinkle Star Dance - Find a Studio</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <!--@if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif-->

            <!--<div class="content">-->
            <div class="container">
                {{ HTML::image('img/tsdhome.jpg', 'She will love dancing in her Twinkle Wear with her Twinkle Bear', array('class' => 'image-full')) }}
            </div>
            <div class="container">
                <div class="title m-b-md">
                    Find Twinkle Star Dance™<br/>
                    Near You!
                </div>
                <div class='map-filter'>
                    <div class='country-filter'>
                    Country:
                    <select class="country-select">
                     @foreach ($countries as $index => $country)
                        <option value="{{$country->id}}" data-lng='{{$country->longitude}}' data-lat='{{$country->latitude}}' data-zoom='{{$country->zoom}}' >{{$country->name}}</option>
                     @endforeach
                    </select>
                    </div>
                    <div class='state-filter'>
                    State:
                    <select class="state-select">
                    @foreach ($countries as $index => $country)
                        <option data-country="{{$country->id}}" value="{{$country->id}}" data-lng='{{$country->longitude}}' data-lat='{{$country->latitude}}' data-zoom='{{$country->zoom}}'>All</option>
                    @endforeach
                    @foreach ($states as $index => $state)
                        <option value="{{$state->name}}" data-country='{{$state->country}}' data-lng='{{$state->longitude}}' data-lat='{{$state->latitude}}' data-zoom='{{$state->zoom}}' >{{$state->name}}</option>                        
                    @endforeach
                    </select>
                    </div>
                </div>
                <div id="js-map">
                </div>
                <div class="search-by-zip">
                    Search by ZIP code:
                    <input type="text" class="search-by-zip-text"/>                    
                    <input type="button" class="search-by-zip-btn btn-info" value="Search"></input>
                </div>
                <div class="search-by-zip-results">
                </div>
                <!--<div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>-->
            </div>
        </div>
        <footer>
            <div class="container">
                © 2012-{{Carbon\Carbon::today()->format('Y')}} Twinkle Star Dance. All rights reserved.
            </div>
        </footer>
        <script>
            var csrf_token = '{{ csrf_token() }}';
            var studios = [];
            @foreach ($studios as $index => $studio)
                studios.push({name:"{!! $studio->name !!}",latitude:{!! $studio->latitude !!},longitude:{!! $studio->longitude !!}, address:"{!! $studio->address !!}", phone:"{!! $studio->phone !!}",email:"{!! $studio->email !!}",website:"{!! $studio->website !!}",zip:"{!! preg_replace( '/\r|\n/', '', $studio->zip); !!}",country:"{!! $studio->country !!}" });
             @endforeach
            var countries = [];
            @foreach ($countries as $index => $country)
                countries.push({name:"{!! $country->name !!}",latitude:{!! $country->latitude !!},longitude:{!! $country->longitude !!}, zoom:"{!! $country->zoom !!}" });
             @endforeach
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
        var map;
        </script>
         <script src="https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/src/markerclusterer.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBX3QoDDjWlh3AHKVwDg4vWqG9IVf5wQpk">
    </script>
    </body>
</html>
