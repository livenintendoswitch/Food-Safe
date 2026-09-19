@extends('layouts.app')

@section('content')
<main class="p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Restaurant Profile</h1>
    <form method="POST" action="{{ route('partner.restaurants.update', $restaurant) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Restaurant Name</label>
            <input name="name" value="{{ old('name', $restaurant->name) }}" required class="w-full border rounded-md p-2">
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" class="w-full border rounded-md p-2">{{ old('description', $restaurant->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Address</label>
            <input name="address" value="{{ old('address', $restaurant->address) }}" required class="w-full border rounded-md p-2">
            @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <button class="bg-gray-900 text-white rounded-md px-4 py-2">Update</button>
    </form>
</main>
@endsection