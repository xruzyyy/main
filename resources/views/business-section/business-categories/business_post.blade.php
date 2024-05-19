<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->businessName }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="path/to/your/custom.css">
    <style>
        /* Custom CSS */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .business-details {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .business-image-container {
            width: 45%;
            height: 400px;
            /* Fixed height */
            overflow: hidden;
            border-radius: 8px;
        }

        .swiper-container {
            width: 100%;
            height: 100%;
        }

        .business-info {
            width: 50%;
        }

        .business-info h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #333;
        }

        .postText {
            color: #555;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .business-meta {
            margin-bottom: 15px;
        }

        .business-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .rating-form,
        .comment-form {
            margin-top: 20px;
        }

        .btn {
            background-color: #006ce7;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .comment-list {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }

        .comment-item {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 15px;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-details {
            flex: 1;
        }

        .comment-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .star-rating {
            display: flex;
            align-items: center;
            color: #f39c12;
            /* Star color */
        }

        .star-rating i {
            font-size: 1.2rem;
            margin-right: 5px;
        }

        .comment-text {
            color: #333;
            line-height: 1.5;
        }

        .comment-content {
            overflow: overlay;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="business-details">
            <div class="business-image-container">
                <!-- Swiper -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @if ($post->images)
                            @php $imageCount = 0; @endphp <!-- Initialize image counter -->
                            @foreach (json_decode($post->images) as $image)
                                @if ($imageCount < 3)
                                    <!-- Limit the display to the first three images -->
                                    <div class="swiper-slide">
                                        <img src="{{ URL::to($image) }}" class="gallery-image" alt="Business Image">
                                    </div>
                                    @php $imageCount++; @endphp <!-- Increment image counter -->
                                @else
                                @break

                                <!-- Break out of the loop once three images are displayed -->
                            @endif
                        @endforeach
                    @endif
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="business-info">
            <h1>{{ $post->businessName }}</h1>
            <p class="postText">{{ $post->description }}</p>
            <div class="business-meta">
                <p class="postText"><strong>Type:</strong> {{ $post->type }}</p>
                <p class="postText"><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>
                <p class="card-text">
                    <strong>Ratings:</strong>
                    {{( $post->average_rating) ?? 'Not Rated' }}
                    ({{ $post->ratings_count }} ratings),

                </p>
            </div>
            <div class="business-actions">
                <p class="postText">
                    <i class="fas fa-map-marker-alt"></i>
                    <a href="{{ route('mapStore') }}" class="store-map-link">Explore Store on Map</a>
                </p>
                <p class="postText">
                    <a href="/chatify/{{ $post->user_id }}" class="message-link">
                        <i class="fab fa-facebook-messenger"></i>
                        Message: {{ $post->businessName }}
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Rating form -->
    <form action="{{ route('ratings.store', $post->id) }}" method="POST" class="rating-form">
        @csrf
        <fieldset class="starability-grow">
            <span> Rate <i class="fas fa-star"></i> : </span>
            <!-- Add your rating input fields here -->
            <input type="radio" id="rating-1" name="rating" value="1" required />
            <label for="rating-1" title="Terrible">Terrible</label>
            <input type="radio" id="rating-2" name="rating" value="2" />
            <label for="rating-2" title="Not good">Not Good</label>
            <input type="radio" id="rating-3" name="rating" value="3" />
            <label for="rating-3" title="Average">Average</label>
            <input type="radio" id="rating-4" name="rating" value="4" />
            <label for="rating-4" title="Very good">Very Good</label>
            <input type="radio" id="rating-5" name="rating" value="5" />
            <label for="rating-5" title="Amazing">Amazing</i></label>
        </fieldset>
        <button type="submit" class="btn">Submit</button>
    </form>

    <!-- Comment form -->
    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form">
        @csrf
        <div class="mb-3">
            <label for="comment" class="form-label">Leave a Comment:</label>
            <textarea class="form-control" id="comment" name="content" rows="3" placeholder="Add your comment here"></textarea>
        </div>
        <button type="submit" class="btn">Submit</button>
    </form>

    <!-- Comment list -->
    <div class="swiper-container comment-list-container" style="overflow: hidden">
        <div class="swiper-wrapper">
            @php $commentsChunks = $post->comments->sortByDesc('created_at')->chunk(15); @endphp
            @foreach ($commentsChunks as $chunk)
                <div class="swiper-slide">
                    <ul class="comment-list">
                        @foreach ($chunk as $comment)
                            <li class="comment-item">
                                <div class="comment-content">
                                    @if ($comment->user)
                                        <img class="comment-avatar"
                                            src="{{ asset($comment->user->profile_image) }}"
                                            alt="User Profile Image">
                                        <p class="postText"><strong>{{ $comment->user->name }}</strong>:
                                            {{ $comment->content }}</p>

                                        <!-- Generate stars based on user's rating -->
                                        <div class="star-rating">
                                            {!! App\Http\Controllers\CommentController::generateStarsForUser($post->id, $comment->user_id) !!}
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
</body>

</html>
