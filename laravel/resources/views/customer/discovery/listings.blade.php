@extends('layouts.app')

@section('content')
<main class="discovery-page">
    <header class="page-header">
        <p class="home-eyebrow">Discover surplus food</p>
        <h1>Find your next meal.</h1>
        <p>Great food from local restaurants at a lower price.</p>
    </header>

    <section class="discovery-toolbar">
        <label for="listing-search" class="sr-only">
            Search food or restaurant
        </label>

        <input
            type="search"
            id="listing-search"
            class="search-input"
            placeholder="Search food or restaurant..."
            autocomplete="off"
        >

        <div class="filter-list" aria-label="Listing filters">
            <button
                type="button"
                class="filter-button active"
                data-filter="all"
            >
                All
            </button>

            <button
                type="button"
                class="filter-button"
                data-filter="cheapest"
            >
                Cheapest first
            </button>
        </div>
    </section>

    <section class="listing-grid">
        @forelse ($listings as $listing)
            <a
                href="{{ route('customer.discovery.show', $listing) }}"
                class="food-card"
                data-price="{{ (float) $listing->surplus_price }}"
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
            </div>
        @endforelse
    </section>
</main>
@endsection

@push('scripts')
    @vite('resources/js/customer/discovery/listings.js')
@endpush