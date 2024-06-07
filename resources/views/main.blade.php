<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Landing Page</title>
  @vite(['resources/scss/category.scss'])
  @vite(['resources/scss/_section.scss'])
  @vite(['resources/scss/main.scss'])
  @vite(['resources/scss/_bootstrap.scss'])
  @vite(['resources/scss/custom.scss'])
  @vite(['resources/scripts/script.js'])
  <link rel="stylesheet" href="../scss/category.css">
  <link rel="stylesheet" href="../scss/section.css">
  <link rel="stylesheet" href="../scss/main.css">
  <link rel="stylesheet" href="../scss/_bootstrap.css">
  <link rel="stylesheet" href="../scss/custom.css">
  <script src="../../resources/js/app.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>  
  /* Custom styles can be added here */
    .section {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }
    
    .video-background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    .container {
      position: relative;
      z-index: 1;
    }
  </style>
</head>
<body>
    @include('../partials.header')
{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Taytay Online</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#section1">Section 1</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#section2">Section 2</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#section3">Section 3</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#section4">Section 4</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#section5">Section 5</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#section6">Section 6</a>
      </li>
    </ul>
  </div>
</nav> --}}

<div class="section" id="section1">
  <video class="video-background" autoplay loop muted>
    <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">    <!-- Add additional sources for different video formats if needed -->
    Your browser does not support the video tag.
  </video>
  <div class="container text-white">
    <h1>WELCOME,</h1>
    <h1 >SELL AND BUY NEAR YOU <br>
            Simple, Trusted and Efficient</h1>

    <button>BROWSE LOCAL BUSINESS</button>
  </div>
</div>

<div class="section bg-secondary text-white" id="section2">
  <div class="container">
    <h2>Section 2</h2>
    <p>This is section 2 content.</p>
  </div>
</div>

<div class="section bg-success text-white" id="section2">
    <div class="container">
      <h2>Section 3</h2>
      <p>This is section 3 content.</p>
    </div>
  </div>

  <div class="section bg-danger text-white" id="section2">
    <div class="container">
      <h2>Section 4</h2>
      <p>This is section 4 content.</p>
    </div>
  </div>

  <div class="section bg-primary text-white" id="section2">
    <div class="container">
      <h2>Section 5</h2>
      <p>This is section 5 content.</p>
    </div>
  </div>
<!-- Remaining sections -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
