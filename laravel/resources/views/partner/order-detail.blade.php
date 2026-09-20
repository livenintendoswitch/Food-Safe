@extends('layouts.app')

@section('content')
    <main class="mx-auto max-w-lg p-6">
        <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>

        @if (session('success'))
            <p class="mt-4 rounded-md bg-green-100 p-3 text-sm text-green-800">
                {{ session('success') }}
            </p>
        @endif

        <dl class="mt-6 space-y-3 rounded-lg border p-4 text-sm">
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">Customer</dt>
                <dd class="font-medium">{{ $order->customer?->name ?? '-' }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">Listing</dt>
                <dd class="font-medium">{{ $order->listing?->name ?? '-' }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">Quantity</dt>
                <dd class="font-medium">{{ $order->quantity }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">Payment status</dt>
                <dd class="font-medium">{{ $order->payment_status }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">Order status</dt>
                <dd class="font-medium">{{ $order->order_status }}</dd>
            </div>
        </dl>

        @if ($order->payment_status === 'PAID' && $order->order_status === 'PAID')
            <form method="POST" action="{{ route('partner.orders.pickup', $order) }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="pickup_code" class="block text-sm font-medium">Pickup code</label>
                    <input id="pickup_code" name="pickup_code" type="text" required maxlength="12"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                    @error('pickup_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @error('order')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-white">
                    Verify pickup and complete order
                </button>
            </form>
        @endif

        <a href="{{ route('partner.orders') }}" class="mt-6 inline-block underline">
            Back to orders
        </a>
    </main>
@endsection
