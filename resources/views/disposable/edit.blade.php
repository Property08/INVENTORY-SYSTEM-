@extends('layouts.dashboard')

@section('title', 'Edit Disposal Record')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 sm:py-10 font-sans text-slate-900">
    
    <div class="mb-6">
        <a href="{{ route('disposable.index') }}" class="group inline-flex items-center text-[10px] sm:text-xs font-black uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition p-2 -ml-2">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            Back to Registry
        </a>
    </div>

    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-2xl shadow-slate-200/50 overflow-hidden">
        
        <div class="bg-indigo-900 px-6 py-8 sm:px-8 sm:py-10 text-white relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-2 text-indigo-300 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em]">Update Registry Mode</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight leading-tight">Edit Disposal Item</h1>
                <p class="text-indigo-200/70 text-xs sm:text-sm mt-1">Modify details for: <span class="font-mono font-bold text-white break-all">{{ $disposable->property_number }}</span></p>
            </div>
            <div class="absolute right-0 bottom-0 opacity-10 translate-x-10 translate-y-10 hidden xs:block">
                <svg class="w-48 h-48 sm:w-64 sm:h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
        </div>

        <div class="p-6 sm:p-12">
            @if ($errors->any())
                <div class="mb-8 p-4 sm:p-5 bg-red-50 border-l-4 border-red-500 rounded-xl flex gap-3 sm:gap-4 items-start shadow-sm">
                    <svg class="w-5 h-5 sm:w-6  text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="text-[10px] sm:text-sm font-black text-red-800 uppercase tracking-wider mb-1">Update Failed</h4>
                        <ul class="text-[10px] sm:text-xs text-red-700 font-medium space-y-1 italic">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('disposable.update', $disposable->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-8 sm:space-y-10">
                    <div>
                        <h3 class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <span class="w-6 sm:w-8 h-[2px] bg-slate-200"></span> Primary Asset Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                            <div class="md:col-span-2 group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">Accountability Name</label>
                                <input type="text" name="name" value="{{ old('name', $disposable->name) }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all shadow-sm" required>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">Article</label>
                                <input type="text" name="article" value="{{ old('article', $disposable->article) }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all shadow-sm" placeholder="e.g., Laptop, Chair">
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">Unit Value</label>
                                <input type="number" name="unit_value" value="{{ old('unit_value', $disposable->unit_value) }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all shadow-sm" step="0.01" placeholder="e.g., 150.00">
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">Quantity</label>
                                <input type="number" name="quantity" value="{{ old('quantity', $disposable->quantity) }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all shadow-sm" required>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">Property Number</label>
                                <input type="text" name="property_number" value="{{ old('property_number', $disposable->property_number) }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all shadow-sm font-mono uppercase" required>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <span class="w-6 sm:w-8 h-[2px] bg-slate-200"></span> Disposal Audit Data
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">Date Acquired</label>
                                <input type="date" name="DateAcquired" value="{{ old('DateAcquired', $disposable->DateAcquired) }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all shadow-sm" required>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">Year</label>
                                <input type="number" name="year" value="{{ old('year', $disposable->year) }}"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all shadow-sm" required>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">WMR Number</label>
                                <input type="text" name="WMR_num" value="{{ old('WMR_num', $disposable->WMR_num) }}"
                                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all shadow-sm" required>
                            </div>

                            <div class="md:col-span-2 group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 tracking-widest">Disposal Item Description</label>
                                <textarea name="description" rows="4"
                                          class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl px-4 py-3 sm:px-5 sm:py-4 text-sm font-medium focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all italic leading-relaxed shadow-sm" required>{{ old('description', $disposable->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 mt-10 sm:mt-12 pt-8 border-t border-slate-100">
                    <a href="{{ route('disposable.index') }}"
                       class="w-full sm:w-auto px-10 py-4 rounded-xl sm:rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-slate-900 hover:bg-slate-50 transition-all text-center">
                        Cancel Changes
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto bg-indigo-600 text-white px-12 py-4 rounded-xl sm:rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all">
                        Update Registry
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection