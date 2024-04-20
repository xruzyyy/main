<!-- resources/views/business_post.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->businessName }}</title>
    <!-- Include any necessary CSS stylesheets or JavaScript libraries -->
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
        font-family: fantasy;
        color: #000000;
    }
    h1 {
        font-family: fantasy;
        font-size: 24px;
        color: #000000;
        margin-bottom: 20px;
    }

    img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .card-text {
        margin-bottom: 10px;
    }

    .card-text strong {
        font-weight: bold;
    }

    .card-text a {
        text-decoration: none;
        color: #006ce7f1;
    }

    .card-text a:hover {
        text-decoration: underline;
    }

    .message-link {
        text-decoration: none;
        color: #333;
        display: inline-block;
        margin-top: 10px;
    }

    .message-link i {
        margin-right: 5px;
    }
</style>
</head>
<body>

    <div class="container">
        <h1>{{ $post->businessName }}</h1>
        <img src="{{ asset($post->image) }}" alt="Business Image">
        <p class="card-text">{{ $post->description }}</p>
        <p><strong>Type:</strong> {{ $post->type }}</p>
        <p>{{ $post->description }}</p>
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
        </a>    </div>
</body>
</html>
