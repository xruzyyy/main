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

<!-- Card section for business posts -->
<section id="card" style="background-color: black;">
    <div class="container">
        <div class="row justify-content-center mb-4 pb-2">
            <div class="col-md-6 text-center">
                <h1 class="headline load-hidden" style="color: antiquewhite;">Featured Posts</h1>
            </div>
        </div>
        <!-- Smaller Carousel slider for products -->
        <div id="carousel" class="sectionCarousel">
            @if ($latestPosts->isEmpty())
                <div class="text-center" style="color: antiquewhite;">No posts available</div>
            @else
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($latestPosts->take(6) as $key => $post)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                @php
                                    $images = json_decode($post->images);
                                    $firstImage = isset($images[0]) ? $images[0] : null;
                                @endphp
                                @if ($firstImage)
                                    <img class="d-block w-100 img-fluid" src="{{ asset($firstImage) }}" alt="Slide {{ $key + 1 }}">
                                @endif
                                <div class="carousel-caption">
                                    <h5>{{ \Illuminate\Support\Str::limit($post->businessName, 50) }}</h5>
                                    <p>{{ \Illuminate\Support\Str::limit($post->description, 150) }}</p>
                                </div>
                            </div>
                        @endforeach

                        @for ($i = 0; $i < (6 - count($latestPosts)); $i++)
                            <!-- Repeat the first post to fill the remaining slides -->
                            <div class="carousel-item">
                                <img class="d-block w-100 img-fluid" src="{{ asset($firstImage) }}" alt="Slide {{ $i + count($latestPosts) + 1 }}">
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
            @endif
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
        carousel.addEventListener('slid.bs.carousel', function() {});
    });
</script>
