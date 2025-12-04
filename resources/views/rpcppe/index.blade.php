@extends('layouts.dashboard')

@section('title', 'RPCPPE')

@section('content')
<!-- Left Side: Add New Button -->
<div class="flex items-center justify-between mb-6">
     <h1 class="text-3xl font-bold text-gray-800">REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT AND EQUIPMENT</h1>
    <a href="{{ route('rpcppe.create') }}"
       class="inline-flex items-center gap-2 bg-gradient-to-r from-white-500 to-blue-700 text-black px-6 py-3 rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Add New RPCPPE</span>
    </a>
</div>

<!-- Middle: Search + Filter -->
<div class="flex-1 mt-4">
    <form method="GET" action="{{ route('rpcppe.index') }}" class="flex gap-2 justify-end">
        <input type="text" name="search" value="{{ request('search') }}"
               class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 w-60"
               placeholder="Search...">
        <select name="filter"
                class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">
            <option value="">All</option>
            <option value="article" {{ request('filter')=='article' ? 'selected' : '' }}>Article</option>
            <option value="description" {{ request('filter')=='description' ? 'selected' : '' }}>Description</option>
            <option value="property_no" {{ request('filter')=='property_no' ? 'selected' : '' }}>Property No</option>
            <option value="accountable_person" {{ request('filter')=='accountable_person' ? 'selected' : '' }}>Accountable Person</option>
            <option value="location" {{ request('filter')=='location' ? 'selected' : '' }}>Location</option>
            <option value="division" {{ request('filter')=='division' ? 'selected' : '' }}>Division</option>
            <option value="section_unit" {{ request('filter')=='section_unit' ? 'selected' : '' }}>Section/Unit</option>
            <option value="remarks" {{ request('filter')=='remarks' ? 'selected' : '' }}>Remarks</option>
        </select>
        <button type="submit"
                class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition">
            🔍 Search
        </button>
    </form>
</div>

<!-- Reports & Export Dropdown -->
<div class="relative inline-block text-left mb-4 mt-4">
    <button type="button"
            id="menu-button"
            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-700 text-sm font-medium text-white hover:bg-gray-800 focus:outline-none">
        📂 Reports & Export
        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
        </svg>
    </button>
  <!-- Dropdown menu -->
        <div class="origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden"
             id="dropdown-menu">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="menu-button">
                <a href="{{ route('rpcppe.print.table') }}" target="_blank"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                   🖨 Print Table (PDF)
                </a>
                <a href="{{ route('rpcppe.reports.appendix73') }}" target="_blank"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                   🖨 Print Appendix 73 (PDF)
                </a>
                <a href="{{ route('rpcppe.reports.appendix73.export') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                   📊 Download Appendix 73 (Excel)
                </a>
                <a href="{{ route('rpcppe.export.excel') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                   📑 Download RPCPPE (Excel)
                </a>
                 <!-- Print Filtered -->
                    <a href="{{ route('rpcppe.print.filtered', request()->query()) }}" target="_blank"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                       📑 Print Search Results (PDF)
                    </a>
        </div>
    </div>
</div>

    <!-- Data Table -->
<div class="bg-white shadow-md rounded-lg p-4 overflow-x-auto">
    <table class="w-full border-collapse text-sm">
        <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-2 border" rowspan="2">Property No.</th>
            <th class="p-2 border" rowspan="2">Article</th>
            <th class="p-2 border" rowspan="2">Description</th>
            <th class="p-2 border" rowspan="2">Unit of Measure</th>
            <th class="p-2 border" rowspan="2">Unit Value</th>

            <th class="p-2 border text-center" colspan="2">Quantity Per</th>
            <th class="p-2 border text-center" colspan="2">Shortage / Overage</th>

            <th class="p-2 border" rowspan="2">Remarks</th>
            <th class="p-2 border" rowspan="2">Date Acquired</th>
            <th class="p-2 border" rowspan="2">Accountable Person</th>
            <th class="p-2 border" rowspan="2">Location</th>
            <th class="p-2 border" rowspan="2">PRSD</th>
            <th class="p-2 border" rowspan="2">Division</th>
            <th class="p-2 border" rowspan="2">Section/Unit</th>
            <th class="p-2 border" rowspan="2">Transferred to</th>
            <th class="p-4 border no-print" rowspan="2">Actions</th>
        </tr>
        <tr class="bg-gray-200 text-left">
            <th class="p-2 border">Card</th>
            <th class="p-2 border">Physical</th>
            <th class="p-2 border">Qty</th>
            <th class="p-2 border">Value</th>
        </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                <td class="p-2 border">{{ $item->property_no }}</td>
                <td class="p-2 border">{{ $item->article }}</td>
                <td class="p-2 border">{{ $item->description }}</td>
                <td class="p-2 border">{{ $item->unit_of_measure }}</td>
                <td class="p-2 border">{{ $item->unit_value }}</td>
                <td class="p-2 border">{{ $item->quantity_per_property_card }}</td>
                <td class="p-2 border">{{ $item->quantity_per_physical_count }}</td>
                <td class="p-2 border">{{ $item->shortage_overage_qty }}</td>
                <td class="p-2 border">{{ $item->shortage_overage_value }}</td>
                <td class="p-2 border">{{ $item->remarks }}</td>
                <td class="p-2 border">{{ \Carbon\Carbon::parse($item->date_acquired)->format('Y-m-d') }}</td>
                <td class="p-2 border">{{ $item->accountable_person }}</td>
                <td class="p-2 border">{{ $item->location }}</td>
                <td class="p-2 border">{{ $item->ptsd }}</td>
                <td class="p-2 border">{{ $item->division }}</td>
                <td class="p-2 border">{{ $item->section_unit }}</td>
                <td class="p-2 border">{{ $item->transfer_to }}</td>
                <td class="p-4 border no-print">
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('rpcppe.edit', $item->id) }}"
                           class="bg-blue-500 text-white shadow hover:bg-blue-800 text-xs py-2 px-6 rounded">
                            Edit
                        </a>
                        <form action="{{ route('rpcppe.destroy', $item->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white shadow hover:bg-red-800 text-xs py-2 px-6 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="18" class="text-center py-4 text-gray-500">
                    No records found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("menu-button").addEventListener("click", function () {
    document.getElementById("dropdown-menu").classList.toggle("hidden");
});
window.addEventListener('click', function (e) {
    const button = document.getElementById("menu-button");
    const menu   = document.getElementById("dropdown-menu");
    if (!button.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
@if(session('action') === 'add')
    Swal.fire({ title: 'Success!', text: "Record added successfully!", icon: 'success' });
@elseif(session('action') === 'edit')
    Swal.fire({ title: 'Updated!', text: "Record updated successfully!", icon: 'info' });
@elseif(session('action') === 'delete')
    Swal.fire({ title: 'Deleted!', text: "Record deleted successfully!", icon: 'success' });
@endif
</script>
@endsection
