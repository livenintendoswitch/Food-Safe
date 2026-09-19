@extends('layouts.app')

@section('content')
<main class="p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-2">Order #{{ $order->id }}</h1>
    <p class="text-gray-600 mb-4">{{ $order->listing?->name }} — {{ $order->customer?->name }}</p>

    @if ($order->order_status !== 'COMPLETED')
        <form method="POST" action="{{ route('partner.orders.pickup', $order) }}" class="space-y-3">
            @csrf
            <label class="block text-sm font-medium">Pickup Code</label>
            <input name="pickup_code" maxlength="12" required class="w-full border rounded p-2 tracking-widest text-center">
            @error('pickup_code') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            <button class="w-full bg-gray-900 text-white rounded py-2">Verify Pickup</button>
        </form>
    @else
        <p class="text-green-700 font-medium">✓ Pickup completed</p>
    @endif
</main>
@endsection