@extends(Auth::user()->type === 'business' ? 'layouts.businessHome' : 'layouts.app')

@section('content')

<!-- HTML -->
<section id="section3">
    <div class="container section3-container">
        <h2 class="animate-on-scroll">Latest Business Posts</h2>
          <!-- Search Form -->
        <form action="{{ route('showFashionCategories') }}" method="GET" class="row g-3 align-items-center">
            <div class="col">
                <input type="text" class="form-control" placeholder="Search Business Posts" name="search">
            </div>
            <div class="col-auto">
                <select style="margin-bottom:0.1em;" class="form-select" style="width:1em; margin-top:2.3em;" name="sort_by">
                    <option value="">Sort by</option>
                    <option value="highest_rating">Highest Rating</option>
                    <option value="highest_reviews">Highest Reviews</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Card Deck for Latest Business Posts -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-between">
            @foreach ($posts as $post)
                <div class="col mb-4">
                    <div class="card h-100">
                        @php
                            $images = json_decode($post->images);
                            $firstImage = isset($images[0]) ? $images[0] : null;
                        @endphp
                        <img src="{{ asset($firstImage) }}" class="card-img-top" alt="Business Image" onclick="openFullScreen('{{ route('businessPost', ['id' => $post->id]) }}')">
                        <div class="card-body">
                            <p class="card-text"><strong>Type:</strong> {{ $post->type }}</p>
                            <h5 class="card-title">{{ $post->businessName }}</h5>
                            <p class="card-text">
                                <strong>Ratings:</strong>
                                {{( $post->average_rating) ?? 'Not Rated' }}
                                ({{ $post->ratings_count }} ratings),

                            </p>
                            <p class="card-text"><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt" style="color: #006ce7f1;"></i>
                                <a href="{{ route('mapStore') }}" class="store-map-link" style="text-decoration: none;">
                                    <b style="color: black;">Explore Store on Map</b>
                                </a>
                            </p>
                            <a href="/chatify/{{ $post->user_id }}" class="message-link">
                                <b style="color:black;">Message:</b>
                                <i class="fa-brands fa-facebook-messenger"></i>
                                {{ $post->businessName }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</section>
<!-- JavaScript -->
<script>
    // Function to open the business post in a new full-screen window
    function openFullScreen(url) {
        window.open(url, '_blank', 'fullscreen=yes');
    }
</script>
@endsection
