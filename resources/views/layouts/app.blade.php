<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config(
        'app.name',
        'TaytayOnline
                    ',
    ) }}</title>

    @if (!request()->is('login'))
        @vite(['resources/scss/category.scss'])
        @vite(['resources/scss/_section.scss'])
        @vite(['resources/scss/main.scss'])
        {{-- @vite(['resources/scss/_bootstrap.scss']) --}}
        @vite(['resources/scss/_businessHome.scss'])
        {{-- @vite(['resources/scss/custom.scss']) --}}
        @vite(['resources/scripts/script.js'])
        @vite(['resources/js/app.js'])
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-...." crossorigin="anonymous" />




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .form-control {
            color: #000 !important;
        }

        .btn-primary {
            background-color: #20acda !important;
            color: white !important;
            padding: 10px 20px !important;
            border: none !important;
            border-radius: 5px !important;
            font-family: Arial, sans-serif !important;
            font-size: 16px !important;
            transition: background-color 0.3s !important, box-shadow 0.3s !important, transform 0.5s !important;
        }


        .btn-primary:hover {
            background-color: #00000084 !important;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1) !important;
            transform: scale(1.05) !important;
        }

        .sectionCarousel{
            margin-top: -20px !important;
        }
        .py-4 {
    padding-top: 0rem !important;
    padding-bottom: 0rem !important;
}
    </style>
</head>

<body>
    <div id="app">



        <main class="py-4">
            @yield('content')
            @yield('scripts')
            @yield('styles')
        </main>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
