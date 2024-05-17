@extends(auth()->user()->type === 'business' ? 'layouts.businessHome' : 'layouts.app')

@section('content')
<style>
    .container {
        margin-top: 2rem;
    }
    .card-body {
        padding: 3rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .input {
        height: 3.5rem;
    }

    .file-input {
        height: 3.5rem;
    }

    .button {
        height: 3.5rem;
    }

    /* Styles for the map selection button */
    .map-button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 8px;
        display: flex;
        align-items: center;
    }

    .map-button-icon {
        margin-right: 8px;
    }

    .map-button:hover {
        background-color: #45a049; /* Darker Green */
    }

    /* Styling for latitude and longitude input */
    .readonly-input {
        background-color: #f5f5f5;
        border: none;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
    }
</style>

<div class="container2">
    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="card">
                <div class="card-header">
                    <p class="card-header-title">Create Listing</p>
                </div>
                <div class="card-content">

                    <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(session('error'))
                        <div class="notification is-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                        <a href="{{ route('map') }}" class="map-button" required title="Please provide your business location">
                            <i class="fas fa-map-marked-alt map-button-icon"></i> Provide Location
                        </a>


                        <div class="field">
                            <label class="label">Business Name</label>
                            <div class="control">
                                <input type="text" class="input" id="businessName" name="businessName" required title="Please provide the name of your business">
                            </div>
                        </div>


                        <div class="field">
                            <label class="label">Description</label>
                            <div class="control">
                                <textarea class="textarea" id="description" name="description" rows="3" required title="Please provide a description of your business"></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Contact Number</label>
                            <div class="control">
                                <input type="tel" class="input" id="contactNumber" name="contactNumber" pattern="[0-9]{11}" title="Please enter a valid 11-digit numeric contact number" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label" for="type">Type</label>
                            <div class="control">
                                <select id="type" name="type" class="input" title="Please Choose a type" required>
                                    <option value="" disabled selected>Please select</option>
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
                        </div>

                        <div class="field">
                            <label class="label">Images</label>
                            <p class="image-note">Please upload high-resolution images. You can select multiple images.</p>
                            <div class="control">
                                <div class="file has-name is-boxed">
                                    <label class="file-label">
                                        <input type="file" class="file-input" id="images" name="images[]" accept="image/*" multiple required onchange="previewImages(event)">
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">
                                                Choose files…
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Image Previews</label>
                            <div class="control">
                                <div id="imagePreviews" class="image-previews"></div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="labelLocated">Latitude</label>
                            <div class="labelLocated">
                                <input type="text" class="input readonly-input" id="latitude" name="latitude" value="{{ $latitude }}" readonly required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="labelLocated">Longitude</label>
                            <div class="labelLocated">
                                <input style="display: hide" type="text" class="input readonly-input" id="longitude" name="longitude" value="{{ $longitude }}" readonly required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-primary">Create Listing</button>
                            </div>
                        </div>
                    </form>
                </div>
</div>



@if($errors->any())
    <div class="container mt-3">
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@endsection

{{-- <script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var img = document.getElementById("imagePreview");
            img.src = reader.result;
            img.style.display = "block";
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script> --}}

<script>
    function previewImages(event) {
        var files = event.target.files;

        var previewContainer = document.getElementById('imagePreviews');
        previewContainer.innerHTML = '';

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100%';
                img.style.maxHeight = '200px';
                img.style.marginRight = '10px';
                previewContainer.appendChild(img);
            }

            reader.readAsDataURL(file);
        }
    }
</script>
