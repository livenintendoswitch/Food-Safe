@extends('layouts.app')

@section('content')
<main class="p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Restaurant Profile</h1>
    <form method="POST" action="{{ route('partner.restaurants.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Restaurant Name</label>
            <input name="name" value="{{ old('name') }}" required class="w-full border rounded-md p-2">
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" class="w-full border rounded-md p-2">{{ old('description') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Address</label>
            <input name="address" value="{{ old('address') }}" required class="w-full border rounded-md p-2">
            @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <button class="bg-gray-900 text-white rounded-md px-4 py-2">Save</button>
    </form>
</main>
@endsection