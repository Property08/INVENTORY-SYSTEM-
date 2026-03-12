@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-xl transition">
        <h2 class="text-xl font-semibold mb-2">Home</h2>
        <p class="text-gray-600">Quick overview of your system.</p>
        <a href="{{ route('dashboard') }}" class="mt-3 inline-block text-[#001F3F] font-semibold hover:underline">
            Go Home →
        </a>
    </div>

    <div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-xl transition">
        <h2 class="text-xl font-semibold mb-2">Disposable Storage</h2>
        <p class="text-gray-600">Manage your disposable items.</p>
        <a href="{{ route('disposable') }}" class="mt-3 inline-block text-[#001F3F] font-semibold hover:underline">
            Go to Storage →
        </a>
    </div>

    

</div>
@endsection