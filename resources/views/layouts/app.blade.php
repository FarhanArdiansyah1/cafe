<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .vertical-scrollable>.row {
            height: 300px;
            overflow-y: scroll;
        }

    </style>
    <livewire:styles />
</head>

<body class="font-sans antialiased bg-light">
    <livewire:scripts />
    @include('layouts.navigation')

    <!-- Page Content -->
    <main class="container my-5">
        {{ $slot }}
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src={{ asset('bootstrap/js/bootstrap.bundle.min.js') }}></script>
</body>

</html>
