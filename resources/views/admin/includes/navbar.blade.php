<!-- Deletion Confirmation Modal -->
<div class="modal fade" id="deleteAllNotificationsModal" tabindex="-1" aria-labelledby="deleteAllNotificationsModalLabel" aria-hidden="true">
    <!-- Modal content -->
</div>

<!-- Header -->
<header class="navbar navbar-expand-lg flex-md-nowrap p-3 shadow" tabindex="1" data-bs-theme="light" style="color: goldenrod; background-color: black;">
    <!-- Brand -->
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" style="color: goldenrod;" onmouseover="this.style.color='azure'" onmouseout="this.style.color='goldenrod'" href="{{ url('/admin/dashboard') }}">TaytayOnline</a>

    <ul class="navbar-nav flex-row ms-auto">
        <!-- Logout Dropdown Menu -->
        <!-- Notification Dropdown Menu -->
        <li class="nav-item dropdown">
            <a id="notificationDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: goldenrod;">
                <i class="fa fa-bell"></i>
                <span class="badge badge-light bg-danger badge-xs">{{ auth()->user()->unreadNotifications->count() }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end bg-light" aria-labelledby="notificationDropdown">
                <!-- Header with action buttons -->
                <div class="d-flex justify-content-between align-items-center px-3 py-2">
                    <h6 class="mb-0 text-dark">Notifications</h6>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAllNotificationsModal">Delete All</button>
                </div>
                <!-- Notification items -->
<div class="notification-list-container" style="max-height: 800px; overflow-y: auto;">
    <div class="notification-list" id="notificationList">
        @if (auth()->user()->unreadNotifications->count() > 0)
            <!-- Mark all as read button -->
            <a href="{{ route('mark-as-read') }}" class="btn btn-sm btn-success text-success mb-2 ms-3 bg-light">Mark All as Read</a>
            <!-- Unread Notifications -->
            @foreach (auth()->user()->unreadNotifications as $notification)
                <a href="#" class="dropdown-item notification-item bg-inherit">
                    <span class="notification-message">
                        <!-- Red Dot for Unread Notification -->
                        <span class="red-dot"></span>
                        <!-- Display notification message -->
                        @if ($notification->type === 'App\Notifications\NewUserNotification' && isset($notification->data['new_user_name']))
                            New user registered: {{ $notification->data['new_user_name'] }} (Type: {{ $notification->data['new_user_type'] ?? 'Unknown' }})
                        @elseif ($notification->type === 'App\Notifications\BusinessListingNotification' && isset($notification->data['business_name']))
                            New business listing added: {{ $notification->data['business_name'] }} (User ID: {{ $notification->data['user_id'] ?? 'Unknown' }})
                        @else
                            {{ $notification->data['message'] ?? '' }}
                        @endif
                    </span>
                    <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
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
                        New user registered: {{ $notification->data['new_user_name'] }} (Type: {{ $notification->data['new_user_type'] ?? 'Unknown' }})
                    @elseif ($notification->type === 'App\Notifications\BusinessListingNotification' && isset($notification->data['business_name']))
                        New business listing added: {{ $notification->data['business_name'] }} (User ID: {{ $notification->data['user_id'] ?? 'Unknown' }})
                    @else
                        {{ $notification->data['message'] ?? '' }}
                    @endif
                </span>
                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
            </a>
        @endforeach

        <!-- No new notifications message -->
        @if (auth()->user()->unreadNotifications->isEmpty() && auth()->user()->readNotifications->isEmpty())
            <p class="dropdown-item text-muted text-center my-2">No new notifications</p>
        @endif

        <!-- View All button -->
        @if (auth()->user()->notifications->count() > 10)
            <button type="button" class="btn btn-primary btn-sm mx-3 my-2" id="viewAllNotifications">View All</button>
        @endif
    </div>
</div>

        </li>

    </ul>
</header>
<style>
    /* CSS for Red Dot */
.red-dot {
    width: 8px;
    height: 8px;
    background-color: red;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px; /* Adjust as needed for spacing */
}

</style>
<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Show only first 10 notifications
    var notifications = document.querySelectorAll('.notification-list .dropdown-item');
    var viewAllButton = document.getElementById('viewAllNotifications');

    notifications.forEach(function(notification, index) {
        if (index >= 10) {
            notification.style.display = 'none';
        }
    });

    // Event listener for View All button
    viewAllButton.addEventListener('click', function() {
        notifications.forEach(function(notification) {
            notification.style.display = 'block';
        });
        viewAllButton.style.display = 'none';
    });
});

</script>
