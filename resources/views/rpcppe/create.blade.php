@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

    <h1 class="text-2xl font-bold text-gray-700 mb-6">➕ Add New RPCPPE</h1>

    <form action="{{ route('rpcppe.store') }}" method="POST"
          class="space-y-6 bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        @csrf

        <!-- Grid Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Property No. <span class="text-red-500">*</span></label>
                <input type="text" name="property_no" required
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Article</label>
                <input type="text" name="article"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

           <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input type="text" name="description"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit of Measure</label>
                <input type="text" name="unit_of_measure"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit Value</label>
                <input type="number" step="0.01" name="unit_value"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity per Card</label>
                <input type="text" name="quantity_per_property_card"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity per Physical Count</label>
                <input type="number" name="quantity_per_physical_count"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Shortage/Overage (Qty)</label>
                <input type="number" name="shortage_overage_qty"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Shortage/Overage (Value)</label>
                  <input type="number" name= "shortage_overage_value"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

             <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                <textarea name="remarks" rows="3"
                          class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

             <div>
                <label class="block font-medium">Date Acquired</label>
                <input type="date" name="date_acquired" value="{{ old('date_acquired') }}" class="w-full border px-3 py-2 rounded">
            </div>

            <!-- ✅ NEW FIELDS -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Accountable Person</label>
               <input type="text" name="accountable_person"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
               <input type="text" name="location"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">PRSD</label>
             <input type="text" name="ptsd"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Division</label>
               <input type="text" name="division"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section / Unit</label>
               <input type="text" name="section_unit"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Transfer To</label>
             <input type="text" name="transfer_to"
                       class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Action Buttons -->
           <div class="mt-6 flex gap-4 justify-end">
            <a href="{{ route('rpcppe.index') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded">
                Cancel
            </a>
            <button type="submit"
                     class="bg-gray-500 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded">
                Save
            </button>
        </div>
    </form>
</div>
@endsection