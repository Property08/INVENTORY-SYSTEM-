@extends('layouts.dashboard')

@section('title', 'Import Records')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold mb-4">Import Records</h2>
    <p class="text-gray-600 mb-4">View and manage your import history.</p>

    <!-- Example: placeholder table -->
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 p-2">Date</th>
                <th class="border border-gray-300 p-2">Item</th>
                <th class="border border-gray-300 p-2">Quantity</th>
                <th class="border border-gray-300 p-2">Supplier</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border border-gray-300 p-2">2025-08-22</td>
                <td class="border border-gray-300 p-2">Sample Item</td>
                <td class="border border-gray-300 p-2">100</td>
                <td class="border border-gray-300 p-2">ABC Supplier</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection