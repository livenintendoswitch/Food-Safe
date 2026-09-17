<?php

namespace Tests\Feature\Partner;

use App\Models\Listing;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PickupTest extends TestCase
{
    use RefreshDatabase;

    public function test_restaurant_owner_can_complete_a_paid_order_with_correct_code(): void
    {
        [$partner, $order] = $this->order();

        $this->actingAs($partner)->post(route('partner.orders.pickup', $order), [
            'pickup_code' => $order->pickup_code,
        ])->assertRedirect(route('partner.orders.show', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id, 'payment_status' => 'PAID', 'order_status' => 'COMPLETED',
        ]);
    }

    public function test_pickup_rejects_invalid_code(): void
    {
        [$partner, $order] = $this->order();

        $response = $this->from(route('partner.orders.show', $order))->actingAs($partner)
            ->post(route('partner.orders.pickup', $order), ['pickup_code' => 'WRONGCODE001']);

        $response->assertRedirect(route('partner.orders.show', $order));
        $response->assertSessionHasErrors('pickup_code');
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'order_status' => 'PAID']);
    }

    public function test_unpaid_order_cannot_be_completed(): void
    {
        [$partner, $order] = $this->order(['payment_status' => 'PENDING', 'order_status' => 'PENDING']);

        $response = $this->from(route('partner.orders.show', $order))->actingAs($partner)
            ->post(route('partner.orders.pickup', $order), ['pickup_code' => $order->pickup_code]);

        $response->assertRedirect(route('partner.orders.show', $order));
        $response->assertSessionHasErrors('order');
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'order_status' => 'PENDING']);
    }

    public function test_other_partner_cannot_complete_pickup(): void
    {
        [, $order] = $this->order();
        $otherPartner = User::query()->create([
            'name' => 'Other Partner', 'email' => 'other-partner@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'partner',
        ]);

        $this->actingAs($otherPartner)->post(route('partner.orders.pickup', $order), [
            'pickup_code' => $order->pickup_code,
        ])->assertForbidden();
    }

    public function test_completed_order_cannot_be_completed_again(): void
    {
        [$partner, $order] = $this->order(['order_status' => 'COMPLETED']);

        $response = $this->from(route('partner.orders.show', $order))->actingAs($partner)
            ->post(route('partner.orders.pickup', $order), ['pickup_code' => $order->pickup_code]);

        $response->assertRedirect(route('partner.orders.show', $order));
        $response->assertSessionHasErrors('order');
    }

    private function order(array $overrides = []): array
    {
        $partner = User::query()->create([
            'name' => 'Partner', 'email' => 'partner@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'partner',
        ]);
        $customer = User::query()->create([
            'name' => 'Customer', 'email' => 'customer@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'customer',
        ]);
        $restaurant = Restaurant::query()->create([
            'owner_id' => $partner->id, 'name' => 'Test Restaurant', 'address' => 'Jakarta',
        ]);
        $listing = Listing::query()->create([
            'restaurant_id' => $restaurant->id, 'name' => 'Test Listing',
            'original_price' => 30000, 'surplus_price' => 15000, 'quantity' => 10,
            'pickup_start' => now()->addHour(), 'pickup_end' => now()->addHours(2), 'status' => 'ACTIVE',
        ]);
        $order = Order::query()->create(array_merge([
            'customer_id' => $customer->id, 'restaurant_id' => $restaurant->id,
            'listing_id' => $listing->id, 'quantity' => 1, 'total_price' => 15000,
            'payment_status' => 'PAID', 'order_status' => 'PAID', 'pickup_code' => 'PICKUPTEST01',
        ], $overrides));

        return [$partner, $order];
    }
}
