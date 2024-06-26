<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .control-label {
            text-align: left !important;
        }
    </style>
</head>

<body>

    <form action="{{ route('businessUsers.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container">

            <h1>Edit Profile</h1>
            <hr>
            <div class="row">
                <!-- Left column for profile -->
                <div class="col-md-3">
                    <div class="text-center">
                        <img src="{{ $user->profile_image ? asset('/' . $user->profile_image) : 'https://png.pngitem.com/pimgs/s/150-1503945_transparent-user-png-default-user-image-png-png.png' }}" id="imagePreviews" class="avatar img-circle" alt="avatar">
                        <h6>Upload a different Profile...</h6>
                        <input type="file" name="profile_image" id="profile_image" class="form-control" onchange="previewImages(event)">
                        <hr>
                        <h4>Account Expiration Date:</h4>
                        <p>{{ $user->account_expiration_date ? \Carbon\Carbon::parse($user->account_expiration_date)->format('F j, Y, g:i a') : 'N/A' }}</p>
                        <p>Account Type: {{ $user->type }}</p>
                        @if(isset($post))
                        <a href="{{ route('businessPost', ['id' => $post->id]) }}">Your Post</a>
                        @else
                        <p>No post found</p>
                        @endif
                    </div>
                </div>
                <!-- Edit form column -->
                <div class="col-md-9 personal-info">
                    @if(session('status'))
                    <div class="alert alert-success alert-dismissable">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissable">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label for="name" class="col-md-3 control-label">Name</label>
                        <div class="col-md-8">
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required disabled>
                            <small class="text-muted">You cannot edit your name.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3 control-label">Email</label>
                        <div class="col-md-8">
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                            <small class="text-muted">You cannot update or edit your email.</small>
                        </div>
                    </div>


                    <!-- Password Fields -->
                    <div class="form-group row">
                        <label for="current_password" class="col-md-3 control-label">Current Password</label>
                        <div class="col-md-8">
                            <input type="password" name="current_password" id="current_password" class="form-control">
                            <small class="text-muted">Enter current password to change password</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-3 control-label">New Password</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" aria-describedby="password-addon">
                                <span class="input-group-addon" id="password-addon">
                                    <span class="glyphicon glyphicon-eye-open" id="password-toggle" style="cursor: pointer;"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-3 control-label">Confirm New Password</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" aria-describedby="confirm-password-addon">
                                <span class="input-group-addon" id="confirm-password-addon">
                                    <span class="glyphicon glyphicon-eye-open" id="confirm-password-toggle" style="cursor: pointer;"></span>
                                </span>
                            </div>
                            <div id="password-validation-message" class="text-danger"></div>
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-default" onclick="location.href='{{ route('business.home') }}'">Cancel</button>
                        </div>
                    </div>
    </form>
    </div>
    </div>
    </div>

    @if(isset($post))
    <form action="{{ route('businessPost.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container">
            <div class="form-group row">
                <label for="description" class="col-md-3 control-label">Description:</label>
                <div class="col-md-8">
                    <textarea class="form-control" id="description" name="description" rows="3">{{ $post->description }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="contact_number" class="col-md-3 control-label">Contact Number:</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ $post->contactNumber }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </div>
            </div>
        </div>
    </form>
    @else
    <p>No post to update.</p>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#password-toggle').click(function() {
                var passwordInput = $('#password');
                var passwordToggle = $('#password-toggle');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    passwordToggle.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                } else {
                    passwordInput.attr('type', 'password');
                    passwordToggle.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                }
            });

            $('#confirm-password-toggle').click(function() {
                var confirmPasswordInput = $('#password_confirmation');
                var confirmPasswordToggle = $('#confirm-password-toggle');

                if (confirmPasswordInput.attr('type') === 'password') {
                    confirmPasswordInput.attr('type', 'text');
                    confirmPasswordToggle.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                } else {
                    confirmPasswordInput.attr('type', 'password');
                    confirmPasswordToggle.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                }
            });

            $('#password_confirmation').on('keyup', function() {
                var newPassword = $('#password').val();
                var confirmPassword = $(this).val();

                if (newPassword != confirmPassword) {
                    $('#password-validation-message').html('Passwords do not match');
                } else {
                    $('#password-validation-message').html('');
                }
            });
        });

        function previewImages(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('imagePreviews');
            previewContainer.src = URL.createObjectURL(files[0]);
            previewContainer.onload = function() {
                URL.revokeObjectURL(previewContainer.src);
            }
        }
    </script>

</body>

</html>