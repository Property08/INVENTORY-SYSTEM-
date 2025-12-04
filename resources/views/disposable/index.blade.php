@extends('layouts.dashboard')

@section('title', 'Disposable Items')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">🧻 Disposable Items</h1>
        <a href="{{ route('disposable.create') }}"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-xl shadow-lg transition">
            <span class="mr-2">➕</span> Add New
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg mb-6 shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Quantity</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($disposables as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->id }}</td>
                        <td class="px-6 py-4">{{ $item->name }}</td>
                        <td class="px-6 py-4">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-center flex items-center justify-center gap-3">
                            <!-- Edit Button -->
                            <a href="{{ route('disposable.edit', $item->id) }}"
                               class="p-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg shadow transition"
                               title="Edit">
                                ✏️
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('disposable.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow transition"
                                        title="Delete">
                                    🗑
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                            No disposable items found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection