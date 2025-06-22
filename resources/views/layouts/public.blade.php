<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Campaign Codex')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-900">
    <header class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold">Campaign Codex</a>
            <nav>
                <a href="{{ route('items.index') }}" class="text-sm text-gray-700 hover:underline">Items</a>
            </nav>
        </div>
    </header>

    <main class="flex-grow container mx-auto my-8">
        @yield('content')
    </main>

    <footer class="bg-white border-t p-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Campaign Codex
    </footer>
</body>
</html>
