@extends('layouts.dashboard')

@section('title', 'System Overview')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">

    <div class="relative overflow-hidden bg-white border border-slate-200 rounded-[2rem] p-6 sm:p-8 mb-8 shadow-sm">
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-8">
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full mb-4">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">System Online</span>
                </div>
                <h2 class="text-2xl xs:text-3xl md:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight uppercase mb-3">
                    Welcome back, <span class="text-indigo-600">ADMIN!</span>
                </h2>
                <p class="text-slate-500 font-medium italic text-sm md:text-base max-w-xl mx-auto lg:mx-0">
                    Property and Supply Management System is ready for your instructions.
                </p>
            </div>

            <div class="w-full lg:w-auto bg-slate-900 text-white p-6 rounded-2xl shadow-2xl min-w-[280px] border-b-4 border-indigo-500 relative overflow-hidden group">
                <div class="relative z-10">
                    <div id="current-date" class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-400 mb-1"></div>
                    <div id="current-time" class="text-2xl xs:text-3xl font-black tracking-tighter tabular-nums"></div>
                </div>
                <div class="absolute -right-4 -bottom-4 text-white/5 group-hover:text-indigo-500/10 transition-colors">
                    <svg class="w-20 h-20 sm:w-24 sm:h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-12">
        
        <a href="{{ route('rpcppe.index') }}" 
           class="group relative bg-white border border-slate-200 p-6 sm:p-8 rounded-[2rem] shadow-sm hover:shadow-xl hover:border-indigo-500 transition-all duration-300 overflow-hidden">
            <div class="relative z-10">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-600 transition-all shadow-lg">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="text-base sm:text-lg font-black text-slate-800 uppercase tracking-tight mb-2">RPCPPE Registry</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">Manage and track Physical Count of Property, Plant, and Equipment.</p>
                <div class="mt-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-indigo-600 opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0">
                    Access Registry <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 text-slate-50 opacity-0 group-hover:opacity-100 transition-opacity">
                 <svg class="w-24 h-24 sm:w-32 sm:h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z"/></svg>
            </div>
        </a>

        <a href="{{ route('disposable.index') }}" 
           class="group relative bg-white border border-slate-200 p-6 sm:p-8 rounded-[2rem] shadow-sm hover:shadow-xl hover:border-red-500 transition-all duration-300 overflow-hidden">
            <div class="relative z-10">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-red-600 group-hover:text-white transition-all shadow-lg">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-base sm:text-lg font-black text-slate-800 uppercase tracking-tight mb-2">Disposal Hub</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">Record and process waste materials and retired properties.</p>
                <div class="mt-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-red-600 opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0">
                    Open Storage <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
        </a>

        <a href="{{ route('ppe-recap.index') }}" 
           class="group relative bg-white border border-slate-200 p-6 sm:p-8 rounded-[2rem] shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all duration-300 overflow-hidden">
            <div class="relative z-10">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-lg">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 002-2V2z"/></svg>
                </div>
                <h3 class="text-base sm:text-lg font-black text-slate-800 uppercase tracking-tight mb-2">Recap Data</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">Generate summarized analytical reports and totals.</p>
                <div class="mt-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0">
                    View Analytics <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
        </a>

        <a href="{{ route('records.index') }}" 
           class="group relative bg-white border border-slate-200 p-6 sm:p-8 rounded-[2rem] shadow-sm hover:shadow-xl hover:border-amber-500 transition-all duration-300 overflow-hidden">
            <div class="relative z-10">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all shadow-lg">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <h3 class="text-base sm:text-lg font-black text-slate-800 uppercase tracking-tight mb-2">History Log</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">Audit trail and archived records for long-term storage.</p>
                <div class="mt-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-amber-600 opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0">
                    Open Archives <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
        </a>

    </div>
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'short', month: 'short', day: '2-digit', year: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };

        document.getElementById('current-date').innerText = now.toLocaleDateString('en-US', dateOptions);
        document.getElementById('current-time').innerText = now.toLocaleTimeString('en-US', timeOptions);
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
@endsection