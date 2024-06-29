<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto Condensed', sans-serif;
            background-color: #0077cc;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 10vh;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0099ff" fill-opacity="1" d="M0,192L80,165.3C160,139,320,85,480,80C640,75,800,117,960,144C1120,171,1280,181,1360,186.7L1440,192L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path></svg>');
            z-index: 1;
            animation: wave 20s infinite linear;
        }

        .circle {
            z-index: -1;
            border-radius: 50%;
            background: linear-gradient(135deg, transparent 20%, #142992);
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scale(1);
            width: 200px;
            height: 200px;
            animation: circle 10s infinite ease-in-out;
        }

        .circle.one {
            width: 130px;
            height: 130px;
            top: 10vh;
            right: -40px;
        }

        .circle.two {
            width: 80px;
            height: 80px;
            top: 10vh;
            right: 30px;
        }

        @keyframes wave {
            0% {
                transform: translateY(-5px);
            }

            50% {
                transform: translateY(5px);
            }

            100% {
                transform: translateY(-5px);
            }
        }

        @keyframes circle {
            0% {
                transform: translateX(-50%) scale(1);
            }

            50% {
                transform: translateX(-50%) scale(1.05);
            }

            100% {
                transform: translateX(-50%) scale(1);
            }
        }

        /* Adjustments for responsiveness */
        @media (max-width: 480px) {

            /* Reduce margin for smaller screens */
            form {
                margin: 20px;
            }

            /* Adjust image preview styling */
            #image-preview {
                max-width: 100%;
                /* Ensure image fits within form */
                height: auto;
                /* Maintain aspect ratio */
                margin-top: 10px;
                /* Add some spacing */
            }
        }

        @media (min-width: 768px) {

            /* Center image preview horizontally */
            #image-preview {
                display: block;
                margin: 0 auto;
                max-width: 100%;
                /* Ensure image fits within form */
                height: auto;
                /* Maintain aspect ratio */
                margin-top: 20px;
                /* Add some spacing */
            }
        }

        /* Form styles */
        h1 {
            color: #fff;
            text-align: center;
            margin-top: 0;
            font-size: 2rem;
            font-weight: 500;
        }

        form {
            max-width: 90%;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #0099ff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        @media (min-width: 768px) {
            form {
                max-width: 500px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                margin-top: 10vh;
                font-size: 1.5rem;
            }

            input[type="text"],
            input[type="file"] {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Wave pattern -->
    <div class="wave"></div>
    <!-- Circle effect -->
    <div class="circle"></div>
    <div style="margin: 9em" class="circle"></div>
    <div style="margin: -9em" class="circle"></div>

    <!-- Your HTML content -->
    <h1>Update Account Details</h1>

    @if (session('success'))
        <div style="text-align: center;">
            <div
                style="background-color: white; color: green; font-weight: bold; font-size: larger; text-align: center; padding: 10px; border-radius: 10px; display: inline-block;">
                {{ session('success') }}
            </div>
        </div>
    @endif



    @if ($errors->any())
        <div style=" text-align: center; ">
            <ul style="list-style: none">
                @foreach ($errors->all() as $error)
                    <li><b style="background-color: #fff; color: red; border-radius:1px; width:70%; height:40px;">
                            {{ $error }}</b></li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('post_update_account_details') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Display rejection details -->
        <div style="color: #000000e5; text-align: center; margin-top: 2rem;">
            <h2 style="margin-bottom: 1rem; font-size: 1.5rem; font-family: 'Roboto Condensed', sans-serif;">Rejection
                Details:</h2>
            <b style="background-color: #fff; color: red; border-radius:1px; width:70%; height:40px;">
                {{ $rejectionDetails }}</b>
        </div>

        <div>
            <label for="name">Business Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="image">New Permit Image:</label>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
            <img id="image-preview" src="#" alt="Image Preview" style="display: none;">
        </div>

        <button type="submit">Update</button>
    </form>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('image-preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
