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
        @include('../partials.header')
    @endif
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">

    <style>
        /* Global styles */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            /* Center-align all content */
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 1em;
            margin-bottom: 1em;
            color: #333;
            /* Adjust text color */
        }

        .business-details {
            display: inline-block;
            /* Ensures it respects text-align:center */
            text-align: left;
            /* Align text inside the business details to the left */
            margin: 20px;
            /* Adjust margin as needed */
        }

        .business-details h1 {
            color: #333;
            /* Adjust heading color */
            font-size: 32px;
        }

        .business-details p {
            color: #555;
            /* Adjust paragraph text color */
        }

        .business-details a {
            color: #006ce7;
            /* Adjust link color */
            text-decoration: none;
        }

        .business-details a:hover {
            text-decoration: underline;
            /* Add underline on hover */
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
    </style>
</head>

<body>

    <div class="container">
        <div class="business-details">
            <img src="{{ asset($post->image) }}" alt="Business Image" class="business-image" style="width: 40em">
            <h1>{{ $post->businessName }}</h1>
            <p>{{ $post->description }}</p>
            <p><strong>Type:</strong> {{ $post->type }}</p>
            <p><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>
            <p><strong>Ratings:</strong> {{ $post->average_rating }} ({{ $post->ratings_count }} ratings)</p>
    
            <p>
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
    
        <!-- Rating form -->
        <form action="{{ route('ratings.store', $post->id) }}" method="POST" class="rating-form">
            @csrf
            <fieldset class="starability-grow">
                <input type="radio" id="rating-1" name="rating" value="1" required />
                <label for="rating-1" title="Terrible">1 star</label>
                <input type="radio" id="rating-2" name="rating" value="2" />
                <label for="rating-2" title="Not good">2 stars</label>
                <input type="radio" id="rating-3" name="rating" value="3" />
                <label for="rating-3" title="Average">3 stars</label>
                <input type="radio" id="rating-4" name="rating" value="4" />
                <label for="rating-4" title="Very good">4 stars</label>
                <input type="radio" id="rating-5" name="rating" value="5" />
                <label for="rating-5" title="Amazing">5 stars</label>
            </fieldset>
            <button type="submit" class="btn btn-primary">Submit Rating</button>
        </form>
    
        <!-- Comment form -->
        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form">
            @csrf
            <div class="mb-3">
                <label for="comment" class="form-label">Leave a Comment:</label>
                <textarea class="form-control" id="comment" name="content" rows="3" placeholder="Add your comment here"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    
        <!-- Comment list -->
        <ul class="comment-list">
            @foreach ($post->comments as $comment)
                <li class="comment-item">
                    <div class="comment-content">
                        <img class="comment-avatar" src="{{ asset($comment->user->profile_image) }}" alt="User Profile Image">
                        <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    

</body>

</html>
