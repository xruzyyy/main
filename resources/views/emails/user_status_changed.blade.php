<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Account Status Changed</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>

    <p>Your account status has been changed.</p>
    <p>Status: {{ $statusMessage }}</p>

    <p>You can login to your account <a href="{{ route('login') }}">here</a>.</p>

    <p>Thank you,</p>
    <p>Your Application Team</p>
</body>
</html>
