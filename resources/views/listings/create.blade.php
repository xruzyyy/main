@extends('layouts.app')

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

<div class="container">
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="card">
                <div class="card-header">
                    <p class="card-header-title">Create Listing</p>
                </div>
                <div class="card-content">
                    @if(session('error'))
                        <div class="notification is-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="field">
                            <label class="label">Business Name</label>
                            <div class="control">
                                <input type="text" class="input" id="businessName" name="businessName" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Description</label>
                            <div class="control">
                                <textarea class="textarea" id="description" name="description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Image</label>
                            <div class="control">
                                <div class="file has-name is-boxed">
                                    <label class="file-label">
                                        <input type="file" class="file-input" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">
                                                Choose a file…
                                            </span>
                                        </span>
                                    </label>
                                    <a href="{{ route('map') }}" class="map-button">
                                        <i class="fas fa-map-marked-alt map-button-icon"></i> Provide Location
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Image Preview</label>
                            <div class="control">
                                <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100%; max-height: 200px; display: none;">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Latitude</label>
                            <div class="control">
                                <input type="text" class="input readonly-input" id="latitude" name="latitude" value="{{ $latitude }}" readonly required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Longitude</label>
                            <div class="control">
                                <input type="text" class="input readonly-input" id="longitude" name="longitude" value="{{ $longitude }}" readonly required>
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

@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif

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

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var img = document.getElementById("imagePreview");
            img.src = reader.result;
            img.style.display = "block";
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>