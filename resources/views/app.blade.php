<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trivalo Sourcing — Global Sourcing from China</title>
    <meta name="description" content="Trivalo Sourcing connects international businesses with verified Chinese manufacturers. Sourcing, quality control, and shipping — all under one roof.">
    <meta property="og:title" content="Trivalo Sourcing — Global Sourcing from China">
    <meta property="og:description" content="Your trusted sourcing partner in China. We handle everything from supplier discovery to doorstep delivery.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div id="app"></div>
</body>
</html>
