<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Vite import for SCSS and JS --}}

    @vite(['resources/scss/_header.scss','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            @auth
                @php
                    $user = auth()->user();
                    $userType = $user->type;
                    $homeRoute = $userType === 'admin' ? 'admin.dashboard' : ($userType === 'business' ? 'business.home' : 'home');
                @endphp
                <a class="navbar-brand" href="{{ route($homeRoute) }}">
                    <img src="{{ asset('images/Taytay.png') }}" alt="Taytay Logo" width="100" height="auto">
                </a>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('business.home') }}" class="nav-link">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" onclick="scrollToAbout()">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" onclick="scrollToservicesMainBusiness()">Services</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" id="signInView" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" id="signUpView" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else




                        <li class="nav-item me-3">
                            <a href="/chatify" class="btn btn-outline-light btn-sm position-relative">
                                <i class="fas fa-envelope"></i>
                                @if($unseenCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unseenCount }}
                                    </span>
                                @endif
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
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


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-BsZ7XORStCwXXn9DFluBu/Ap8f7Qp6Ddf/g+QEQYtdOg7GQugQclJ9O+Rjt7O6gD" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9bBodhuEpMOmKgl14h9QT/60L7/pJ5lCrtHGLr5zEyhJHxtM5U7kCxZ" crossorigin="anonymous">
    </script>
    <script>
        function scrollToAbout() {
            const aboutSection = document.getElementById('about');
            if (aboutSection) {
                aboutSection.scrollIntoView({
                    behavior: 'smooth'
                });
            } else {
                window.location.href = '{{ route('business.home') }}#about';
            }
        }

        function scrollToservicesMainBusiness() {
            const servicesMainBusiness = document.getElementById('servicesMainBusiness');
            if (servicesMainBusiness) {
                servicesMainBusiness.scrollIntoView({
                    behavior: 'smooth'
                });
            } else {
                window.location.href = '{{ route('business.home') }}#servicesMainBusiness';
            }
        }
    </script>


    </script>
</body>

</html>
