@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    
    <div class="flex items-center mb-6">
        <a href="{{ route('customer.orders.show', $order->id) }}" class="text-green-600 hover:text-green-700 mr-4 font-medium transition-colors">
            &larr; Back to Order Details
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 text-center">
        
        <!-- Header -->
        <div class="bg-green-600 px-6 py-4">
            <h1 class="text-xl font-bold text-white">Your Pickup Code</h1>
            <p class="text-green-100 text-sm mt-1">Show this screen to the restaurant staff</p>
        </div>

        <div class="p-6 space-y-6">
            
            <!-- Order Status -->
            <div>
                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                    {{ $order->status === 'COMPLETED' ? 'bg-gray-100 text-gray-600' : 'bg-blue-100 text-blue-800' }}">
                    Status: {{ $order->status }}
                </span>
            </div>

            <!-- The Code -->
            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6">
                <span class="block text-5xl font-extrabold text-gray-800 tracking-widest">
                    {{ $order->pickup_code }}
                </span>
            </div>

            <!-- Order Information -->
            <div class="text-left space-y-3 pt-4 border-t border-gray-100">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Order Number</span>
                    <span class="font-bold text-gray-800">#{{ $order->order_number ?? $order->id }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Restaurant</span>
                    <span class="font-bold text-gray-800">{{ $order->listing->restaurant->name ?? 'Unknown' }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Pickup Window</span>
                    <span class="font-bold text-gray-800">{{ $order->listing->pickup_window ?? 'TBA' }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Items</span>
                    <span class="font-bold text-gray-800">{{ $order->listing->food_name }} (x{{ $order->quantity }})</span>
                </div>
            </div>

        </div>
        
        <!-- Footer Action -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-gray-900 transition-colors">
                Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/customer/pickup.js')
@endpush