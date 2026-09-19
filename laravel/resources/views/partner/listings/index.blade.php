@extends('layouts.app')

@section('content')
<main class="p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">My Listings</h1>
        <a href="{{ route('partner.listings.create') }}" class="bg-gray-900 text-white rounded px-4 py-2 text-sm">+ New Listing</a>
    </div>
    <div class="space-y-3">
        @forelse ($listings ?? [] as $listing)
            <div class="border rounded p-4 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $listing->name }}</p>
                    <p class="text-sm text-gray-500">Rp{{ number_format($listing->surplus_price, 0, ',', '.') }} · pickup {{ $listing->pickup_start?->format('d M H:i') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2 py-1 rounded {{ $listing->status === 'ACTIVE' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $listing->status }} · {{ $listing->quantity }} left
                    </span>
                    <a href="{{ route('partner.listings.edit', $listing) }}" class="text-sm underline">Edit</a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No listings yet.</p>
        @endforelse
    </div>
</main>
@endsection