@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Checkout</h1>

    <!-- Backend Validation & Error States -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('customer.orders.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        @csrf
        
        <!-- Hidden reference to the listing ID -->
        <input type="hidden" name="listing_id" value="{{ $listing->id }}">

        <!-- Order Summary (Sourced purely from Backend Variables) -->
        <div class="mb-6 border-b border-gray-200 pb-4">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Order Summary</h2>
            
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Restaurant:</span>
                    <span class="font-medium text-gray-800">{{ $restaurant->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Food:</span>
                    <span class="font-medium text-gray-800">{{ $listing->food_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pickup Window:</span>
                    <span class="font-medium text-gray-800">{{ $listing->pickup_window }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Surplus Price:</span>
                    <span class="font-medium text-green-600">Rp {{ number_format($listing->surplus_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Available Stock:</span>
                    <span class="font-medium text-gray-800">
                        @if($listing->stock > 0)
                            {{ $listing->stock }} portions
                        @else
                            <span class="text-red-600">SOLD OUT</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Quantity Selection -->
        <div class="mb-6">
            <label for="quantity" class="block text-gray-700 font-bold mb-2">Select Quantity</label>
            <input type="number"
                   id="quantity"
                   name="quantity"
                   min="1"
                   max="{{ $listing->stock }}"
                   value="{{ old('quantity', 1) }}"
                   data-price="{{ $listing->surplus_price }}"
                   class="w-32 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('quantity') border-red-500 @enderror"
                   required
                   {{ $listing->stock < 1 ? 'disabled' : '' }}>
            
            <!-- Backend Form Validation Errors -->
            @error('quantity')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Visual Total (UI Only) -->
        <div class="mb-8 bg-gray-50 p-4 rounded-md border border-gray-100">
            <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-gray-800">Estimated Total:</span>
                <span class="text-xl font-bold text-green-600">
                    Rp <span id="estimated-total">{{ number_format($listing->surplus_price, 0, ',', '.') }}</span>
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">* Final total is calculated by the system upon order submission.</p>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard', $listing->id) }}" class="px-6 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 font-medium transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-green-600 text-white font-bold rounded-md hover:bg-green-700 transition-colors disabled:opacity-50"
                    {{ $listing->stock < 1 ? 'disabled' : '' }}>
                Proceed to Payment
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    @vite('resources/js/Customer Transaction/Checkout/checkout.js')
@endpush