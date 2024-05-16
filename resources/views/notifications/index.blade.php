@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Notifications</div>

                <div class="card-body">
                    <div class="notification-list-container">
                        @if($notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <div class="notification-item {{ $notification->read_at ? 'read' : '' }}">
                                    @if ($notification->type === 'App\Notifications\NewCommentNotification' && isset($notification->data['comment_content']) && isset($notification->data['commenter_profile_image']))
                                        @php
                                            $commentData = $notification->data;
                                        @endphp
                                        <div class="notification-message">
                                            <img src="{{ $commentData['commenter_profile_image'] }}" alt="{{ $commentData['commenter_name'] }}'s profile image" class="commenter-profile-image">
                                            New comment by {{ $commentData['commenter_name'] }} on your post: "{{ $commentData['comment_content'] }}"
                                        </div>
                                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p>No new notifications</p>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Mark All as Read</button>
                    </form>
                    <form action="{{ route('notifications.deleteAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete All</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
