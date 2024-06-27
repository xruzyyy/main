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
                        <form action="{{ route('listings.update', ['id' => $listing->id]) }}" method="POST"
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
                                        <option value="Accounting"
                                            {{ old('type', $listing->type) == 'Accounting' ? 'selected' : '' }}>Accounting
                                        </option>
                                        <option value="Agriculture"
                                            {{ old('type', $listing->type) == 'Agriculture' ? 'selected' : '' }}>
                                            Agriculture</option>
                                        <!-- Add other options here, ensure to compare with $listing->type -->
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

                            <div class="field">
                                <label class="labelLocated">Latitude</label>
                                <div class="labelLocated">
                                    <input type="text" class="input readonly-input" id="latitude" name="latitude"
                                        value="{{ $listing->latitude }}" readonly required>
                                </div>
                            </div>
                            <div class="field">
                                <label class="labelLocated">Longitude</label>
                                <div class="labelLocated">
                                    <input type="text" class="input readonly-input" id="longitude" name="longitude"
                                        value="{{ $listing->longitude }}" readonly required>
                                </div>
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
