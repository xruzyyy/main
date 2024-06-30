<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Listing Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        *,
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            -moz-osx-font-smoothing: grayscale;
            background-color: #152733;
            color: #fff;
        }

        .form-holder {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-content {
            width: 100%;
            max-width: 800px;
            padding: 40px;
            border: 3px solid #fff;
            border-radius: 10px;
            text-align: left;
            transition: all 0.4s ease;
        }

        .form-items {
            width: 100%;
        }

        .form-content h3 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-content p {
            font-size: 17px;
            font-weight: 300;
            margin-bottom: 20px;
        }

        .form-content label {
            font-weight: 500;
        }

        .form-content input[type=text],
        .form-content input[type=password],
        .form-content input[type=email],
        .form-content input[type=tel],
        .form-content input[type=file],
        .form-content select,
        .form-content textarea {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 6px;
            background-color: #fff;
            font-size: 15px;
            color: #333;
            margin-top: 10px;
        }

        .form-content input[type=time] {
            width: 48%;
        }

        .form-check-input {
            margin-top: 6px;
        }

        .form-button {
            text-align: right;
            margin-top: 20px;
        }

        .btn-primary {
            background-color: #6C757D;
            border: none;
            box-shadow: none;
            color: #fff;
            padding: 12px 24px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #495056;
            color: #fff;
            text-decoration: none;
        }

        .invalid-feedback {
            color: #ff606e;
            display: block;
            margin-top: 5px;
        }

        .valid-feedback {
            color: #2acc80;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<body>

    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
        <script>
            // JavaScript redirect after success message display
            setTimeout(function() {
                window.location.href = "{{ route('business.home') }}";
            }, 2000); // Redirect after 3 seconds (adjust as needed)
        </script>
    @endif

    <div class="form-holder">
        <div class="form-content">
            <div class="form-items">
                <a href="{{ route('business.home') }}" class="nav-link">
                    <i class="fas fa-home fa-3x"></i>
                </a>

                <h3>Update Listing</h3>
                <p>Fill in the data below.</p>
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
                    <!-- Icon for location button -->
                    <img src="{{ asset('images/map.png') }}" alt="Store Icon"
                        style="background-color: #007bff; height: 40px; width: 40px; border-radius: 50%; margin-right: 5px;">
                    Provide Location
                    <!-- Indicator icon -->
                    @if ($latitude && $longitude)
                        <i class="fas fa-check"
                            style="background-color: green; height:20px; width:20px; border-radius:5px;"></i>
                    @else
                        <i class="fas fa-times"
                            style="background-color: red; height:20px; width:20px; border-radius:5px;"></i>
                    @endif
                    </a>
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
                    <!-- Monday -->
                    <div class="field">
                        <label class="label">Monday</label>
                        <div class="control">
                            <input type="time" id="mondayOpen" name="mondayOpen"
                                value="{{ old('mondayOpen', $listing->monday_open) }}">
                            <input type="time" id="mondayClose" name="mondayClose"
                                value="{{ old('mondayClose', $listing->monday_close) }}">
                        </div>
                    </div>

                    <!-- Tuesday -->
                    <div class="field">
                        <label class="label">Tuesday</label>
                        <div class="control">
                            <input type="time" id="tuesdayOpen" name="tuesdayOpen"
                                value="{{ old('tuesdayOpen', $listing->tuesday_open) }}">
                            <input type="time" id="tuesdayClose" name="tuesdayClose"
                                value="{{ old('tuesdayClose', $listing->tuesday_close) }}">
                        </div>
                    </div>

                    <!-- Wednesday -->
                    <div class="field">
                        <label class="label">Wednesday</label>
                        <div class="control">
                            <input type="time" id="wednesdayOpen" name="wednesdayOpen"
                                value="{{ old('wednesdayOpen', $listing->wednesday_open) }}">
                            <input type="time" id="wednesdayClose" name="wednesdayClose"
                                value="{{ old('wednesdayClose', $listing->wednesday_close) }}">
                        </div>
                    </div>

                    <!-- Thursday -->
                    <div class="field">
                        <label class="label">Thursday</label>
                        <div class="control">
                            <input type="time" id="thursdayOpen" name="thursdayOpen"
                                value="{{ old('thursdayOpen', $listing->thursday_open) }}">
                            <input type="time" id="thursdayClose" name="thursdayClose"
                                value="{{ old('thursdayClose', $listing->thursday_close) }}">
                        </div>
                    </div>

                    <!-- Friday -->
                    <div class="field">
                        <label class="label">Friday</label>
                        <div class="control">
                            <input type="time" id="fridayOpen" name="fridayOpen"
                                value="{{ old('fridayOpen', $listing->friday_open) }}">
                            <input type="time" id="fridayClose" name="fridayClose"
                                value="{{ old('fridayClose', $listing->friday_close) }}">
                        </div>
                    </div>

                    <!-- Saturday -->
                    <div class="field">
                        <label class="label">Saturday</label>
                        <div class="control">
                            <input type="time" id="saturdayOpen" name="saturdayOpen"
                                value="{{ old('saturdayOpen', $listing->saturday_open) }}">
                            <input type="time" id="saturdayClose" name="saturdayClose"
                                value="{{ old('saturdayClose', $listing->saturday_close) }}">
                        </div>
                    </div>

                    <!-- Sunday -->
                    <div class="field">
                        <label class="label">Sunday</label>
                        <div class="control">
                            <input type="time" id="sundayOpen" name="sundayOpen"
                                value="{{ old('sundayOpen', $listing->sunday_open) }}">
                            <input type="time" id="sundayClose" name="sundayClose"
                                value="{{ old('sundayClose', $listing->sunday_close) }}">
                        </div>
                    </div>


                    <div class="field">
                        <label class="label" for="type">Type</label>
                        <div class="control">
                            <select id="type" name="type" class="input" required>
                                <option value="" disabled>Please select</option>
                                <option value="Accounting"
                                    {{ old('type', $listing->type) == 'Accounting' ? 'selected' : '' }}>Accounting
                                </option>
                                <option value="Agriculture"
                                    {{ old('type', $listing->type) == 'Agriculture' ? 'selected' : '' }}>Agriculture
                                </option>
                                <option value="Construction"
                                    {{ old('type', $listing->type) == 'Construction' ? 'selected' : '' }}>Construction
                                </option>
                                <option value="Education"
                                    {{ old('type', $listing->type) == 'Education' ? 'selected' : '' }}>Education
                                </option>
                                <option value="Finance"
                                    {{ old('type', $listing->type) == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Retail"
                                    {{ old('type', $listing->type) == 'Retail' ? 'selected' : '' }}>Retail</option>
                                <option value="Fashion Photography Studios"
                                    {{ old('type', $listing->type) == 'Fashion Photography Studios' ? 'selected' : '' }}>
                                    Fashion Photography Studios</option>
                                <option value="Healthcare"
                                    {{ old('type', $listing->type) == 'Healthcare' ? 'selected' : '' }}>Healthcare
                                </option>
                                <option value="Coffee Shops"
                                    {{ old('type', $listing->type) == 'Coffee Shops' ? 'selected' : '' }}>Coffee Shops
                                </option>
                                <option value="Information Technology"
                                    {{ old('type', $listing->type) == 'Information Technology' ? 'selected' : '' }}>
                                    Information Technology</option>
                                <option value="Shopping Malls"
                                    {{ old('type', $listing->type) == 'Shopping Malls' ? 'selected' : '' }}>Shopping
                                    Malls</option>
                                <option value="Trading Goods"
                                    {{ old('type', $listing->type) == 'Trading Goods' ? 'selected' : '' }}>Trading
                                    Goods</option>
                                <option value="Consulting"
                                    {{ old('type', $listing->type) == 'Consulting' ? 'selected' : '' }}>Consulting
                                </option>
                                <option value="Barbershop"
                                    {{ old('type', $listing->type) == 'Barbershop' ? 'selected' : '' }}>Barbershop
                                </option>
                                <option value="Fashion Consultancy"
                                    {{ old('type', $listing->type) == 'Fashion Consultancy' ? 'selected' : '' }}>
                                    Fashion Consultancy</option>
                                <option value="Beauty Salon"
                                    {{ old('type', $listing->type) == 'Beauty Salon' ? 'selected' : '' }}>Beauty Salon
                                </option>
                                <option value="Logistics"
                                    {{ old('type', $listing->type) == 'Logistics' ? 'selected' : '' }}>Logistics
                                </option>
                                <option value="Sports"
                                    {{ old('type', $listing->type) == 'Sports' ? 'selected' : '' }}>Sports</option>
                                <option value="Pets" {{ old('type', $listing->type) == 'Pets' ? 'selected' : '' }}>
                                    Pets</option>
                                <option value="Entertainment"
                                    {{ old('type', $listing->type) == 'Entertainment' ? 'selected' : '' }}>
                                    Entertainment</option>
                                <option value="Pattern Making Services"
                                    {{ old('type', $listing->type) == 'Pattern Making Services' ? 'selected' : '' }}>
                                    Pattern Making Services</option>
                                <option value="Maintenance"
                                    {{ old('type', $listing->type) == 'Maintenance' ? 'selected' : '' }}>Maintenance
                                </option>
                                <option value="Pharmaceuticals"
                                    {{ old('type', $listing->type) == 'Pharmaceuticals' ? 'selected' : '' }}>
                                    Pharmaceuticals</option>
                                <option value="Automotive"
                                    {{ old('type', $listing->type) == 'Automotive' ? 'selected' : '' }}>Automotive
                                </option>
                                <option value="Environmental"
                                    {{ old('type', $listing->type) == 'Environmental' ? 'selected' : '' }}>
                                    Environmental</option>
                                <option value="Quick Service Restaurants"
                                    {{ old('type', $listing->type) == 'Quick Service Restaurants' ? 'selected' : '' }}>
                                    Quick Service Restaurants</option>
                                <option value="Food & Beverage"
                                    {{ old('type', $listing->type) == 'Food & Beverage' ? 'selected' : '' }}>Food &
                                    Beverage</option>
                                <option value="Garment Manufacturing"
                                    {{ old('type', $listing->type) == 'Garment Manufacturing' ? 'selected' : '' }}>
                                    Garment Manufacturing</option>
                                <option value="Fashion Events Management"
                                    {{ old('type', $listing->type) == 'Fashion Events Management' ? 'selected' : '' }}>
                                    Fashion Events Management</option>
                                <option value="Retail Clothing Stores"
                                    {{ old('type', $listing->type) == 'Retail Clothing Stores' ? 'selected' : '' }}>
                                    Retail Clothing Stores</option>
                                <option value="Fashion Design Studios"
                                    {{ old('type', $listing->type) == 'Fashion Design Studios' ? 'selected' : '' }}>
                                    Fashion Design Studios</option>
                                <option value="Shoe Manufacturing"
                                    {{ old('type', $listing->type) == 'Shoe Manufacturing' ? 'selected' : '' }}>Shoe
                                    Manufacturing</option>
                                <option value="Tailoring and Alterations"
                                    {{ old('type', $listing->type) == 'Tailoring and Alterations' ? 'selected' : '' }}>
                                    Tailoring and Alterations</option>
                                <option value="Textile Printing and Embroidery"
                                    {{ old('type', $listing->type) == 'Textile Printing and Embroidery' ? 'selected' : '' }}>
                                    Textile Printing and Embroidery</option>
                                <option value="Fashion Accessories"
                                    {{ old('type', $listing->type) == 'Fashion Accessories' ? 'selected' : '' }}>
                                    Fashion Accessories</option>
                                <option value="Boutiques"
                                    {{ old('type', $listing->type) == 'Boutiques' ? 'selected' : '' }}>Boutiques
                                </option>
                                <option value="Apparel Recycling and Upcycling"
                                    {{ old('type', $listing->type) == 'Apparel Recycling and Upcycling' ? 'selected' : '' }}>
                                    Apparel Recycling and Upcycling</option>
                                <option value="Apparel Exporters"
                                    {{ old('type', $listing->type) == 'Apparel Exporters' ? 'selected' : '' }}>Apparel
                                    Exporters</option>
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
                                        accept="image/*" multiple required>
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
                    <div class="form-group" style="display: none;">
                        <label for="latitude">Latitude</label>
                        <input type="text" id="latitude" name="latitude"
                            value="{{ old('latitude', request()->input('latitude', $listing->latitude)) }}" required>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="longitude">Longitude</label>
                        <input type="text" id="longitude" name="longitude"
                            value="{{ old('longitude', request()->input('longitude', $listing->longitude)) }}"
                            required>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button type="submit" class="button is-primary">Update Listing</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        (function() {
            'use strict';
            const forms = document.querySelectorAll('.requires-validation');
            Array.from(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

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
</body>

</html>
