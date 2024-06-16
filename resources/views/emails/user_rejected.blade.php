<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Rejected</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>

    <p>We regret to inform you that your account has been rejected for the following reason:</p>

    <blockquote>{{ $user->rejection_details }}</blockquote>

    <p>If you have any questions or concerns, please feel free to contact us.</p>

    <p>Thank you,</p>
    <p>The Admin Team</p>
</body>
</html>
