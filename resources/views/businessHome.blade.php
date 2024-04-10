<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Landing Page</title>
  @vite(['resources/scss/category.scss'])
  @vite(['resources/scss/_section.scss'])
  @vite(['resources/scss/main.scss'])
  {{-- @vite(['resources/scss/_bootstrap.scss']) --}}
  @vite(['resources/scss/_businessHome.scss'])
  {{-- @vite(['resources/scss/custom.scss']) --}}
  @vite(['resources/scripts/script.js'])
  @vite(['resources/js/app.js'])
  <link rel="stylesheet" href="../scss/businessHome.css">
  <link rel="stylesheet" href="../scss/category.css">
  <link rel="stylesheet" href="../scss/section.css">
  <link rel="stylesheet" href="../scss/main.css">
  <link rel="stylesheet" href="../scss/_bootstrap.css">
  <link rel="stylesheet" href="../scss/custom.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
    <h1>Welcome Back, {{ auth()->user()->name }}!</h1>
    <h1 >SELL AND BUY NEAR YOU <br>
            Simple, Trusted and Efficient</h1>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn" type="submit"><i class="fas fa-search"></i> Search</button>
            </form>
    </div>
</div>


<section class="business-section" id="section2">
    <div class="container">

        <h2 class="section-title text-center mb-4">Business Categories</h2>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <ul class="business-list">
                    <li class="business-item">
                        <i class="fas fa-calculator business-icon"></i>
                        <span class="business-name">Accounting</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-tractor business-icon"></i>
                        <span class="business-name">Agriculture</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-hard-hat business-icon"></i>
                        <span class="business-name">Construction</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-graduation-cap business-icon"></i>
                        <span class="business-name">Education</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-dollar-sign business-icon"></i>
                        <span class="business-name">Finance</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <ul class="business-list">
                    <li class="business-item">
                        <i class="fas fa-hospital business-icon"></i>
                        <span class="business-name">Healthcare</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-hotel business-icon"></i>
                        <span class="business-name">Hospitality</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-shopping-cart business-icon"></i>
                        <span class="business-name">Retail</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-laptop business-icon"></i>
                        <span class="business-name">Information Technology</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-shopping-bag business-icon"></i>
                        <span class="business-name">Shopping Malls</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-briefcase business-icon"></i>
                        <span class="business-name">Consulting</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <ul class="business-list">
                    <li class="business-item">
                        <i class="fas fa-paint-brush business-icon"></i>
                        <span class="business-name">Design</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-shipping-fast business-icon"></i>
                        <span class="business-name">Logistics</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-futbol business-icon"></i>
                        <span class="business-name">Sports</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-paw business-icon"></i>
                        <span class="business-name">Pets</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-music business-icon"></i>
                        <span class="business-name">Entertainment</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <ul class="business-list">
                    <li class="business-item">
                        <i class="fas fa-globe business-icon"></i>
                        <span class="business-name">International Trade</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-wrench business-icon"></i>
                        <span class="business-name">Maintenance</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-medkit business-icon"></i>
                        <span class="business-name">Pharmaceuticals</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-car business-icon"></i>
                        <span class="business-name">Automotive</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-tree business-icon"></i>
                        <span class="business-name">Environmental</span>
                    </li>
                    <li class="business-item">
                        <i class="fas fa-utensils business-icon"></i>
                        <span class="business-name">Food & Beverage</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="text-container">
            <p class="scroll-text">Browse <br> The <br>Different <br>Businesses</p>
        </div>
         <!-- New business person image -->
         <div class="business-person">
            <img src="{{ asset('images/covermodel.png') }}">
        </div>
    </div>
</section>




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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var scrollText = document.querySelector('.scroll-text');
    var section = document.getElementById('section2');

    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function onScroll() {
        if (isElementInViewport(section)) {
            scrollText.classList.add('scroll-text-visible');
            window.removeEventListener('scroll', onScroll);
        }
    }

    window.addEventListener('scroll', onScroll);

    // Trigger on page load if section is already in view
    onScroll();
});

</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
