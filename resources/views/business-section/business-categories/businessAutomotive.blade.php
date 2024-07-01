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
        <form action="{{ route('showAutomotiveCategories') }}" method="GET" class="row g-3 align-items-center">
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
                <button style="margin-bottom: 1.5em;" class="btn" type="submit"><i style="color: black" class="fas fa-search"></i></button>
            </div>
        </form>

        @if ($posts->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                No business posts available at the moment. Please check back later.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($posts as $post)
                    <div class="col">
                        <div class="card h-100">
                            @php
                                $images = json_decode($post->images);
                                $firstImage = isset($images[0]) ? $images[0] : null;
                                $current_time = \Carbon\Carbon::now()->setTimezone(config('app.timezone'));
                                $current_day = strtolower($current_time->format('l'));
                                $open_field = $current_day . '_open';
                                $close_field = $current_day . '_close';
                                $open_time = \Carbon\Carbon::parse($post->$open_field)->setTimezone(config('app.timezone'));
                                $close_time = \Carbon\Carbon::parse($post->$close_field)->setTimezone(config('app.timezone'));
                                $is_open = $current_time->between($open_time, $close_time);
                            @endphp
                            <img src="{{ asset($firstImage) }}" class="card-img-top" alt="Business Image" onclick="openFullScreen('{{ route('businessPost', ['id' => $post->id]) }}')">
                            <div class="card-body">
                                <h5 class="card-title">{{ \Illuminate\Support\Str::limit($post->businessName, 12) }}</h5>
                                <p class="card-text">
                                    <i class="fas fa-map-marker-alt mr-2" style="color: #006ce7f1;"></i>
                                    <a href="{{ route('mapStore', ['business' => rawurlencode($post->businessName)]) }}" class="store-map-link">
                                        Map
                                    </a>
                                    <a href="/chatify/{{ $post->user_id }}" class="message-link ml-3">
                                        <i class="fa-brands fa-facebook-messenger mr-1" style="color: #006ce7f1;"></i>
                                        Message
                                    </a>
                                </p>
                                <p class="card-text"><strong>Type:</strong> {{ $post->type }}</p>
                                <p class="card-text">
                                    <strong style="color:darkgoldenrod;">Permit Status:</strong>
                                    <span class="{{ $post->is_active ? 'status-active' : 'status-inactive' }}">
                                        {{ $post->is_active ? 'Active' : 'Permit Not Active' }}
                                    </span>
                                </p>
                                @if ($post->$open_field && $post->$close_field)
                                    <p class="card-text store-hours">
                                        <strong>{{ ucfirst($current_day) }}:</strong>
                                        {{ $open_time->format('h:i A') }} - {{ $close_time->format('h:i A') }}
                                        <span class="{{ $is_open ? 'status-active' : 'status-inactive' }}">
                                            {{ $is_open ? 'Open' : 'Closed' }}
                                        </span>
                                    </p>
                                @endif
                                <p class="card-text">
                                    <strong>Ratings:</strong>
                                    <span id="average-rating-{{ $post->id }}">{{ number_format($post->ratings()->avg('rating'), 2) ?? 'Not Rated' }}</span>
                                    (<span id="ratings-count-{{ $post->id }}">{{ $post->ratings()->count() }}</span> reviews)
                                </p>
                                <p class="card-text">
                                    <strong>Comments:</strong>
                                    <span id="comments-count-{{ $post->id }}">{{ $post->comments()->count() }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</section>

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
        var elements = ['average-rating', 'ratings-count', 'comments-count'];
        elements.forEach(function(element) {
            var el = document.getElementById(element + "-" + postId);
            if (el) {
                el.innerHTML = formatNumber(el.innerHTML);
            }
        });
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
