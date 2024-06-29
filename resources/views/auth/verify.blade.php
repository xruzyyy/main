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

        .btn-secondar

        y {
            background-color: #ff6b6b;
            color: #fff;
            border-radius: 5px;
            padding: 10px 25px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 5px;
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
            <h3 style="color: tomato;">After proceed please make sure to update your profile</h3>
            <p>Please click the button below to verify your email address and proceed.</p>
            <form method="POST" action="{{ route('verification.verify-manually') }}">
                @csrf
                <button type="submit" class="btn-secondary">Verify Now</button>
            </form>
        </div>
    </div>
</body>
</html>
