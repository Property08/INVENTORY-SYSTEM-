<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Inventory System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-300">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-blue-300 flex flex-col shadow-xl">
            <div class="p-6 text-center text-xl font-extrabold tracking-wide border-b border-sky-500 text-black">
                ⚡ Inventory System
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition-all duration-200 border-l-4 
                   {{ request()->routeIs('dashboard') 
                        ? 'bg-sky-600 border-blue-500 text-black shadow-md font-semibold' 
                        : 'text-slate-300 border-transparent hover:bg-sky-500 hover:text-gray-500 hover:border-sky-300' }}">
                    🏠 <span>Dashboard</span>
                </a>

                 <a href="{{ route('rpcppe.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition-all duration-200 border-l-4
                   {{ request()->routeIs('rpcppe.*') 
                        ? 'bg-sky-600 border-blue-500 text-black shadow-md font-semibold' 
                        : 'text-slate-300 border-transparent hover:bg-sky-500 hover:text-gray-500 hover:border-sky-300' }}">
                    📊 <span>RPCPPE</span>
                </a>


                <a href="{{ route('disposable.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition-all duration-200 border-l-4
                   {{ request()->routeIs('disposable.*') 
                        ? 'bg-sky-600 border-blue-500 text-black shadow-md font-semibold' 
                        : 'text-slate-300 border-transparent hover:bg-sky-500 hover:text-gray-500  hover:border-sky-300' }}">
                    📦 <span>Disposable Items</span>
                </a>

                <a href="{{ route('recap.index') }}"
                    class="flex items-center gap-3 py-2.5 px-4 rounded-lg transition-all duration-200 border-l-4
                    {{ request()->routeIs('recap.*')
                        ? 'bg-sky-600 border-blue-500 text-black shadow-md font-semibold'
                        : 'text-slate-300 border-transparent hover:bg-sky-500 hover:text-gray-500 hover:border-sky-300' }}">
                    📑 <span>RECAP/SUMMARY</span>
                </a>


            </nav>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="p-4">
                @csrf
                <button type="submit"
                    class="w-full bg-red-600 text-white py-2 rounded-lg font-medium shadow hover:bg-red-500 transition-all duration-200">
                    🚪 Logout
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            
            

            <!-- Page Content -->
            <section class="flex-1 p-8 bg-slate-50">
                <div class="bg-white p-6 rounded-xl shadow-md border border-slate-200">
                    @yield('content')
                </div>
            </section>
        </main>

    </div>
</body>
</html>

