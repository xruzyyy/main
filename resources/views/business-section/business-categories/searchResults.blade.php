@extends(auth()->user()->type === 'business' ? 'layouts.businessHome' : 'layouts.app')

@section('content')
    <div id="section3">
        <div class="container section3-container">
            <h2>Searched Business Posts</h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-between">
                @foreach ($posts as $post)
                    <div class="col mb-4">
                        <div class="card h-100">
                            @php
                                $images = json_decode($post->images);
                                $firstImage = isset($images[0]) ? $images[0] : null;
                            @endphp
                            <img src="{{ asset($firstImage) }}" class="card-img-top" alt="Business Image"
                                onclick="openFullScreen('{{ route('businessPost', ['id' => $post->id]) }}')">
                            <div class="card-body">
                                <p class="card-text"><strong>Type:</strong> {{ $post->type }}</p>

                                <h5 class="card-title">{{ $post->businessName }}</h5>

                                {{-- <p class="postText"><strong>Ratings:</strong> {{ $post->average_rating }}
                                ({{ $post->ratings_count }} ratings)
                                <strong>Reviews:</strong> {{ $post->reviews }}
                            </p> --}}


                                <!-- Display average rating and number of ratings -->
                                <p class="card-text">
                                    <strong>Ratings:</strong>
                                    {{ $post->avg_rating ? number_format($post->avg_rating, 2) : 'Not Rated' }}
                                    ({{ $post->rating_count }} ratings)
                                </p>

                                <!-- Display number of reviews -->
                                <p class="card-text">
                                    <strong>Reviews:</strong> {{ $post->reviews }}
                                </p>


                                <p class="card-text"><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function openFullScreen(url) {
            window.open(url, '_blank', 'fullscreen=yes');
        }
    </script>
@endsection
