@extends('layouts.dashboard')
@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-4">
    <h2 class="text-xl font-bold mb-4 text-center">Edit RPCPPE Record</h2>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 max-w-3xl mx-auto">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('rpcppe.update', $rpcppe) }}" method="POST" 
          class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
        @csrf
        @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Property No --}}
            <div>
                <label class="block font-medium mb-1">Property No.</label>
                <input type="text" name="property_no" 
                       value="{{ old('property_no', $rpcppe->property_no) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            {{-- Article --}}
            <div>
                <label class="block font-medium mb-1">Article</label>
                <input type="text" name="article" 
                       value="{{ old('article', $rpcppe->article) }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Description --}}
            <div>
                <label class="block font-medium mb-1">Description</label>
                <input type="text" name="description" 
                       value="{{ old('description', $rpcppe->description) }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Remarks --}}
            <div >
                <label class="block font-medium mb-1">Remarks</label>
                <input type="text" name="remarks" 
                       value="{{ old('remarks', $rpcppe->remarks) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Accountable Person --}}
            <div >
                <label class="block font-medium mb-1">Accountable Person</label>
                <input type="text" name="accountable_person" 
                       value="{{ old('accountable_person', $rpcppe->accountable_person) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Location --}}
            <div>
                <label class="block font-medium mb-1">Location</label>
                <input type="text" name="location" 
                       value="{{ old('location', $rpcppe->location) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Division --}}
            <div >
                <label class="block font-medium mb-1">Division</label>
                <input type="text" name="division" 
                       value="{{ old('division', $rpcppe->division) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Section Unit --}}
            <div >
                <label class="block font-medium mb-1">Section Unit</label>
                <input type="text" name="section_unit" 
                       value="{{ old('section_unit', $rpcppe->section_unit) }}" 
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- PRSD --}}
            <div >
                <label class="block font-medium mb-1">PRSD</label>
                <input type="text" name="ptsd" 
                       value="{{ old('ptsd', $rpcppe->ptsd) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Transferred To --}}
            <div >
                <label class="block font-medium mb-1">Transferred To</label>
                <input type="text" name="transfer_to" 
                       value="{{ old('transfer_to', $rpcppe->transfer_to) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- Buttons --}}
        <div class="mt-6 flex gap-4 justify-center">
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded">
                Update
            </button>
            <a href="{{ route('rpcppe.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection