@extends('layouts.dashboard')

@section('title', 'Add New RPCPPE')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8 font-sans">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight uppercase">Encode New Item</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium">Registry Module: Fill in the property details below.</p>
        </div>
        <a href="{{ route('rpcppe.index') }}" 
           class="inline-flex items-center justify-center gap-2 text-slate-500 hover:text-slate-800 font-bold text-[10px] sm:text-xs uppercase transition border border-slate-200 px-4 py-2.5 rounded-xl bg-white shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Registry
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="font-black text-red-800 text-[10px] uppercase">Please check your inputs</span>
            </div>
            <ul class="list-disc list-inside text-[10px] sm:text-xs text-red-700 space-y-1">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rpcppe.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- ITEM IDENTITY --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-4 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <svg class="w-4 sm:w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <h3 class="font-black text-slate-700 uppercase text-[10px] sm:text-xs tracking-widest">Item Identity</h3>
            </div>
            
            <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                <div class="sm:col-span-2 md:col-span-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Property Number <span class="text-red-500">*</span></label>
                    <input type="text" name="property_no" required value="{{ old('property_no') }}"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm" placeholder="e.g. 2023-100-01">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Article Name</label>
                    <input type="text" name="article" value="{{ old('article') }}"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm" placeholder="e.g. Desktop Computer">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Unit of Measure</label>
                    <input type="text" name="unit_of_measure" value="{{ old('unit_of_measure') }}"
                           class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm" placeholder="e.g. pc, unit, set">
                </div>

                <div class="sm:col-span-2 md:col-span-3">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Technical Description</label>
                    <textarea name="description" rows="2" 
                              class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm" placeholder="Enter brand, model, specs, etc.">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- INVENTORY & VALUATION --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-4 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                    <svg class="w-4  sm:w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-black text-slate-700 uppercase text-[10px] sm:text-xs tracking-widest">Inventory & Valuation</h3>
            </div>
            
            <div class="p-4 sm:p-6 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Unit Value (₱)</label>
                    <input type="number" step="0.01" name="unit_value" id="unit_value" value="{{ old('unit_value') }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Qty (Card)</label>
                    <input type="number" name="quantity_per_property_card" id="qty_card" value="{{ old('quantity_per_property_card') }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Qty (Actual)</label>
                    <input type="number" name="quantity_per_physical_count" id="qty_phys" value="{{ old('quantity_per_physical_count') }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm">
                </div>
                <div class="col-span-2 md:col-span-1 bg-orange-50 rounded-xl px-4 py-2 border border-orange-100 flex flex-col justify-center">
                    <label class="block text-[9px] font-black text-orange-400 uppercase mb-0.5 tracking-tighter leading-tight">Calculated Shortage</label>
                    <input type="number" name="shortage_overage_qty" id="shortage_qty" readonly value="{{ old('shortage_overage_qty', 0) }}"
                           class="w-full bg-transparent border-none text-orange-700 font-black text-xl p-0 focus:ring-0 cursor-default">
                </div>
            </div>
        </div>

        {{-- DEPLOYMENT DETAILS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-4 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                    <svg class="w-4  sm:w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="font-black text-slate-700 uppercase text-[10px] sm:text-xs tracking-widest">Deployment Details</h3>
            </div>
            
            <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Accountable Person</label>
                    <input type="text" name="accountable_person" value="{{ old('accountable_person') }}" placeholder="Full Name"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Transfer to</label>
                    <input type="text" name="transfer_to" value="{{ old('transfer_to') }}" placeholder="Full Name"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. PAGASA"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Date Acquired</label>
                    <input type="text" name="date_acquired" value="{{ old('date_acquired') }}" 
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" 
                           placeholder="YYYY-MM-DD or Year only">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Division</label>
                    <input type="text" name="division" value="{{ old('division') }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Section</label>
                    <input type="text" name="section_unit" value="{{ old('section_unit') }}"
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm">
                </div>

                <div class="sm:col-span-2 md:col-span-3">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Remarks</label>
                    <input type="text" name="remarks" value="{{ old('remarks') }}" placeholder="Notes regarding the item condition..."
                           class="w-full border-slate-200 rounded-xl px-4 py-3 text-sm shadow-sm">
                </div>
            </div>
        </div>

        {{-- FORM ACTIONS --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 p-2 pb-10">
            <button type="reset" class="w-full sm:w-auto text-slate-400 hover:text-red-500 font-bold text-[10px] uppercase transition tracking-widest py-2">
                Clear All Fields
            </button>
            <div class="flex flex-col-reverse sm:flex-row gap-3 w-full sm:w-auto">
                <a href="{{ route('rpcppe.index') }}" 
                   class="w-full sm:w-auto px-8 py-3 rounded-xl text-slate-600 font-bold text-[10px] uppercase hover:bg-slate-100 transition text-center border border-transparent hover:border-slate-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto bg-slate-900 text-white px-10 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-slate-300 hover:bg-black hover:-translate-y-1 transition transform active:scale-95">
                    Save Property Record
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const qtyCard = document.getElementById('qty_card');
    const qtyPhys = document.getElementById('qty_phys');
    const shortQty = document.getElementById('shortage_qty');

    function calculateShortage() {
        const cardValue = parseInt(qtyCard.value) || 0;
        const physValue = parseInt(qtyPhys.value) || 0;
        shortQty.value = cardValue - physValue;
    }

    [qtyCard, qtyPhys].forEach(input => {
        input.addEventListener('input', calculateShortage);
    });
</script>
@endsection