<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/content.js') }}" defer></script>
    <script src="{{ asset('js/firstScript.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- 現状こっちで読み込んでいる -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}"> <!-- Styles -->

    <!-- for tutorial -->
    <!-- <link href="{{ asset('css/content.css') }}" rel="stylesheet"> -->
</head>
<body>
    <div id="app">
        <!-- <nav class="navbar navbar-expand-md navbar-light navbar-laravel"> -->
        <div class="navbar navbar-light main-header">
            <div class="container">
                <!-- <a class="navbar-brand" href="{{ url('/home') }}"> -->
                <a id="app-title" href="{{ url('/') }}">
                    Fields
                    <!-- {{ config('app.name', 'Home') }} -->
                </a>
                @auth
                    <span class="user_icon" id="header_icon" style="background-image: url('{{asset('storage/'.Auth::user()->icon_path)}}')"></span>
                    <!-- <img id="header_icon" src="{{asset('storage/'.Auth::user()->icon_path)}}"></img> -->
                @endauth
                <div class="ml-auto" id="navbar">
                    <input id="nav-input" type="checkbox" class="unshown">
                    <label id="nav-icon" for="nav-input"><span></span></label>
                    <label class="unshown" id="nav-close" for="nav-input"></label>
                    <div id="nav-content">
                        <ul>
                            <li>Menu</li>
                            @guest
                                <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @else
                                <li><a class="nav-link" href="{{ route('rooms.index') }}">{{ __('Show Your Room') }}</a></li>
                                <li><a class="nav-link" href="{{ route('find') }}">{{ __('Find Room') }}</a></li>
                                <li><a class="nav-link" href="{{ route('rooms.create') }}">{{ __('Create Room') }}</a></li>
                                <li><a class="nav-link" href="{{ route('setUser', ['id' => Auth::user()->user_id] ) }}">{{ __('Setting') }}</a></li>
                                <li><a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form></li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
            <!-- </div -->
        </div>
        <!-- </nav> -->

        <main class="py-4">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error}}</li>
                    @endforeach
                </ul>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
