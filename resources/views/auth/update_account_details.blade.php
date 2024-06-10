<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account Details</title>
</head>
<body>
    <h1>Update Account Details</h1>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('post_update_account_details') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Business Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="image">New Permit Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit">Update</button>
    </form>
</body>
</html>
