@extends('layouts.dashboard')

@section('title', 'Archived Records')

@section('content')
<style>
    /* Professional Scrollbar Layout */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    .font-tabular { font-variant-numeric: tabular-nums; }
</style>

<div class="max-w-[98%] mx-auto px-2 sm:px-4 py-4 sm:py-8">
    
    {{-- HEADER --}}
    <div class="md:flex md:items-center md:justify-between mb-6 sm:mb-8 border-l-4 border-blue-700 pl-4">
        <div class="flex-1 min-w-0">
            <h2 class="text-xl font-extrabold tracking-tight text-gray-900 sm:text-3xl uppercase">
                Archived Records
            </h2>
            <p class="mt-1 text-xs sm:text-sm text-gray-500 font-medium">
                Official Inventory Repository & Property Filing Management
            </p>
        </div>
    </div>

    {{-- TAB SWITCHER --}}
    <div class="mb-6 sm:mb-8 overflow-x-auto custom-scrollbar whitespace-nowrap">
        <div class="flex p-1 bg-slate-200/60 backdrop-blur-sm rounded-xl w-full sm:w-fit border border-slate-200">
            <button onclick="switchTab('recaps')" id="btn-recaps" 
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-2.5 text-[11px] sm:text-xs font-bold rounded-lg transition-all duration-300 uppercase tracking-wider whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Yearly Recaps
            </button>
            <button onclick="switchTab('cabinet')" id="btn-cabinet" 
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-2.5 text-[11px] sm:text-xs font-bold rounded-lg transition-all duration-300 uppercase tracking-wider whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                Filing Cabinet
            </button>
        </div>
    </div>

    {{-- SECTION 1: YEARLY RECAPS --}}
     <div id="section-recaps" class="hidden space-y-4 animate-in fade-in duration-500">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px] tracking-widest">
                    <tr>
                        <th class="px-8 py-4">Archival Period</th>
                        <th class="px-8 py-4">Document Details</th>
                        <th class="px-8 py-4">Timestamp</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                    <tr class="group hover:bg-slate-50/80 transition-all">
                        <td class="px-8 py-5">
                            <div class="text-xl font-bold text-slate-800">{{ $r->year }}</div>
                        </td>
                        <td class="px-8 py-5 text-slate-700">
                            <div class="font-bold">{{ $r->title }}</div>
                            <span class="text-[9px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded font-mono uppercase">ID: {{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-8 py-5 text-slate-600">{{ $r->created_at->format('M d, Y') }}</td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('records.pdf', $r->id) }}" class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold hover:bg-red-50 hover:text-red-600 transition-all">PDF</a>
                                <a href="{{ route('records.excel', $r->id) }}" class="px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-bold hover:bg-blue-600 transition-all">EXCEL</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 italic font-bold">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SECTION 2: FILING CABINET --}}
    <div id="section-cabinet" class="hidden space-y-6 animate-in slide-in-from-bottom-4 duration-500">
        
        <!-- COMPACT YEAR FILTER DROPDOWN FORM WITH RESET -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-md font-black text-slate-700 uppercase tracking-wider">Fiscal Year Target:</span>
                @if($selectedYear)
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-extrabold rounded border border-blue-200 animate-pulse">
                        Active: FY {{ $selectedYear }}
                    </span>
                @else
                    <span class="px-3 py-3 bg-emerald-50 text-emerald-700 text-xs font-extrabold rounded border border-emerald-200">
                        ALL YEARS (CONSOLIDATED)
                    </span>
                @endif
            </div>
           
            <form action="{{ route('records.index') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="tab" value="cabinet">
               
                <div class="relative">
                    <select name="year" class="appearance-none pl-3 pr-10 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs font-bold text-slate-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                        <option value="" {{ !$selectedYear ? 'selected' : '' }}>-- Select Year --</option>
                        @foreach($availableYears as $yr)
                            <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>
                                FY {{ $yr }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                <button type="submit" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter
                </button>
                @if(request()->has('year') && request('year') != '')
                    <a href="?tab=cabinet" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 text-xs font-bold rounded-lg transition-all flex items-center gap-1 border border-slate-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Clear
                    </a>
                @endif
            </form>
        </div>

        @if(!request('folder'))
            <div class="p-4 sm:p-8 bg-slate-50/50 rounded-2xl border border-dashed border-slate-300">
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 {{ $selectedYear ? 'bg-blue-500' : 'bg-emerald-500' }} rounded-full shrink-0"></div>
                        <h3 class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider sm:tracking-[0.2em]">
                            {{ $selectedYear ? "Folders Archive for Year $selectedYear" : "Consolidated Folders Archive (All Years Mixed)" }}
                        </h3>
                    </div>
                    <span class="w-fit text-xs font-bold text-slate-400 bg-white border border-slate-200 px-3 py-1 rounded-full">
                        Total Categories: {{ $folders->count() }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($folders as $f)
                        <a href="?folder={{ $f->prefix }}{{ $selectedYear ? '&year='.$selectedYear : '' }}&tab=cabinet#section-cabinet" 
                           class="group relative flex flex-col p-5 bg-white border border-slate-200 rounded-xl hover:border-blue-500 hover:shadow-xl transition-all duration-200">
                            
                            <div class="flex items-start justify-between mb-4">
                                <div class="p-2.5 {{ $selectedYear ? 'bg-blue-50' : 'bg-emerald-50' }} rounded-lg group-hover:bg-blue-600 transition-colors">
                                    <svg class="w-5 h-5 {{ $selectedYear ? 'text-blue-600' : 'text-emerald-600' }} group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                    </svg>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded">CODE {{ $f->prefix }}</span>
                            </div>
                            
                            <h3 class="text-xs font-bold text-slate-800 uppercase group-hover:text-blue-600 leading-tight mb-6 min-h-[32px]">
                                {{ $f->label }}
                            </h3>

                            <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between gap-2">
                                <div>
                                    <p class="text-[9px] uppercase tracking-wider text-slate-400 font-bold">Records</p>
                                    <p class="text-xs font-bold text-slate-700">{{ number_format($f->total) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[9px] uppercase tracking-wider text-slate-400 font-bold">Total Amount</p>
                                    <p class="text-xs font-bold text-blue-600 font-tabular">₱{{ number_format($f->total_amount, 2) }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12 bg-white rounded-xl border border-slate-200">
                            <p class="text-sm text-slate-400 italic font-bold">No historical data available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        @if(request('folder'))
            {{-- DATA TABLE INSIDE ACTIVE FOLDER --}}
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="?{{ $selectedYear ? 'year='.$selectedYear.'&' : '' }}tab=cabinet#section-cabinet" class="group flex items-center gap-2 px-3 sm:px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-50 transition-all">
                            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Back to Folders
                        </a>
                        <h3 class="font-bold text-xs sm:text-sm text-slate-800 uppercase tracking-tight break-all">
                            Folder {{ request('folder') }} ({{ $selectedYear ? "FY $selectedYear" : "All Years Combined" }})
                        </h3>
                    </div>
                    <a href="{{ route('records.export_folder', ['folder' => request('folder'), 'year' => $selectedYear]) }}" class="text-center px-5 py-2.5 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 shadow-md w-full sm:w-auto transition-all">
                        Download Excel
                    </a>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto custom-scrollbar"> 
                        <table class="w-full text-left text-[11px] border-separate border-spacing-0 min-w-[1000px]">
                            <thead class="sticky top-0 z-20">
                                <tr class="bg-slate-900 text-white uppercase tracking-wider">
                                    <th class="p-4 border-r border-slate-800 font-bold sticky left-0 z-30 bg-slate-900">Property No.</th>
                                    <th class="p-4 border-r border-slate-800 font-bold min-w-[150px]">Article</th>
                                    <th class="p-4 border-r border-slate-800 font-bold min-w-[250px]">Description</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center">Unit</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-right">Value</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center bg-slate-800">Qty(C)</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center bg-slate-800">Qty(P)</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center">Remarks</th>
                                    <th class="p-4 font-bold min-w-[150px]">Accountable Person</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($inventoryItems as $item)
                                <tr class="hover:bg-blue-50/40 transition-colors group">
                                    <td class="p-4 border-r border-slate-50 font-mono font-bold text-blue-600 sticky left-0 bg-white group-hover:bg-blue-50">
                                        <button onclick="viewFullDetails({{ json_encode($item) }})" class="hover:underline text-left">
                                            {{ $item->property_no }}
                                        </button>
                                    </td>
                                    <td class="p-4 border-r border-slate-50 font-bold text-slate-800 uppercase">{{ $item->article }}</td>
                                    <td class="p-4 border-r border-slate-50 text-slate-500 italic">{{ Str::limit($item->description, 50) }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center">{{ $item->unit_of_measure }}</td>
                                    <td class="p-4 border-r border-slate-50 text-right font-bold font-tabular text-slate-700">₱{{ number_format($item->unit_value, 2) }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-black bg-slate-50/50">{{ $item->quantity_per_property_card }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-black bg-slate-50/50">{{ $item->quantity_per_physical_count }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-semibold">{{ $item->remarks ?: '--' }}</td>
                                    <td class="p-4 font-bold text-slate-700 uppercase">{{ $item->accountable_person }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="9" class="p-20 text-center text-slate-400 italic font-bold text-base">Folder is empty.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">{{ $inventoryItems->links() }}</div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL PREVIEW SIDEBOX --}}
<div id="descModal" class="hidden fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDescriptionModal()"></div>
        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all w-full sm:max-w-2xl border border-slate-200 m-2">
            <div class="bg-white px-4 sm:px-6 pt-5 sm:pt-6 pb-4">
                <div class="flex justify-between items-start mb-4 gap-2">
                    <div>
                        <h3 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Full Record Details</h3>
                        <h2 class="text-base sm:text-lg font-black text-slate-800 uppercase leading-tight" id="modal-article-title">---</h2>
                    </div>
                    <button onclick="closeDescriptionModal()" class="text-slate-400 hover:text-slate-600 shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="mt-4 bg-slate-50 rounded-xl border border-slate-200 overflow-hidden shadow-inner max-h-[55vh] overflow-y-auto custom-scrollbar">
                    <table class="w-full text-left text-xs">
                        <tbody id="modal-details-body" class="divide-y divide-slate-200"></tbody>
                    </table>
                </div>
            </div>
            <div class="bg-slate-100 px-4 sm:px-6 py-4 flex justify-end">
                <button onclick="closeDescriptionModal()" class="w-full sm:w-auto px-6 py-2.5 bg-slate-800 text-white text-xs font-black rounded hover:bg-black transition uppercase tracking-widest text-center">Close Preview</button>
            </div>
        </div>
    </div>
</div>

<script>
    function viewFullDetails(item) {
        document.getElementById('modal-article-title').innerText = item.article || 'N/A';
        const tbody = document.getElementById('modal-details-body');
        
        const fields = [
            { label: 'Property Number', value: item.property_no, highlight: true },
            { label: 'Description', value: item.description },
            { label: 'Unit Value', value: '₱' + parseFloat(item.unit_value || 0).toLocaleString(undefined, {minimumFractionDigits: 2}) },
            { label: 'Unit of Measure', value: item.unit_of_measure },
            { label: 'Qty (Card)', value: item.quantity_per_property_card },
            { label: 'Qty (Physical)', value: item.quantity_per_physical_count },
            { label: 'Shortage (Qty)', value: item.shortage_overage_qty },
            { label: 'Shortage (Value)', value: '₱' + parseFloat(item.shortage_overage_value || 0).toLocaleString(undefined, {minimumFractionDigits: 2}) },
            { label: 'Remarks', value: item.remarks || '--' },
            { label: 'Date Acquired', value: item.date_acquired || '--' },
            { label: 'Accountable Person', value: item.accountable_person },
            { label: 'Transfer To', value: item.transfer_to || '--' },
            { label: 'Location', value: item.location },
            { label: 'Division', value: item.division },
            { label: 'Section_unit', value: item.section_unit },
        ];

        tbody.innerHTML = fields.map(field => `
            <tr>
                <td class="p-3 font-black text-slate-500 uppercase w-1/3 bg-slate-100/50 border-r border-slate-200">${field.label}</td>
                <td class="p-3 ${field.highlight ? 'text-blue-700 font-black' : 'text-slate-800 font-semibold'} italic">${field.value}</td>
            </tr>`).join('');

        document.getElementById('descModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDescriptionModal() {
        document.getElementById('descModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function switchTab(tab) {
        const sections = { recaps: 'section-recaps', cabinet: 'section-cabinet' };
        const buttons = { recaps: 'btn-recaps', cabinet: 'btn-cabinet' };
        Object.keys(sections).forEach(key => {
            const isMatch = key === tab;
            const s = document.getElementById(sections[key]);
            const b = document.getElementById(buttons[key]);
            if(s) s.style.display = isMatch ? 'block' : 'none';
            if(b) b.className = isMatch 
                ? "flex items-center gap-2 px-6 py-2.5 text-xs font-bold rounded-lg transition-all duration-300 uppercase tracking-wider bg-white text-blue-600 shadow-sm border border-slate-200"
                : "flex items-center gap-2 px-6 py-2.5 text-xs font-bold rounded-lg transition-all duration-300 uppercase tracking-wider text-slate-400 hover:text-slate-600";
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    switchTab(urlParams.has('folder') || urlParams.get('tab') === 'cabinet' ? 'cabinet' : 'recaps');
</script>
@endsection