@extends('businessHome')

@section('businessHomePost')
<div class="container">
    <h2>Latest Business Posts</h2>
    <!-- Card Deck for Latest Business Posts -->
    <div class="card-deck">
        @foreach ($categories as $post)
        <div class="card">
            <img src="{{ asset($post->image) }}" class="card-img-top" alt="Business Image">
            <div class="card-body">
                <h5 class="card-title">{{ $post->businessName }}</h5>
                <p class="card-text">Description: {{ $post->description }}</p>
                <p class="card-text">Located At: {{ $post->locatedAt }}</p>
                <!-- Add any other relevant information here -->
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
