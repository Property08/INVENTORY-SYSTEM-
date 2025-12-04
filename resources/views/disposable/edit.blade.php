@extends('layouts.dashboard')

@section('title', 'Edit Disposable Item')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Disposable Item</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('disposable.update', $disposable->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Item Name</label>
            <input type="text" name="name" value="{{ old('name', $disposable->name) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" value="{{ old('quantity', $disposable->quantity) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('disposable.index') }}"
               class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                Cancel
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
