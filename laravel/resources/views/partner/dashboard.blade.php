@extends('layouts.app')

@section('content')
<main class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Welcome, {{ $restaurant->name ?? 'Partner' }}</h1>
    <div class="grid grid-cols-3 gap-4">
        <a href="{{ route('partner.restaurants.index') }}" class="border rounded p-4 hover:bg-gray-50">Restaurant Profile</a>
        <a href="{{ route('partner.listings.index') }}" class="border rounded p-4 hover:bg-gray-50">Manage Listings</a>
        <a href="{{ route('partner.orders') }}" class="border rounded p-4 hover:bg-gray-50">Incoming Orders</a>
    </div>
</main>
@endsection