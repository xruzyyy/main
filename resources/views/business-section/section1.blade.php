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
