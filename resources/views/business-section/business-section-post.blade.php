<!-- HTML -->
<section class="business-section-post" id="section3">
    <div class="container section3-container">
        <h2 class="animate-on-scroll">Latest Business Posts</h2>

        <!-- Card Deck for Latest Business Posts -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-between">
            @foreach ($posts as $post)
                <div class="col mb-4">
                    <div class="card h-100 animate-on-scroll">
                        <!-- Display only the first image from the array -->
                        @php
                            $images = json_decode($post->images);
                            $firstImage = isset($images[0]) ? $images[0] : null;
                        @endphp
                        <img src="{{ asset($firstImage) }}" class="card-img-top" alt="Business Image"
                            onclick="openFullScreen('{{ route('businessPost', ['id' => $post->id]) }}')">
                        <div class="card-body">
                            <p class="card-text"><strong>Type:</strong> {{ $post->type }}</p>
                            <h5 class="card-title">{{ $post->businessName }}</h5>
                            <!-- Limit description to 30 characters -->
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($post->description, 60) }}</p>
                            <!-- Display the type -->
                            <p class="card-text"><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>
                            <!-- Display average rating and ratings count -->
                            <p class="card-text">
                                <strong>Ratings:</strong> {{ number_format($post->ratings()->avg('rating'), 2) ?? 'Not Rated' }} ({{ $post->ratings()->count() }} ratings)
                            </p>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt" style="color: #006ce7f1;"></i>
                                <a href="{{ route('mapStore') }}" class="store-map-link" style="text-decoration: none;">
                                    <b style="color: black;">Explore Store on Map</b>
                                </a>
                            </p>
                            <!-- Updated HTML for the link -->
                            <a href="/chatify/{{ $post->user_id }}" class="message-link">
                                <b style="color:black;">Message:</b>
                                <i class="fa-brands fa-facebook-messenger"></i>
                                {{ $post->businessName }}
                            </a>
                            <!-- Add any other relevant information here -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- JavaScript -->
<script>
    // Function to open the business post in a new full-screen window
    function openFullScreen(url) {
        // Open a new window with the provided URL and make it full-screen
        window.open(url, '_blank', 'fullscreen=yes');
    }
</script>
