@extends('layouts.master')

@section('manageUsersCreate')
<style>
     #togglePassword,
#toggleConfirmPassword {
    cursor: pointer;
    margin-right: 10px;
    margin-top: -30px;
    margin-bottom: 40px;
    position: relative;
    float: right;
}

#togglePassword:hover,
#toggleConfirmPassword:hover {
    color: #0056b3;
}

input::-ms-reveal,
      input::-ms-clear {
        display: none;
      }
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Create User
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <script>
                                // JavaScript to automatically go back to previous page on validation error, with a 1-second delay
                                if (window.history && window.history.length > 1) {
                                    // Check if sessionStorage flag is set
                                    if (!sessionStorage.getItem('backNavigated')) {
                                        // Set sessionStorage flag to prevent subsequent back navigations
                                        sessionStorage.setItem('backNavigated', true);
                                        setTimeout(function() {
                                            window.history.back();
                                        }, 1000); // 1000 milliseconds = 1 second
                                    }
                                }
                            </script>

                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

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
                                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password">
                                <i id="togglePassword" class="fas fa-eye"></i>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input placeholder="Confirm Password" id="password_confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="new-password">
                                <i id="toggleConfirmPassword" class="fas fa-eye"></i>
                            </div>

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control" onchange="toggleBusinessPermitSection(this.value)" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="business">Business</option>
                                </select>
                            </div>

                            <div id="business_permit_section" class="form-group" style="display: {{ old('type') == 'business' ? 'block' : 'none' }};">
                                <label for="image">Permit</label>
                                <input type="file" name="image" id="image" class="form-control-file" {{ old('type') == 'business' ? 'required' : '' }}>
                            </div>

                            <!-- Add profile image field -->
                            <div class="mb-3 row align-items-center">
                                <label for="profile_image" class="col-md-4 col-form-label text-md-center label-custom"><b>Profile</b></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="profile_image" type="file" class="form-control file-input @error('profile_image') is-invalid @enderror" name="profile_image" {{ old('profile_image') ? '' : 'required' }}>
                                        <label class="input-group-text btn btn-primary" for="profile_image"><i class="fas fa-upload"></i> Choose File</label>
                                    </div>
                                    @if (old('profile_image'))
                                        <img src="{{ old('profile_image') }}" alt="Profile Image" class="img-thumbnail mt-2" width="100">
                                    @endif
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

@section('scripts')
    <script>
        // Function to handle toggle between user and business type and display image preview
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

    </script>
@endsection
