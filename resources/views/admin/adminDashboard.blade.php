@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="float-right">
            @include('components.user-card-section') <!-- Include user card section -->
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="float-right">
            @include('components.listing-card-section') <!-- Include listing card section -->
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="float-right">
            @include('components.pending-business-user-card-section') <!-- Include listing card section -->
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="float-left">
            @include('components.expired-business-user-card-section') <!-- Include listing card section -->
        </div>
    </div>

    {{-- <div class="col-md-6 mb-4">
        <div class="float-right">
            @include('components.pending-business-user-card-section') <!-- Include listing card section -->
        </div>
    </div> --}}

</div>

<!-- Scripts -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('f8722a19e8bc706d28f9', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event, function(data) {
    console.log(data); // Log the event data
    alert(JSON.stringify(data));
});

</script>


@endsection






@section('styles')
<style>

    #myChartPie{
        box-shadow: 5px 6px 8px rgb(0, 0, 0);

    }
    #myChartBar{
        box-shadow: 5px 6px 8px rgb(0, 0, 0);

    }
    .flex-container {
        display: flex;
        margin: 10px 0;
        box-shadow: 10px 4px 6px rgb(0, 0, 0);

    }

    .flex-container > div {
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgb(0, 0, 0);
        transition: all 0.3s ease;

    }

    .flex-container > div:hover {
        background-color: black;
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
    }


    .flex-container > div > h3 {
        font-size: 24px;
        margin-bottom: 10px;
        box-shadow: 0 4px 6px rgb(0, 0, 0);

    }

    .flex-container > div > span {
        font-size: 14px;
    }
</style>
@endsection

