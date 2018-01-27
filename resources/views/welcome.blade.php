<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('/homes/css/app.css') }}" rel="stylesheet">
</head>
<body>

<div id="app">
    <app></app>
</div>

<!-- Scripts -->
<script src="{{ asset('/homes/js/app.js') }}"></script>
</body>
</html>
