<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Vite import for SCSS and JS --}}
    @vite(['resources/scss/_header.scss', 'resources/scripts/script.js', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            {{-- @auth
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
            @endauth --}}

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

                        <li class="nav-item" style="margin-top: 7px;">
                        <a href="/chatify" style="text-decoration: none;color: #e79e00f1; margin-left:15px;">
                                    <i class="fa-solid fa-envelope"></i>
                                    <div class="unread_notification">
                                            {{ $unseenCount }} <!-- Display the unseenCount here -->
                                        </div>
                                    </i>
                                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link create-listing-btn" href="{{ route('listings.create') }}">Create Listings</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                <!-- Profile Link -->
                                <a style="font-family: Montserrat, sans-serif;" class="dropdown-item" href="{{ route('business.profile') }}"><i  class="fa-regular fa-user"></i>Profile</a>
                                <!-- Logout Link -->
                                <a class="dropdown-item" style="background-color: rgb(223, 26, 0); border-radius:12px; width:60%;" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
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
