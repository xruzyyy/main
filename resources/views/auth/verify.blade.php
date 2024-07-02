<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1c1c1c, #9ea1a3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .verification-card {
            animation: fadeIn 0.7s ease-in-out;
            background: #333;
            border-radius: 15px;
            box-shadow: 15px 15px 45px #1a1a1a, -15px -15px 45px #474747;
            border: 1px solid #444;
            width: 85%;
            max-width: 380px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background-color: #ff6b6b;
            color: #fff;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
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

        .btn-secondary {
            background-color: #ff6b6b;
            color: #fff;
            border-radius: 5px;
            padding: 10px 25px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #e55a5a;
        }

        .btn-secondary:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="verification-card">
        <div class="card-header">Email Verification In Progress</div>

        <div class="card-body">
            <h1 style="color:tomato;">If you already verified your account by clicking the link, <b style="color:rgb(32, 218, 63);"> Reopen the verify link.</b></h1>
            <p>Once verification is complete, you will be able to proceed.</p>
            <p>If you haven't received the verification email after a few minutes, you can request another.</p>
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn-secondary">Resend Verification Email</button>
            </form>
        </div>
    </div>

    <script>
        function exitBrowser() {
            window.open('', '_self', '');
            window.close();
        }
    </script>
</body>
</html>
