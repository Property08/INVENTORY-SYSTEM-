@extends('layouts.dashboard')

@section('title', 'Archived Records')

@section('content')
<div class="max-w-[98%] mx-auto px-4 py-10">
    
    {{-- HEADER --}}
    <div class="md:flex md:items-center md:justify-between mb-8 border-l-4 border-blue-700 pl-4">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl uppercase">
                Archived Records
            </h2>
            <p class="mt-1 text-sm text-gray-500 font-medium">
                Official Inventory Repository & Property Filing Management
            </p>
        </div>
    </div>

    {{-- TAB SWITCHER --}}
    <div class="mb-6">
        <div class="flex p-1.5 bg-slate-200/50 backdrop-blur-sm rounded-2xl w-fit border border-slate-200">
            <button onclick="switchTab('recaps')" id="btn-recaps" 
                class="flex items-center gap-2 px-6 py-3 text-xs font-bold rounded-xl transition-all duration-300 uppercase tracking-tighter">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Yearly Recaps
            </button>
            <button onclick="switchTab('cabinet')" id="btn-cabinet" 
                class="flex items-center gap-2 px-6 py-3 text-xs font-bold rounded-xl transition-all duration-300 uppercase tracking-tighter">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                Filing Cabinet
            </button>
        </div>
    </div>

    {{-- SECTION 1: YEARLY RECAPS --}}
    <div id="section-recaps" class="hidden space-y-4 animate-in fade-in zoom-in-95 duration-300">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Archival Period</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Document Details</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Timestamp</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Export/Tools</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-8 py-6">
                            <div class="text-2xl font-black text-slate-800 tracking-tighter">{{ $r->year }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="font-bold text-slate-800 text-base">{{ $r->title }}</div>
                            <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-mono">ID: {{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-sm font-semibold text-slate-700">{{ $r->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('records.pdf', $r->id) }}" class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-bold hover:text-red-600 transition-all">PDF</a>
                                <a href="{{ route('records.excel', $r->id) }}" class="px-3 py-1 bg-slate-900 text-white rounded-lg text-xs font-bold hover:bg-blue-600 transition-all">EXCEL</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 italic">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SECTION 2: FILING CABINET --}}
    <div id="section-cabinet" class="hidden space-y-6 animate-in slide-in-from-bottom-10 duration-500">
        @if(!request('folder'))
            <div class="flex flex-wrap gap-3 p-6 bg-white rounded-[2rem] border border-slate-200 shadow-sm">
                <div class="w-full mb-2">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Select a Folder to Open</h3>
                </div>
                @foreach($folders as $f)
                    <a href="?folder={{ $f->prefix }}&tab=cabinet#section-cabinet" 
                    class="group flex items-center gap-4 p-5 bg-white border border-slate-200 rounded-3xl hover:border-blue-500 hover:shadow-xl transition-all min-w-[280px]">
                        
                        <span class="text-3xl transition-transform group-hover:scale-110">📁</span>
                        
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-400 tracking-wider">CODE {{ $f->prefix }}</span>
                            
                            <span class="text-xs font-black text-slate-700 uppercase group-hover:text-blue-600 leading-tight mb-1">
                                {{ $f->label }}
                            </span>
                            
                            {{-- Eto yung hiningi mong style --}}
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-blue-500 font-bold">
                                    {{ number_format($f->total) }} Records
                                </span>
                                <span class="text-slate-300 text-[10px]">|</span>
                                <span class="text-[10px] text-slate-600 font-bold">
                                    ₱{{ number_format($f->total_amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                       </div>
                 @endif

        @if(request('folder'))
            <div class="space-y-4">
                <div class="flex items-center justify-between px-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('records.index') }}?tab=cabinet" class="group flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all">
                            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/></svg>
                            Back
                        </a>
                        <h3 class="font-black text-slate-800 uppercase tracking-tighter">Folder {{ request('folder') }}</h3>
                    </div>
                    <a href="{{ route('records.export_folder', ['folder' => request('folder')]) }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 shadow-lg">
                        Download Excel
                    </a>
                </div>

                <div class="bg-white border border-slate-200 rounded-[2rem] shadow-2xl overflow-hidden">
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto custom-scrollbar"> 
                        <table class="w-full text-left text-[11px] border-separate border-spacing-0">
                            <thead class="sticky top-0 z-20">
                                <tr class="bg-slate-900 text-white uppercase tracking-tighter">
                                    <th class="p-4 border-r border-slate-800 font-bold sticky left-0 z-30 bg-slate-900">Property No.</th>
                                    <th class="p-4 border-r border-slate-800 font-bold min-w-[150px]">Article</th>
                                    <th class="p-4 border-r border-slate-800 font-bold min-w-[250px]">Description</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center">Unit</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-right">Value</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center bg-slate-800">Qty(C)</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center bg-slate-800">Qty(P)</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center bg-slate-800">Shortage(Qty)</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center bg-slate-800">Shortage(Value)</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center">Remarks</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center">Date Acquired</th>
                                    <th class="p-4 font-bold min-w-[150px]">Accountable Person</th>
                                     <th class="p-4 border-r border-slate-800 font-bold text-center">Transferred To</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center">Location</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center">Division</th>
                                    <th class="p-4 border-r border-slate-800 font-bold text-center">Section</th>

                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($inventoryItems as $item)
                                <tr class="hover:bg-blue-50/50 transition-colors group">
                                    {{-- CLICKABLE PROPERTY NO --}}
                                    <td class="p-4 border-r border-slate-50 font-mono font-bold text-blue-600 sticky left-0 bg-white group-hover:bg-blue-50">
                                        <button onclick="viewFullDetails({{ json_encode($item) }})" class="hover:underline">
                                            {{ $item->property_no }}
                                        </button>
                                    </td>
                                    <td class="p-4 border-r border-slate-50 font-bold text-slate-800 uppercase leading-tight">{{ $item->article }}</td>
                                    <td class="p-4 border-r border-slate-50 text-slate-700 italic">
                                        {{ Str::limit($item->description, 50) }}
                                    </td>
                                    <td class="p-4 border-r border-slate-50 text-center">{{ $item->unit_of_measure }}</td>
                                    <td class="p-4 border-r border-slate-50 text-right font-bold">₱{{ number_format($item->unit_value, 2) }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-black bg-slate-50/50">{{ $item->quantity_per_property_card }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-black bg-slate-50/50">{{ $item->quantity_per_physical_count }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-black bg-slate-50/50">{{ $item->shortage_overage_qty }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-bold bg-slate-50/50">₱{{ number_format($item->shortage_overage_value, 2) }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-semibold">{{ $item->remarks }}</td>
                                     <td class="p-4 border-r border-slate-50 text-right font-bold">{{ $item->date_acquired ?? '--' }}</td>
                                    <td class="p-4 font-bold text-slate-700 uppercase">{{ $item->accountable_person }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-bold text-emerald-600">{{ $item->transferred_to ?? '--' }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-semibold">{{ $item->location }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-semibold">{{ $item->division }}</td>
                                    <td class="p-4 border-r border-slate-50 text-center font-semibold">{{ $item->section_unit }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="8" class="p-20 text-center text-slate-400 italic font-bold">Folder is empty.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">{{ $inventoryItems->links() }}</div>
            </div>
        @else
            
        @endif
    </div>
</div>

{{-- MODAL --}}
<div id="descModal" class="hidden fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDescriptionModal()"></div>
        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full border border-slate-200">
            <div class="bg-white px-6 pt-6 pb-4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Full Record Details</h3>
                        <h2 class="text-lg font-black text-slate-800 uppercase leading-tight" id="modal-article-title">---</h2>
                    </div>
                    <button onclick="closeDescriptionModal()" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="mt-4 bg-slate-50 rounded-xl border border-slate-200 overflow-hidden shadow-inner max-h-[60vh] overflow-y-auto">
                    <table class="w-full text-left text-xs">
                        <tbody id="modal-details-body" class="divide-y divide-slate-200"></tbody>
                    </table>
                </div>
            </div>
            <div class="bg-slate-100 px-6 py-4 flex justify-end">
                <button onclick="closeDescriptionModal()" class="px-6 py-2 bg-slate-800 text-white text-xs font-black rounded hover:bg-black transition uppercase tracking-widest">Close Preview</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            document.getElementById(sections[key]).style.display = isMatch ? 'block' : 'none';
            document.getElementById(buttons[key]).className = isMatch 
                ? "flex items-center gap-2 px-6 py-3 text-xs font-bold rounded-xl transition-all duration-300 uppercase tracking-tighter bg-white text-blue-600 shadow-sm border border-slate-200"
                : "flex items-center gap-2 px-6 py-3 text-xs font-bold rounded-xl transition-all duration-300 uppercase tracking-tighter text-slate-400 hover:text-slate-600";
        });
    }

    // Init
    const urlParams = new URLSearchParams(window.location.search);
    switchTab(urlParams.has('folder') || urlParams.get('tab') === 'cabinet' ? 'cabinet' : 'recaps');
</script>
@endsection