@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
    <h1>Edit Listing</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('listings.update', ['id' => $listing->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="businessName">Business Name</label>
            <input type="text" id="businessName" name="businessName" class="form-control" value="{{ old('businessName', $listing->businessName) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="5" required>{{ old('description', $listing->description) }}</textarea>
        </div>

        {{-- Add fields for other data like images, contact number, store hours, etc. --}}

        <button type="submit" class="btn btn-primary">Update Listing</button>
    </form>
@endsection
