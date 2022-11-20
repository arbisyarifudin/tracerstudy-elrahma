<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    {{-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> --}}
</head>
<body>

    <div id="app">
        <app-component></app-component>
    </div>

    {{-- <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script> --}}
    @vite(['node_modules/tw-elements/dist/js/index.min.js'])
</body>
</html>

