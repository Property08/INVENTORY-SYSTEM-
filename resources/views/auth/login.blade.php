<x-guest-layout>
    <body class="antialiased bg-gradient-to-br from-gray-100 to-gray-300 dark:from-gray-900 dark:to-gray-800 min-h-screen flex items-center justify-center">

        <div class="w-full max-w-md bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl relative overflow-hidden">

            <!-- Decorative background circle -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-tr from-blue-400 to-blue-600 rounded-full opacity-20"></div>

            <!-- Header -->
            <div class="relative z-10 text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="logo_outline.png" alt="Logo" class="w-12 h-12">
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome Back 👋</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Login to your account to continue</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-green-600 text-sm text-center">{{ session('status') }}</div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6 relative z-10">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Enter your email">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Password">
                </div>

                <!-- Forgot password -->
                <div class="flex justify-end">
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-transform transform hover:scale-[1.02]">
                    Sign In
                </button>

                <!-- Divider -->
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                    <span class="mx-2 text-sm text-gray-400">or</span>
                    <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                </div>

                <!-- Google Sign In -->
                <button type="button"
                    class="w-full flex items-center justify-center gap-2 border border-gray-300 dark:border-gray-600 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo" class="w-5 h-5">
                    <span class="text-gray-700 dark:text-gray-200 font-medium">Sign in with Google</span>
                </button>
            </form>

            <!-- Sign up link -->
            @if (Route::has('register'))
                <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6 relative z-10">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Sign up for free</a>
                </p>
            @endif
        </div>
    </body>
</x-guest-layout>
