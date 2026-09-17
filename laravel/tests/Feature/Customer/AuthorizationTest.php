<?php

namespace Tests\Feature\Customer;

use App\Models\Listing;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_for_customer_orders(): void
    {
        $this->get('/orders')->assertRedirect('/login');
    }

    public function test_customer_cannot_view_pay_or_see_pickup_code_for_another_customers_order(): void
    {
        [$owner, $order] = $this->paidOrder();
        $otherCustomer = User::query()->create([
            'name' => 'Other Customer', 'email' => 'other@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'customer',
        ]);

        $this->assertNotSame($owner->id, $otherCustomer->id);
        $this->actingAs($otherCustomer)->get(route('customer.orders.show', $order))->assertForbidden();
        $this->actingAs($otherCustomer)->post(route('customer.orders.payment', $order))->assertForbidden();
        $this->actingAs($otherCustomer)->get(route('customer.orders.pickup', $order))->assertForbidden();
    }

    public function test_partner_cannot_access_customer_order_routes(): void
    {
        [, $order] = $this->paidOrder();
        $partner = User::query()->create([
            'name' => 'Partner', 'email' => 'partner@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'partner',
        ]);

        $this->actingAs($partner)->get(route('customer.orders.show', $order))->assertForbidden();
    }

    private function paidOrder(): array
    {
        $owner = User::query()->create([
            'name' => 'Owner', 'email' => 'owner@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'customer',
        ]);
        $restaurantOwner = User::query()->create([
            'name' => 'Restaurant Owner', 'email' => 'restaurant-owner@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'partner',
        ]);
        $restaurant = Restaurant::query()->create([
            'owner_id' => $restaurantOwner->id, 'name' => 'Test Restaurant', 'address' => 'Jakarta',
        ]);
        $listing = Listing::query()->create([
            'restaurant_id' => $restaurant->id, 'name' => 'Test Listing',
            'original_price' => 30000, 'surplus_price' => 15000, 'quantity' => 10,
            'pickup_start' => now()->addHour(), 'pickup_end' => now()->addHours(2), 'status' => 'ACTIVE',
        ]);
        $order = Order::query()->create([
            'customer_id' => $owner->id, 'restaurant_id' => $restaurant->id,
            'listing_id' => $listing->id, 'quantity' => 1, 'total_price' => 15000,
            'payment_status' => 'PAID', 'order_status' => 'PAID', 'pickup_code' => 'AUTHCODE0001',
        ]);

        return [$owner, $order];
    }
}
