@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">
                <a href="{{ route('rpcppe.archive.index') }}" class="hover:text-blue-600 transition-colors">Filing Cabinet</a>
                <span><i class="fa-solid fa-angle-right text-[10px]"></i></span>
                <span class="text-slate-600">Folder View</span>
            </div>
            <h1 class="text-xl font-black text-slate-800 uppercase tracking-tight flex items-center space-x-2">
                <i class="fa-regular fa-folder-open text-blue-600"></i>
                <span>{{ $classification }}</span>
            </h1>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('rpcppe.archive.index', ['archive_year' => request('archive_year')]) }}" class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all shadow-sm flex items-center space-x-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Cabinet</span>
            </a>
            
            <a href="{{ route('rpcppe.export.excel', ['archive_classification' => $classification, 'archive_year' => request('archive_year'), 'is_archive' => true]) }}" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-sm shadow-blue-100 flex items-center space-x-2">
                <i class="fa-solid fa-file-excel"></i>
                <span>EXPORT THIS FOLDER</span>
            </a>
        </div>
    </div>

    <div class="mb-6 bg-blue-50/60 border border-blue-100 p-4 rounded-2xl flex items-center justify-between text-xs text-blue-700 font-medium shadow-sm">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-circle-info text-sm text-blue-500"></i>
            <span>Ipinapakita ang mga historical archived assets sa ilalim ng cluster code na ito.</span>
        </div>
        @if(request('archive_year'))
            <span class="px-2.5 py-1 bg-blue-600 text-white font-bold rounded-lg uppercase tracking-wider">Filtered Year: {{ request('archive_year') }}</span>
        @else
            <span class="px-2.5 py-1 bg-slate-500 text-white font-bold rounded-lg uppercase tracking-wider">All Historical Years</span>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="p-4">Property No.</th>
                        <th class="p-4">Article</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Unit Value</th>
                        <th class="p-4">Qty (Card)</th>
                        <th class="p-4">Qty (Physical)</th>
                        <th class="p-4">Date Acquired</th>
                        <th class="p-4">Accountable Person</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-xs font-medium text-slate-700">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 font-bold text-slate-900">{{ $item->property_no }}</td>
                            <td class="p-4 uppercase">{{ $item->article }}</td>
                            <td class="p-4 max-w-xs truncate uppercase text-slate-500" title="{{ $item->description }}">{{ $item->description ?: '—' }}</td>
                            <td class="p-4 font-semibold text-blue-600">₱{{ number_format($item->unit_value, 2) }}</td>
                            <td class="p-4 text-center font-bold">{{ $item->quantity_per_property_card ?? 0 }}</td>
                            <td class="p-4 text-center font-bold">{{ $item->quantity_per_physical_count ?? 0 }}</td>
                            <td class="p-4 text-slate-500">{{ $item->date_acquired ?: '—' }}</td>
                            <td class="p-4 uppercase text-slate-800">{{ $item->accountable_person ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400 bg-slate-50/30">
                                <div class="mb-2"><i class="fa-regular fa-folder-open text-2xl text-slate-300"></i></div>
                                <span class="text-xs font-medium">Walang nakitang records sa loob ng folder na ito para sa napiling parameter.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="p-4 border-t border-slate-50 bg-slate-50/40">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection