<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaytayOnline
    ') }}</title>

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">


    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

        .py-4{
            background-color: rgb(195, 221, 236);
        }
        .nav-link{
            color: wheat !important;
            font-family: 'Montserrat', sans-serif;
        }
        .navbar-toggler-icon {
            color: aliceblue !important;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            color: aliceblue !important;
        }

    </style>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> 
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm">
    <div class="container-fluid">
        @auth
            @if(auth()->user()->type === 'admin')
                <a class="navbar-brand" href="{{ url('/admin/dashboard') }}">
                    {{ config('app.name', 'TaytayOnline') }}
                </a>
            @elseif(auth()->user()->type === 'business')
                <a class="navbar-brand" href="{{ url('/business/home') }}">
                    {{ config('app.name', 'TaytayOnline') }}
                </a>
            @elseif(auth()->user()->type === 'user')
                <a class="navbar-brand" href="{{ url('home') }}">
                    {{ config('app.name', 'TaytayOnline') }}
                </a>
            @endif
        @endauth
        
        <button class="navbar-toggler" type="button" style="background-color: rgba(218, 165, 32, 0.884)" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" id="signInView" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" id="signUpView" href="{{ route('login') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>


        <main class="py-4">
            @yield('content')
            @yield('scripts')
            @yield('styles')
        </main>
    </div>

    
    
</body>
</html>
