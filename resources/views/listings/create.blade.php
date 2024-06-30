<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Listing Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="path/to/your/custom/styles.css"> <!-- Ensure this links to your custom styles -->
    <style>
        /* Your custom styles here */
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

        .readonly-input {
            background-color: #f0f0f0;
        }

        .image-note {
            font-size: 14px;
            color: #ccc;
            margin-top: 5px;
        }

        .file-input {
            display: none;
        }

        .file-cta {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .file-cta:hover {
            background-color: #f0f0f0;
        }

        .file-label {
            display: flex;
            align-items: center;
        }

        .file-icon {
            margin-right: 8px;
        }

        .image-previews {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .image-preview {
            max-width: 100px;
            max-height: 100px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            overflow: hidden;
            position: relative;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .delete-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 4px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-image:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
</head>

<body>

    @if (session('success'))
    <div class="container mt-3">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="form-holder">
        <div class="form-content">
            <div class="form-items">
                <a href="{{ route('business.home') }}" class="nav-link">
                    <i class="fas fa-home fa-3x"></i>
                </a>

                <h3>Create Listing</h3>
                <p>Fill in the data below.</p>

                <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Location indicator -->
                    <div class="field">
                        <label class="label">Location</label>
                        <div class="control">
                            <a href="{{ route('map') }}" class="map-button" title="Provide your business location">
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
                            <p class="readonly-input">{{ $user->name }}</p>
                            @else
                            <input type="text" class="input" id="businessName" name="businessName" required
                                title="Please provide the name of your business" value="{{ old('businessName') }}">
                            @error('businessName')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                            @endif
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Description</label>
                        <div class="control">
                            <textarea class="textarea" id="description" name="description" rows="3" required
                                title="Please provide a description of your business">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Contact Number</label>
                        <div class="control">
                            <input type="tel" class="input" id="contactNumber" name="contactNumber"
                                pattern="[0-9]{11}" title="Please enter a valid 11-digit numeric contact number"
                                required value="{{ old('contactNumber') }}">
                            @error('contactNumber')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
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
                            <input type="time" id="{{ strtolower($day) }}Open" name="{{ strtolower($day) }}Open"
                                value="{{ old(strtolower($day) . 'Open') }}">
                            <input type="time" id="{{ strtolower($day) }}Close"
                                name="{{ strtolower($day) }}Close" value="{{ old(strtolower($day) . 'Close') }}">
                        </div>
                    </div>
                    @endforeach

                    <div class="field">
                        <label class="label" for="type">Type</label>
                        <div class="control">
                            <select id="type" name="type" class="input" title="Please Choose a type" required>
                                <option value="" disabled selected>Please select</option>
                                @foreach (['Accounting', 'Agriculture', 'Construction', 'Education', 'Finance', 'Retail', 'Fashion Photography Studios', 'Healthcare', 'Coffee Shops', 'Information Technology', 'Shopping Malls', 'Trading Goods', 'Consulting', 'Barbershop', 'Fashion Consultancy', 'Beauty Salon', 'Logistics', 'Sports', 'Pets', 'Entertainment', 'Pattern Making Services', 'Maintenance', 'Pharmaceuticals', 'Automotive', 'Environmental', 'Quick Service Restaurants', 'Food & Beverage', 'Garment Manufacturing', 'Fashion Events Management', 'Retail Clothing Stores', 'Fashion Design Studios', 'Shoe Manufacturing', 'Tailoring and Alterations', 'Textile Printing and Embroidery', 'Fashion Accessories', 'Boutiques', 'Apparel Recycling and Upcycling', 'Apparel Exporters'] as $type)
                                <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('type')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
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
                                @error('images')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
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
                            <input type="text" class="input readonly-input" id="longitude" name="longitude" value="{{ $longitude }}" readonly required>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <button type="submit" class="btn btn-primary">Create Listing</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        function previewImages(event) {
            var previewContainer = document.getElementById('imagePreviews');
            previewContainer.innerHTML = '';

            var files = event.target.files;

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function (e) {
                    var imageDiv = document.createElement('div');
                    imageDiv.classList.add('image-preview');

                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;

                    var deleteButton = document.createElement('span');
                    deleteButton.classList.add('delete-image');
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteButton.addEventListener('click', function () {
                        imageDiv.remove();
                    });

                    imageDiv.appendChild(img);
                    imageDiv.appendChild(deleteButton);

                    previewContainer.appendChild(imageDiv);
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>
