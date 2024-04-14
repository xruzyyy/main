<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- Vite import for SCSS --}}
        @vite(['../../scss/_header.scss'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .navbar{
    background-color: black !important;
}
        </style>
    </head>
<body>

<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">TaytayOnline</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            @if(Auth::check())
            @if(Auth::user()->type == 'admin')
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home" style="margin-top: 10px;"></i>
                </a>
            @elseif(Auth::user()->type == 'business')
            <a href="{{ route('business.home') }}"><i class="fas fa-home" style="margin-top: 10px;"></i>
            </a>
            @else
                <a href="{{ route('home') }}"><i class="fas fa-home"></i></i></a></a>
            @endif
        @else
            <a href="{{ route('home') }}"><i class="fas fa-home" style="margin-top: 10px;"></i>
            </a>
        @endif
    </li>

          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">More</a>
          </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav">
            @if (Auth::check() && Auth::user()->email_verified_at && !request()->is('login'))
                <li style="margin-right: 10px;">
                    <a href="/chatify" style="text-decoration: none;color: #006ce7f1">
                        <i class="fa-brands fa-facebook-messenger">
                            <div class="unread_notification">
                                {{ $unseenCount }} <!-- Display the unseenCount here -->
                            </div>
                        </i>
                    </a>
                </li>
            @endif
        </ul>

        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('listings.create') }}">Create Listings</a>
            </li>

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
        </ul>
  </div>
    </div>
</nav>


</body>
</html>
