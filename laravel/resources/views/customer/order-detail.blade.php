@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    
    <div class="flex items-center mb-6">
        <a href="{{ route('customer.orders') }}" class="text-green-600 hover:text-green-700 mr-4">
            &larr; Back to Orders
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
    </div>

    <!-- Backend Error/Success States -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        
        <!-- Header Info -->
        <div class="border-b border-gray-200 pb-4 mb-4 flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500 font-bold mb-1">Order #{{ $order->order_number ?? $order->id }}</p>
                <p class="text-xs text-gray-400">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right space-y-1">
                <div class="px-3 py-1 text-xs font-semibold rounded-full inline-block
                    {{ $order->payment_status === 'PAID' ? 'bg-green-100 text-green-800' : 
                      ($order->payment_status === 'FAILED' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    Payment: {{ $order->payment_status }}
                </div>
                <div class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 inline-block block mt-2">
                    Status: {{ $order->status }}
                </div>
            </div>
        </div>

        <!-- Order Items & Total -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Order Summary</h2>
            <div class="flex justify-between items-center mb-2">
                <div>
                    <p class="font-medium text-gray-800">{{ $order->listing->food_name }} (x{{ $order->quantity }})</p>
                    <p class="text-sm text-gray-600">{{ $order->listing->restaurant->name }}</p>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                <span class="font-bold text-gray-800">Total Price</span>
                <span class="text-xl font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Pickup Information -->
        <div class="mb-8 bg-gray-50 p-4 rounded-md border border-gray-100">
            <h2 class="text-sm font-bold text-gray-700 uppercase mb-2">Pickup Information</h2>
            <p class="text-gray-800"><span class="font-medium">Restaurant:</span> {{ $order->listing->restaurant->name }}</p>
            <p class="text-gray-800 mt-1"><span class="font-medium">Pickup Window:</span> {{ $order->listing->pickup_window }}</p>
        </div>

        <!-- Next Actions (Handled via Backend standard routing) -->
        <div class="flex justify-end">
            @if($order->payment_status === 'PENDING')
                <!-- Assume backend has a payment processing route setup -->
                <form action="{{ route('customer.orders.payment', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white font-bold rounded-md hover:bg-green-700 transition-colors">
                        Proceed to Payment
                    </button>
                </form>
            @elseif($order->payment_status === 'PAID' && $order->status !== 'COMPLETED' && $order->status !== 'CANCELLED')
                <!-- Proceed to Pickup Code screen -->
                <a href="{{ route('customer.orders.pickup', $order->id) }}" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 transition-colors">
                    View Pickup Code
                </a>
            @elseif($order->status === 'COMPLETED')
                <span class="px-6 py-2 bg-gray-100 text-gray-500 font-bold rounded-md">
                    Order Completed
                </span>
            @endif
        </div>

    </div>
</div>
@endsection