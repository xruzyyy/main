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

    /* Ensure the map container has a fixed height */
    #map-container {
        height: 400px;
        margin-bottom: 1rem; /* Adjust as needed */
    }
</style>

<div class="container">
    <form action="{{ route('listings.create') }}" method="GET">
        <button type="submit">Create Listings</button>
    </form>
</div>
@endsection
