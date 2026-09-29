@extends('layouts.dashboard')

@section('title', 'Disposal Registry')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    {{-- Success Alert Notification --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl text-xs font-bold shadow-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Error Alert Notification --}}
    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-xl text-xs font-bold shadow-sm flex items-center justify-between">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Header Section with Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase">Disposal Items Registry</h1>
            <p class="text-xs text-slate-500 font-medium">List of Disposal inventory and WMR records.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('disposable.exportPDF') }}" class="px-4 py-2.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-bold hover:bg-rose-100 transition shadow-sm flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export PDF
            </a>

            <a href="{{ route('disposable.exportExcel') }}" class="px-4 py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-bold hover:bg-emerald-100 transition shadow-sm flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </a>

            <a href="{{ route('disposable.create') }}" class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-black transition shadow-lg">
                + Add New Item
            </a>
        </div>
    </div>

    {{-- Search Bar Section --}}
    <form method="GET" action="{{ route('disposable.index') }}" class="mb-6">
        <div class="flex gap-2">
            <div class="relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search Property #, Description, Name, Place, WMR #, or Type (wmr/disposed)..." 
                       class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 shadow-sm">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition shadow-sm">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('disposable.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition flex items-center">
                    Clear
                </a>
            @endif
        </div>
    </form>

    {{-- Table Section --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Property #</th>
                        <th class="p-4">Article / Description</th>
                        <th class="p-4">Qty</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Place / Location</th>
                        <th class="p-4">Accountability Name</th>
                        <th class="p-4">WMR # / Type</th>
                        <th class="p-4 text-center">Attachment</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($disposables as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-mono font-bold text-slate-900 whitespace-nowrap">{{ $item->property_number }}</td>
                            <td class="p-4 font-bold text-slate-800">
                                {{ $item->article ?? $item->description ?? '—' }}
                                @if($item->description)
                                    <span class="block text-[10px] text-slate-400 font-normal">Description: {{ $item->description }}</span>
                                @endif
                            </td>
                            <td class="p-4 font-bold">{{ $item->quantity }}</td>
                            <td class="p-4 font-bold">{{ $item->unit_value ? '₱' . number_format($item->unit_value, 2) : '—' }}</td>
                            <td class="p-4 font-bold text-slate-600">{{ $item->place ?? ($item->location ?? '—') }}</td>
                            <td class="p-4 font-bold">{{ $item->name }}</td>
                            
                            {{-- WMR # and Disposal Type Badge Column --}}
                            <td class="p-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-slate-800 block">{{ $item->WMR_num ?? '—' }}</span>
                                @if(strtolower($item->disposal_type) == 'disposed')
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded text-[9px] font-bold uppercase tracking-wider">Disposed</span>
                                @else
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded text-[9px] font-bold uppercase tracking-wider">WMR</span>
                                @endif
                            </td>
                            
                            {{-- Multiple File Attachments Column --}}
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                    @if(!empty($item->scanned_photos) && is_array($item->scanned_photos))
                                        @foreach($item->scanned_photos as $index => $file)
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank" 
                                               class="px-2 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg text-[10px] font-bold hover:bg-blue-100 transition"
                                               title="View File #{{ $index + 1 }}">
                                               📄 File {{ $index + 1 }}
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="text-[10px] text-slate-300 font-normal">None</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Actions Column --}}
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    {{-- Restore Button --}}
                                    <form id="restore-form-{{ $item->id }}" action="{{ route('disposable.restore', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="button" 
                                                onclick="confirmRestore({{ $item->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-600 hover:text-white rounded-lg text-xs font-bold transition"
                                                title="Restore to RPCPPE">
                                            Restore
                                        </button>
                                    </form>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('disposable.edit', $item->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-bold transition">
                                        Edit
                                    </a>

                                    {{-- Delete Button --}}
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('disposable.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete({{ $item->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-600 hover:text-white rounded-lg text-xs font-bold transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-400 italic">
                                No disposable records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SweetAlert2 CDN and Script --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure you want to delete this?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function confirmRestore(id) {
        Swal.fire({
            title: 'You sure you want to restore this item/record?',
            text: "This item/record will be restored to the main RPCPPE inventory.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, restore it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('restore-form-' + id).submit();
            }
        });
    }
</script>
@endsection