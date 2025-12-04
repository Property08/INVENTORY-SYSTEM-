<x-app-layout>
    <div class="min-h-screen bg-gray-100">
        <!-- Top Navbar -->
        <nav class="bg-blue-900 px-6 py-4 flex items-center justify-between shadow-md">
            <!-- Left Side Title -->
            <h1 class="text-2xl italic font-bold text-white">Inventory System</h1>

            <!-- Centered Navigation -->
            <div class="flex-1 flex justify-center">
                <div class="space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-gray-200 hover:text-white">HOME</a>
                    <a href="{{ route('rpcppe.index') }}" class="text-lg font-semibold text-gray-200 hover:text-white">RPCPPE</a>
                    <a href="{{ route('disposable.index') }}" class="text-lg font-semibold text-gray-200 hover:text-white">DISPOSABLE</a>
                    <a href="{{ route('recap.index') }}" class="text-lg font-semibold text-gray-200 hover:text-white">RECAP</a>
                    
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="relative" x-data="{ userMenu: false }">
                <button @click="userMenu = !userMenu"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-white hover:bg-blue-800 transition">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="userMenu" @click.away="userMenu = false"
                    x-transition
                    class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-6xl bg-white p-10 rounded-2xl shadow-lg">
                
                <!-- Header -->
                <h2 class="text-3xl font-bold mb-4 text-center text-[#0a2a4d]">
                    Welcome to the Inventory System
                </h2>
                <p class="text-gray-600 text-center mb-10">
                    Manage your items with ease. Navigate through the modules below.
                </p>

                <!-- ✅ Quick Stats Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-blue-800 text-black rounded-xl p-6 shadow-md">
                        <h3 class="text-2xl font-bold">120</h3>
                        <p>Total Disposable Items</p>
                    </div>
                    <div class="bg-green-600 text-white rounded-xl p-6 shadow-md">
                        <h3 class="text-2xl font-bold">35</h3>
                        <p>RECAP/SUMMARY</p>
                    </div>
                    <div class="bg-indigo-600 text-white rounded-xl p-6 shadow-md">
                        <h3 class="text-2xl font-bold">5</h3>
                        <p>Active Users</p>
                    </div>
                </div>

                <!-- Cards Section -->

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                

                 <!-- System Overview Card -->
                    <div class="bg-gray-50 shadow-md rounded-xl p-6 hover:shadow-lg transition">
                        <div class="text-4xl mb-3">📊</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#001F3F]">RPCPPE</h3>
                        <p class="text-gray-600">Quick summary of your inventory activities.</p>
                        <a href="{{ route('rpcppe.index') }}" 
                           class="text-[#001F3F] font-medium hover:underline mt-3 inline-block">
                           Go to RPCPPE →
                        </a>
                    </div>

                    <!-- Disposable Items Card -->
                    <div class="bg-gray-50 shadow-md rounded-xl p-6 hover:shadow-lg transition">
                        <div class="text-4xl mb-3">📦</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#0a2a4d]">Disposable Items</h3>
                        <p class="text-gray-600">Track and manage all disposable items efficiently.</p>
                        <a href="{{ route('disposable.index') }}" 
                           class="text-[#001F3F] font-medium hover:underline mt-3 inline-block">
                           Go to Storage →
                        </a>
                    </div>

                    <!-- Import Records Card -->
                    <div class="bg-gray-50 shadow-md rounded-xl p-6 hover:shadow-lg transition">
                        <div class="text-4xl mb-3">📑</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#001F3F]">RECAP/SUMMARY</h3>
                        <p class="text-gray-600">View the RECAP/SUMMARY of your records.</p>
                        <a href="{{ route('recap.index') }}" 
                           class="text-[#001F3F] font-medium hover:underline mt-3 inline-block">
                           RECAP/SUMMARY →
                        </a>
                    </div>

                </div>
            </div>
        </main>
    </div>
</x-app-layout>
