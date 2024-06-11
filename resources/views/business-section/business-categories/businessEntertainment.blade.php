@extends(Auth::user()->type === 'business' ? 'layouts.businessHome' : 'layouts.app')

@section('content')

<!-- HTML -->
<section id="section3">
    <div class="container section3-container">
        <h2 >Latest Business Posts</h2>
          <!-- Search Form -->
        <form action="{{ route('showEntertainmentCategories') }}" method="GET" class="row g-3 align-items-center">
            <div class="col">
                <input style="margin-bottom: 2.5em;"  type="text" class="form-control" placeholder="Search Business Posts" name="search">
            </div>
            <div class="col-auto">
                <select style="margin-bottom:0.1em;" class="form-select" style="width:1em; margin-top:2.3em;" name="sort_by">
                    <option value="">Sort by</option>
                    <option value="highest_rating">Highest Rating</option>
                    <option value="comments">Most Comments</option>
                </select>
            </div>
            <div class="col-auto">
                <button style="margin-bottom: 1.5em;" class="btn" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <!-- Card Deck for Latest Business Posts -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-between">
            @if ($posts->isEmpty())
                <div class="col-12 text-center">
                    <p>No business posts available at the moment. Please check back later.</p>
                </div>
            @else
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
                                    <span id="average-rating-{{ $post->id }}">{{ number_format($post->ratings()->avg('rating'), 2) ?? 'Not Rated' }}</span>
                                    (<span id="ratings-count-{{ $post->id }}">{{ $post->ratings()->count() }}</span> reviews)
                                    <br>
                                    <strong>Comments:</strong> <span id="comments-count-{{ $post->id }}">{{ $post->comments()->count() }}</span>
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
            @endif
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</section>

<!-- JavaScript -->
<script>
    function openFullScreen(url) {
        window.open(url, '_blank', 'fullscreen=yes');
    }

    document.addEventListener("DOMContentLoaded", function() {
        @foreach ($posts as $post)
            formatNumbers('{{ $post->id }}');
        @endforeach
    });

    function formatNumbers(postId) {
        var averageRatingElement = document.getElementById("average-rating-" + postId);
        var ratingsCountElement = document.getElementById("ratings-count-" + postId);
        var commentsCountElement = document.getElementById("comments-count-" + postId);

        if (averageRatingElement) {
            averageRatingElement.innerHTML = formatNumber(averageRatingElement.innerHTML);
        }
        if (ratingsCountElement) {
            ratingsCountElement.innerHTML = formatNumber(ratingsCountElement.innerHTML);
        }
        if (commentsCountElement) {
            commentsCountElement.innerHTML = formatNumber(commentsCountElement.innerHTML);
        }
    }

    function formatNumber(number) {
        if (number >= 1000 && number < 1000000) {
            return (number / 1000).toFixed(1) + "<span class='number-suffix'>k</span>";
        } else if (number >= 1000000) {
            return (number / 1000000).toFixed(1) + "<span class='number-suffix'>M</span>";
        }
        return number;
    }
</script>
@endsection
