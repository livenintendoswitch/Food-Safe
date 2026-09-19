@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
        
        <div class="bg-gray-800 text-white text-center py-4">
            <h1 class="text-xl font-bold">Secure Payment Gateway</h1>
            <p class="text-sm text-gray-300">Mock Payment Environment</p>
        </div>

        <div class="p-6">
            <div class="mb-6 text-center">
                <p class="text-gray-600 text-sm mb-1">Paying for Order #{{ $order->order_number ?? $order->id }}</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mt-2">Merchant: {{ $order->listing->restaurant->name ?? 'Unknown' }}</p>
            </div>

            <!-- Backend Validation Error Handling for 'order' -->
            @error('order')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
                    {{ $message }}
                </div>
            @enderror

            <div class="space-y-3">
                <!-- Submits directly to the PaymentController's store method -->
                <form action="{{ route('customer.orders.payment', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded transition duration-150 flex justify-center items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pay Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </button>
                </form>
            </div>

            <div class="mt-6 text-center">
                <!-- Updated route to match the backend controller -->
                <a href="{{ route('customer.orders.show', $order->id) }}" class="text-sm text-gray-500 hover:text-gray-800 underline">
                    Cancel and return to Order Details
                </a>
            </div>
        </div>
    </div>
</div>
@endsection