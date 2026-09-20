@extends('layouts.app')

@section('content')
<main class="listing-detail-page">
    <a
        href="{{ route('customer.discovery.listings') }}"
        class="back-link"
    >
        ← Back to listings
    </a>

    <article class="listing-detail-card">
        @if ($listing->image)
            <img
                src="{{ $listing->image }}"
                alt="{{ $listing->name }}"
                class="detail-image"
            >
        @else
            <div class="detail-image detail-image-placeholder">
                🍱
            </div>
        @endif

        <div class="detail-content">
            <p class="home-eyebrow">
                {{ $listing->restaurant?->name ?? 'Restaurant' }}
            </p>

            <h1>{{ $listing->name }}</h1>

            <p class="detail-location">
                {{ $listing->restaurant?->address }}
            </p>

            <div class="detail-price">
                <strong>
                    Rp{{ number_format($listing->surplus_price, 0, ',', '.') }}
                </strong>

                <span>
                    Rp{{ number_format($listing->original_price, 0, ',', '.') }}
                </span>
            </div>

            @if ($listing->description)
                <div class="detail-description">
                    <h2>About this food</h2>
                    <p>{{ $listing->description }}</p>
                </div>
            @endif

            <div class="detail-meta">
                <div>
                    <span>Available</span>
                    <strong>{{ $listing->quantity }} portions</strong>
                </div>

                <div>
                    <span>Pickup</span>
                    <strong>
                        {{ $listing->pickup_start->format('H:i') }}
                        –
                        {{ $listing->pickup_end->format('H:i') }}
                    </strong>
                </div>
            </div>

            @if ($listing->isAvailable())
                @guest
                    <div class="order-cta">
                        <a href="{{ route('login') }}" class="order-submit">
                            Log in to order
                        </a>
                    </div>
                @else
                    @if (auth()->user()->role === 'customer')
                        <form method="POST" action="{{ route('customer.orders.store') }}" class="order-cta">
                            @csrf
                            <input type="hidden" name="listing_id" value="{{ $listing->id }}">

                            <div>
                                <label for="order-quantity">Quantity</label>
                                <input
                                    id="order-quantity"
                                    class="order-quantity"
                                    type="number"
                                    name="quantity"
                                    min="1"
                                    max="{{ $listing->quantity }}"
                                    value="1"
                                    required
                                >
                            </div>

                            <button type="submit" class="order-submit">
                                Continue to order
                            </button>
                        </form>
                    @else
                        <div class="order-cta" role="status">
                            <p>Only customer accounts can place orders.</p>
                        </div>
                    @endif
                @endguest
            @endif
        </div>
    </article>
</main>
@endsection
