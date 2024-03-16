<!-- main.blade.php -->
<div class="container">
    <h1>Run Schedule</h1>
    @if(isset($successMessage))
        <div class="success-message">{{ $successMessage }}</div>
    @elseif(isset($infoMessage))
        <div class="info-message">{{ $infoMessage }}</div>
    @endif

    <div class="buttons">
        @include('check-expired')

        <a href="{{ route('show-active-users') }}"><button>Show Active Users</button></a>
        <a href="{{ route('show-expired-users') }}"><button>Show Expired Users</button></a>
        <a href="{{ route('show-inactive-users') }}"><button>Show Inactive Users</button></a>
    </div>

    @yield('content')
</div>
