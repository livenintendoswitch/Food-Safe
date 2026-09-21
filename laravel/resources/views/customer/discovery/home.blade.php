@extends('layouts.app')

@section('content')
<main class="customer-home">

    <header class="home-header">
        <div>
            <p class="home-eyebrow">Good food, less waste</p>
            <h1>
                Save food.<br>
                Save money.
            </h1>
            <p class="home-description">
                Discover delicious surplus food from restaurants near you.
            </p>
        </div>

        @guest
            <a href="{{ route('login') }}" class="discovery-login-button">
                Log in
            </a>
        @endguest
    </header>

    <section class="search-section">
        <label for="discovery-search" class="sr-only">
            Search food or restaurant
        </label>

        <input
            type="search"
            id="discovery-search"
            class="search-input"
            placeholder="Search food or restaurant..."
            autocomplete="off"
        >
    </section>

    <section class="listing-section">
        <div class="section-heading">
            <div>
                <h2>Nearby food</h2>
                <p>Available surplus food ready for pickup.</p>
            </div>

            <a
                href="{{ route('customer.discovery.listings') }}"
                class="browse-all-link"
            >
                Browse all →
            </a>
        </div>

        <div class="listing-grid">
            @forelse ($listings as $listing)
                <a
                    href="{{ route('customer.discovery.show', $listing) }}"
                    class="food-card"
                >
                    @if ($listing->image)
                        <img
                            src="{{ $listing->image }}"
                            alt="{{ $listing->name }}"
                            class="food-image"
                        >
                    @else
                        <div class="food-image food-image-placeholder">
                            🍱
                        </div>
                    @endif

                    <div class="food-info">
                        <div class="food-card-top">
                            <div>
                                <h3>{{ $listing->name }}</h3>
                                <p class="restaurant-name">
                                    {{ $listing->restaurant?->name ?? 'Restaurant' }}
                                </p>
                            </div>

                            <span class="food-stock">
                                {{ $listing->quantity }} left
                            </span>
                        </div>

                        @if ($listing->restaurant?->address)
                            <p class="location-text">
                                {{ $listing->restaurant->address }}
                            </p>
                        @endif

                        <div class="price-row">
                            <strong>
                                Rp{{ number_format($listing->surplus_price, 0, ',', '.') }}
                            </strong>

                            <span>
                                Rp{{ number_format($listing->original_price, 0, ',', '.') }}
                            </span>
                        </div>

                        <p class="pickup-text">
                            Pickup
                            {{ $listing->pickup_start->format('H:i') }}
                            –
                            {{ $listing->pickup_end->format('H:i') }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="empty-listings">
                    <div class="empty-listings-icon">🍱</div>
                    <h3>No surplus food available</h3>
                    <p>Check back later for new food listings.</p>
                    <a
                        href="{{ route('customer.discovery.listings') }}"
                        class="empty-listings-link"
                    >
                        Browse listings
                    </a>
                </div>
            @endforelse
        </div>
    </section>
</main>
@endsection
