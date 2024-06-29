<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Vite import for SCSS --}}
    @vite(['resources/scss/_header.scss'])
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .navbar {
            background-color: black !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        @auth
        @if(auth()->user()->type === 'admin')
            <a class="navbar-brand" href="{{ url('/admin/dashboard') }}">
                <img src="{{ asset('images/Taytay.png') }}" style="width: 100px; height:auto;" class="img-fluid" alt="Taytay Logo">
            </a>
        @elseif(auth()->user()->type === 'business')
            <a class="navbar-brand" href="{{ url('/business/home') }}">
                <img src="{{ asset('images/Taytay.png') }}" style="width: 100px; height:auto;" class="img-fluid" alt="Taytay Logo">
            </a>
        @elseif(auth()->user()->type === 'user')
            <a class="navbar-brand" href="{{ url('/home') }}">
                <img src="{{ asset('images/Taytay.png') }}" style="width: 100px; height:auto;" class="img-fluid" alt="Taytay Logo">
            </a>
        @endif
    @endauth

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    @if(Auth::check())
                        @if(Auth::user()->type == 'admin')
                            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home" style="margin-top: 10px;"></i></a>
                        @elseif(Auth::user()->type == 'business')
                            <a href="{{ route('business.home') }}"><i class="fas fa-home" style="margin-top: 10px;"></i></a>
                        @else
                            <a href="{{ route('home') }}"><i class="fas fa-home" style="margin-top: 10px;"></i></a>
                        @endif
                    @else
                        <a href="{{ route('home') }}"><i class="fas fa-home" style="margin-top: 10px;"></i></a>
                    @endif
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" onclick="scrollToAbout()">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" onclick="scrollToservicesUser()">Services</a>
                </li>
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
                    <!-- Right Side Of Navbar -->
                    {{-- <ul class="navbar-nav ms-auto mt-2">
                        @if (Auth::check() && Auth::user()->email_verified_at && !request()->is('login'))

                    @endif
                    </ul> --}}
                     {{-- <li class="chatify mt-2">
                        <a href="/chatify" style="text-decoration: none;color: #006ce7f1">
                            <i class="fa-brands fa-facebook-messenger">
                                <div class="unread_notification">
                                    {{ $unseenCount }} <!-- Display the unseenCount here -->
                                </div>
                            </i>
                        </a>
                    </li> --}}

                    <button class="inbox-btn">
                        <svg viewBox="0 0 512 512" height="16" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"
                            ></path>
                        </svg>
                        <a href="/chatify" class="msg-count"> {{ $unseenCount }}</a>
                    </button>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<script>
    function scrollToAbout() {
        const aboutSection = document.getElementById('aboutUser');
        if (aboutSection) {
            aboutSection.scrollIntoView({ behavior: 'smooth' });
        } else {
            window.location.href = '{{ route('home') }}#aboutUser';
        }
    }

    function scrollToservicesUser() {
        const servicesUserSection = document.getElementById('servicesUser');
        if (servicesUserSection) {
            servicesUserSection.scrollIntoView({ behavior: 'smooth' });
        } else {
            window.location.href = '{{ route('home') }}#servicesUser';
        }
    }
</script>

</body>
</html>
