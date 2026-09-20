@extends('layouts.app')

@section('content')
<main class="p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Listing</h1>
    <form method="POST" action="{{ route('partner.listings.update', $listing) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="restaurant_id" value="{{ $listing->restaurant_id }}">
        <div>
            <label class="block text-sm font-medium mb-1">Item Name</label>
            <input name="name" value="{{ old('name', $listing->name) }}" required class="w-full border rounded-md p-2">
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" class="w-full border rounded-md p-2">{{ old('description', $listing->description) }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Photo</label>
            <input type="file" name="image" accept="image/*" class="w-full">
            @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Original Price</label>
                <input type="number" step="0.01" name="original_price" value="{{ old('original_price', $listing->original_price) }}" required class="w-full border rounded-md p-2">
                @error('original_price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Surplus Price</label>
                <input type="number" step="0.01" name="surplus_price" value="{{ old('surplus_price', $listing->surplus_price) }}" required class="w-full border rounded-md p-2">
                @error('surplus_price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Quantity</label>
            <input type="number" name="quantity" min="1" value="{{ old('quantity', $listing->quantity) }}" required class="w-full border rounded-md p-2">
            @error('quantity') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Pickup Start</label>
                <input type="datetime-local" name="pickup_start" value="{{ old('pickup_start', $listing->pickup_start?->format('Y-m-d\TH:i')) }}" required class="w-full border rounded-md p-2">
                @error('pickup_start') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Pickup End</label>
                <input type="datetime-local" name="pickup_end" value="{{ old('pickup_end', $listing->pickup_end?->format('Y-m-d\TH:i')) }}" required class="w-full border rounded-md p-2">
                @error('pickup_end') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded-md p-2">
                @foreach (['DRAFT', 'ACTIVE', 'SOLD_OUT', 'EXPIRED'] as $status)
                    <option value="{{ $status }}" {{ old('status', $listing->status) === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
            @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <button class="bg-gray-900 text-white rounded-md px-4 py-2">Update Listing</button>
    </form>

    <form method="POST" action="{{ route('partner.listings.destroy', $listing) }}" class="mt-4"
          onsubmit="return confirm('Delete this listing? This cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm text-red-600 underline">Delete this listing</button>
    </form>
</main>
@endsection