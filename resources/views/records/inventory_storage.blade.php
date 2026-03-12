@extends('layouts.dashboard')

@section('title', 'Inventory Storage')

@section('content')
<div class="max-w-[98%] mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    {{-- TOP NAV & HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">PROPERTY <span class="text-blue-600">ARCHIVE</span></h1>
            <p class="text-slate-500 text-sm">Inventory Filing Cabinet & Asset Repository</p>
        </div>
        
        <div class="flex p-1 bg-slate-100 rounded-xl border border-slate-200">
            <a href="{{ route('records.index') }}" class="px-5 py-2 text-xs font-bold text-slate-500 hover:text-slate-700 transition">YEARLY RECAPS</a>
            <a href="#" class="px-5 py-2 text-xs font-bold bg-white text-blue-600 rounded-lg shadow-sm ring-1 ring-slate-200">FILING CABINET</a>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- LEFT COLUMN: THE FOLDERS --}}
        <div class="w-full lg:w-72 flex-shrink-0">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Account Folders</h3>
            <div class="space-y-2 max-h-[70vh] overflow-y-auto pr-2 custom-scrollbar">
                @foreach($folders as $f)
                <div class="relative group">
                    <a href="?folder={{ $f->prefix }}#section-cabinet" 
                       class="flex items-center justify-between p-3 rounded-xl transition-all border {{ request('folder') == $f->prefix ? 'bg-blue-600 border-blue-600 shadow-lg shadow-blue-100' : 'bg-white border-slate-200 hover:border-blue-300 group-hover:shadow-md' }}">
                       
                       
                       
                

                    {{-- Floating Excel Button --}}
                    <a href="{{ route('records.export_folder', $f->prefix) }}" 
                       class="absolute -right-2 top-1/2 -translate-y-1/2 translate-x-1 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 bg-emerald-500 text-white p-2 rounded-lg shadow-xl hover:bg-emerald-600 transition-all z-10"
                       title="Export to Excel">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0112.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        {{-- RIGHT COLUMN: THE CONTENT --}}
        <div class="flex-1 min-w-0">
            <div class="bg-white shadow-2xl shadow-slate-200/60 border border-slate-200 rounded-[2rem] overflow-hidden flex flex-col h-[75vh]">
                
                {{-- Search Bar Header --}}
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-8 bg-blue-600 rounded-full"></div>
                        <h2 class="font-black text-slate-800 tracking-tight">
                            @if(request('folder')) Folder: <span class="text-blue-600">{{ request('folder') }}</span> @else All Items @endif
                        </h2>
                    </div>

                    <form action="{{ route('records.inventory_storage') }}" method="GET" class="relative w-full sm:w-72">
                        <input type="hidden" name="folder" value="{{ request('folder') }}">
                        <input type="text" name="description" value="{{ request('description') }}" 
                               placeholder="Filter assets..." 
                               class="w-full pl-4 pr-10 py-2.5 text-sm bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>

                {{-- Table Area --}}
                <div class="overflow-auto flex-1 custom-scrollbar">
                    <table class="w-full text-left text-[11px] border-separate border-spacing-0">
                        <thead class="sticky top-0 z-20">
                            <tr class="bg-slate-900 text-white uppercase tracking-tighter shadow-md">
                                <th class="p-4 border-r border-slate-800 font-bold sticky left-0 bg-slate-900 z-30">Property No.</th>
                                <th class="p-4 border-r border-slate-800 font-bold whitespace-nowrap">Article</th>
                                <th class="p-4 border-r border-slate-800 font-bold min-w-[250px]">Description</th>
                                <th class="p-4 border-r border-slate-800 font-bold text-center">Unit</th>
                                <th class="p-4 border-r border-slate-800 font-bold text-right">Value</th>
                                <th class="p-4 border-r border-slate-800 font-bold text-center bg-slate-800">Qty(C)</th>
                                <th class="p-4 border-r border-slate-800 font-bold text-center bg-slate-800">Qty(P)</th>
                                <th class="p-4 border-r border-slate-800 font-bold text-center bg-red-900/40 text-red-200">Shortage</th>
                                <th class="p-4 border-r border-slate-800 font-bold text-right bg-red-900/40 text-red-200">S. Value</th>
                                <th class="p-4 border-r border-slate-800 font-bold">Accountable</th>
                                <th class="p-4 border-r border-slate-800 font-bold">Acquired</th>
                                <th class="p-4 font-bold">Location Info</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $item)
                            <tr class="hover:bg-blue-50/50 transition-colors group">
                                <td class="p-4 border-r border-slate-100 font-mono font-bold text-blue-600 sticky left-0 bg-white group-hover:bg-blue-50 z-10 transition-colors">{{ $item->property_no }}</td>
                                <td class="p-4 border-r border-slate-100 font-bold text-slate-800 uppercase leading-none">{{ $item->article }}</td>
                                <td class="p-4 border-r border-slate-100 text-slate-500 leading-relaxed italic">{{ $item->description }}</td>
                                <td class="p-4 border-r border-slate-100 text-center font-medium">{{ $item->unit_of_measure }}</td>
                                <td class="p-4 border-r border-slate-100 text-right font-mono font-bold">₱{{ number_format($item->unit_value, 2) }}</td>
                                <td class="p-4 border-r border-slate-100 text-center bg-slate-50/50">{{ $item->quantity_per_property_card }}</td>
                                <td class="p-4 border-r border-slate-100 text-center bg-slate-50/50">{{ $item->quantity_per_physical_count }}</td>
                                <td class="p-4 border-r border-slate-100 text-center font-black {{ $item->shortage_overage_qty > 0 ? 'text-red-600 bg-red-50' : 'text-slate-300' }}">
                                    {{ $item->shortage_overage_qty }}
                                </td>
                                <td class="p-4 border-r border-slate-100 text-right font-bold {{ $item->shortage_overage_value > 0 ? 'text-red-600 bg-red-50' : 'text-slate-300' }}">
                                    {{ number_format($item->shortage_overage_value, 2) }}
                                </td>
                                <td class="p-4 border-r border-slate-100">
                                    <div class="font-bold text-slate-700 uppercase">{{ $item->accountable_person }}</div>
                                    <div class="text-[10px] text-slate-400">To: {{ $item->transfer_to ?? '--' }}</div>
                                </td>
                                <td class="p-4 border-r border-slate-100 text-center text-slate-500 whitespace-nowrap font-mono">{{ $item->date_acquired ?? '--' }}</td>
                                <td class="p-4">
                                    <div class="text-slate-600 font-bold uppercase">{{ $item->location }}</div>
                                    <div class="text-[9px] text-slate-400 font-black uppercase tracking-tighter">{{ $item->division }} • {{ $item->section_unit }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="p-20 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        <p class="text-xl font-black italic tracking-widest uppercase">Vault Empty</p>
                                        <p class="text-xs">Select a folder or try a different search</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                @if($items->hasPages())
                <div class="p-5 border-t border-slate-100 bg-slate-50">
                    {{ $items->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection