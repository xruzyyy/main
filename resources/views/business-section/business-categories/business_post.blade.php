<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->businessName }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: silver;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 1em;
            margin-bottom: 1em;
        }
        p{
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            color: #000000;
            margin-top: 0; /* Remove default margin */
        }
        h1 {
            font-family: fantasy;
            font-size: 24px;
            color: #000000;
            margin-bottom: 20px;
        }

        .businessCommentImage {
            max-width: 60px; /* Adjust as needed */
            height: auto;
            margin-right: 10px;
            border-radius: 50%; /* Ensures rounded corners for the image */
            float: left; /* Float the image to the left */
        }

        .comment {
            margin-bottom: 20px;
            overflow: hidden; /* Clear float */
        }

        .comment strong {
            font-weight: bold;
        }

        .comment .comment-content {
            margin-left: 70px; /* Ensure enough space for the image */
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>{{ $post->businessName }}</h1>
        <img src="{{ asset($post->image) }}" alt="Business Image">
        <p class="card-text">{{ $post->description }}</p>
        <p><strong>Type:</strong> {{ $post->type }}</p>
        <p><strong>Contact Number:</strong> {{ $post->contactNumber }}</p>
        <p class="card-text">
            <i class="fas fa-map-marker-alt" style="color: #006ce7f1;"></i>
            <a href="{{ route('mapStore') }}" class="store-map-link" style="text-decoration: none;">
                <b style="color: black;">Explore Store on Map</b>
            </a>
        </p>
        <!-- Updated HTML for the link -->
        <a href="/chatify/{{ $post->user_id }}" class="message-link">
            <b style="color:black;">Message:</b>
            <i class="fa-brands fa-facebook-messenger"></i>
            {{ $post->businessName }}
        </a>

        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="field">
                <label class="label">Comment</label>
                <div class="control">
                    <textarea class="textarea" name="content" placeholder="Add your comment here"></textarea>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-primary">Submit</button>
                </div>
            </div>
        </form>
        <!-- Loop through comments and display -->
        @foreach($post->comments as $comment)
        <div class="comment">
            <img class="businessCommentImage" src="{{ asset($comment->user->profile_image) }}" alt="User Profile Image">
            <div class="comment-content">
                <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
            </div>
        </div>
        @endforeach
    </div>

</body>
</html>
