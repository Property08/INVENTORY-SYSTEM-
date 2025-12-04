@extends('layouts.dashboard')

@section('title', 'RECAP / SUMMARY')

@section('content')

<!-- 🔎 Search & Actions -->
<div class="flex-1 mt-4lex items-center justify-between">
     <h1 class="text-3xl font-bold text-gray-800">RECAP/SUMMARY RECORD</h1>
    <!-- Search Form -->
    <form method="GET" action="{{ route('recap.index') }}" class="flex gap-2 justify-end">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search Recap..."
               class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 w-60">

        
            <button type="submit"
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition">
                Search
            </button>

             @if(request()->has('search'))  
        <a href="{{ route('recap.index') }}" class="bg-gray-400 text-white px-6 py-3 rounded hover:bg-gray-600 transition">  
            Reset  
        </a>  
    @endif  
        
    </form>

    <!-- Action Buttons -->
    <div>
        <a href="{{ route('recap.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-white-500 to-blue-700 text-black px-6 py-3 rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New
        </a>

        
    </div>
</div>

  <!-- PRINT/PDF BUTTON -->  
  <div class="justify-end flex mb-4">  
     <a href="{{ route('recap.print.pdf', request()->all()) }}"  
        id="menu-button"  
    class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition">  
         RECAP/SUMMARY Report  
         
    </a>  
</div> 

<!-- 📊 Table Section -->
<div class="bg-white shadow-lg rounded-lg mt-6 overflow-x-auto">
    <table class="w-full border-collapse text-sm min-w-[1000px]">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-3 border text-center" colspan="2">Acct. Code</th>
                <th class="p-3 border" rowspan="2">Classification Code</th>
                <th class="p-3 border" rowspan="2">Beginning Balance</th>
                <th class="p-3 border" rowspan="2">Purchases</th>
                <th class="p-3 border" rowspan="2">Reclassified From</th>
                <th class="p-3 border" rowspan="2">Reclassified To</th>
                <th class="p-3 border" rowspan="2">Disposed</th>
                <th class="p-3 border" rowspan="2">Donated</th>
                <th class="p-3 border" rowspan="2">Adjustments</th>
                <th class="p-3 border" rowspan="2">Total</th>
                <th class="p-3 border no-print text-center" rowspan="2">Actions</th>
            </tr>
            <tr>
                <th class="p-2 border text-center">Old</th>
                <th class="p-2 border text-center">New</th>
            </tr>
        </thead>
        <tbody class="text-gray-600">
            @forelse($recap as $asset)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-2 border text-center">{{ $asset->acct_code_old }}</td>
                    <td class="p-2 border text-center">{{ $asset->acct_code_new }}</td>
                    <td class="p-2 border">{{ $asset->classification_code }}</td>
                    <td class="p-2 border text-right">{{ number_format($asset->beginning_balance, 2) }}</td>
                    <td class="p-2 border text-right">{{ number_format($asset->purchase_2024, 2) }}</td>
                    <td class="p-2 border text-right">{{ number_format($asset->reclassified_from_other, 2) }}</td>
                    <td class="p-2 border text-right">{{ number_format($asset->reclassified_to_other, 2) }}</td>
                    <td class="p-2 border text-right">{{ number_format($asset->disposed, 2) }}</td>
                    <td class="p-2 border text-right">{{ number_format($asset->donated, 2) }}</td>
                    <td class="p-2 border text-right">{{ number_format($asset->cancelled_adjustment, 2) }}</td>
                    <td class="p-2 border text-right font-semibold">{{ number_format($asset->total_2024, 2) }}</td>
                    <td class="p-2 border no-print text-center">
                        <div class="flex flex-col sm:flex-row justify-center gap-2">
                            <a href="{{ route('recap.edit', $asset->id) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 shadow w-full sm:w-auto text-center">
                                Edit
                            </a>
                            <form action="{{ route('recap.destroy', $asset->id) }}" method="POST" class="delete-form inline-block w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 shadow w-full sm:w-auto">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center py-6 text-gray-500">
                        No records found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="p-4">
        {{ $recap->links() }}
    </div>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Delete Record?',
            text: "This record will be permanently removed.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});

@if(session('action') === 'add')
    Swal.fire({ title: 'Success!', text: "Record added successfully!", icon: 'success', timer: 1200, showConfirmButton: false });
@elseif(session('action') === 'edit')
    Swal.fire({ title: 'Updated!', text: "Record updated successfully!", icon: 'info', timer: 1200, showConfirmButton: false });
@elseif(session('action') === 'delete')
    Swal.fire({ title: 'Deleted!', text: "Record deleted successfully!", icon: 'success', timer: 1200, showConfirmButton: false });
@endif
</script>
@endsection
