<x-guest-layout>
    <body class="antialiased bg-gradient-to-br from-gray-100 to-gray-300 dark:from-gray-900 dark:to-gray-800 min-h-screen flex items-center justify-center">

        <div class="w-full max-w-md bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg relative overflow-hidden">

            <!-- Decorative accent -->
            <div class="absolute -top-10 -right-10 w-28 h-28 bg-gradient-to-tr from-green-400 to-green-600 rounded-full opacity-20"></div>

            <!-- Header -->
            <div class="relative z-10 text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Create an Account</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Join us and start managing your inventory today.</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5 relative z-10">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="w-full px-4 py-3 mt-1 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                        placeholder="John Doe">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="w-full px-4 py-3 mt-1 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                        placeholder="example@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 mt-1 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-3 mt-1 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                        placeholder="Re-enter password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Register Button -->
                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition-transform transform hover:scale-[1.02]">
                    Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                <span class="mx-2 text-sm text-gray-400">or</span>
                <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
            </div>

            <!-- Google Sign Up -->
            <button type="button"
                class="w-full flex items-center justify-center gap-2 border border-gray-300 dark:border-gray-600 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo" class="w-5 h-5">
                <span class="text-gray-700 dark:text-gray-200 font-medium">Sign up with Google</span>
            </button>

            <!-- Already registered -->
            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6 relative z-10">
                Already have an account?
                <a href="{{ route('login') }}" class="text-green-600 font-medium hover:underline">Login here</a>
            </p>
        </div>
    </body>
</x-guest-layout>