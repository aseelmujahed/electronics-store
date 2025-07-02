<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Electro Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased min-h-screen">
    <div class="flex flex-col items-center justify-center min-h-screen px-4">
        <div class="mb-8">

            <svg class="w-16 h-16 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24">
                <rect x="5" y="8" width="14" height="10" rx="2" fill="#3b82f6" />
                <rect x="9" y="3" width="6" height="5" rx="1" fill="#93c5fd" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">
            Welcome to Electro Store
        </h1>
        <p class="text-gray-600 text-base mb-8 text-center max-w-2xl">
            Discover the latest electronics and gadgets. Shop easily and securely!
        </p>

        @if (Route::has('login'))
        <div class="flex gap-6 mb-8">
            <a href="{{ route('login') }}"
                class="px-6 py-2 bg-blue-600 text-white text-base rounded-lg shadow hover:bg-blue-700 transition font-semibold">
                Login
            </a>
            <a href="{{ route('register') }}"
                class="px-6 py-2 bg-white text-blue-600 border border-blue-600 text-base rounded-lg shadow hover:bg-blue-50 transition font-semibold">
                Register
            </a>
        </div>

        @endif
</body>

</html>