<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Updated</title>
</head>
<body>
    <h2>Hello Admin,</h2>

    <p>The account with the email address <strong>{{ $user->email }}</strong> has been updated from Rejection Status Details.</p>

    <p>Name: {{ $user->name }}</p>

    <p>You can view the user's profile by logging in to the admin panel.</p>

    <p>Thank you!</p>
</body>
</html>
