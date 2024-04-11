<section class="business-section-post" id="section3">
    <div class="container section3-container">
        <h2>Latest Business Posts</h2>

        <!-- Card Deck for Latest Business Posts -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
            @foreach ($categories as $post)
    <div class="col mb-4">
        <div class="card h-100">
            <img src="{{ asset($post->image) }}" class="card-img-top" alt="Business Image">
            <div class="card-body">
                <h5 class="card-title">{{ $post->businessName }}</h5>
                <p class="card-text">{{ $post->description }}</p>
                <a href="/chatify/{{ $post->user_id }}" style="text-decoration: none; color: goldenrod;">
                    <i class="fa-solid fa-envelope">
                        MESSAGE
                        <!-- Dynamic business name -->
                        {{ $post->businessName }}
                    </i>
                </a>
                <p class="card-text">
                    <i class="fas fa-map-marker-alt"></i>
                    <a href="{{ route('mapStore') }}" class="card-link">Explore Store on Map</a>
                </p>
                <!-- Add any other relevant information here -->
            </div>
        </div>
    </div>
@endforeach

        </div>
    </div>
</section>
