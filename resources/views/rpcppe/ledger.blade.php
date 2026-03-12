@extends('layouts.dashboard')
@section('content')
<div class="p-6">
    <div class="bg-white border-l-8 border-blue-600 shadow-md p-6 mb-6 rounded-r-lg">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ $prop_no }}</h1>
                <p class="text-blue-600 font-bold uppercase tracking-widest text-sm">{{ $title }} - Account History</p>
            </div>
            <a href="{{ route('rpcppe.index') }}" class="text-xs font-bold bg-slate-100 px-4 py-2 rounded hover:bg-slate-200">← BACK TO MAIN TABLE</a>
        </div>
    </div>

    <div class="bg-white border border-slate-300 rounded-lg shadow-xl overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-800 text-white uppercase">
                <tr>
                    <th class="p-4 border-r border-slate-700">Year Acquired</th>
                    <th class="p-4 border-r border-slate-700">Accountable Person</th>
                    <th class="p-4 border-r border-slate-700">Description</th>
                    <th class="p-4 border-r border-slate-700">Unit Value</th>
                    <th class="p-4 border-r border-slate-700">Location</th>
                    <th class="p-4">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr class="border-b hover:bg-blue-50 transition-colors">
                    <td class="p-4 font-black text-blue-700 bg-blue-50/50">{{ $record->date_acquired }}</td>
                    <td class="p-4 font-bold">{{ $record->accountable_person }}</td>
                    <td class="p-4 italic text-slate-600">{{ $record->description }}</td>
                    <td class="p-4">₱{{ number_format($record->unit_value, 2) }}</td>
                    <td class="p-4">{{ $record->location }}</td>
                    <td class="p-4 text-orange-600 font-medium">{{ $record->remarks }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection