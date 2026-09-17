<?php

namespace Tests\Feature\Customer;

use App\Models\Listing;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_an_order_with_a_server_calculated_total(): void
    {
        $customer = $this->customer();
        $listing = $this->listing(quantity: 10, surplusPrice: 15000);

        $response = $this->actingAs($customer)->post('/orders', [
            'listing_id' => $listing->id,
            'quantity' => 2,
            'total_price' => 1,
        ]);

        $order = Order::query()->sole();

        $response->assertRedirect(route('customer.orders.show', $order));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_id' => $customer->id,
            'restaurant_id' => $listing->restaurant_id,
            'listing_id' => $listing->id,
            'quantity' => 2,
            'total_price' => 30000,
            'payment_status' => 'PENDING',
            'order_status' => 'PENDING',
        ]);
        $this->assertSame(8, $listing->fresh()->quantity);
        $this->assertSame(12, strlen($order->pickup_code));
    }

    public function test_order_rejects_an_invalid_quantity(): void
    {
        $customer = $this->customer();
        $listing = $this->listing(quantity: 10);

        $response = $this->from('/orders')->actingAs($customer)->post('/orders', [
            'listing_id' => $listing->id,
            'quantity' => 0,
        ]);

        $response->assertRedirect('/orders');
        $response->assertSessionHasErrors('quantity');
        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(10, $listing->fresh()->quantity);
    }

    public function test_order_rejects_insufficient_stock_without_changing_stock(): void
    {
        $customer = $this->customer();
        $listing = $this->listing(quantity: 1);

        $response = $this->from('/orders')->actingAs($customer)->post('/orders', [
            'listing_id' => $listing->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect('/orders');
        $response->assertSessionHasErrors('quantity');
        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(1, $listing->fresh()->quantity);
    }

    public function test_customer_cannot_view_another_customers_order(): void
    {
        $owner = $this->customer();
        $otherCustomer = $this->customer('other@example.test');
        $listing = $this->listing();
        $order = $this->order($owner, $listing);

        $this->actingAs($otherCustomer)
            ->get(route('customer.orders.show', $order))
            ->assertForbidden();
    }

    private function customer(string $email = 'customer@example.test'): User
    {
        return User::query()->create([
            'name' => 'Customer', 'email' => $email,
            'password' => Hash::make('Password123!'), 'role' => 'customer',
        ]);
    }

    private function listing(int $quantity = 10, int $surplusPrice = 15000): Listing
    {
        $partner = User::query()->create([
            'name' => 'Partner', 'email' => 'partner-'.uniqid().'@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'partner',
        ]);
        $restaurant = Restaurant::query()->create([
            'owner_id' => $partner->id, 'name' => 'Test Restaurant', 'address' => 'Jakarta',
        ]);

        return Listing::query()->create([
            'restaurant_id' => $restaurant->id, 'name' => 'Test Listing',
            'original_price' => 30000, 'surplus_price' => $surplusPrice,
            'quantity' => $quantity, 'pickup_start' => now()->addHour(),
            'pickup_end' => now()->addHours(2), 'status' => 'ACTIVE',
        ]);
    }

    private function order(User $customer, Listing $listing): Order
    {
        return Order::query()->create([
            'customer_id' => $customer->id, 'restaurant_id' => $listing->restaurant_id,
            'listing_id' => $listing->id, 'quantity' => 1,
            'total_price' => $listing->surplus_price, 'payment_status' => 'PENDING',
            'order_status' => 'PENDING', 'pickup_code' => 'ORDERTEST001',
        ]);
    }
}
