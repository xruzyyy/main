<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #000000, #eef2f3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .authentication-card {
            animation: fadeIn 0.5s ease-in-out;
            background: #f0f3f5;
            border-radius: 20px;
            box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
            border: 1px solid #ddd;
            width: 90%;
            max-width: 400px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background-color: #6759fb;
            color: #fff;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            padding: 15px;
            text-align: center;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        p {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #6759fb;
            color: #fff;
            border-radius: 5px;
            padding: 12px 30px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #4b3ca7;
        }

        .btn-primary:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="authentication-card">
        <div class="card-header">Verify Your Email Address</div>

        <div class="card-body">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            <p>Before proceeding, please check your email for a verification link, and open the link in the same browser.</p>
            <p>If you did not receive the email</p>
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn-primary">Click here to request another</button>.
            </form>
        </div>
    </div>
</body>
</html>
