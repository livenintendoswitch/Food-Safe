@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-md px-4 py-8">
    <div class="mb-6 flex items-center">
        <a
            href="{{ route('customer.orders.show', $order) }}"
            class="mr-4 font-medium text-green-600 hover:text-green-700"
        >
            &larr; Back to Order Details
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white text-center shadow-lg">
        <div class="bg-green-600 px-6 py-4">
            <h1 class="text-xl font-bold text-white">Your Pickup Code</h1>
            <p class="mt-1 text-sm text-green-100">
                Show this screen to the restaurant staff.
            </p>
        </div>

        <div class="space-y-6 p-6">
            <span class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide
                {{ $order->order_status === 'COMPLETED'
                    ? 'bg-gray-100 text-gray-600'
                    : 'bg-blue-100 text-blue-800' }}">
                Status: {{ $order->order_status }}
            </span>

            <div class="rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-6">
                <span class="block text-5xl font-extrabold tracking-widest text-gray-800">
                    {{ $order->pickup_code }}
                </span>
            </div>

            <div class="space-y-3 border-t border-gray-100 pt-4 text-left">
                <div class="flex justify-between gap-4">
                    <span class="text-sm text-gray-500">Order Number</span>
                    <span class="font-bold text-gray-800">#{{ $order->id }}</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-sm text-gray-500">Restaurant</span>
                    <span class="font-bold text-gray-800">
                        {{ $order->restaurant?->name ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-sm text-gray-500">Pickup Window</span>
                    <span class="font-bold text-gray-800">
                        {{ $order->listing?->pickup_start?->format('d M H:i') ?? '-' }}
                        –
                        {{ $order->listing?->pickup_end?->format('H:i') ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-sm text-gray-500">Items</span>
                    <span class="font-bold text-gray-800">
                        {{ $order->listing?->name ?? '-' }} (x{{ $order->quantity }})
                    </span>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
            <a
                href="{{ route('customer.discovery.listings') }}"
                class="text-sm font-bold text-gray-600 hover:text-gray-900"
            >
                Browse More Food
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/customer/pickup.js')
@endpush