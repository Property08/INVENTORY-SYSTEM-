<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PPGSS - AD PROPERTY INVENTORY SYSTEM</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gradient-to-br from-gray-100 to-gray-300 dark:from-gray-900 dark:to-gray-800">
    <div class="flex flex-col items-center justify-center min-h-screen px-6">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white tracking-wide">
                PPGSS - AD PROPERTY INVENTORY SYSTEM
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Manage property inventory efficiently and securely</p>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 w-full max-w-md">
            @if (Route::has('login'))
                <div class="flex flex-col space-y-4 text-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition">
                            Log In
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-10 text-sm text-gray-600 dark:text-gray-400">
            &copy; {{ date('Y') }} PPGSS. All rights reserved.
        </div>

    </div>
</body>
</html>
