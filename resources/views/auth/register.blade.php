<x-guest-layout>
<body class="antialiased min-h-screen flex items-center justify-center bg-[#f8fafc] px-4 py-10">
    
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-blue-400/10 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-500/10 blur-[120px]"></div>
    </div>

    <div class="relative w-full max-w-[480px]">
        
        <div class="bg-white/80 backdrop-blur-2xl border border-white shadow-[0_20px_50px_rgba(8,_112,_184,_0.07)] rounded-[2.5rem] p-8 sm:p-12">
            
            <div class="flex flex-col items-center mb-8">
                <div class="p-3 bg-white shadow-sm rounded-2xl mb-4 border border-slate-100">
                    <img src="{{ asset('storage/logo_outline.png') }}" class="w-10 h-10 object-contain" alt="Logo">
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight text-center">
                    Create Account
                </h2>
                <p class="text-slate-500 mt-2 text-sm text-center">
                    Join us and start managing your inventory
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        placeholder="Juan Dela Cruz"
                        class="w-full px-5 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-900 text-sm transition-all focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="example@email.com"
                        class="w-full px-5 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-900 text-sm transition-all focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Password</label>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full px-5 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-900 text-sm transition-all focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Confirm</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••"
                            class="w-full px-5 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-900 text-sm transition-all focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-error :messages="$errors->get('password')" class="text-xs" />
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-[#0A2540] hover:bg-slate-800 text-white font-bold rounded-2xl shadow-lg shadow-blue-900/10 transition-all active:scale-[0.98] mt-2">
                    Create Account
                </button>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                    <div class="relative flex justify-center text-xs uppercase"><span class="bg-white/0 px-4 text-slate-400 font-semibold tracking-widest">OR</span></div>
                </div>

                <button type="button"
                    class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 py-3.5 rounded-2xl hover:bg-slate-50 transition-all">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                    <span class="text-slate-700 font-bold text-sm">Google</span>
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-8">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:text-blue-700 transition-colors">
                    Log in
                </a>
            </p>
        </div>
    </div>
</body>
</x-guest-layout>