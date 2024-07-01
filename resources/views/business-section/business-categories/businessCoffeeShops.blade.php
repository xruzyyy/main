@extends(Auth::user()->type === 'business' ? 'layouts.businessHome' : 'layouts.app')

@section('content')
<style>
    #section3 {
        background-color: #f8f9fa;
        padding: 50px 0;
    }
    .section3-container {
        max-width: 1200px;
    }
    h2 {
        color: #333;
        font-size: 32px;
        margin-bottom: 30px;
        text-align: center;
    }
    .form-control, .form-select {
        width: 100%;
        border: 1px solid #ced4da;
        border-radius: 20px;
        padding: 10px 15px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        border-color: #80bdff;
    }
    .btn-search {
        background-color: #007bff;
        color: white;
        border-radius: 20px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    .btn-search:hover {
        background-color: #0056b3;
    }
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    .card-img-top {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
    }
    .card-body {
        padding: 20px;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .card-text {
        font-size: 14px;
        color: #6c757d;
    }
    .number-suffix {
        color: #28a745;
        font-weight: bold;
    }
    .pagination {
        justify-content: center;
    }
    .store-map-link, .message-link {
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .store-map-link:hover, .message-link:hover {
        color: #0056b3;
    }
    .status-active {
        color: green;
        font-weight: bold;
    }
    .status-inactive {
        color: red;
        font-weight: bold;
    }
    .store-hours {
        font-size: 14px;
        margin-top: 10px;
    }
</style>

<section  id="section3">
    <div class="container section3-container">
        <h2 >Latest Business Posts</h2>
          <!-- Search Form -->
        <form action="{{ route('showCoffeeShopsCategories') }}" method="GET" class="row g-3 align-items-center">
            <div class="col">
                <input style="margin-bottom: 2.5em;" type="text" class="form-control" placeholder="Search Business Posts" name="search">
            </div>
            <div class="col-auto">
                <select style="margin-bottom:0.1em;" class="form-select" style="width:1em; margin-top:2.3em;" name="sort_by">
                    <option value="">Sort by</option>

                    <option value="highest_rating">Highest Rating</option>
                    <option value="comments">Most Comments</option>

                </select>
            </div>
            <div class="col-auto">
                <button style="margin-bottom: 1.5em;" class="btn" type="submit"><i style="color: black" class="fas fa-search"></i></button>
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
                                {{ number_format($post->avg_rating, 2, '.', '') ?? 'Not Rated' }}
                                ({{ $post->ratings_count }} ratings)
                                <strong>Reviews:</strong> {{ $post->reviews }}
                            </p>
                            <p class="card-text"><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt" style="color: #006ce7f1;"></i>
                                <a href="{{ route('mapStore', ['business' => rawurlencode($post->businessName)]) }}" class="store-map-link" style="text-decoration: none;">
                                    <b style="color: black;">Map</b>
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
        {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</section>
<!-- JavaScript -->
<script>
        function openFullScreen(url) {
            window.open(url, '_blank', 'fullscreen=yes');
        }


        // Wait for the DOM content to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Get elements containing raw numbers and format them
        @foreach ($posts as $post)
            formatNumbers('{{ $post->id }}');
        @endforeach
    });

    // Function to format numbers with appropriate suffixes and style "k" with green color
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

    // Function to format numbers with appropriate suffixes
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
