@extends('layouts.dashboard')

@section('title', 'Edit RPCPPE')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8 font-sans">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-indigo-600 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em]">Maintenance Mode</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight uppercase">Edit Property Record</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium italic">Updating: {{ $rpcppe->property_no }}</p>
        </div>
        <a href="{{ route('rpcppe.index') }}" 
           class="inline-flex items-center justify-center gap-2 text-slate-500 hover:text-slate-800 font-bold text-[10px] sm:text-xs uppercase transition border border-slate-200 px-4 py-2.5 rounded-xl bg-white shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Discard Changes
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
            <ul class="list-disc list-inside text-[10px] sm:text-xs text-red-700 space-y-1 font-medium">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rpcppe.update', $rpcppe->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-indigo-50/50 px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-600 text-white rounded-lg">
                        <svg class="w-4  sm:w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-700 uppercase text-[10px] sm:text-xs tracking-widest">Core Specifications</h3>
                </div>
                <span class="hidden xs:inline-block text-[10px] font-bold text-indigo-400 bg-indigo-50 px-2 py-1 rounded">ID: #{{ $rpcppe->id }}</span>
            </div>
            
           <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 sm:gap-6">
                    {{-- Property Number Column --}}
                    <div class="sm:col-span-2 md:col-span-1">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1 tracking-wider">Property Number</label>
                        <input type="text" name="property_no" value="{{ old('property_no', $rpcppe->property_no) }}"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm">

                    </div>

                    {{-- Article Column --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1 tracking-wider">Article</label>
                        <input type="text" name="article" value="{{ old('article', $rpcppe->article) }}"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition shadow-sm">
                    </div>

                    {{-- Description - Full Width sa MD pataas --}}
                    <div class="sm:col-span-2 md:col-span-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1 tracking-wider">Description</label>
                        <textarea name="description" rows="2" 
                                class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition shadow-sm">{{ old('description', $rpcppe->description) }}</textarea>
                    </div>

                 <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1 tracking-wider">Unit of Measure</label>
                    <input type="text" name="unit_of_measure" value="{{ old('unit_of_measure', $rpcppe->unit_of_measure) }}"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition shadow-sm">
                </div>

                 <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1 tracking-wider">Unit of Value</label>
                    <input type="text" name="unit_value" value="{{ old('unit_value', $rpcppe->unit_value) }}"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition shadow-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1 tracking-wider">Quantity per Card.</label>
                    <input type="text" name="quantity_per_property_card" value="{{ old('quantity_per_property_card', $rpcppe->quantity_per_property_card) }}"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition shadow-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1 tracking-wider">Quantity per Physical Acct.</label>
                    <input type="text" name="quantity_per_physical_count" value="{{ old('quantity_per_physical_count', $rpcppe->quantity_per_physical_count) }}"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition shadow-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1 tracking-wider">Remarks</label>
                    <input type="text" name="remarks" value="{{ old('remarks', $rpcppe->remarks) }}"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition shadow-sm">
                </div>

            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="p-2 bg-slate-800 text-white rounded-lg">
                    <svg class="w-4  sm:w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                </div>
                <h3 class="font-black text-slate-700 uppercase text-[10px] sm:text-xs tracking-widest">Assignment & Logistics</h3>
            </div>
            
            <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Accountable Person</label>
                    <input type="text" name="accountable_person" value="{{ old('accountable_person', $rpcppe->accountable_person) }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500/20">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Location</label>
                    <input type="text" name="location" value="{{ old('location', $rpcppe->location) }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500/20">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Division</label>
                    <input type="text" name="division" value="{{ old('division', $rpcppe->division) }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500/20">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Section Unit</label>
                    <input type="text" name="section_unit" value="{{ old('section_unit', $rpcppe->section_unit) }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500/20">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Transferred To</label>
                    <input type="text" name="transfer_to" value="{{ old('transfer_to', $rpcppe->transfer_to) }}"
                           class="w-full border-amber-200 bg-amber-50/30 rounded-xl px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-amber-500/20">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Date Acquired</label>
                     <input type="text" name="date_acquired" value="{{ old('date_acquired', $rpcppe->date_acquired ?? '') }}" class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500/20" placeholder="YYYY-MM-DD or Year only">
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4 pt-4 pb-10">
            <button type="button" onclick="window.history.back()" class="w-full sm:w-auto text-slate-400 hover:text-slate-600 font-bold text-[10px] uppercase transition tracking-widest py-3">
                Go Back
            </button>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <button type="submit" 
                        class="w-full sm:w-auto bg-indigo-600 text-white px-10 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition transform active:scale-95">
                    Update Record
                </button>
            </div>
        </div>
    </form>
</div>
@endsection