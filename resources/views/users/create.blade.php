@extends('layouts.master')

@section('manageUsersCreate')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Create User
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="business">Business</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1">Active</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Permit</label>
                                <input type="file" name="image" id="image" class="form-control-file" required>
                            </div>
                            <!-- Add profile image field -->
                        <div class="mb-3 row align-items-center">
                            <label for="profile_image" class="col-md-4 col-form-label text-md-center label-custom"><b>Profile</b></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="profile_image" type="file" class="form-control file-input @error('profile_image') is-invalid @enderror" name="profile_image" required>
                                    <label class="input-group-text btn btn-primary" for="profile_image"><i class="fas fa-upload"></i> Choose File</label>
                                </div>
                                @error('profile_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                            <!-- Add a hidden input field for email_verified_at with current timestamp -->
                            <input type="hidden" name="email_verified_at" value="{{ now() }}">

                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
