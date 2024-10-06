<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/mapbox.js'])
        <style>
            #map {
                height: 100vh;
                width: 100vw;
            }
            .mapboxgl-ctrl { background: white; }
            /* Side panel styles */
            #side-panel {
                position: absolute;
                top: 0;
                left: -25%; /* Hidden by default */
                width: 25%;
                height: 100%;
                background-color: rgb(31 41 55 / var(--tw-bg-opacity));
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
                transition: left 0.3s ease; /* Slide animation */
                padding: 20px;
                overflow-y: auto;
                color: #ffffff;
            }

            /* Side panel visible state */
            #side-panel.active {
                left: 0; /* Slide in when active */
            }

            /* Popup content */
            .popup-content {
                max-width: 200px;
            }

            h3 {
                margin-top: 0;
            }
            /* Pulse animation */
            .pulse-marker {
                width: 20px;
                height: 20px;
                background-color: rgba(255, 100, 100, 1); /* Marker color */
                border-radius: 50%;
                position: relative;
                box-shadow: 0 0 15px rgba(255, 100, 100, 0.5);
            }
            
            /* The animated pulse effect */
            .pulse-marker::before {
                content: "";
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: rgba(255, 100, 100, 0.5); /* Pulse color */
                position: absolute;
                top: -10px;
                left: -10px;
                animation: pulse 1.5s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(0.5);
                    opacity: 1;
                }
                100% {
                    transform: scale(1.5);
                    opacity: 0;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
