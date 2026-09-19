@extends('layouts.app')

@section('content')
<main class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Incoming Orders</h1>
    <div class="space-y-3">
        @forelse ($orders ?? [] as $order)
            <a href="{{ route('partner.orders.show', $order) }}" class="block border rounded p-4 hover:bg-gray-50">
                <p class="font-medium">{{ $order->listing?->name }}</p>
                <p class="text-sm text-gray-500">{{ $order->customer?->name }} · {{ $order->order_status }} · Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            </a>
        @empty
            <p class="text-gray-500">No orders yet.</p>
        @endforelse
    </div>
</main>
@endsection