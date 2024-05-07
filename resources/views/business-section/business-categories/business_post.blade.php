<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->businessName }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-...." crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/starability/starability-basic.min.css">
    <script src="https://cdn.jsdelivr.net/npm/starability/starability.min.js"></script>

    @if (!request()->is('login'))
        @vite(['resources/scss/main.scss'])
        {{-- @vite(['resources/scss/_bootstrap.scss']) --}}
        @vite(['resources/scss/_businessHome.scss'])
        {{-- @vite(['resources/scss/custom.scss']) --}}
        @vite(['resources/scripts/script.js'])
        @vite(['resources/js/app.js'])
    @endif

    @if (!request()->is('login'))
    @include('../partials.userHeader')
    @endif
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">

    <style>
        /* Global styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .business-details {
            margin: 20px auto;
            text-align: left;
        }

        .business-details h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .business-details p {
            color: #555;
            margin-bottom: 15px;
        }

        .business-details a {
            color: #006ce7;
            text-decoration: none;
        }

        .business-details a:hover {
            text-decoration: underline;
        }

        .comment-list {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }

        .comment-item {
            background-color: #fff;
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

        .comment-content {
            display: flex;
            overflow: overlay;
            align-items: center;
        }

        .comment-content p {
            margin: 0;
            color: #000000;
        }

        .comment-form {
            margin-bottom: 20px;
            color: #000;
        }

        .comment-form label {
            font-weight: bold;
        }

        .comment-form textarea {
            width: 100%;
            color: #000 !important;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: none;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .comment-form button {
            background-color: rgb(255, 255, 255);
            color: #000000;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        .comment-form button:hover {
            background-color: #000000;
        }

        .star-rating {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .star-rating i {
            color: gold;
            font-size: 1.2rem;
        }
        .business-image-container {
        width: 100%;
        max-height: 400px; /* Adjust as needed */
        overflow: hidden;
    }

    .business-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="business-details">
           <div class="business-image-container">
                <img src="{{ asset($post->image) }}" alt="Business Image" class="business-image">
            </div>
            <div class="business-info">
                <h1>{{ $post->businessName }}</h1>
                <p class="postText">{{ $post->description }}</p>
                <div class="business-meta">
                    <p class="postText"><strong>Type:</strong> {{ $post->type }}</p>
                    <p class="postText"><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>
                    <p class="postText"><strong>Ratings:</strong> {{ $post->average_rating }} ({{ $post->ratings_count }}
                        ratings)</p>
                </div>
                <div class="business-actions">
                    <p class="postText">
                        <i class="fas fa-map-marker-alt" style="color: #006ce7f1;"></i>
                        <a href="{{ route('mapStore') }}" class="store-map-link" style="text-decoration: none;">
                            <b>Explore Store on Map</b>
                        </a>
                    </p>
                    <p class="postText">
                        <a href="/chatify/{{ $post->user_id }}" class="message-link"
                            style="text-decoration: none;">
                            <b>Message:</b>
                            <i class="fa-brands fa-facebook-messenger"></i>
                            {{ $post->businessName }}
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
                <textarea class="form-control" id="comment" name="content" rows="3"
                    placeholder="Add your comment here"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Comment list -->
        <ul class="comment-list">
            @foreach ($post->comments as $comment)
            <li class="comment-item">
                <div class="comment-content">
                    <img class="comment-avatar" src="{{ asset($comment->user->profile_image) }}"
                        alt="User Profile Image">
                    <p class="postText"><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>

                    <!-- Generate stars based on user's rating -->
                    <div class="star-rating">
                        {!! App\Http\Controllers\CommentController::generateStarsForUser($post->id, $comment->user_id) !!}
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

</body>

</html>
