<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->businessName }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Custom CSS */
        @import url(https://fonts.googleapis.com/css?family=Roboto:500,100,300,700,400);

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .number-suffix {
            color: #00E676;
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
            background-color: #000000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: goldenrod;
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

        /* Rating form styles */
        .rating-form {
            margin-top: 20px;
            text-align: left !important;
        }


        .stars {
            display: flex;
            direction: rtl;
        }

        .stars input.star {
            display: none;

        }

        .stars label.star {
            font-size: 36px;
            color: #444;
            cursor: pointer;
            transition: transform 0.2s, color 0.2s;
        }

        .stars input.star:checked~label.star {
            color: #FD4;
        }

        .stars input.star-5:checked~label.star {
            color: #FE7;
            text-shadow: 0 0 20px #952;
        }

        .stars input.star-1:checked~label.star {
            color: #F62;
        }

        .stars label.star:hover,
        .stars label.star:hover~label.star {
            transform: rotate(-15deg) scale(1.3);
            color: #FD4;
        }


        .stars input.star:checked~label.star:before {}

        .business-image-container {
            position: relative;
        }


        .gallery-image {
    display: block;
    margin: 0 auto; /* Center the image horizontally */
    width: auto; /* Ensure the image takes up the full width of its container */
    height: 30em; /* Maintain the aspect ratio */
    object-fit: contain; /* Ensure the image covers the container without distortion */
}

#swiper-pic{
    display: flex;
    align-items: center; /* Center the image vertically */
    justify-content: center; /* Center the image horizontally */
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
                                    <div class="swiper-slide" id="swiper-pic">
                                        <img src="{{ URL::to($image) }}" class="gallery-image" alt="Business Image">
                                    </div>
                                    @php $imageCount++; @endphp <!-- Increment image counter -->
                                @else
                                @break

                                <!-- Break out of the loop once three images are displayed -->
                            @endif
                        @endforeach
                        @if (count(json_decode($post->images)) > 3)
                            <!-- Add indicator for more images using Font Awesome arrow icon -->
                            <div class="swiper-slide more-images-indicator">
                                <i class="fas fa-arrow-right"></i> <!-- Use a right arrow icon -->
                            </div>
                        @endif
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
                <!-- Display the ratings and comments count -->
                <p class="card-text">
                    <strong>Ratings:</strong>
                    <span
                        id="average-rating-{{ $post->id }}">{{ number_format($post->ratings()->avg('rating'), 2) ?? 'Not Rated' }}</span>
                    (<span id="ratings-count-{{ $post->id }}">{{ $post->ratings()->count() }}</span> reviews)
                    <!-- Display total comments count -->
                    <br>
                    <strong>Comments:</strong> <span
                        id="comments-count-{{ $post->id }}">{{ $post->comments()->count() }}</span>
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
    <form style="text-align: left; margin-right:80%;" action="{{ route('ratings.store', $post->id) }}"
        method="POST" class="rating-form">
        @csrf
        <fieldset class="stars">
            <input class="star star-5" id="star-5" type="radio" name="rating" value="5" />
            <label class="star star-5" for="star-5"><i class="fas fa-star"></i></label>
            <input class="star star-4" id="star-4" type="radio" name="rating" value="4" />
            <label class="star star-4" for="star-4"><i class="fas fa-star"></i></label>
            <input class="star star-3" id="star-3" type="radio" name="rating" value="3" />
            <label class="star star-3" for="star-3"><i class="fas fa-star"></i></label>
            <input class="star star-2" id="star-2" type="radio" name="rating" value="2" />
            <label class="star star-2" for="star-2"><i class="fas fa-star"></i></label>
            <input class="star star-1" id="star-1" type="radio" name="rating" value="1" />
            <label class="star star-1" for="star-1"><i class="fas fa-star"></i></label>
            <button type="submit" class="btn">Rate</button>
        </fieldset>
    </form>



    <!-- Comment form -->
    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form">
        @csrf
        <label for="comment" class="form-label">Leave a Comment:</label>
        <!-- Add this code to your view file where you want to display the error message -->
        @if (session('error'))
            <div style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color:red;"
                class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="mb-3">
            <textarea
                style="margin-top: 20px !important; width: 20em; background-color: #f5f5f5; border: 1px solid #ccc; padding: 10px; border-radius: 4px;"
                class="form-control" id="comment" name="content" rows="3" placeholder="Add your comment here"></textarea>
        </div>
        <button type="submit" class="btn">Submit</button>
    </form>


    <!-- Comment list -->
<div class="swiper-container comment-list-container" style="overflow: hidden">
    <div class="swiper-wrapper">
        @php
            $comments = $post->comments()->latest()->get(); // Retrieve comments in reverse order
            $commentsChunks = $comments->chunk(15);
        @endphp
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

    document.addEventListener("DOMContentLoaded", function() {
    const images = document.querySelectorAll(".gallery-image");

    images.forEach(image => {
        image.onload = function() {
            if (this.naturalWidth > this.naturalHeight) {
                // Landscape orientation
                this.classList.add('landscape');
            } else {
                // Portrait orientation
                this.classList.add('portrait');
            }
        };
    });
});

    // Wait for the DOM content to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Get elements containing raw numbers and format them
        formatNumbers('{{ $post->id }}');
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
</body>

</html>
