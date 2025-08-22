@extends('layouts.dashboard')

@section('title', 'Disposable Items')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold mb-4">Manage Disposable Items</h2>
    <p class="text-gray-600 mb-4">Here you can add, update, or remove disposable items from your inventory.</p>

    <!-- Example: placeholder table -->
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-500 p-2">Item</th>
                <th class="border border-gray-500 p-2">Quantity</th>
                <th class="border border-gray-500 p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border border-gray-300 p-2">Sample Item</td>
                <td class="border border-gray-300 p-2">50</td>
                <td class="border border-gray-300 p-2">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection