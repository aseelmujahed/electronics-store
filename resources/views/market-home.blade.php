<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Electronics Market</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center">
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-lg w-full text-center">
        <h1 class="text-3xl font-bold mb-6 text-blue-700">Electronics Market</h1>
        <p class="mb-8 text-gray-600">Choose your electronics store:</p>
        <div class="flex flex-row gap-4 justify-center flex-wrap">
            @forelse($stores as $store)
            <a href="http://{{ $store->id }}.localhost:8000/welcome"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded shadow transition text-lg"
                target="_blank">
                {{ ucfirst($store->id) }}
            </a>
            @empty
            <span class="text-gray-400">No stores found.</span>
            @endforelse
        </div>

        <div class="mt-10 text-xs text-gray-400">More stores coming soon.</div>
    </div>
</body>

</html>