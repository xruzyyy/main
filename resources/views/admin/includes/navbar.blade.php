<!-- Delete All Notifications Confirmation Modal -->
<div class="modal fade" id="deleteAllNotificationsModal" tabindex="-1" aria-labelledby="deleteAllNotificationsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAllNotificationsModalLabel">Delete All Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete all notifications?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('notifications.deleteAll') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete All</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Header -->
<header class="navbar navbar-expand-lg flex-md-nowrap p-3 shadow" tabindex="1" data-bs-theme="light"
    style="color: goldenrod; background-color: black;">
    <!-- Brand -->
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" style="color: goldenrod;"
        onmouseover="this.style.color='azure'" onmouseout="this.style.color='goldenrod'"
        href="{{ url('/admin/dashboard') }}">
        <img src="{{ asset('images/Taytay.png') }}" style="width: 100px; height:auto;" class="img-fluid" alt="Taytay Logo">    </a>

    <ul class="navbar-nav flex-row ms-auto">
        <!-- Notification Dropdown Menu -->
        <li class="nav-item dropdown">

            <a id="notificationDropdown" class="me-4 dropdown-toggle" href="#" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: goldenrod;">
                <i class="fa fa-bell"></i>
                <span
                    class="badge badge-light bg-danger badge-xs">{{ auth()->user()->unreadNotifications->count() }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end bg-light" aria-labelledby="notificationDropdown">
                <!-- Header with action buttons -->
                <div class="d-flex justify-content-between align-items-center px-3 py-2">
                    <h6 class="mb-0 text-dark">Notifications</h6>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#deleteAllNotificationsModal">Delete All</button>
                </div>
                <!-- Notification items -->
                <div class="notification-list-container" style="max-height: 800px; overflow-y: auto;">
                    <div class="notification-list" id="notificationList">
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <!-- Mark all as read button -->
                            <a href="{{ route('mark-as-read') }}"
                                class="btn btn-sm btn-success text-success mb-2 ms-3 bg-light">Mark All as Read</a>
                            <!-- Unread Notifications -->
                            @foreach (auth()->user()->unreadNotifications as $notification)
                                <a href="#" class="dropdown-item notification-item bg-inherit">
                                    <span class="notification-message">
                                        <!-- Red Dot for Unread Notification -->
                                        <span class="red-dot"></span>
                                        <!-- Display notification message -->
                                        @if ($notification->type === 'App\Notifications\NewUserNotification' && isset($notification->data['new_user_name']))
                                            New user registered: {{ $notification->data['new_user_name'] }} (Type:
                                            {{ $notification->data['new_user_type'] ?? 'Unknown' }})
                                        @elseif (
                                            $notification->type === 'App\Notifications\BusinessListingNotification' &&
                                                isset($notification->data['business_name']))
                                            New business listing added: {{ $notification->data['business_name'] }} (User
                                            ID: {{ $notification->data['user_id'] ?? 'Unknown' }})
                                        @else
                                            {{ $notification->data['message'] ?? '' }}
                                        @endif
                                    </span>
                                    <span
                                        class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                </a>
                            @endforeach
                            <!-- View All button -->
                            @if (auth()->user()->unreadNotifications->count() > 10)
                            @endif
                        @else
                            <p class="dropdown-item text-muted text-center my-2">No new notifications</p>
                        @endif

                        <!-- Read Notifications -->
                        @foreach (auth()->user()->readNotifications as $notification)
                            <a href="#" class="dropdown-item notification-item read">
                                <span class="notification-message">
                                    <!-- Display notification message -->
                                    @if ($notification->type === 'App\Notifications\NewUserNotification' && isset($notification->data['new_user_name']))
                                        New user registered: {{ $notification->data['new_user_name'] }} (Type:
                                        {{ $notification->data['new_user_type'] ?? 'Unknown' }})
                                    @elseif (
                                        $notification->type === 'App\Notifications\BusinessListingNotification' &&
                                            isset($notification->data['business_name']))
                                        New business listing added: {{ $notification->data['business_name'] }} (User
                                        ID: {{ $notification->data['user_id'] ?? 'Unknown' }})
                                    @else
                                        {{ $notification->data['message'] ?? '' }}
                                    @endif
                                </span>
                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        @endforeach

                        {{-- <!-- No new notifications message -->
                    @if (auth()->user()->unreadNotifications->isEmpty() && auth()->user()->readNotifications->isEmpty())
                        <p class="dropdown-item text-muted text-center my-2">No new notifications</p>
                    @endif --}}

                        <!-- View All button -->
                        @if (auth()->user()->notifications->count() > 10)
                            <button type="button" class="btn btn-primary btn-sm mx-3 my-2"
                                id="viewAllNotifications">View All</button>
                        @endif
                    </div>
                </div>
            </div>
        </li>
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

        <!-- User Profile Dropdown Menu -->
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                style="color: aliceblue;">
                {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-start border-0 shadow-sm rounded-0">
                {{-- <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}">Profile</a></li> --}}
                {{-- <li><a class="dropdown-item" href="{{ route('admin.password.index') }}">Change Password</a></li> --}}
                {{-- <li><hr class="dropdown-divider"></li> --}}
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>


    <label class="popup">
        <input type="checkbox">
        <div class="burger" tabindex="0">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <nav class="popup-window">
          <legend>Actions</legend>
          <ul>
            <li>
              <button>
                <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle r="4" cy="7" cx="9"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Colloborators</span>
              </button>
            </li>
            <li>
              <button>
                <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                  <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                </svg>
                <span>Magic Link</span>
              </button>
            </li>
            <hr>
            <li>
              <button>
                <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
                  <rect ry="2" rx="2" height="13" width="13" y="9" x="9"></rect>
                  <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
                <span>Clone</span>
              </button>
            </li>
            <li>
              <button>
                <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
                  <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                </svg>
                <span>Edit</span>
              </button>
            </li>
            <hr>
            <li>
              <button>
                <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
                  <line y2="18" x2="6" y1="6" x1="18"></line>
                  <line y2="18" x2="18" y1="6" x1="6"></line>
                </svg>
                <span>Delete</span>
              </button>
            </li>
          </ul>
        </nav>
      </label>
</header>
<style>
    /* CSS for Red Dot */
    .red-dot {
        width: 8px;
        height: 8px;
        background-color: red;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        /* Adjust as needed for spacing */
    }

    .unread_notification {
        margin-top: 5px;
        margin-left: -3px;
        background-color: rgb(255, 51, 51);
        display: inline-block;
        color: whitesmoke;
        height: 15px;
        width: 15px;
        text-align: center;
        font-size: 13px;
        border-radius: 80%;
    }
</style>




<!-- JavaScript -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var notifications = document.querySelectorAll('.notification-list .dropdown-item');
        var viewAllButton = document.getElementById('viewAllNotifications');
        var dropdownMenu = document.querySelector('.dropdown-menu');

        // Initially show only first 10 notifications
        notifications.forEach(function(notification, index) {
            if (index >= 10) {
                notification.style.display = 'none';
            }
        });

        // Event listener for View All button
        viewAllButton.addEventListener('click', function(event) {
            // Show all notifications
            notifications.forEach(function(notification) {
                notification.style.display = 'block';
            });

            // Prevent dropdown from closing
            event.stopPropagation(); // Prevents dropdown from closing
        });

        // JavaScript for deleting a single notification
        function deleteNotification(id) {
            if (confirm('Are you sure you want to delete this notification?')) {
                document.getElementById('delete-notification-form-' + id).submit();
            }
        }
    });
</script>



@foreach (auth()->user()->unreadNotifications as $notification)
    <form id="delete-notification-form-{{ $notification->id }}"
        action="{{ route('notifications.delete', ['id' => $notification->id]) }}" method="POST"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

@foreach (auth()->user()->readNotifications as $notification)
    <form id="delete-notification-form-{{ $notification->id }}"
        action="{{ route('notifications.delete', ['id' => $notification->id]) }}" method="POST"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach
