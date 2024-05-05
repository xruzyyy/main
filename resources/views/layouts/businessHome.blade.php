<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Homepage</title>
  @vite(['resources/scss/category.scss'])
  @vite(['resources/scss/_section.scss'])
  @vite(['resources/scss/main.scss'])
  @vite(['resources/scss/_businessHome.scss'])
  @vite(['resources/scss/_about.scss'])
  @vite(['resources/scripts/script.js'])
  @vite(['resources/js/app.js'])

  {{-- <link rel="stylesheet" href="../scss/custom.css"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    @include('../partials.header')

<div class="section" id="section1">
  <video class="video-background" autoplay loop muted>
    <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">    <!-- Add additional sources for different video formats if needed -->
    Your browser does not support the video tag.
  </video>
  <div class="container text-white">
    <h1>Welcome Back, {{ auth()->user()->name }}!</h1>
    <h1 >SELL AND BUY NEAR YOU <br>
            Simple, Trusted and Efficient</h1>
            <form action="{{ route('searchPosts') }}" method="GET" class="row g-3 align-items-center">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search Business Posts" name="search">
                </div>
                <div class="col-auto">
                    <button class="btn" type="submit"><i class="fas fa-search"></i>Search</button>
                </div>
            </form>

    </div>
</div>


@yield('content')
@include('servicesMain')
@include('footer')

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
