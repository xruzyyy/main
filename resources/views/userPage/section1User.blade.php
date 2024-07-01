<style>
    .button {
  position: relative;
  border: none;
  background-color: rgb(0, 0, 0);
  color: #212121;
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  font-weight: 600;
  gap: 10px;
  border-radius: 10px;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  overflow: hidden;
}

.button span {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1;
}

.button::before {
  content: "";
  position: absolute;
  background-color: rgb(112, 204, 216);
  width: 100%;
  height: 100%;
  left: 0%;
  bottom: 0%;
  transform: translate(-100%, 100%);
  border-radius: inherit;
}

.button svg {
  fill: rgb(216, 209, 112);
  transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.button:hover::before {
  animation: shakeBack 0.6s forwards;
}

.button:hover svg {
  fill: rgb(0, 0, 0);
  scale: 1.3;
}

.button:active {
  box-shadow: none;
}

@keyframes shakeBack {
  0% {
    transform: translate(-100%, 100%);
  }

  50% {
    transform: translate(20%, -20%);
  }

  100% {
    transform: translate(0%, 0%);
  }
}

</style>
<div class="section" id="section1">
    <div class="video-overlay"></div>
    <video class="video-background" autoplay loop muted>
        <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container text-white">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>SELL AND BUY NEAR YOU <br> Simple, Trusted and Efficient</h1>
        <form action="{{ route('searchPosts') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-12">
                <input type="text" class="form-control" placeholder="Search Business Posts" name="search">
            </div>
            <div class="col-lg">
                <select class="form-select" name="category">
                    <option value="" selected>All Categories</option>
                    <option value="" disabled>Please select</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Agriculture">Agriculture</option>
                    <option value="Construction">Construction</option>
                    <option value="Education">Education</option>
                    <option value="Finance">Finance</option>
                    <option value="Retail">Retail</option>
                    <option value="Fashion Photography Studios">Fashion Photography Studios</option>
                    <option value="Healthcare">Healthcare</option>
                    <option value="Coffee Shops">Coffee Shops</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Shopping Malls">Shopping Malls</option>
                    <option value="Trading Goods">Trading Goods</option>
                    <option value="Consulting">Consulting</option>
                    <option value="Barbershop">Barbershop</option>
                    <option value="Fashion Consultancy">Fashion Consultancy</option>
                    <option value="Beauty Salon">Beauty Salon</option>
                    <option value="Logistics">Logistics</option>
                    <option value="Sports">Sports</option>
                    <option value="Pets">Pets</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Pattern Making Services">Pattern Making Services</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Automotive">Automotive</option>
                    <option value="Environmental">Environmental</option>
                    <option value="Quick Service Restaurants">Quick Service Restaurants</option>
                    <option value="Food & Beverage">Food & Beverage</option>
                    <option value="Garment Manufacturing">Garment Manufacturing</option>
                    <option value="Fashion Events Management">Fashion Events Management</option>
                    <option value="Retail Clothing Stores">Retail Clothing Stores</option>
                    <option value="Fashion Design Studios">Fashion Design Studios</option>
                    <option value="Shoe Manufacturing">Shoe Manufacturing</option>
                    <option value="Tailoring and Alterations">Tailoring and Alterations</option>
                    <option value="Textile Printing and Embroidery">Textile Printing and Embroidery</option>
                    <option value="Fashion Accessories">Fashion Accessories</option>
                    <option value="Boutiques">Boutiques</option>
                    <option value="Apparel Recycling and Upcycling">Apparel Recycling and Upcycling</option>
                    <option value="Apparel Exporters">Apparel Exporters</option>
                </select>
            </div>
            <div class="col-lg">
                <select class="form-select" name="sort_by">
                    <option value="">Sort by</option>
                    <option value="highest_rating">Highest Rating</option>
                    <option value="comments">Most Comments</option>
                </select>
            </div>
            {{-- <div class="col-lg-auto">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div> --}}
            <button class="button col-lg-auto">
                <span>
                  <svg viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M9.145 18.29c-5.042 0-9.145-4.102-9.145-9.145s4.103-9.145 9.145-9.145 9.145 4.103 9.145 9.145-4.102 9.145-9.145 9.145zm0-15.167c-3.321 0-6.022 2.702-6.022 6.022s2.702 6.022 6.022 6.022 6.023-2.702 6.023-6.022-2.702-6.022-6.023-6.022zm9.263 12.443c-.817 1.176-1.852 2.188-3.046 2.981l5.452 5.453 3.014-3.013-5.42-5.421z"></path></svg>
                </span>
            </button>
        </form>
    </div>
</div>

<style>
    .section {
        position: relative;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
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

    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 0;
    }

    .container {
        position: relative;
        z-index: 1;
    }

    .text-white {
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .form-control,
    .form-select {
        background-color: rgba(0, 0, 0, 0.8);
        border: 1px solid #ccc;
        color: #fff;
    }

    .btn-primary {
        background-color: #000000;
        border-color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #000000;
        border-color: #00b7ff;
    }
</style>
