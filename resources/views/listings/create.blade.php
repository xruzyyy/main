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

                    @if(session('success'))
                        <div class="notification is-success">
                            {{ session('success') }}
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
                                        <input type="file" class="file-input" id="image" name="image" accept="image/*" required>
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">
                                                Choose a file…
                                            </span>
                                        </span>
                                        
                                    </label>
                                </div>
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