@extends('layouts.app')

@section('content')
<main class="customer-browse">

    <header class="browse-header">
        <div>
            <p class="browse-eyebrow">Discover surplus food</p>
            <h1>Browse food</h1>
            <p class="browse-description">
                Find good food nearby before it goes to waste.
            </p>
        </div>
    </header>

    <section class="browse-tools">

        <input
            type="text"
            id="browse-search"
            class="browse-search"
            placeholder="Search food or restaurant..."
        >

        <div class="filter-row">
            <button class="filter-button active" data-filter="all">All</button>
            <button class="filter-button" data-filter="nearest">Nearest</button>
            <button class="filter-button" data-filter="cheapest">Cheapest</button>
            <button class="filter-button" data-filter="today">Pickup today</button>
        </div>

    </section>

    <section class="browse-listings">

        <div class="browse-section-heading">
            <div>
                <h2>Available food</h2>
                <p>3 listings nearby</p>
            </div>
        </div>

        <div class="listing-grid">

            <article
                class="food-card"
                data-name="Nasi Ayam"
                data-restaurant="Warung ABC"
                data-distance="0.8"
                data-price="15000"
            >
                <div class="food-image">🍱</div>

                <div class="food-info">
                    <h3>Nasi Ayam</h3>
                    <p class="restaurant-name">Warung ABC</p>
                    <p class="location-text">📍 0.8 km away</p>

                    <div class="price-row">
                        <strong>Rp15.000</strong>
                        <span>Rp25.000</span>
                    </div>
                </div>
            </article>

            <article
                class="food-card"
                data-name="Pasta Carbonara"
                data-restaurant="Cafe XYZ"
                data-distance="1.2"
                data-price="20000"
            >
                <div class="food-image">🍝</div>

                <div class="food-info">
                    <h3>Pasta Carbonara</h3>
                    <p class="restaurant-name">Cafe XYZ</p>
                    <p class="location-text">📍 1.2 km away</p>

                    <div class="price-row">
                        <strong>Rp20.000</strong>
                        <span>Rp35.000</span>
                    </div>
                </div>
            </article>

            <article
                class="food-card"
                data-name="Chicken Sandwich"
                data-restaurant="Daily Bites"
                data-distance="1.5"
                data-price="12000"
            >
                <div class="food-image">🥪</div>

                <div class="food-info">
                    <h3>Chicken Sandwich</h3>
                    <p class="restaurant-name">Daily Bites</p>
                    <p class="location-text">📍 1.5 km away</p>

                    <div class="price-row">
                        <strong>Rp12.000</strong>
                        <span>Rp20.000</span>
                    </div>
                </div>
            </article>

        </div>

    </section>

</main>
@endsection
