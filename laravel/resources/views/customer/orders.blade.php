@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl px-4 py-8">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">My Orders</h1>

    @if ($orders->isEmpty())
        <div class="rounded-lg border border-gray-200 bg-white p-8 text-center">
            <p class="text-lg text-gray-500">You haven't placed any orders yet.</p>

            <a
                href="{{ route('customer.discovery.listings') }}"
                class="mt-4 inline-block font-semibold text-green-600 hover:text-green-700"
            >
                Browse surplus food
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($orders as $order)
                <div class="flex flex-col items-start justify-between rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
                    <div class="mb-4 sm:mb-0">
                        <div class="mb-2 flex items-center space-x-3">
                            <span class="text-sm font-bold text-gray-500">
                                #{{ $order->id }}
                            </span>

                            <span class="rounded-full px-2 py-1 text-xs font-semibold
                                {{ $order->payment_status === 'PAID'
                                    ? 'bg-green-100 text-green-800'
                                    : ($order->payment_status === 'FAILED'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $order->payment_status }}
                            </span>

                            <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">
                                {{ $order->order_status }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800">
                            {{ $order->listing?->name ?? 'Unknown Food' }}
                        </h3>

                        <p class="text-sm text-gray-600">
                            {{ $order->restaurant?->name ?? 'Unknown Restaurant' }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            Pickup:
                            {{ $order->listing?->pickup_start?->format('d M H:i') ?? '-' }}
                            –
                            {{ $order->listing?->pickup_end?->format('H:i') ?? '-' }}
                        </p>
                    </div>

                    <div class="flex w-full flex-col text-left sm:w-auto sm:items-end sm:text-right">
                        <p class="mb-1 text-sm text-gray-600">
                            Qty: {{ $order->quantity }}
                        </p>

                        <p class="mb-3 text-lg font-bold text-green-600">
                            Rp{{ number_format($order->total_price, 0, ',', '.') }}
                        </p>

                        <a
                            href="{{ route('customer.orders.show', $order) }}"
                            class="inline-block rounded border border-gray-300 px-4 py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
    @vite('resources/js/customer/orders.js')
@endpush