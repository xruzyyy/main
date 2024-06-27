@extends(auth()->user()->type === 'business' ? 'layouts.businessHome' : 'layouts.app')

@section('content')
    <style>
        :root {
            --primary-color: #070a0e;
            --secondary-color: #f0f0f0;
            --success-color: #1dbe4e;
            --danger-color: #721c24;
        }

        .container {
            margin-top: 20px;
        }

        .map-button {
            text-decoration: none;
        }

        .map-button:hover {
            background-color: var(--success-color);
            padding: 2px;
            border-radius: 8px;
        }

        .columns.is-centered {
            display: flex;
            justify-content: center;
        }

        .column.is-half {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .cardCreate {
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cardCreate-header {
            background-color: #f0f0f0;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            padding: 10px;
        }

        .cardCreate-header-title {
            font-weight: bold;
            margin: 0;
        }

        .cardCreate-content {
            padding: 20px;
        }

        .field {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
        }

        .input,
        .textarea,
        .select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .input[type="file"] {
            display: none;
        }

        .file-cta {
            cursor: pointer;
        }

        .file-label {
            overflow: hidden;
            cursor: pointer;
        }

        .file-icon {
            margin-right: 5px;
        }

        .image-previews img {
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .readonly-input {
            background-color: #f0f0f0;
        }

        .button.is-primary {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .button.is-primary:hover {
            background-color: #2769c5;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            border-color: #c3e6cb;
            color: var(--success-color);
        }

        .alert-danger {
            background-color: var(--danger-color);
            border-color: #f5c6cb;
            color: var(--secondary-color);
        }

        .image-note {
            font-style: italic;
        }
    </style>

    <div class="container">
        @if (session('success'))
            <div class="container mt-3">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="cardCreate">
                    <div class="cardCreate-header">
                        <p class="cardCreate-header-title">Edit Listing</p>
                    </div>
                    <div class="cardCreate-content">
                        <form action="{{ route('listings.update.put', ['id' => $listing->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Location indicator -->
                            <div class="field">
                                <label class="label">Location</label>
                                <div class="control">
                                    <a href="{{ route('map') }}" class="map-button" required
                                        title="Please provide your business location">
                                        <i class="fas fa-map-marked-alt map-button-icon"></i> Provide Location
                                        <!-- Indicator icon -->
                                        @if ($listing->latitude && $listing->longitude)
                                            <i class="fas fa-check" style="color: green;"></i>
                                        @else
                                            <i class="fas fa-times" style="color: red;"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Business Name</label>
                                <div class="control">
                                    @if ($isBusiness)
                                        <input type="hidden" name="businessName" value="{{ $user->name }}">
                                        <p>{{ $user->name }}</p> <!-- Display the business name as plain text -->
                                    @else
                                        <input type="text" class="input" id="businessName" name="businessName" required
                                            title="Please provide the name of your business"
                                            value="{{ old('businessName', $listing->businessName) }}" readonly>
                                        <!-- Use old('businessName', $listing->businessName) to pre-fill the input with the current value -->
                                    @endif
                                </div>
                            </div>


                            <div class="field">
                                <label class="label">Description</label>
                                <div class="control">
                                    <textarea class="textarea" id="description" name="description" rows="5" required>{{ old('description', $listing->description) }}</textarea>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Contact Number</label>
                                <div class="control">
                                    <input type="tel" class="input" id="contactNumber" name="contactNumber"
                                        pattern="[0-9]{11}" value="{{ old('contactNumber', $listing->contactNumber) }}"
                                        required>
                                </div>
                            </div>

                            <label class="label">Store Hours</label>
                            <div class="field">
                                <label class="label">Monday</label>
                                <div class="control">
                                    <input type="time" id="mondayOpen" name="monday_open"
                                        value="{{ old('monday_open', $listing->monday_open) }}">
                                    <input type="time" id="mondayClose" name="monday_close"
                                        value="{{ old('monday_close', $listing->monday_close) }}">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Tuesday</label>
                                <div class="control">
                                    <input type="time" id="tuesdayOpen" name="tuesday_open"
                                        value="{{ old('tuesday_open', $listing->tuesday_open) }}">
                                    <input type="time" id="tuesdayClose" name="tuesday_close"
                                        value="{{ old('tuesday_close', $listing->tuesday_close) }}">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Wednesday</label>
                                <div class="control">
                                    <input type="time" id="wednesdayOpen" name="wednesday_open"
                                        value="{{ old('wednesday_open', $listing->wednesday_open) }}">
                                    <input type="time" id="wednesdayClose" name="wednesday_close"
                                        value="{{ old('wednesday_close', $listing->wednesday_close) }}">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Thursday</label>
                                <div class="control">
                                    <input type="time" id="thursdayOpen" name="thursday_open"
                                        value="{{ old('thursday_open', $listing->thursday_open) }}">
                                    <input type="time" id="thursdayClose" name="thursday_close"
                                        value="{{ old('thursday_close', $listing->thursday_close) }}">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Friday</label>
                                <div class="control">
                                    <input type="time" id="fridayOpen" name="friday_open"
                                        value="{{ old('friday_open', $listing->friday_open) }}">
                                    <input type="time" id="fridayClose" name="friday_close"
                                        value="{{ old('friday_close', $listing->friday_close) }}">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Saturday</label>
                                <div class="control">
                                    <input type="time" id="saturdayOpen" name="saturday_open"
                                        value="{{ old('saturday_open', $listing->saturday_open) }}">
                                    <input type="time" id="saturdayClose" name="saturday_close"
                                        value="{{ old('saturday_close', $listing->saturday_close) }}">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Sunday</label>
                                <div class="control">
                                    <input type="time" id="sundayOpen" name="sunday_open"
                                        value="{{ old('sunday_open', $listing->sunday_open) }}">
                                    <input type="time" id="sundayClose" name="sunday_close"
                                        value="{{ old('sunday_close', $listing->sunday_close) }}">
                                </div>
                            </div>

                            <div class="field">
                                <label class="label" for="type">Type</label>
                                <div class="control">
                                    <select id="type" name="type" class="input" required>
                                        <option value="" disabled>Please select</option>
                                        <option value="Accounting" {{ old('type', $listing->type) == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                                        <option value="Agriculture" {{ old('type', $listing->type) == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                                        <option value="Construction" {{ old('type', $listing->type) == 'Construction' ? 'selected' : '' }}>Construction</option>
                                        <option value="Education" {{ old('type', $listing->type) == 'Education' ? 'selected' : '' }}>Education</option>
                                        <option value="Finance" {{ old('type', $listing->type) == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Retail" {{ old('type', $listing->type) == 'Retail' ? 'selected' : '' }}>Retail</option>
                                        <option value="Fashion Photography Studios" {{ old('type', $listing->type) == 'Fashion Photography Studios' ? 'selected' : '' }}>Fashion Photography Studios</option>
                                        <option value="Healthcare" {{ old('type', $listing->type) == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                        <option value="Coffee Shops" {{ old('type', $listing->type) == 'Coffee Shops' ? 'selected' : '' }}>Coffee Shops</option>
                                        <option value="Information Technology" {{ old('type', $listing->type) == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                                        <option value="Shopping Malls" {{ old('type', $listing->type) == 'Shopping Malls' ? 'selected' : '' }}>Shopping Malls</option>
                                        <option value="Trading Goods" {{ old('type', $listing->type) == 'Trading Goods' ? 'selected' : '' }}>Trading Goods</option>
                                        <option value="Consulting" {{ old('type', $listing->type) == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                                        <option value="Barbershop" {{ old('type', $listing->type) == 'Barbershop' ? 'selected' : '' }}>Barbershop</option>
                                        <option value="Fashion Consultancy" {{ old('type', $listing->type) == 'Fashion Consultancy' ? 'selected' : '' }}>Fashion Consultancy</option>
                                        <option value="Beauty Salon" {{ old('type', $listing->type) == 'Beauty Salon' ? 'selected' : '' }}>Beauty Salon</option>
                                        <option value="Logistics" {{ old('type', $listing->type) == 'Logistics' ? 'selected' : '' }}>Logistics</option>
                                        <option value="Sports" {{ old('type', $listing->type) == 'Sports' ? 'selected' : '' }}>Sports</option>
                                        <option value="Pets" {{ old('type', $listing->type) == 'Pets' ? 'selected' : '' }}>Pets</option>
                                        <option value="Entertainment" {{ old('type', $listing->type) == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                        <option value="Pattern Making Services" {{ old('type', $listing->type) == 'Pattern Making Services' ? 'selected' : '' }}>Pattern Making Services</option>
                                        <option value="Maintenance" {{ old('type', $listing->type) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="Pharmaceuticals" {{ old('type', $listing->type) == 'Pharmaceuticals' ? 'selected' : '' }}>Pharmaceuticals</option>
                                        <option value="Automotive" {{ old('type', $listing->type) == 'Automotive' ? 'selected' : '' }}>Automotive</option>
                                        <option value="Environmental" {{ old('type', $listing->type) == 'Environmental' ? 'selected' : '' }}>Environmental</option>
                                        <option value="Quick Service Restaurants" {{ old('type', $listing->type) == 'Quick Service Restaurants' ? 'selected' : '' }}>Quick Service Restaurants</option>
                                        <option value="Food & Beverage" {{ old('type', $listing->type) == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                                        <option value="Garment Manufacturing" {{ old('type', $listing->type) == 'Garment Manufacturing' ? 'selected' : '' }}>Garment Manufacturing</option>
                                        <option value="Fashion Events Management" {{ old('type', $listing->type) == 'Fashion Events Management' ? 'selected' : '' }}>Fashion Events Management</option>
                                        <option value="Retail Clothing Stores" {{ old('type', $listing->type) == 'Retail Clothing Stores' ? 'selected' : '' }}>Retail Clothing Stores</option>
                                        <option value="Fashion Design Studios" {{ old('type', $listing->type) == 'Fashion Design Studios' ? 'selected' : '' }}>Fashion Design Studios</option>
                                        <option value="Shoe Manufacturing" {{ old('type', $listing->type) == 'Shoe Manufacturing' ? 'selected' : '' }}>Shoe Manufacturing</option>
                                        <option value="Tailoring and Alterations" {{ old('type', $listing->type) == 'Tailoring and Alterations' ? 'selected' : '' }}>Tailoring and Alterations</option>
                                        <option value="Textile Printing and Embroidery" {{ old('type', $listing->type) == 'Textile Printing and Embroidery' ? 'selected' : '' }}>Textile Printing and Embroidery</option>
                                        <option value="Fashion Accessories" {{ old('type', $listing->type) == 'Fashion Accessories' ? 'selected' : '' }}>Fashion Accessories</option>
                                        <option value="Boutiques" {{ old('type', $listing->type) == 'Boutiques' ? 'selected' : '' }}>Boutiques</option>
                                        <option value="Apparel Recycling and Upcycling" {{ old('type', $listing->type) == 'Apparel Recycling and Upcycling' ? 'selected' : '' }}>Apparel Recycling and Upcycling</option>
                                        <option value="Apparel Exporters" {{ old('type', $listing->type) == 'Apparel Exporters' ? 'selected' : '' }}>Apparel Exporters</option>
                                    </select>

                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Images</label>
                                <p class="image-note">Please upload high-resolution images. You can select multiple images.
                                </p>
                                <div class="control">
                                    <div class="file has-name is-boxed">
                                        <label class="file-label">
                                            <input type="file" class="file-input" id="images" name="images[]"
                                                accept="image/*" multiple>
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

                            <!-- Latitude and Longitude fields -->
    <div class="form-group">
        <label for="latitude">Latitude</label>
        <input type="text" id="latitude" name="latitude" value="{{ old('latitude', request()->input('latitude', $listing->latitude)) }}" required>
      </div>

      <div class="form-group">
        <label for="longitude">Longitude</label>
        <input type="text" id="longitude" name="longitude" value="{{ old('longitude', request()->input('longitude', $listing->longitude)) }}" required>
      </div>


                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-primary">Update Listing</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
           document.addEventListener('DOMContentLoaded', function() {
            // Check sessionStorage flag for location selection
            var locationSelected = sessionStorage.getItem('locationSelected');
            if (locationSelected) {
                // Restore latitude and longitude values if available
                var urlParams = new URLSearchParams(window.location.search);
                var latitude = urlParams.get('latitude');
                var longitude = urlParams.get('longitude');
                if (latitude !== null && longitude !== null) {
                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                }

                // Clear sessionStorage flag after use
                sessionStorage.removeItem('locationSelected');
            }
        });
    </script>
@endsection
