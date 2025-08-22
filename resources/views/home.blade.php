<x-app-layout>
    <!-- Home Page Content -->
    <div class="min-h-screen bg-gray-100">
        <!-- Top Navbar -->
        <nav class="bg-blue-900 px-6 py-4 flex justify-between items-center shadow-md">
            <!-- Left Side Title -->
            <h1 class="text-2xl italic font-bold text-white">Inventory System</h1>

            <!-- Centered Navigation -->
            <div class="flex-1 flex justify-center">
                <div class="space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-black hover:text-gray-800">Home</a>
                    <a href="{{ route('disposable') }}" class="text-lg font-semibold text-black hover:text-gray-800">Disposable</a>
                    <a href="{{ route('records') }}" class="text-lg font-semibold text-black hover:text-gray-800">Records</a>
                </div>
            </div>
        </nav>
       
        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-6xl bg-white p-10 rounded-2xl shadow-lg">
                
                <!-- Header -->
                <h2 class="text-3xl font-bold mb-4 text-center text-[#0a2a4d]">Welcome to the Inventory System</h2>
                <p class="text-gray-600 text-center mb-10">
                    Manage your items with ease. Navigate through the modules below.
                </p>

                <!-- ✅ Quick Stats Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-[#0a2a4d] text-white rounded-xl p-6 shadow-md">
                        <h3 class="text-2xl font-bold">120</h3>
                        <p class="text-gray-200">Total Disposable Items</p>
                    </div>
                    <div class="bg-green-600 text-white rounded-xl p-6 shadow-md">
                        <h3 class="text-2xl font-bold">35</h3>
                        <p class="text-gray-200">Import Records</p>
                    </div>
                    <div class="bg-indigo-600 text-white rounded-xl p-6 shadow-md">
                        <h3 class="text-2xl font-bold">5</h3>
                        <p class="text-gray-200">Active Users</p>
                    </div>
                </div>

                <!-- Cards Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    
                    <!-- Disposable Items Card -->
                    <div class="bg-gray-50 shadow-md rounded-xl p-6 hover:shadow-lg transition">
                        <div class="text-4xl mb-3">📦</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#0a2a4d]">Disposable Items</h3>
                        <p class="text-gray-600">Track and manage all disposable items efficiently.</p>
                        <a href="{{ route('disposable') }}" 
                           class="text-[#0a2a4d] font-medium hover:underline mt-3 inline-block">
                           Go to Storage →
                        </a>
                    </div>

                    <!-- Import Records Card -->
                    <div class="bg-gray-50 shadow-md rounded-xl p-6 hover:shadow-lg transition">
                        <div class="text-4xl mb-3">📑</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#0a2a4d]">Import Records</h3>
                        <p class="text-gray-600">View and manage your history of imported records.</p>
                        <a href="{{ route('records') }}" 
                           class="text-[#0a2a4d] font-medium hover:underline mt-3 inline-block">
                           View Records →
                        </a>
                    </div>

                    <!-- System Overview Card -->
                    <div class="bg-gray-50 shadow-md rounded-xl p-6 hover:shadow-lg transition">
                        <div class="text-4xl mb-3">📊</div>
                        <h3 class="text-xl font-semibold mb-2 text-[#0a2a4d]">System Overview</h3>
                        <p class="text-gray-600">Quick summary of your inventory activities.</p>
                        <a href="{{ route('dashboard') }}" 
                           class="text-[#0a2a4d] font-medium hover:underline mt-3 inline-block">
                           Go to Dashboard →
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>