@extends('layouts.dashboard')

@section('title', 'RPCPPE Management System')

@section('content')
<div class="max-w-[1600px] mx-auto px-2 sm:px-4 py-4 sm:py-6 font-sans text-slate-900">
    
    {{-- HEADER SECTION --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-6 border-b-2 border-slate-300 pb-5 gap-4">
        <div class="max-w-3xl">
            <h1 class="text-lg sm:text-xl md:text-2xl font-black tracking-tight text-slate-800 uppercase leading-tight">
                Report on the Physical Count of Property, Plant and Equipment
            </h1>
            <p class="text-[9px] sm:text-xs font-bold text-slate-500 mt-1 uppercase tracking-widest">
                Registry Module: Appendix 73 / Inventory Master List
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <div class="relative w-full sm:w-auto" id="export-container">
                <button type="button" id="menu-button" 
                        class="w-full inline-flex items-center justify-center gap-2 bg-slate-900 text-emerald-400 border border-emerald-500/30 px-5 py-2.5 rounded shadow-[0_0_15px_rgba(16,185,129,0.1)] text-xs font-black tracking-widest hover:bg-emerald-600 hover:text-white transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    GENERATE REPORTS
                </button>
                
                <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-72 bg-slate-900 border border-slate-700 shadow-2xl rounded-lg z-50 overflow-hidden ring-1 ring-emerald-500/20">
                    <div class="px-4 py-2 bg-slate-800/50 text-[10px] font-black text-emerald-500 tracking-widest border-b border-slate-700">PDF DOCUMENTS</div>
                    <a href="{{ route('rpcppe.print.table') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 text-xs text-slate-300 hover:bg-emerald-600 hover:text-white transition">
                        <span class="opacity-70">📄</span> RPCPPE Report Table
                    </a>
                    <a href="{{ route('rpcppe.reports.appendix73') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 text-xs text-slate-300 hover:bg-emerald-600 hover:text-white transition border-b border-slate-700">
                        <span class="opacity-70">📑</span> Appendix 73 (Official)
                    </a>

                    <div class="px-4 py-2 bg-slate-800/50 text-[10px] font-black text-blue-400 tracking-widest border-b border-slate-700">EXCEL DATA EXPORTS</div>
                    <a href="{{ route('rpcppe.export.excel', request()->query()) }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold text-emerald-400 hover:bg-slate-800 transition border-b border-slate-700/50">
                        <span>📊 Export Current View</span>
                        <span class="text-[9px] bg-emerald-500/10 px-2 py-0.5 rounded text-emerald-500">ACTIVE</span>
                    </a>
                    <a href="{{ route('rpcppe.reports.appendix73.export') }}" class="flex items-center gap-3 px-4 py-3 text-xs text-slate-300 hover:bg-slate-800 hover:text-white transition">
                        <span class="opacity-70">📥</span> Appendix 73 Master
                    </a>
                    <a href="{{ route('rpcppe.export.excel', ['all' => 1]) }}" class="flex items-center gap-3 px-4 py-3 text-xs text-slate-400 hover:bg-red-900/20 hover:text-red-400 transition">
                        <span class="opacity-70">⚠️</span> Full System Backup (All)
                    </a>
                </div>
            </div>

            <a href="{{ route('rpcppe.create') }}" 
               class="w-full sm:w-auto bg-slate-900 text-white px-5 py-2.5 rounded shadow-md text-xs font-bold hover:bg-black transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                ENCODE NEW ITEM
            </a>

            <form action="{{ route('rpcppe.import') }}" method="POST" enctype="multipart/form-data" id="importForm" class="flex items-center gap-2">
                @csrf
                <input type="file" name="file" class="hidden" id="importFile" accept=".xlsx, .xls, .csv">
                <button type="button" onclick="document.getElementById('importFile').click()" 
                        class="w-full sm:w-auto bg-emerald-600 text-white px-5 py-2.5 rounded shadow-md text-xs font-bold hover:bg-emerald-700 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    IMPORT XLSX
                </button>
            </form>
        </div>
    </div>

    {{-- FILTER FORM --}}
    <div class="bg-white border border-slate-300 rounded-lg p-4 sm:p-5 mb-6 shadow-sm">
        <form method="GET" action="{{ route('rpcppe.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase mb-1">Article</label>
                <input type="text" name="article" value="{{ request('article') }}" 
                       class="w-full border-slate-300 rounded text-xs py-2 px-3 focus:ring-1 focus:ring-slate-400" placeholder="Search item...">
            </div>

             <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase mb-1">Description</label>
                <input type="text" name="description" value="{{ request('description') }}" 
                       class="w-full border-slate-300 rounded text-xs py-2 px-3 focus:ring-1 focus:ring-slate-400" placeholder="Search item...">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase mb-1">Property No.</label>
                <input type="text" name="property_no" value="{{ request('property_no') }}" 
                       class="w-full border-slate-300 rounded text-xs py-2 px-3 focus:ring-1 focus:ring-slate-400" placeholder="e.g. 235-01">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase mb-1">Date Acquired</label>
                <input type="text" name="date_acquired" value="{{ request('date_acquired') }}" 
                       class="w-full border-slate-300 rounded text-xs py-2 px-3 focus:ring-1 focus:ring-slate-400" placeholder="Year or Full Date">
            </div>

          <div class="lg:col-span-2">
            <label class="block text-[10px] font-black text-slate-500 uppercase mb-1">Accountable, Transfer to: / Remarks</label>
            <input type="text" name="search_general" value="{{ request('search_general') }}" list="name_suggestions" 
                class="w-full border-slate-300 rounded text-xs py-2 px-3 focus:ring-1 focus:ring-slate-400" 
                placeholder="Name or Remarks...">
            <datalist id="name_suggestions">
                @foreach($allNames as $name)
                    <option value="{{ $name }}"></option>
                @endforeach
            </datalist>
        </div>
            
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase mb-1">Location</label>
                <input type="text" name="location" value="{{ request('location') }}" 
                    class="w-full border-slate-300 rounded text-xs py-2 px-3 focus:ring-1 focus:ring-slate-400" 
                    placeholder="Search location (e.g. NCR)...">
            </div>
                    
            <div>      
                <label class="block text-[10px] font-black text-slate-500 uppercase mb-1">Division</label>
                <input type="text" name="division" value="{{ request('division') }}" 
                    class="w-full border-slate-300 rounded text-xs py-2 px-3 focus:ring-1 focus:ring-slate-400" 
                    placeholder="Search division...">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-slate-800 text-white px-3 py-2 rounded text-xs font-bold hover:bg-black transition shadow-md h-[34px]">
                    FILTER
                </button>
                <a href="{{ route('rpcppe.index') }}" class="flex-1 flex items-center justify-center bg-white border border-slate-300 text-slate-600 px-3 py-2 rounded text-xs font-bold hover:bg-slate-100 transition shadow-sm h-[34px]">
                    RESET
                </a>
            </div>
        </form>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white border border-slate-300 rounded shadow-xl overflow-hidden">
        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full text-left border-collapse min-w-[1800px] table-fixed">
                <thead class="bg-gray-200 border-b-2 border-slate-300 sticky top-0 z-30">
                    <tr class="text-[10px] text-slate-700 uppercase tracking-wider">
                        <th class="p-2 border w-40 sticky left-0 bg-gray-200 z-10">Property No.</th>
                        <th class="p-2 border w-56">Article</th>
                        <th class="p-2 border w-72">Description</th>
                        <th class="p-2 border w-28">Unit of Measure</th>
                        <th class="p-2 border w-32 text-right">Unit of Value</th>
                        <th class="p-2 border w-32 text-center">Qty(Card)</th>
                        <th class="p-2 border w-32 text-center">Qty(Physical)</th>
                        <th class="p-2 border w-32 text-center text-orange-700">Shortage</th>
                        <th class="p-2 border w-36 text-right text-orange-700">S. Value</th>
                        <th class="p-2 border w-56">Remarks</th>
                        <th class="p-2 border w-32 text-center">Date Acquired</th>
                        <th class="p-2 border w-48">Accountable Person</th>
                        <th class="p-2 border w-48">Transfer to</th>
                        <th class="p-2 border w-40">Location</th>
                        <th class="p-2 border w-40">Division</th>
                        <th class="p-2 border w-40">Section</th>
                        <th class="p-3 border w-24 text-center sticky right-0 bg-gray-200 z-10 shadow-[-2px_0_5px_-2px_rgba(0,0,0,0.1)]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($items as $item)
                    <tr class="text-[11px] hover:bg-blue-50/50 transition-colors group">
                       <td class="p-2 border sticky left-0 bg-white group-hover:bg-blue-50/50 font-bold">
                            <button type="button" onclick="viewFullDetails({{ json_encode($item) }})" class="text-blue-700 hover:text-blue-900 hover:underline text-left">
                                {{ $item->property_no }}
                            </button>
                        </td>
                        <td class="p-2 border uppercase font-semibold text-slate-800">{{ $item->article }}</td>
                        <td class="p-2 border text-slate-700 italic">{{ Str::limit($item->description, 50) }}</td>    
                        <td class="p-2 border text-center">{{ $item->unit_of_measure }}</td>
                        <td class="p-2 border text-right">₱{{ number_format($item->unit_value, 2) }}</td>
                        <td class="p-2 border text-center">{{ $item->quantity_per_property_card }}</td>
                        <td class="p-2 border text-center">{{ $item->quantity_per_physical_count }}</td>
                        <td class="p-2 border text-center font-black text-orange-600">{{ $item->shortage_overage_qty }}</td>
                        <td class="p-2 border text-right font-black text-orange-600">₱{{ number_format($item->shortage_overage_value, 2) }}</td>
                        <td class="p-2 border text-slate-500 italic">{{ $item->remarks ?? '--' }}</td>
                        <td class="p-2 border text-center">{{ $item->date_acquired ?? '--' }}</td>
                        <td class="p-2 border uppercase">{{ $item->accountable_person }}</td>
                        <td class="p-2 border uppercase">{{ $item->transfer_to ?? '--' }}</td>
                        <td class="p-2 border uppercase">{{ $item->location }}</td>
                        <td class="p-2 border uppercase font-bold">{{ $item->division }}</td>
                        <td class="p-2 border uppercase">{{ $item->section_unit }}</td>
                        <td class="p-2 border sticky right-0 bg-white group-hover:bg-blue-50/50 text-center">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('rpcppe.edit', $item->id) }}" class="text-indigo-600 hover:scale-125 transition-transform" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('rpcppe.destroy', $item->id) }}" method="POST" class="delete-form inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-700 transition-transform hover:scale-125">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="17" class="p-10 text-center text-slate-400 italic">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-4 py-4 bg-slate-50 border-t-2 border-slate-300 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-[10px] font-black text-slate-500 uppercase">
                Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} entries
            </div>
            <div>
                {{ $items->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

{{-- CAPTURE MODAL --}}
<div id="descModal" class="hidden fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDescriptionModal()"></div>
        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full border border-slate-200">
            <div class="bg-white px-6 pt-6 pb-4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-1">Full Record Details</h3>
                        <h2 class="text-lg font-black text-slate-800 uppercase leading-tight" id="modal-article-title">---</h2>
                    </div>
                    <button onclick="closeDescriptionModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="mt-4 bg-slate-50 rounded-xl border border-slate-200 overflow-hidden shadow-inner max-h-[60vh] overflow-y-auto">
                    <table class="w-full text-left text-xs">
                        <tbody id="modal-details-body" class="divide-y divide-slate-200"></tbody>
                    </table>
                </div>
            </div>
            <div class="bg-slate-100 px-6 py-4 flex justify-end">
                <button type="button" onclick="closeDescriptionModal()" class="px-6 py-2 bg-slate-800 text-white text-xs font-black rounded hover:bg-black transition tracking-widest">CLOSE PREVIEW</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function viewFullDetails(item) {
        const modal = document.getElementById('descModal');
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
            { label: 'Section / Unit', value: item.section_unit },
            { label: 'Location', value: item.location },
            { label: 'Division', value: item.division }
        ];

        tbody.innerHTML = fields.map(field => `
            <tr>
                <td class="p-3 font-black text-slate-500 uppercase w-1/3 bg-slate-100/50 border-r border-slate-200">${field.label}</td>
                <td class="p-3 ${field.highlight ? 'text-blue-700 font-black' : 'text-slate-800 font-semibold'} italic">${field.value}</td>
            </tr>`).join('');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDescriptionModal() {
        document.getElementById('descModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // --- SESSION ALERTS ---
        @if(session('success'))
            Swal.fire({ title: 'Operation Successful', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#10b981', timer: 3000 });
        @endif

        @if(session('error'))
            Swal.fire({ title: 'System Error', text: "{{ session('error') }}", icon: 'error', confirmButtonColor: '#ef4444' });
        @endif

        @if ($errors->any())
            Swal.fire({ title: 'Validation Error', text: "{{ $errors->first() }}", icon: 'error', confirmButtonColor: '#ef4444' });
        @endif

        // --- IMPORT LOGIC ---
        const importInput = document.getElementById('importFile');
        if(importInput) {
            importInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const fileName = this.files[0].name;
                    Swal.fire({
                        title: 'Confirm Import',
                        text: `ARE YOU SURE YOU WANT TO IMPORT ${fileName}?`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Import it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({ title: 'Importing Data...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                            document.getElementById('importForm').submit();
                        } else {
                            this.value = '';
                        }
                    });
                }
            });
        }

        // --- DROPDOWN LOGIC ---
        const menuBtn = document.getElementById("menu-button");
        const dropdown = document.getElementById("dropdown-menu");
        if(menuBtn) {
            menuBtn.addEventListener("click", (e) => {
                e.stopPropagation();
                dropdown.classList.toggle("hidden");
            });
        }
        window.addEventListener('click', (e) => {
            if (dropdown && !document.getElementById('export-container').contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // --- DELETE WITH PIN LOGIC ---
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Manage Record',
                    text: "What would you like to do with this item?",
                    icon: 'question',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Permanent Delete',
                    denyButtonText: 'Move to Disposal',
                    confirmButtonColor: '#ef4444', 
                    denyButtonColor: '#10b981',    
                    cancelButtonColor: '#64748b',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Pin Security Step
                        Swal.fire({
                            title: 'Security Verification',
                            text: 'Enter ADMIN PIN to confirm deletion:',
                            input: 'password',
                            inputAttributes: { maxlength: 6, placeholder: 'Enter PIN' },
                            showCancelButton: true,
                            confirmButtonText: 'Verify PIN',
                            confirmButtonColor: '#ef4444',
                            preConfirm: (pin) => {
                                const correctPin = "123456"; // Palitan mo ito if needed
                                if (pin === correctPin) { return true; } 
                                else { Swal.showValidationMessage('Invalid PIN Code!'); return false; }
                            }
                        }).then((pinResult) => {
                            if (pinResult.isConfirmed) {
                                Swal.fire({ title: 'Deleting...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                                let input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'action_type';
                                input.value = 'permanent';
                                this.appendChild(input);
                                this.submit();
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire({ title: 'Moving to Disposal...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'action_type';
                        input.value = 'dispose';
                        this.appendChild(input);
                        this.submit();
                    }
                });
            });
        });
    });
</script>

<style>
    .overflow-x-auto::-webkit-scrollbar { height: 8px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f1f5f9; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection
