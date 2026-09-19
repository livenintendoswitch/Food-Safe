@extends('layouts.app')

@section('content')
<main class="p-6 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">Restaurant Profile</h1>

    @if ($restaurant ?? false)
        <div class="border rounded p-4 space-y-2">
            <p class="font-medium">{{ $restaurant->name }}</p>
            <p class="text-sm text-gray-500">{{ $restaurant->address }}</p>
            <p class="text-sm text-gray-600">{{ $restaurant->description }}</p>
            <a href="{{ route('partner.restaurants.edit', $restaurant) }}" class="inline-block mt-2 text-sm underline">Edit Profile</a>
        </div>
    @else
        <p class="text-gray-500 mb-4">You haven't set up your restaurant yet.</p>
        <a href="{{ route('partner.restaurants.create') }}" class="bg-gray-900 text-white rounded px-4 py-2 text-sm">+ Create Restaurant</a>
    @endif
</main>
@endsection