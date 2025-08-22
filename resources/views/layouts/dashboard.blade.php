<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Inventory System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-[#0a2a4d] text-white flex flex-col shadow-lg">
            <div class="p-6 text-center text-2xl font-bold border-b border-[#133a66]">
                Inventory System
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="block py-2.5 px-4 rounded-lg transition 
                   {{ request()->routeIs('dashboard') ? 'bg-[#133a66] text-white font-semibold' : 'hover:bg-[#133a66] hover:text-white' }}">
                    🏠 Dashboard
                </a>
                <a href="{{ route('disposable') }}"
                   class="block py-2.5 px-4 rounded-lg transition 
                   {{ request()->routeIs('disposable') ? 'bg-[#133a66] text-white font-semibold' : 'hover:bg-[#133a66] hover:text-white' }}">
                    📦 Disposable Items
                </a>
                <a href="{{ route('records') }}"
                   class="block py-2.5 px-4 rounded-lg transition 
                   {{ request()->routeIs('records') ? 'bg-[#133a66] text-white font-semibold' : 'hover:bg-[#133a66] hover:text-white' }}">
                    📑 Import Records
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="p-4">
                @csrf
                <button type="submit"
                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-500 transition">
                    🚪 Logout
                </button>
            </form>
        </aside>

        <!-- Main -->
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">@yield('title')</h1>
            @yield('content')
        </main>

    </div>
</body>
</html>