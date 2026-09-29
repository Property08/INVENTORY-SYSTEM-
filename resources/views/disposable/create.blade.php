@extends('layouts.dashboard')
@section('title', 'Add New Record - Disposal Item / WMR')

@section('content')
<div class="container mx-auto p-4 md:p-8 max-w-5xl font-sans">

    {{-- Top Header Bar --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight uppercase">
                ENCODE DISPOSAL ITEM
            </h1>
            <p class="text-slate-500 text-xs md:text-sm font-medium mt-0.5">
                WMR Registry Module: Fill in the property details below.
            </p>
        </div>

        {{-- Top Right Back Button --}}
        <div>
            <a href="{{ route('disposable.index') }}" 
                class="inline-flex items-center gap-2 px-4 py-2 border border-slate-300 rounded-xl bg-white text-slate-700 text-xs font-bold hover:bg-slate-50 transition shadow-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                BACK TO REGISTRY
            </a>
        </div>
    </div>

    {{-- Validation Errors Alert --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r shadow-sm">
            <div class="flex items-center mb-1">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <h3 class="text-xs font-bold text-red-800 uppercase tracking-wider">Please fix the following validation errors:</h3>
            </div>
            <ul class="list-disc pl-8 text-xs text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Main Form Container --}}
    <form action="{{ route('disposable.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- SECTION 1: ITEM IDENTITY --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="bg-blue-50/60 border-b border-blue-100/80 px-6 py-3.5 flex items-center gap-3">
                <div class="p-1.5 bg-blue-100 rounded-lg text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h2 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                    ITEM IDENTITY
                </h2>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            WMR NUMBER <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="WMR_num" value="{{ old('WMR_num') }}" required
                            placeholder="e.g., WMR-2026-001"
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-slate-400 focus:ring-0 transition uppercase font-mono">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            PROPERTY NUMBER <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="property_number" value="{{ old('property_number') }}" required
                            placeholder="e.g., 2023-100-01"
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-slate-400 focus:ring-0 transition uppercase font-mono">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            SUBMITTED BY <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            placeholder="e.g. John Doe"
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        ARTICLE / CLASSIFICATION
                    </label>
                    <textarea name="description" rows="3"
                        placeholder="Notes regarding the item condition or reason for disposal..."
                        class="w-full bg-slate-50/80 border border-slate-200 rounded-xl p-4 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-slate-400 focus:ring-0 transition resize-y">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- SECTION 2: INVENTORY & VALUATION --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="bg-emerald-50/60 border-b border-emerald-100/80 px-6 py-3.5 flex items-center gap-3">
                <div class="p-1.5 bg-emerald-100 rounded-lg text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                    INVENTORY & VALUATION
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            QUANTITY <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="0" required
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            UNIT VALUE (₱)
                        </label>
                        <input type="number" step="0.01" name="unit_value" value="{{ old('unit_value') }}"
                            placeholder="e.g. 15000.00"
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            RECORD YEAR <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="year" value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y')+1 }}" required
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            RPCPPE REF. ID <span class="text-slate-300 font-normal">(OPTIONAL)</span>
                        </label>
                        <input type="number" name="rpcppe_id" value="{{ old('rpcppe_id') }}"
                            placeholder="Ref ID"
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: DISPOSAL DETAILS & ATTACHMENT --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="bg-purple-50/60 border-b border-purple-100/80 px-6 py-3.5 flex items-center gap-3">
                <div class="p-1.5 bg-purple-100 rounded-lg text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                    DISPOSAL DETAILS & ATTACHMENT
                </h2>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            DATE ACQUIRED
                        </label>
                        <input type="date" name="DateAcquired" value="{{ old('DateAcquired') }}"
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            LOCATION / OFFICE
                        </label>
                        <input type="text" name="place" value="{{ old('place') }}"
                            placeholder="e.g. Property Unit, PAGASA"
                            class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        DISPOSAL TYPE <span class="text-red-500">*</span>
                    </label>
                    <select name="disposal_type" required
                        class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                        <option value="">-- SELECT --</option>
                        <option value="wmr" {{ old('disposal_type') == 'wmr' ? 'selected' : '' }}>WMR</option>
                        <option value="disposed" {{ old('disposal_type') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        DISPOSAL DESCRIPTION / REMARKS
                    </label>
                    <input type="text" name="article" value="{{ old('article') }}"
                        placeholder="e.g., IT Equipment, Office Furniture"
                        class="w-full bg-slate-50/80 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-slate-400 focus:ring-0 transition">
                </div>

                {{-- MULTIPLE ATTACHMENTS FIELD --}}
                <div class="p-4 bg-slate-50/60 rounded-xl border border-slate-200/80">
                    <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">
                        📎 ATTACHMENTS (DOCUMENTS OR PHOTOS)
                    </label>
                    <p class="text-[11px] text-slate-400 mb-2.5">
                       Can upload multiple files. Accepted formats: PDF, PNG, JPG, JPEG, WEBP. Max file size: 10MB each.
                    </p>

                    <input type="file" name="scanned_photos[]" accept=".pdf,.png,.jpg,.jpeg,.webp" multiple
                        class="w-full text-xs text-slate-500 bg-white border border-slate-200 rounded-xl p-2.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                </div>
            </div>
        </div>

        {{-- Bottom Action Footer Bar --}}
        <div class="flex items-center justify-between pt-4 pb-12">
            <button type="reset" class="text-xs font-black text-slate-400 hover:text-slate-600 tracking-wider uppercase transition">
                CLEAR ALL FIELDS
            </button>

            <div class="flex items-center gap-4">
                <a href="{{ route('disposable.index') }}" 
                    class="text-xs font-black text-slate-500 hover:text-slate-800 tracking-wider uppercase transition">
                    CANCEL
                </a>

                <button type="submit" 
                    class="px-8 py-3.5 bg-[#0f172a] hover:bg-slate-800 text-white text-xs font-black tracking-wider uppercase rounded-xl shadow-md transition active:scale-95">
                    SAVE PROPERTY RECORD
                </button>
            </div>
        </div>
    </form>
</div>
@endsection