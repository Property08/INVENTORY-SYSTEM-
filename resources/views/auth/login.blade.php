<x-guest-layout>
    <!-- Login Card -->
   <body class="antialiased bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-md">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-center text-gray-900">Welcome back</h2>
        <p class="text-center text-gray-500 mb-8">Welcome back! Please enter your details.</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm text-center">{{ session('status') }}</div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none"
                    placeholder="Enter your email">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none"
                    placeholder="Password">
            </div>

            <!-- Forgot password -->
            <div class="flex justify-end">
                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:underline">Forgot password</a>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-black hover:bg-gray-900 text-white font-medium py-3 rounded-lg transition">
                Login
            </button>

            <!-- Google Sign In -->
            <button type="button"
                class="w-full flex items-center justify-center gap-2 border border-gray-300 py-3 rounded-lg hover:bg-gray-50 transition">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo" class="w-5 h-5">
                <span class="text-gray-700 font-medium">Sign in with Google</span>
            </button>
        </form>

        <!-- Sign up link -->
        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-600 mt-6">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-black font-medium hover:underline">Sign up for free</a>
            </p>
        @endif
    </div>
</body>
</x-guest-layout>
