<?php

namespace Tests\Feature\Partner;

use Tests\TestCase;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_can_create_listing_for_their_restaurant(): void
    {
        // 1. Setup: Create a partner and their restaurant
        $partner = User::factory()->create(['role' => 'partner']);
        $restaurant = Restaurant::factory()->create(['owner_id' => $partner->id]);

        // 2. Action: Simulate the partner submitting the "Create Listing" form
        $response = $this->actingAs($partner)->post(route('partner.listings.store'), [
            'restaurant_id' => $restaurant->id,
            'name' => 'Surplus Donuts',
            'original_price' => 50000,
            'surplus_price' => 20000,
            'quantity' => 10,
            'pickup_start' => now()->addHour()->toDateTimeString(),
            'pickup_end' => now()->addHours(3)->toDateTimeString(),
            'status' => 'ACTIVE',
        ]);

        // 3. Assert: The request succeeded and the database contains the donuts
        $response->assertRedirect(route('partner.listings.index'));
        $this->assertDatabaseHas('listings', [
            'name' => 'Surplus Donuts',
            'quantity' => 10,
        ]);
    }

    public function test_partner_cannot_create_listing_for_someone_elses_restaurant(): void
    {
        // 1. Setup: Create Partner A and Partner B, but only give Partner B a restaurant
        $partnerA = User::factory()->create(['role' => 'partner']);
        $partnerB = User::factory()->create(['role' => 'partner']);
        $restaurantB = Restaurant::factory()->create(['owner_id' => $partnerB->id]);

        // 2. Action: Partner A tries to add food to Partner B's restaurant
        $response = $this->actingAs($partnerA)->post(route('partner.listings.store'), [
            'restaurant_id' => $restaurantB->id,
            'name' => 'Stolen Donuts',
            'original_price' => 50000,
            'surplus_price' => 20000,
            'quantity' => 10,
            'pickup_start' => now()->addHour()->toDateTimeString(),
            'pickup_end' => now()->addHours(3)->toDateTimeString(),
        ]);

        // 3. Assert: The system throws a 403 Forbidden error
        $response->assertStatus(403);
        $this->assertDatabaseMissing('listings', [
            'name' => 'Stolen Donuts',
        ]);
    }

    public function test_partner_can_update_their_own_listing(): void
    {
        $partner = User::factory()->create(['role' => 'partner']);
        $restaurant = Restaurant::factory()->create(['owner_id' => $partner->id]);
        $listing = Listing::factory()->create([
            'restaurant_id' => $restaurant->id,
            'name' => 'Old Name',
        ]);

        $response = $this->actingAs($partner)->put(route('partner.listings.update', $listing), [
            'restaurant_id' => $restaurant->id,
            'name' => 'New Updated Name',
            'original_price' => 50000,
            'surplus_price' => 20000,
            'quantity' => 5,
            'pickup_start' => now()->addHour()->toDateTimeString(),
            'pickup_end' => now()->addHours(3)->toDateTimeString(),
        ]);

        $response->assertRedirect(route('partner.listings.index'));
        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'name' => 'New Updated Name',
        ]);
    }
}