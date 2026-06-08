<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Career Tracker') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-[#F8F9FD] font-sans text-[#191C1F] antialiased">

    <div class="flex h-screen overflow-hidden">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">

            @include('layouts.topbar')

            <main class="flex-1 overflow-y-auto p-8">

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>