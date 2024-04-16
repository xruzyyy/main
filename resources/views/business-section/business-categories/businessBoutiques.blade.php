@extends('layouts.app')

@section('content')

<section class="business-section-post" id="section3">
    <div class="container section3-container">
        <h2 class="animate-on-scroll">Accounting Business Posts</h2>

        <!-- Card Deck for Latest Business Posts -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-between">
            @foreach ($categories as $post)
                <div class="col mb-4">
                    <div class="card h-100 animate-on-scroll">
                        <img src="{{ asset($post->image) }}" class="card-img-top" alt="Business Image">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $post->businessName }}</h5>
                            <p class="card-text">{{ $post->description }}</p>
                          <!-- Updated HTML for the link -->
                            <a href="/chatify/{{ $post->user_id }}" class="message-link">
                                <b style="color:black;">Message:</b>
                                <i class="fa-brands fa-facebook-messenger"></i>
                                {{ $post->businessName }}
                            </a>

                            <p class="card-text">
                                <i class="fas fa-map-marker-alt" style="color: #006ce7f1;                                "></i>
                                <a href="{{ route('mapStore') }}" class="store-map-link" style="text-decoration: none;">
                                    <b style="color: black;">Explore Store on Map</b>
                                </a>
                            </p>

                            <!-- Add any other relevant information here -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
