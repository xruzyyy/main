

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
</style>

<!-- Smaller Carousel slider for products -->
<div id="carousel" class="sectionCarousel">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($latestPosts->take(6) as $key => $post)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                @php
                $images = json_decode($post->images);
                $firstImage = isset($images[0]) ? $images[0] : null;
            @endphp
                <img class="d-block w-100 img-fluid" src="{{ asset($firstImage) }}" alt="Slide {{ $key + 1 }}">
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
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- Card section for business posts -->
<section id="card" style="background-color: black;">
    <div class="container">
        <div class="row justify-content-center mb-4 pb-2">
            <div class="col-md-6 text-center">
                <h1 class="headline load-hidden" style="color: antiquewhite;">Featured Posts</h1>
            </div>
        </div>
        <div class="row">
            @foreach ($latestPosts->take(6) as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div  style="border: 4px solid rgb(255, 252, 252) !important;" class="card h-100 shadow-sm">
                    <!-- Assuming the 'images' field contains an array of image URLs -->
                    @php
                    $images = json_decode($post->images);
                    $firstImage = isset($images[0]) ? $images[0] : '';
                    @endphp
                    <img class="card-img-top" src="{{ asset($firstImage) }}" alt="Card image cap">
                    <div class="card-body">
                        <h5>{{ \Illuminate\Support\Str::limit($post->businessName, 22) }}</h5>
                        <p class="card-text">
                                    <strong>Status:</strong>
                                    @if ($post->is_active)
                                        <span style="color: green"><b>Active</b></span>
                                    @else
                                        <span style="color: red"><b>Expired Permit</b></span>
                                    @endif
                                </p>
                                <p class="card-text"><strong>Type:</strong> {{ $post->type }}</p>
                                <p class="card-text">
                                    <strong>Ratings:</strong>
                                    <span id="average-rating-{{ $post->id }}">{{ number_format($post->ratings()->avg('rating'), 2) ?? 'Not Rated' }}</span>
                                    (<span id="ratings-count-{{ $post->id }}">{{ $post->ratings()->count() }}</span> reviews)
                                    <br>
                                    <strong>Comments:</strong> <span id="comments-count-{{ $post->id }}">{{ $post->comments()->count() }}</span>
                                </p>
                                <p class="card-text"><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>
                                <p class="card-text mb-10">
                                    <i class="fas fa-map-marker-alt" style="color: #006ce7f1;"></i>
                                    <a href="{{ route('mapStore') }}" class="store-map-link" style="text-decoration: none;">
                                        <b style="color: black;">Map</b>
                                    </a>
                                    <a href="/chatify/{{ $post->user_id }}" class="message-link">
                                        <b style="color: rgb(0, 0, 0);">Message</b>
                                    </a>
                                    <i class="fa-brands fa-facebook-messenger" style="color: #006ce7f1; margin-right: 40px;"></i>
                                </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>



<!-- Custom script for carousel controls -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the carousel with an interval of 1 second (1000 milliseconds)
        var carousel = document.querySelector('#carouselExampleControls');
        var carouselInstance = new bootstrap.Carousel(carousel, {
            interval: 3000
        });

        // Handle the 'slid.bs.carousel' event to verify slide transition
        carousel.addEventListener('slid.bs.carousel', function() {
        });
    });
</script>

