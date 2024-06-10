<section class="business-section-post" id="section3">
    <div class="container section3-container">
        <h2 class="animate-on-scroll">Latest Business Posts</h2>

        <!-- Card Deck for Latest Business Posts -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-between">
            @foreach ($posts as $post)
                <div class="col mb-4">
                    <div class="card h-100 animate-on-scroll">
                        @php
                            $images = json_decode($post->images);
                            $firstImage = isset($images[0]) ? $images[0] : null;
                        @endphp
                        <img src="{{ asset($firstImage) }}" class="card-img-top" alt="Business Image"
                            onclick="openFullScreen('{{ route('businessPost', ['id' => $post->id]) }}')">
                        <div class="card-body">
                            <h5>{{ \Illuminate\Support\Str::limit($post->businessName, 22) }}</h5>
                            <p class="card-text">
                                <strong>Status:</strong>
                                <span style="color: {{ $post->is_active ? 'green' : 'red' }}"><b>{{ $post->is_active ? 'Active' : 'Expired Permit' }}</b></span>
                            </p>
                            <h5>{{ \Illuminate\Support\Str::limit($post->type, 22) }}</h5>
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
                                <a href="/chatify/{{ $post->user_id }}" >
                                    <b style="color:rgb(0, 0, 0);">Message</b>
                                </a>
                                <i class="fa-brands fa-facebook-messenger"  style="color: #006ce7f1; margin-right:40px;"></i>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
