@extends(auth()->user()->type === 'business' ? 'layouts.businessHome' : 'layouts.app')

@section('content')
    <div id="section3">
        <div class="container section3-container">
            <h2>Searched Business Posts</h2>

            <!-- Search Form -->
            <form action="{{ route('searchPosts') }}" method="GET" class="row g-3 align-items-center">
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

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-between">
                @if ($posts->isEmpty())
                    <div class="col mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">No post found</h5>
                                <!-- You can customize the message further if needed -->
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($posts as $post)
                        <div class="col mb-4">
                            <div class="card h-100">
                                @php
                                    $images = json_decode($post->images);
                                    $firstImage = isset($images[0]) ? $images[0] : 'default-image.jpg'; // Provide a default image
                                @endphp
                                <img src="{{ asset($firstImage) }}" class="card-img-top" alt="Business Image" onclick="openFullScreen('{{ route('businessPost', ['id' => $post->id]) }}')">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ \Illuminate\Support\Str::limit($post->businessName, 12) }}
                                    </h5>
                                    <p class="card-text">
                                        <strong>Status:</strong>
                                        @if ($post->is_active && $post->is_active !=3)
                                            <span style="color: green"><b>Active</b></span>
                                        @else
                                            <span style="color: red"><b>Permit Not Active</b></span>
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
                                    <a class="card-text">
                                        <i class="fas fa-map-marker-alt" style="color: #006ce7f1;"></i>
                                        <a href="{{ route('mapStore') }}" class="store-map-link" style="text-decoration: none;">
                                            <b style="color: black;">Explore</b>
                                        </a>
                                    </a>
                                    <a href="/chatify/{{ $post->user_id }}" class="message-link">
                                        <b style="color:black;">Message:</b>
                                        <i class="fa-brands fa-facebook-messenger"></i>
                                    {{ \Illuminate\Support\Str::limit($post->businessName, 12) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @if (!$posts->isEmpty())
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif

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
            number = parseFloat(number);
            if (number >= 1000 && number < 1000000) {
                return (number / 1000).toFixed(1) + "<span class='number-suffix'>k</span>";
            } else if (number >= 1000000) {
                return (number / 1000000).toFixed(1) + "<span class='number-suffix'>M</span>";
            }
            return number;
        }
    </script>
@endsection
