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
                                <p class="card-text">
                                    <strong>Ratings:</strong>
                                    {{ number_format($post->ratings()->avg('rating'), 2) ?? 'Not Rated' }}
                                    ({{ $post->ratings()->count() }} ratings)
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
        {{-- <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div> --}}
    </div>
    <script>
        function openFullScreen(url) {
            window.open(url, '_blank', 'fullscreen=yes');
        }
    </script>
@endsection
