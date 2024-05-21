<div class="section" id="section1">
    <div class="video-overlay"></div>
    <video class="video-background" autoplay loop muted>
        <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container text-white">
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
                    <option value="Pharmaceuticals">Pharmaceuticals</option>
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
            <div class="col-lg-auto">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
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

.form-control, .form-select {
    background-color: rgba(255, 255, 255, 0.8);
    border: 1px solid #ccc;
    color: #333;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}
</style>
