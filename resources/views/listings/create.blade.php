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

    <div class="container2">

        <div class="columns is-centered">
            <div class="column is-half">
                <div class="cardCreate">
                    <div class="cardCreate-header">
                        <h3 class="cardCreate-header-title">Create Listing</h3>
                        <p>Fill the data below</p>
                        @if ($errors->any())
                            <div class="error-container">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="container mt-3">
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="cardCreate-content">
                        <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (session('error'))
                                <div class="notification is-danger">
                                    {{ session('error') }}
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
                                        @if ($latitude && $longitude)
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
                                        <p>{{ $user->name }}</p>
                                    @else
                                        <input type="text" class="input" id="businessName" name="businessName" required
                                            title="Please provide the name of your business"
                                            value="{{ old('businessName') }}">
                                    @endif
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Description</label>
                                <div class="control">
                                    <textarea class="textarea" id="description" name="description" rows="3" required
                                        title="Please provide a description of your business">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Contact Number</label>
                                <div class="control">
                                    <input type="tel" class="input" id="contactNumber" name="contactNumber"
                                        pattern="[0-9]{11}" title="Please enter a valid 11-digit numeric contact number"
                                        required value="{{ old('contactNumber') }}">
                                </div>
                            </div>

                            <label class="label">Store Hours</label>
                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp

                            @foreach ($days as $day)
                                <div class="field">
                                    <label class="label">{{ $day }}</label>
                                    <div class="control">
                                        <input type="time" id="{{ strtolower($day) }}Open"
                                            name="{{ strtolower($day) }}Open"
                                            value="{{ old(strtolower($day) . 'Open') }}">
                                        <input type="time" id="{{ strtolower($day) }}Close"
                                            name="{{ strtolower($day) }}Close"
                                            value="{{ old(strtolower($day) . 'Close') }}">
                                    </div>
                                </div>
                            @endforeach

                            <div class="field">
                                <label class="label" for="type">Type</label>
                                <div class="control">
                                    <select id="type" name="type" class="input" title="Please Choose a type"
                                        required>
                                        <option value="" disabled selected>Please select</option>
                                        @foreach (['Accounting', 'Agriculture', 'Construction', 'Education', 'Finance', 'Retail', 'Fashion Photography Studios', 'Healthcare', 'Coffee Shops', 'Information Technology', 'Shopping Malls', 'Trading Goods', 'Consulting', 'Barbershop', 'Fashion Consultancy', 'Beauty Salon', 'Logistics', 'Sports', 'Pets', 'Entertainment', 'Pattern Making Services', 'Maintenance', 'Pharmaceuticals', 'Automotive', 'Environmental', 'Quick Service Restaurants', 'Food & Beverage', 'Garment Manufacturing', 'Fashion Events Management', 'Retail Clothing Stores', 'Fashion Design Studios', 'Shoe Manufacturing', 'Tailoring and Alterations', 'Textile Printing and Embroidery', 'Fashion Accessories', 'Boutiques', 'Apparel Recycling and Upcycling', 'Apparel Exporters'] as $type)
                                            <option value="{{ $type }}"
                                                {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
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
                                                accept="image/*" multiple required onchange="previewImages(event)">
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
                                    <input type="text" class="input readonly-input" id="latitude" name="latitude"
                                        value="{{ $latitude }}" readonly required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="labelLocated">Longitude</label>
                                <div class="labelLocated">
                                    <input type="text" class="input readonly-input" id="longitude" name="longitude"
                                        value="{{ $longitude }}" readonly required>
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
            </div>
        </div>
    </div>

    <script>
        function previewImages(event) {
            var files = event.target.files;
            var imagePreviews = document.getElementById('imagePreviews');
            imagePreviews.innerHTML = '';

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100%';
                    imagePreviews.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
