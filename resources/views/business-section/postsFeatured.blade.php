@extends('layouts.businessHome')

@section('content')

<style>
    /* Custom styles for the carousel */
    #carouselExampleControls {
        max-height: 500px; /* Adjust the max-height as needed */
        margin-top: 0;
        padding: 0;
    }

    .carousel-item img {
        object-fit: cover;
        max-height: 500px; /* Adjust the max-height as needed */
        position: relative;
    }

    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px;
        color: white;
        bottom: 0;
        width: 100%;
        position: absolute;
        left: 0;
        right: 0;
    }

    .carousel-caption h5,
    .carousel-caption p {
        margin: 0;
        padding: 0;
    }

    /* Overlay layer */
    .dark-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Adjust opacity as needed */
    }
</style>

<!-- Smaller Carousel slider for products -->
<div id="carousel" class="sectionCarousel">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($latestPosts->take(6) as $key => $post)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <!-- Assuming 'images' field contains an array of image paths -->
                @php
                $images = json_decode($post->images);
                $firstImage = isset($images[0]) ? $images[0] : '';
                @endphp
                <img class="d-block w-100 img-fluid" src="{{ $firstImage }}" alt="Slide {{ $key + 1 }}">
                <div class="carousel-caption">
                    <h5>{{ \Illuminate\Support\Str::limit($post->businessName, 50) }}</h5>
                    <p>{{ \Illuminate\Support\Str::limit($post->description, 150) }}</p>
                </div>
            </div>
            @endforeach

            @for ($i = 0; $i < (6 - count($latestPosts)); $i++)
            <!-- Repeat the first post to fill the remaining slides -->
            <div class="carousel-item">
                <img class="d-block w-100 img-fluid" src="{{ $latestPosts[0]->images[0] }}" alt="Slide {{ $i + count($latestPosts) + 1 }}">
                <div class="carousel-caption">
                    <h5>{{ \Illuminate\Support\Str::limit($latestPosts[0]->businessName, 50) }}</h5>
                    <p>{{ \Illuminate\Support\Str::limit($latestPosts[0]->description, 150) }}</p>
                </div>
            </div>
            @endfor
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!-- Card section for business posts -->
<section id="card">
    <div class="container">
        <div class="row justify-content-center mb-4 pb-2">
            <div class="col-md-6 text-center">
                <h1 class="headline load-hidden">Popular Products</h1>
            </div>
        </div>
        <div class="row">
            @foreach ($latestPosts->take(6) as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Assuming the 'images' field contains an array of image URLs -->
                    @php
                    $images = json_decode($post->images);
                    $firstImage = isset($images[0]) ? $images[0] : '';
                    @endphp
                    <img class="card-img-top" src="{{ $firstImage }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->businessName }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($post->description, 100) }}</p>
                        <!-- Assuming there's a route named 'business.show' to view a specific business -->
                        <a href="{{ route('businessFeatured.show', ['id' => $post->id]) }}" class="btn btn-primary btn-block">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom script for carousel controls -->
<script>
    // Make sure jQuery is ready
    $(document).ready(function() {
        // Set the carousel interval to 5 seconds
        $('.carousel').carousel({
            interval: 900
        });


    });
</script>

@endsection
