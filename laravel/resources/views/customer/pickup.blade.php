@extends('layouts.app')

@section('content')
    <main class="mx-auto max-w-md p-6">
        <h1 class="text-2xl font-bold">Pickup code</h1>

        <p class="mt-2 text-sm text-gray-600">
            Show this code to the restaurant partner when collecting your order.
        </p>

        <section class="mt-6 rounded-lg border p-5 text-center">
            <p class="text-sm text-gray-500">Order #{{ $order->id }}</p>
            <p class="mt-3 font-mono text-3xl font-bold tracking-widest">
                {{ $order->pickup_code }}
            </p>
        </section>

        <dl class="mt-6 space-y-2 text-sm">
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">Listing</dt>
                <dd class="font-medium">{{ $order->listing?->name ?? '-' }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">Restaurant</dt>
                <dd class="font-medium">{{ $order->restaurant?->name ?? '-' }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">Quantity</dt>
                <dd class="font-medium">{{ $order->quantity }}</dd>
            </div>
        </dl>

        <a href="{{ route('customer.orders.show', $order) }}" class="mt-6 inline-block underline">
            Back to order
        </a>
    </main>
@endsection
