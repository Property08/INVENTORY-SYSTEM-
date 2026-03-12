@extends('layouts.dashboard')

@section('title', 'Disposal Registry')

@section('content')
<div class="max-w-[1600px] mx-auto px-4 sm:px-6 py-6 sm:py-8 font-sans text-slate-900">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 pb-6 border-b-2 border-slate-200 gap-6">
        <div class="text-left">
            <div class="flex items-center gap-2 text-red-600 mb-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span class="text-[10px] font-black uppercase tracking-[0.3em]">Inventory Disposal Module</span>
            </div>
            <h1 class="text-2xl xs:text-3xl font-black text-slate-800 tracking-tight uppercase">Disposable Equipment</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium italic mt-1">Management of Waste Materials and Property Disposal</p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-4">
            {{-- SEARCH BAR --}}
            <form action="{{ route('disposable.index') }}" method="GET" class="w-full max-w-sm min-w-[300px] relative">
                @if(request('search'))
                    <a href="{{ route('disposable.index') }}" class="absolute -top-5 right-0 text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline">&times; Clear Results</a>
                @endif
                <div class="relative">
                    <input name="search" value="{{ request('search') }}" class="w-full bg-white text-slate-700 text-sm border border-slate-200 rounded-md pl-3 pr-28 py-2.5 focus:outline-none focus:border-slate-400 shadow-sm" placeholder="Search property or name..."/>
                    <button class="absolute top-1 right-1 rounded bg-slate-800 py-1.5 px-3 text-xs text-white hover:bg-slate-700 transition-all" type="submit">Search</button>
                </div>
            </form>

            <div class="flex items-center gap-2">
                <a href="{{ route('disposable.pdf') }}" class="flex gap-2 rounded-md bg-slate-100 py-2 px-4 text-slate-700 text-xs font-bold border border-slate-200 hover:bg-slate-200 transition-all">PDF</a>
                <a href="{{ route('disposable.excel') }}" class="flex gap-2 rounded-md bg-slate-800 py-2 px-4 text-white text-xs font-bold hover:bg-slate-700 transition-all shadow-md">EXCEL</a>
                <a href="{{ route('disposable.create') }}" class="flex gap-2 rounded-md bg-red-600 py-2 px-5 text-white text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg active:scale-95">Record Disposal</a>
            </div>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Disposed Items</p>
            <p class="text-3xl font-black text-slate-800">{{ $disposables->count() }}</p>
        </div>
        <div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Quantity</p>
            <p class="text-3xl font-black text-slate-800">{{ $disposables->sum('quantity') }}</p>
        </div>
        <div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Registry Status</p>
            <span class="inline-block mt-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded uppercase">Live Data</span>
        </div>
    </div>

    {{-- DATA TABLE --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-xl shadow-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                        <th class="px-6 py-4">Property Number</th>
                        <th class="px-4 py-4 text-center">Qty</th>
                        <th class="px-6 py-4">Unit Value</th>
                        <th class="px-6 py-4">Article</th>
                        <th class="px-6 py-4">Description</th>
                       <th class="px-6 py-4">Accountability Name</th>
                       <th class="px-6 py-4">Date Acquired</th>
                        <th class="px-6 py-4 text-center">Year</th>
                        <th class="px-6 py-4">WMR Num</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($disposables as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        {{-- CLICKABLE PROPERTY NO --}}
                        <td class="px-6 py-4 font-mono text-[11px] font-bold text-blue-600">
                            <button onclick="viewFullDisposalDetails({{ json_encode($item) }})" class="hover:underline hover:text-blue-800 transition-colors">
                                {{ $item->property_number }}
                            </button>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded text-[10px] font-black">{{ $item->quantity }}</span>
                        </td>
                        <td class="px-6 py-4 text-[10px] font-bold text-slate-800">{{ $item->unit_value ? number_format($item->unit_value, 2) : 'N/A' }}</td>
                        <td class="px-6 py-4 text-[10px] font-bold text-slate-800">{{ $item->article ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500 italic">{{ Str::limit($item->description, 40) }}</td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-800 uppercase">{{ $item->name }}</td>
                        <td class="px-6 py-4 text-center text-[10px] font-semibold text-slate-700">
                            {{ $item->DateAcquired ? \Carbon\Carbon::parse($item->DateAcquired)->format('m/d/Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-center text-[10px] font-black text-slate-800">{{ $item->year ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="text-[9px] bg-red-50 text-red-700 px-2 py-1 rounded font-black border border-red-100 uppercase">{{ $item->WMR_num }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('disposable.edit', $item->id) }}" class="p-1 text-indigo-600 hover:bg-indigo-50 rounded transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('disposable.destroy', $item->id) }}" method="POST" class="delete-form inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1 text-red-400 hover:bg-red-50 rounded transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-20 text-center text-slate-400 font-bold uppercase text-[10px] tracking-widest">No results found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ENHANCED MODAL --}}
<div id="descModal" class="hidden fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDescriptionModal()"></div>
        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-xl sm:w-full border border-slate-200">
            <div class="bg-white px-6 pt-6 pb-4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1">Disposal Record Details</h3>
                        <h2 class="text-lg font-black text-slate-800 uppercase leading-tight" id="modal-item-name">---</h2>
                    </div>
                    <button onclick="closeDescriptionModal()" class="text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="mt-4 bg-slate-50 rounded-xl border border-slate-200 overflow-hidden shadow-inner max-h-[60vh] overflow-y-auto">
                    <table class="w-full text-left text-xs">
                        <tbody id="modal-details-body" class="divide-y divide-slate-200">
                            {{-- JS will inject rows here --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-slate-100 px-6 py-4 flex justify-end gap-3">
                <button onclick="closeDescriptionModal()" class="px-6 py-2 bg-slate-800 text-white text-xs font-black rounded hover:bg-black transition uppercase tracking-widest">Close View</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SweetAlert Deletion with Enhanced UI and PIN
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const REQUIRED_PIN = "0808"; 

        Swal.fire({
            title: `
                <div class="flex flex-col items-center gap-2">
                    <div class="bg-red-100 p-3 rounded-full mb-2">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <span class="uppercase tracking-[0.2em] text-xl font-black text-slate-800">Security Check</span>
                </div>
            `,
            html: `
                <p class="text-slate-500 text-sm font-medium mb-4">You are about to permanently delete a disposal record. This action cannot be undone.</p>
                <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">Please enter Admin PIN</p>
            `,
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off',
                maxlength: 4,
                textAlign: 'center',
                class: 'swal2-input-custom' // We will add styling for this
            },
            showCancelButton: true,
            confirmButtonColor: '#000000', // Black button like your dashboard style
            cancelButtonColor: '#f1f5f9', // Slate-100
            confirmButtonText: 'CONFIRM DESTRUCTION',
            cancelButtonText: 'KEEP RECORD',
            buttonsStyling: true,
            customClass: {
                popup: 'rounded-2xl border-2 border-red-500 shadow-2xl',
                confirmButton: 'px-8 py-3 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all hover:bg-red-600',
                cancelButton: 'px-8 py-3 rounded-lg text-[11px] font-black uppercase tracking-widest text-slate-500 transition-all hover:bg-slate-200',
                input: 'font-mono text-2xl tracking-[0.5em] text-center border-2 border-slate-200 focus:border-red-500 focus:ring-0 rounded-xl'
            },
            preConfirm: (inputPin) => {
                if (inputPin === REQUIRED_PIN) {
                    return true;
                } else {
                    Swal.showValidationMessage(`
                        <span class="text-[10px] font-black uppercase tracking-widest">Access Denied: Incorrect PIN</span>
                    `);
                    return false;
                }
            }
        }).then(result => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '<span class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">Destroying Record...</span>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                setTimeout(() => form.submit(), 800);
            }
            });
        });
    });

    // 2. VIEW DETAILS MODAL FUNCTIONS
    function viewFullDisposalDetails(item) {
        document.getElementById('modal-item-name').innerText = item.name || 'N/A';
        const tbody = document.getElementById('modal-details-body');
        
        const fields = [
            { label: 'Property Number', value: item.property_number, highlight: true },
            { label: 'Description', value: item.description },
            { label: 'Quantity', value: item.quantity },
            { label: 'Date Acquired', value: item.DateAcquired || '--' },
            { label: 'Disposal Year', value: item.year || 'N/A' },
            { label: 'WMR Number', value: item.WMR_num }
        ];

        tbody.innerHTML = fields.map(field => `
            <tr>
                <td class="p-4 font-black text-slate-500 uppercase w-1/3 bg-slate-100/30 border-r border-slate-200">${field.label}</td>
                <td class="p-4 ${field.highlight ? 'text-blue-700 font-black' : 'text-slate-800 font-semibold'} italic">${field.value}</td>
            </tr>`).join('');

        document.getElementById('descModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDescriptionModal() {
        document.getElementById('descModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Keyboard ESC to close modal
    window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDescriptionModal(); });
</script>
@endsection