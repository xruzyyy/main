@extends('layouts.master')

@section('manageUsersCreate')
    <style>
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.2rem;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0;
        }
        .card-body {
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
        }
        .btn-primary {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .file-input-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        .file-input-wrapper .btn-file {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
        }
        .image-preview {
            margin-top: 1rem;
            max-width: 100%;
            max-height: 200px;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Create User
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password">Password</label>
                                        <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <i id="togglePassword" class="fas fa-eye password-toggle"></i>
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input placeholder="Confirm Password" id="password_confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <i id="toggleConfirmPassword" class="fas fa-eye password-toggle"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">User Type</label>
                                        <select name="type" id="type" class="form-control" onchange="toggleBusinessPermitSection(this.value)" required>
                                            <option value="user" {{ old('type') == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="business" {{ old('type') == 'business' ? 'selected' : '' }}>Business</option>
                                        </select>
                                    </div>

                                    <div id="business_permit_section" class="form-group" style="display: {{ old('type') == 'business' ? 'block' : 'none' }};">
                                        <label for="image">Business Permit</label>
                                        <div class="file-input-wrapper">
                                            <button type="button" class="btn btn-secondary btn-file">Choose File</button>
                                            <input type="file" name="image" id="image" class="form-control-file">
                                        </div>
                                        <img id="business_permit_preview" src="#" alt="Business Permit Preview" class="image-preview" style="display: none;">
                                    </div>

                                    <div class="form-group">
                                        <label for="profile_image">Profile Image</label>
                                        <div class="file-input-wrapper">
                                            <button type="button" class="btn btn-secondary btn-file">Choose File</button>
                                            <input id="profile_image" type="file" class="form-control-file @error('profile_image') is-invalid @enderror" name="profile_image">
                                        </div>
                                        <img id="profile_image_preview" src="#" alt="Profile Image Preview" class="image-preview" style="display: none;">
                                        @error('profile_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="email_verified_at" value="{{ now() }}">
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleBusinessPermitSection(userType) {
            var businessPermitSection = document.getElementById('business_permit_section');
            var imageInput = document.getElementById('image');

            if (userType === 'user' || userType === 'admin') {
                businessPermitSection.style.display = 'none';
                imageInput.removeAttribute('required');
            } else {
                businessPermitSection.style.display = 'block';
                imageInput.setAttribute('required', 'required');
            }
        }

        const togglePassword = document.querySelector('#togglePassword');
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const password = document.querySelector('#password');
        const confirmPassword = document.querySelector('#password_confirm');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var preview = document.getElementById(previewId);
                    preview.style.display = 'block';
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('image').addEventListener('change', function () {
            readURL(this, 'business_permit_preview');
        });

        document.getElementById('profile_image').addEventListener('change', function () {
            readURL(this, 'profile_image_preview');
        });
    </script>
@endsection
