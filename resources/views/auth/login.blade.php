    @extends('layouts.app')
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const signUpButton = document.getElementById('signUp');
                const signInButton = document.getElementById('signIn');
                const signUpViewButton = document.getElementById('signUpView');
                const signInViewButton = document.getElementById('signInView');
                const container = document.getElementById('container');

                // Function to handle sign-up button click
                signUpViewButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent default link behavior
                    container.classList.add("right-panel-active");
                });

                // Function to handle sign-in button click
                signInViewButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent default link behavior
                    container.classList.remove("right-panel-active");
                });


                // Function to display image preview when a file is selected
                function displayImagePreview(input, preview) {
                    var imageFile = input.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.parentNode.style.display = 'block'; // Show image preview container
                    };
                    reader.readAsDataURL(imageFile);
                }

                // Event listener for Business Permit image input
                document.getElementById('image').addEventListener('change', function() {
                    displayImagePreview(this, document.getElementById('image_preview_business'));
                });

                // Event listener for Profile Image input
                document.getElementById('profile_image').addEventListener('change', function() {
                    displayImagePreview(this, document.getElementById('image_preview_profile'));
                });

                // Trigger initial toggle based on the default selected type
                toggleBusinessPermitSection(document.getElementById('type').value);
            });
            // Function to handle toggle between user and business type and display image preview
            function toggleBusinessPermitSection(userType) {
                var businessPermitSection = document.getElementById('business_permit_section');
                var imageInput = document.getElementById('image');
                var nameInput = document.getElementById('name');

                if (userType === 'user') {
                    businessPermitSection.style.display = 'none';
                    imageInput.removeAttribute('required');
                    nameInput.placeholder = 'Name'; // Set placeholder to 'Name' for user type
                } else {
                    businessPermitSection.style.display = 'block';
                    imageInput.setAttribute('required', 'required');
                    nameInput.placeholder = 'Business Name'; // Set placeholder to 'Business Name' for business type
                }
            }
        </script>
    @endsection
    @section('styles')
        <style>
            @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

            * {
                box-sizing: border-box;
            }

            .body {
                background: #f6f5f7;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                font-family: 'Montserrat', sans-serif;
                height: 100vh;
                margin: -20px 0 50px;
            }

            h1 {
                font-weight: bold;
                margin: 0;
            }

            h2 {
                text-align: center;
            }

            p {
                font-size: 14px;
                font-weight: 100;
                line-height: 20px;
                letter-spacing: 0.5px;
                margin: 20px 0 30px;
            }

            span {
                font-size: 12px;
            }

            a {
                color: #333;
                font-size: 14px;
                text-decoration: none;
                margin: 15px 0;
            }

            button {
                border-radius: 20px;
                border: 1px solid #FF4B2B;
                background-color: #FF4B2B;
                color: #FFFFFF;
                font-size: 12px;
                font-weight: bold;
                padding: 12px 45px;
                letter-spacing: 1px;
                text-transform: uppercase;
                transition: transform 80ms ease-in;
            }

            button:active {
                transform: scale(0.95);
            }

            button:focus {
                outline: none;
            }

            button.ghost {
                background-color: transparent;
                border-color: #FFFFFF;
            }

            form {
                background-color: #FFFFFF;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                padding: 0 50px;
                height: 90%;
                text-align: center;
            }

            input {
                background-color: #eee;
                border: none;
                padding: 12px 15px;
                margin: 8px 0;
                width: 100%;
            }

            .container {
                border-radius: 5px;
                background-color: #fff;
                box-shadow: 0 14px 28px rgba(255, 255, 255, 0.25),
                    0 10px 10px rgba(0, 0, 0, 0.22);
                position: relative;
                overflow: hidden;
                height: 90vh;
                width: 1068px;
                max-width: 100%;
                min-height: 480px;
            }

            .form-container {
                position: absolute;
                top: 0;
                height: 100%;
                transition: all 0.6s ease-in-out;
            }

            .sign-in-container {

                left: 0;
                width: 50%;
                z-index: 2;
            }

            .container.right-panel-active .sign-in-container {
                transform: translateX(100%);
            }

            .sign-up-container {
                left: 0;
                width: 50%;
                opacity: 0;
                z-index: 1;
                height: 120;
            }

            .container.right-panel-active .sign-up-container {
                transform: translateX(100%);
                opacity: 1;
                z-index: 5;
                animation: show 0.6s;
            }

            @keyframes show {

                0%,
                49.99% {
                    opacity: 0;
                    z-index: 1;
                }

                50%,
                100% {
                    opacity: 1;
                    z-index: 5;
                }
            }

            .overlay-container {
                border-radius: 0px;
                position: absolute;
                top: 0;
                left: 50%;
                width: 50%;
                height: 100%;
                overflow: hidden;
                transition: transform 0.6s ease-in-out;
                z-index: 100;
            }

            .container.right-panel-active .overlay-container {
                transform: translateX(-100%);
            }

            .overlay {
                background: #FF416C;
                background: -webkit-linear-gradient(to right, #4f8dff, #110f10);
                background: linear-gradient(to right, #030303, #0a73eb);
                background-repeat: no-repeat;
                background-size: cover;
                background-position: 0 0;
                color: #FFFFFF;
                position: relative;
                left: -100%;
                height: 100%;
                width: 200%;
                transform: translateX(0);
                transition: transform 0.6s ease-in-out;
            }

            .container.right-panel-active .overlay {
                transform: translateX(50%);
            }

            .overlay-panel {
                position: absolute;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                padding: 0 40px;
                text-align: center;
                top: 0;
                height: 100%;
                width: 50%;
                transform: translateX(0);
                transition: transform 0.6s ease-in-out;
            }

            .overlay-left {
                transform: translateX(-20%);
            }

            .container.right-panel-active .overlay-left {
                transform: translateX(0);
            }

            .overlay-right {
                right: 0;
                transform: translateX(0);
            }

            .container.right-panel-active .overlay-right {
                transform: translateX(20%);
            }

            .social-container {
                margin: 20px 0;
            }

            .social-container a {
                border: 1px solid #DDDDDD;
                border-radius: 50%;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                margin: 0 5px;
                height: 40px;
                width: 40px;
            }

            footer {
                background-color: #222;
                color: #fff;
                font-size: 14px;
                bottom: 0;
                position: fixed;
                left: 0;
                right: 0;
                text-align: center;
                z-index: 999;
            }

            footer p {
                margin: 10px 0;
            }

            footer i {
                color: red;
            }

            footer a {
                color: #3c97bf;
                text-decoration: none;
            }

            .ghost {
                display: inline-block;
                padding: 10px 20px;
                margin-top: 20px;
                border: 2px solid #fff;
                border-radius: 25px;
                background: transparent;
                color: #fff;
                font-size: 16px;
                text-transform: uppercase;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }

            .ghost:hover {
                background-color: #fff;
                color: #333;
            }

            .file-input {
                display: none;
            }

            .input-group-text {
                cursor: pointer;
            }

            .input-group-text:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }

            .select-custom {
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                padding: 0.5rem 2rem 0.5rem 1rem;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
                background-color: #fff;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23000000' width='18px' height='18px'%3e%3cpath d='M7 10l5 5 5-5H7z'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right 0.7rem top 50%;
                background-size: 1.5em auto;
                color: #495057;
            }

            .select-custom:hover {
                border-color: #80bdff;
            }

            .select-custom:focus {
                border-color: #80bdff;
                outline: none;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }
        </style>
    @endsection
    @section('content')

        <div style="margin-top: 2em;" class="container" id="container">
            <div class="form-container sign-up-container">
                <form style="height: 100%;" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <h1>Create Account</h1>
                    <div class="mb-3 row align-items-center">
                        <label for="type" class="col-md-4 col-form-label text-md-end label-custom"><b>Type:</b><i
                                class="fas fa-user"></i></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select style="width: 12em;" id="type"
                                    class="form-select select-custom @error('type') is-invalid @enderror" name="type"
                                    required onchange="toggleBusinessPermitSection(this.value)">
                                    <option value="business" {{ old('type') == 'business' ? 'selected' : '' }}>Business
                                    </option>
                                    <option value="user" {{ old('type') == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input placeholder="{{ old('type') === 'business' ? 'Business Name' : 'Name' }}" id="name"
                        type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input placeholder="Email" id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                        required autocomplete="email">


                    <input placeholder="Password" id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control"
                        name="password_confirmation" required autocomplete="new-password">
                    <!-- Image Upload for Business Permit -->
                    <div class="mb-3 row align-items-center" id="business_permit_section"
                        style="display: {{ old('type') == 'user' ? 'none' : 'block' }}">
                        <!-- <label for="image" class="col-md-4 col-form-label text-md-center label-custom"
                            style="margin-right: 1.5em;"><b>Permit <span style="color: red;">Required</span></b></label> -->
                        <div class="col-md-6">
                            <div class="input-group">
                                <input id="image" type="file"
                                    class="form-control file-input @error('image') is-invalid @enderror" name="image"
                                    value="{{ old('image') }}" required>
                                <label class="input-group-text btn btn-primary" for="image"><i class="fas fa-upload"></i>
                                    Upload A Permite <span style="color: red;">Required</span> </label>
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                    <!-- Image Upload for Profile Image -->
                    <div class="mb-3 row align-items-center" id="profile_image_section">
                        <div class="profile_image col-md-6">
                            <div class="input-group">
                                <input id="profile_image" type="file"
                                    class="form-control file-input @error('profile_image') is-invalid @enderror"
                                    name="profile_image" required>
                                <label class="input-group-text btn btn-primary " for="profile_image"><i
                                        class="fas fa-upload"></i> Choose a Profile<span style="color: red;">Required</span></label>
                            </div>
                            @error('profile_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </form>
            </div>


            <div class="form-container sign-in-container">
                @if ($errors->has('email_verification'))
                    <div class="alert alert-danger mt-4">
                        <ul>
                            <li>{{ $errors->first('email_verification') }}</li>
                            <li>
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link">{{ __('Request another one') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                    @csrf
                    <h1>Sign in</h1>

                    <input placeholder="Email" id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email" autofocus>




                    <input placeholder="Password" id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                    </label>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif


                    @if ($errors->any())
                        <div class="alert alert-danger mt-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    @unless ($error == $errors->first('email_verification'))
                                        <li>{{ $error }}</li>
                                    @endunless
                                @endforeach
                                @error('email_verification')
                                    <li>
                                        {{-- <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-link">{{ __('Request another one') }}</button>
                                        </form> --}}
                                        <a {{ route('verification.notice') }}>{{ $message }}</a>
                                    </li>
                                @enderror
                            </ul>
                        </div>
                    @endif

            </div>
            </form>
                @endif


                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>Welcome Back!</h1>
                            <p style="font-family: Arial, sans-serif;">To keep connected with us please login with your
                                personal
                                info</p>

                            <div class="image-preview" style="display: none;">
                                <img id="image_preview_business" src="#" style="max-width: 100px; height: 200px;">
                                <img id="image_preview_profile" src="#"
                                    style="max-width: 200px; height: 200px; border-radius:50%;">
                            </div>

                            <a class="nav-link" id="signInView" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Hello, There!</h1>
                            <p style="font-family: Arial, sans-serif;">Enter your personal details and explore legit
                                businesses
                            </p>
                            <a class="nav-link" id="signUpView" href="{{ route('login') }}">{{ __('Register') }}</a>
                        </div>
                    </div>
                </div>


            </div>
        @endsection
