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

    <style>
        /* Custom Modal Styles */
        .custom-modal .modal-content {
            background-color: #ffffff;
            /* White background */
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .custom-modal .modal-header {
            background-color: #007bff;
            /* Blue background */
            color: #ffffff;
            /* White text */
            border-radius: 10px 10px 0 0;
            padding: 15px;
        }

        .custom-modal .modal-title {
            font-weight: bold;
            font-size: 1.5rem;
            color: #ffffff;
            /* White text */
        }

        .custom-modal .modal-body {
            padding: 20px;
            background-color: #f8f9fa;
            /* Light gray background */
        }

        .custom-modal .modal-footer {
            background-color: #f8f9fa;
            /* Light gray background */
            border-radius: 0 0 10px 10px;
            padding: 15px;
        }

        .custom-modal .btn-primary {
            background-color: #007bff;
            /* Blue button */
            border-color: #007bff;
            color: #ffffff;
            /* White text */
        }

        .custom-modal .btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            border-color: #0056b3;
        }

        .custom-modal .btn-close {
            color: #ffffff;
            /* White close button */
            font-size: 1.5rem;
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .custom-modal .btn-close:hover {
            color: #ffffff;
            /* White close button on hover */
        }

        .custom-modal .field label {
            font-weight: bold;
            color: #495057;
            /* Dark gray label text */
        }

        .custom-modal .modal-body p {
            color: #495057;
            /* Dark gray paragraph text */
        }

        .custom-modal .control {
            margin-top: 10px;
        }

        .custom-modal .map-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            /* Blue button */
            color: #ffffff;
            /* White text */
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .custom-modal .map-button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        .custom-modal .map-button-icon {
            margin-right: 10px;
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

                <h3>Create Listing</h3>
                <p>Fill in the data below.</p>

                <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <!-- Bootstrap Modal for Instructions -->
                        <div class="modal fade custom-modal" id="instructionModal" tabindex="-1"
                            aria-labelledby="instructionModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="background-color: #007bff;" class="modal-title"
                                            id="instructionModalLabel">Provide A Location</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">x</button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Location indicator -->
                                        <div class="field" style="background-color:white;">
                                            <label class="label" style="background-color: white;">Location</label>
                                            <div class="control" style="background-color: white;">
                                                <!-- Example integration link in your form -->
                                                <a href="{{ route('map') }}" class="map-button"
                                                    title="Provide your business location">
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
                                            </div>
                                        </div>
                                        <!-- Example: -->
                                        <p style="background-color: white; margin-top:2em;">Click and drag the marker to
                                            adjust the location.</p>
                                        <!-- Add your GIF here -->
                                        <div class="gif-container" style="text-align: center; margin-top: 2em;">
                                            <img src="{{ asset('images/instruction.gif') }}"
                                                alt="Location Instructions" style="width: 100%; max-width: 400px;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-lg btn-primary"
                                            data-bs-dismiss="modal">Done</button>
                                        <a href="{{ route('map') }}" class="btn btn-lg btn-success">Proceed</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif




                    <div class="form-group">
                        <label for="businessName">Business Name</label>
                        <input type="text" id="businessName" name="businessName" class="form-control"
                            value="{{ Auth::user()->name }}" readonly>
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
                                <input type="time" id="{{ strtolower($day) }}Open"
                                    name="{{ strtolower($day) }}Open" value="{{ old(strtolower($day) . 'Open') }}">
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
                                        {{ old('type') === $type ? 'selected' : '' }}>
                                        {{ $type }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Images</label>
                        <p class="image-note">Please upload high-resolution images. You can select multiple images.</p>
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

                    <div class="field" style="display: none;">
                        <label class="labelLocated">Latitude</label>
                        <div class="labelLocated">
                            <input type="text" class="input readonly-input" id="latitude" name="latitude"
                                value="{{ $latitude }}" readonly required>
                        </div>
                    </div>

                    <div class="field" style="display: none;">
                        <label class="labelLocated">Longitude</label>
                        <div class="labelLocated">
                            <input type="text" class="input readonly-input" id="longitude" name="longitude"
                                value="{{ $longitude }}" readonly required>
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

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        function previewImages(event) {
            var previewContainer = document.getElementById('imagePreviews');
            previewContainer.innerHTML = '';

            var files = event.target.files;

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imageDiv = document.createElement('div');
                    imageDiv.classList.add('image-preview');

                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;

                    var deleteButton = document.createElement('span');
                    deleteButton.classList.add('delete-image');
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteButton.addEventListener('click', function() {
                        imageDiv.remove();
                    });

                    imageDiv.appendChild(img);
                    imageDiv.appendChild(deleteButton);

                    previewContainer.appendChild(imageDiv);
                };

                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Show the modal on page load
            var myModal = new bootstrap.Modal(document.getElementById('instructionModal'), {
                backdrop: 'static', // Prevent closing on backdrop click
                keyboard: false // Prevent closing with ESC key
            });
            myModal.show();
        });
    </script>
</body>

</html>
