<x-guest-layout>
<body class="antialiased min-h-screen flex items-center justify-center bg-[#f8fafc] px-4">
    
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-blue-400/20 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-indigo-500/20 blur-[120px]"></div>
    </div>

    <div class="relative w-full max-w-[440px]">
        
        <div class="bg-white/80 backdrop-blur-2xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-[2.5rem] p-8 sm:p-12">
            
            <div class="flex flex-col items-center mb-10">
                <div class="p-4 bg-white shadow-sm rounded-2xl mb-6">
                    <img src="{{ asset('assets/image/logo_outline.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                </div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight">
                    Welcome back
                </h2>
                <p class="text-slate-500 mt-2 text-sm">
                    Enter your credentials to access your account
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-medium border border-emerald-100">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 ml-1">Email Address</label>
                    <div class="relative group">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="name@company.com"
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 text-sm transition-all duration-200
                            focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none group-hover:border-slate-300">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-sm font-semibold text-slate-700">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                            Forgot?
                        </a>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 text-sm transition-all duration-200
                        focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none group-hover:border-slate-300">
                </div>

                <button type="submit"
                    class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl shadow-lg shadow-slate-200 transition-all duration-200 active:scale-[0.98] mt-2">
                    Sign In
                </button>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                    <div class="relative flex justify-center text-xs uppercase"><span class="bg-white/0 px-2 text-slate-400 font-medium">Or continue with</span></div>
                </div>

                <button type="button"
                    class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 py-3.5 rounded-2xl hover:bg-slate-50 transition-colors duration-200">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                    <span class="text-slate-700 font-bold text-sm">Google</span>
                </button>
            </form>

            @if (Route::has('register'))
            <p class="text-center text-sm text-slate-600 mt-10">
                New here? 
                <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:text-blue-700">
                    Create an account
                </a>
            </p>
            @endif

        </div>
    </div>
</body>
</x-guest-layout>