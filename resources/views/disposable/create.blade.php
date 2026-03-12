@extends('layouts.dashboard')

@section('title', 'Encode Disposal Item')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10 font-sans text-slate-900">
    
    <div class="mb-6">
        <a href="{{ route('disposable.index') }}" class="group inline-flex items-center text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            Back to Registry
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl shadow-slate-200/50 overflow-hidden">
        
        <div class="bg-slate-900 px-8 py-10 text-white relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-2 text-red-400 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em]">Form Module: WMR-01</span>
                </div>
                <h1 class="text-3xl font-black uppercase tracking-tight">Add Disposable Item</h1>
                <p class="text-slate-400 text-sm mt-1">Please ensure all property details are accurate before saving.</p>
            </div>
            <div class="absolute right-0 bottom-0 opacity-10 translate-x-10 translate-y-10">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
        </div>

        <div class="p-8 sm:p-12">
            @if ($errors->any())
                <div class="mb-8 p-5 bg-red-50 border-l-4 border-red-500 rounded-xl flex gap-4 items-start shadow-sm">
                    <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="text-sm font-black text-red-800 uppercase tracking-wider mb-1">Encoding Errors Detected</h4>
                        <ul class="text-xs text-red-700 font-medium space-y-1 italic">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('disposable.store') }}" method="POST">
                @csrf

                <div class="space-y-8">
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                            <span class="w-8 h-[2px] bg-slate-200"></span> Primary Item Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">Accountability Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:border-slate-900 focus:ring-0 transition-all placeholder:text-slate-300" 
                                       placeholder="e.g., LAPTOP, COMPUTER CHAIR" required>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">Quantity</label>
                                <div class="relative">
                                    <input type="number" name="quantity" value="{{ old('quantity') }}"
                                           class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:border-slate-900 focus:ring-0 transition-all" required>
                                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase">Units</span>
                                </div>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">Property Number</label>
                                <input type="text" name="property_number" value="{{ old('property_number') }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:border-slate-900 focus:ring-0 transition-all font-mono" required>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">Article</label>
                                <input type="text" name="article" value="{{ old('article') }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:border-slate-900 focus:ring-0 transition-all" placeholder="e.g., Laptop, Chair">
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">Unit Value</label>
                                <input type="number" name="unit_value" value="{{ old('unit_value') }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:border-slate-900 focus:ring-0 transition-all" step="0.01" placeholder="e.g., 150.00">
                            </div>

                        </div>
                    </div>

                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                            <span class="w-8 h-[2px] bg-slate-200"></span> Disposal Audit Data
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">Date Acquired</label>
                                <input type="date" name="DateAcquired" value="{{ old('DateAcquired') }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:border-slate-900 focus:ring-0 transition-all uppercase">
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">Year</label>
                                <input type="number" name="year" value="{{ old('year') }}"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:border-slate-900 focus:ring-0 transition-all uppercase"
                                    placeholder="2025" required>
                            </div>


                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">WMR / RIS Number</label>
                                <input type="text" name="WMR_num" value="{{ old('WMR_num') }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:border-slate-900 focus:ring-0 transition-all" placeholder="e.g., 2026-001">
                            </div>

                            <div class="md:col-span-2 group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest transition group-focus-within:text-slate-900">Disposal Item Description</label>
                                <textarea name="description" rows="4"
                                          class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-medium focus:bg-white focus:border-slate-900 focus:ring-0 transition-all italic leading-relaxed"
                                          placeholder="State the condition or reason why the item is being disposed...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-4 mt-12 pt-8 border-t border-slate-100">
                    <a href="{{ route('disposable.index') }}"
                       class="w-full sm:w-auto px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-slate-900 hover:bg-slate-50 transition-all text-center">
                        Discard
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto bg-slate-900 text-white px-12 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-slate-200 hover:bg-black hover:-translate-y-1 transition-all">
                        Finalize & Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Focus effects for the whole group */
    .group:focus-within h3 span { background-color: #0f172a; transition: 0.3s; }
</style>
@endsection