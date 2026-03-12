<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Inventory System</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-slate-50 antialiased text-slate-900" x-data="{ sidebarOpen: false }">
<div class="flex min-h-screen">

    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 z-50 lg:hidden" 
         @click="sidebarOpen = false"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 w-72 bg-[#0A192F] flex flex-col shadow-2xl z-50 transition-transform duration-300 ease-in-out lg:static lg:inset-auto">
        
        <div class="px-8 py-10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-2 bg-indigo-500/10 rounded-xl border border-indigo-500/20">
                    <img src="{{ asset('storage/logo_outline.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                </div>
                <div>
                    <h1 class="text-white text-sm font-black tracking-tighter uppercase leading-none">Inventory</h1>
                    <p class="text-indigo-400 text-[10px] font-bold uppercase tracking-widest mt-1">System v2.0</p>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Main Menu</p>

            @php
                $active = 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20';
                $inactive = 'text-slate-400 hover:bg-white/5 hover:text-white transition-all duration-300';
            @endphp

            <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('dashboard') ? $active : $inactive }}">
                <svg class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span class="text-sm font-semibold tracking-wide">Overview</span>
            </a>

            <a href="{{ route('rpcppe.index') }}" class="group flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('rpcppe.*') ? $active : $inactive }}">
                <svg class="h-5 w-5 {{ request()->routeIs('rpcppe.*') ? 'text-white' : 'group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-sm font-semibold tracking-wide">RPCPPE Registry</span>
            </a>

            <a href="{{ route('disposable.index') }}" class="group flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('disposable.*') ? $active : $inactive }}">
                <svg class="h-5 w-5 {{ request()->routeIs('disposable.*') ? 'text-white' : 'group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span class="text-sm font-semibold tracking-wide">Disposal List</span>
            </a>

            <a href="{{ route('ppe-recap.index') }}" class="group flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('ppe-recap.*') ? $active : $inactive }}">
                <svg class="h-5 w-5 {{ request()->routeIs('ppe-recap.*') ? 'text-white' : 'group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                </svg>
                <span class="text-sm font-semibold tracking-wide">Recap / Analytics</span>
            </a>

            <a href="{{ route('records.index') }}" class="group flex items-center gap-3 py-3 px-4 rounded-xl {{ request()->routeIs('records.*') ? $active : $inactive }}">
                <svg class="h-5 w-5 {{ request()->routeIs('records.*') ? 'text-white' : 'group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
                <span class="text-sm font-semibold tracking-wide">Archive Records</span>
            </a>
        </nav>

        <div class="p-4 mt-auto">
            <div class="bg-white/5 rounded-2xl p-4">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-xs">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-slate-500 font-medium tracking-tight">System Manager</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
        
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </button>

                <div class="flex items-center gap-2">
                    <span class="hidden xs:inline text-[10px] font-black text-slate-400 uppercase tracking-widest">Workspace</span>
                    <svg class="hidden xs:block w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-[10px] xs:text-xs font-black text-slate-800 uppercase tracking-widest">@yield('title')</span>
                </div>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-4">
                <button class="p-2 text-slate-400 hover:text-indigo-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
            </div>
        </header>

        <section class="flex-1 p-4 sm:p-8 overflow-y-auto custom-scrollbar">
            <div class="animate-in fade-in slide-in-from-bottom-2 duration-500">
                @yield('content')
            </div>
        </section>

        <footer class="p-6 sm:p-8 text-center border-t border-slate-100 bg-white/50 mt-auto">
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-900 uppercase tracking-[0.2em] sm:tracking-[0.3em]">
                &copy; 2026 Inventory Management System • Property Section (JAM)
            </p>
        </footer>
    </main>

</div>

<style>
    /* Clean Internal Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
</body>
</html>