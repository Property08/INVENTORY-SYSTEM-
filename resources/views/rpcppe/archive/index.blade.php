@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight uppercase">Archived Records</h1>
            <p class="text-sm text-slate-500">Official Inventory Repository & Property Filing Management</p>
        </div>
    </div>

    <div class="mb-6 bg-slate-50 p-2 rounded-xl border border-slate-200 inline-flex items-center space-x-2 shadow-sm">
        <a href="{{ route('ppe-recap.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800 rounded-lg transition-all duration-200 flex items-center space-x-2">
            <i class="fa-regular fa-file-lines text-base"></i>
            <span>YEARLY RECAPS</span>
        </a>
        <a href="{{ route('rpcppe.archive.index') }}" class="px-4 py-2 text-sm font-semibold text-blue-600 bg-white shadow-sm border border-slate-200/60 rounded-lg flex items-center space-x-2">
            <i class="fa-solid fa-box-archive text-base"></i>
            <span>FILING CABINET</span>
        </a>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mb-6">
        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Select a Filter to Open</div>
        
        <form action="{{ route('rpcppe.archive.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex flex-1 flex-col md:flex-row gap-4 w-full">
                <div class="w-full md:w-48">
                    <select name="archive_year" onchange="this.form.submit()" class="w-full rounded-xl border border-slate-200 p-3 text-sm font-medium text-slate-700 bg-slate-50 focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 transition-all shadow-sm">
                        <option value="">All Available Years</option>
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ request('archive_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center space-x-3 w-full md:w-auto justify-end">
                <button type="button" onclick="openImportModal()" class="w-full md:w-auto px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-xl transition-all shadow-sm shadow-emerald-100 flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-file-import"></i>
                    <span>IMPORT OLD XLSX</span>
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($folders as $folder)
            <a href="{{ route('rpcppe.archive.folder', ['classification' => urlencode($folder->classification ?: 'UNCLASSIFIED'), 'archive_year' => request('archive_year')]) }}" 
               class="group block bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-100 transition-all duration-200 relative overflow-hidden">
                
                <div class="absolute top-0 left-0 right-0 h-[3px] bg-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>

                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <i class="fa-regular fa-folder-open text-xl"></i>
                    </div>
                    <span class="text-[10px] font-bold uppercase px-2 py-1 bg-slate-100 text-slate-500 tracking-wider rounded-md">
                        ACTIVE FILE
                    </span>
                </div>

                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-tight line-clamp-1 group-hover:text-blue-600 transition-colors duration-200 mb-6">
                    {{ $folder->classification ?: 'UNCLASSIFIED' }}
                </h3>

                <div class="grid grid-cols-2 gap-2 pt-4 border-t border-slate-100 text-xs">
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">RECORDS</div>
                        <div class="text-sm font-black text-slate-700">{{ number_format($folder->total_records) }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">TOTAL VALUE</div>
                        <div class="text-sm font-black text-blue-600">₱{{ number_format($folder->total_value, 2) }}</div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-slate-50 rounded-2xl p-12 border border-dashed border-slate-200 text-center">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-folder-minus text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-700 mb-1">No Archived Folders Generated</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Walang makikitang records para sa taong pinili mo sa itaas. Subukang baguhin ang filter o mag-import ng lumang spreadsheet.</p>
            </div>
        @endforelse
    </div>
</div>

<div id="importModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 transition-all">
    <div class="bg-white w-full max-w-md rounded-2xl border border-slate-100 shadow-xl overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div class="flex items-center space-x-2 text-slate-800">
                <i class="fa-solid fa-file-excel text-emerald-600 text-lg"></i>
                <h3 class="font-bold text-sm uppercase tracking-wider">Import Historical Spreadsheet</h3>
            </div>
            <button type="button" onclick="closeImportModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form action="{{ route('rpcppe.import') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Choose Excel File (.xlsx, .xls)</label>
                <input type="file" name="file" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 border border-slate-200 rounded-xl p-1.5 focus:outline-none focus:border-blue-500">
            </div>
            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2 text-xs font-semibold text-slate-500 hover:text-slate-700">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl">Upload and Parse</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openImportModal() { document.getElementById('importModal').classList.remove('hidden'); }
    function closeImportModal() { document.getElementById('importModal').classList.add('hidden'); }
</script>
@endsection