@extends('layouts.dashboard')

@section('title', 'Disposable Items')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Disposable Items</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add New Button -->
    <a href="{{ route('disposable.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow mb-4 inline-block">
        ➕ Add New
    </a>

    <!-- Items Table -->
    <table class="w-full border border-gray-300 rounded-lg overflow-hidden mt-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left">ID</th>
                <th class="border px-4 py-2 text-left">Name</th>
                <th class="border px-4 py-2 text-left">Quantity</th>
                <th class="border px-4 py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($disposables as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $item->id }}</td>
                    <td class="border px-4 py-2">{{ $item->name }}</td>
                    <td class="border px-4 py-2">{{ $item->quantity }}</td>
                    <td class="border px-4 py-2 text-center">
                        <!-- Edit -->
                        <a href="{{ route('disposable.edit', $item->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg">
                            ✏️ Edit
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('disposable.destroy', $item->id) }}" method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Are you sure you want to delete this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg">
                                🗑 Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">No items found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
