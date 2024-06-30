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

    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            @auth
                @php
                    $user = auth()->user();
                    $userType = $user->type;
                    $homeRoute =
                        $userType === 'admin'
                            ? 'admin.dashboard'
                            : ($userType === 'business'
                                ? 'business.home'
                                : 'home');
                @endphp
                <a class="navbar-brand" href="{{ route($homeRoute) }}">
                    <img src="{{ asset('images/Taytay.png') }}" style="width: 100px; height:auto;" class="img-fluid"
                        alt="Taytay Logo">
                </a>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('business.home') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" onclick="scrollToAbout()">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);"
                            onclick="scrollToservicesMainBusiness()">Services</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
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
                        <li class="nav-item">
                            <a id="notificationButton" class="nav-link" href="#" data-bs-toggle="modal"
                                data-bs-target="#notificationModal">
                                <i class="fas fa-bell"></i>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span style="font-size:; color: rgba(255, 196, 0, 0.877); font-weight: 900; margin:0px;"
                                        class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </a>

                        </li>

                        {{-- <li class="nav-item" style="margin-top: 7px;">
                        <a href="/chatify" style="text-decoration: none;color: #e79e00f1; margin-left:15px;">
                                    <i class="fa-solid fa-envelope"></i>
                                    <div class="unread_notification">
                                            {{ $unseenCount }} <!-- Display the unseenCount here -->
                                        </div>
                                    </i>
                                </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link create-listing-btn" href="{{ route('listings.create') }}">Create Listings</a>
                        </li> --}}

                        @php
                        $updateListing = \App\Models\Posts::where('user_id', auth()->user()->id)->exists();
                    @endphp

                    <button class="Listing" onclick="window.location.href='{{ $updateListing ? route('listings.update', ['id' => \App\Models\Posts::where('user_id', auth()->user()->id)->first()->id]) : route('listings.create') }}'">
                        <div class="sign">+</div>
                        <div class="text">Listing</div>
                    </button>


                        <button class="inbox-btn">
                            <svg viewBox="0 0 512 512" height="16" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"
                                ></path>
                            </svg>
                            <a href="/chatify" class="msg-count"> {{ $unseenCount }}</a>
                        </button>


                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                <!-- Profile Link -->
                                <a style="font-family: Montserrat, sans-serif;" class="dropdown-item" href="{{ route('business.profile') }}"><i  class="fa-regular fa-user"></i>Profile</a>
                                <!-- Logout Link -->
                                {{-- <a class="dropdown-item" style="background-color: rgb(223, 26, 0); border-radius:12px; width:60%;" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <!-- Logout Form -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form> --}}

                                <button class="Btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="sign">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                                        </svg>
                                    </div>
                                    <span class="text">Logout</span>
                                </button>

                                <!-- Logout Form -->
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

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="notification-list-container">
                        @if (auth()->user()->notifications->count() > 0)
                            @foreach (auth()->user()->notifications as $notification)
                                <div class="notification-item {{ $notification->read_at ? 'read' : '' }}">
                                    @if (
                                        $notification->type === 'App\Notifications\NewCommentNotification' &&
                                            isset($notification->data['comment_content']) &&
                                            isset($notification->data['commenter_profile_image']))
                                        @php
                                            $commentData = $notification->data;
                                        @endphp
                                        <div class="notification-message">
                                            <img src="{{ asset($commentData['commenter_profile_image']) }}"
                                                alt="{{ $commentData['commenter_name'] }}'s profile image"
                                                class="commenter-profile-image">
                                            <!-- Red dot indicator -->
                                            @if (!$notification->read_at)
                                                <span class="red-dot"></span>
                                            @endif
                                            <!-- End of red dot indicator -->
                                            New comment by {{ $commentData['commenter_name'] }} on your post:
                                            "{{ $commentData['comment_content'] }}"
                                        </div>
                                        <span
                                            class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>

                                        <!-- Add mark as read button -->
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                onclick="return confirm('Are you sure you want to mark this notification as read?')">
                                                <i class="fas fa-check"></i> Mark as Read
                                            </button>
                                        </form>
                                        <!-- End of mark as read button -->

                                        <!-- Add delete button -->
                                        <form action="{{ route('notifications.delete', $notification->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this notification?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        <!-- End of delete button -->
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p>No new notifications</p>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Mark All as Read</button>
                    </form>

                    <form id="delete-notification-form" action="{{ route('notifications.deleteAll') }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete All</button>
                    </form>
                </div>

                <script>
                    // Script to handle individual notification deletion
                    function deleteNotification(id) {
                        event.preventDefault();
                        if (confirm('Are you sure you want to delete this notification?')) {
                            document.getElementById('delete-notification-form').action = '/notifications/delete/' + id;
                            document.getElementById('delete-notification-form').submit();
                        }
                    }
                </script>

            </div>
        </div>
    </div>

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
