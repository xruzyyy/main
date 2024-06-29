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
        width: 100%; /* Ensures the image takes full width of the container */
        height: 500px; /* Fixed height for all images */
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
            @if(count($posts) > 0)
                @foreach ($posts as $key => $post)
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
            @else
                <div class="carousel-item active">
                    <div class="carousel-caption">
                        <h5>No posts available</h5>
                        <p>There are currently no posts to display.</p>
                    </div>
                </div>
            @endif
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

<!-- Custom script for carousel controls -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the carousel with an interval of 3 seconds (3000 milliseconds)
        var carousel = document.querySelector('#carouselExampleControls');
        var carouselInstance = new bootstrap.Carousel(carousel, {
            interval: 3000
        });

        // Handle the 'slid.bs.carousel' event to verify slide transition
        carousel.addEventListener('slid.bs.carousel', function() {
            // Custom logic after each slide transition (if needed)
        });
    });
</script>
