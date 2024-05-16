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
                    <p>Account Type:{{ $user->type }}</p>
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


                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Name</label>
                        <div class="col-md-8">
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required disabled>
                            <small class="text-muted">You cannot edit your name.</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label">Email</label>
                        <div class="col-md-8">
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">Password</label>
                        <div class="col-md-8">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-md-3 control-label">Confirm Password</label>
                        <div class="col-md-8">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImages(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('imagePreviews');
            previewContainer.src = URL.createObjectURL(files[0]);
            previewContainer.onload = function() {
                URL.revokeObjectURL(previewContainer.src);
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
