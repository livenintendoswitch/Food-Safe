@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <div class="mb-6 flex items-center">
        <a
            href="{{ route('customer.orders') }}"
            class="mr-4 text-green-600 hover:text-green-700"
        >
            &larr; Back to Orders
        </a>

        <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
    </div>

    @error('order')
        <div class="mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
            {{ $message }}
        </div>
    @enderror

    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-md">
        <div class="mb-4 flex items-start justify-between border-b border-gray-200 pb-4">
            <div>
                <p class="mb-1 text-sm font-bold text-gray-500">
                    Order #{{ $order->id }}
                </p>

                <p class="text-xs text-gray-400">
                    Placed on {{ $order->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            <div class="space-y-2 text-right">
                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold
                    {{ $order->payment_status === 'PAID'
                        ? 'bg-green-100 text-green-800'
                        : ($order->payment_status === 'FAILED'
                            ? 'bg-red-100 text-red-800'
                            : 'bg-yellow-100 text-yellow-800') }}">
                    Payment: {{ $order->payment_status }}
                </span>

                <span class="block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">
                    Status: {{ $order->order_status }}
                </span>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="mb-3 text-lg font-semibold text-gray-800">Order Summary</h2>

            <p class="font-medium text-gray-800">
                {{ $order->listing?->name ?? '-' }} (x{{ $order->quantity }})
            </p>

            <p class="text-sm text-gray-600">
                {{ $order->restaurant?->name ?? '-' }}
            </p>

            <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                <span class="font-bold text-gray-800">Total Price</span>
                <span class="text-xl font-bold text-green-600">
                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="mb-8 rounded-md border border-gray-100 bg-gray-50 p-4">
            <h2 class="mb-2 text-sm font-bold uppercase text-gray-700">
                Pickup Information
            </h2>

            <p class="text-gray-800">
                <span class="font-medium">Restaurant:</span>
                {{ $order->restaurant?->name ?? '-' }}
            </p>

            <p class="mt-1 text-gray-800">
                <span class="font-medium">Pickup Window:</span>
                {{ $order->listing?->pickup_start?->format('d M Y, H:i') ?? '-' }}
                –
                {{ $order->listing?->pickup_end?->format('H:i') ?? '-' }}
            </p>
        </div>

        <div class="flex justify-end">
            @if ($order->payment_status === 'PENDING')
                <form action="{{ route('customer.orders.payment', $order) }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="rounded-md bg-green-600 px-6 py-2 font-bold text-white hover:bg-green-700"
                    >
                        Proceed to Payment
                    </button>
                </form>
            @elseif ($order->payment_status === 'PAID' && $order->order_status !== 'COMPLETED')
                <a
                    href="{{ route('customer.orders.pickup', $order) }}"
                    class="rounded-md bg-blue-600 px-6 py-2 font-bold text-white hover:bg-blue-700"
                >
                    View Pickup Code
                </a>
            @elseif ($order->order_status === 'COMPLETED')
                <span class="rounded-md bg-gray-100 px-6 py-2 font-bold text-gray-500">
                    Order Completed
                </span>
            @endif
        </div>
    </div>
</div>
@endsection