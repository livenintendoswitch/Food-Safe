<?php

namespace Tests\Feature\Customer;

use App\Models\Listing;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_owner_can_complete_mock_payment(): void
    {
        [$customer, $order] = $this->pendingOrder();

        $this->actingAs($customer)->post(route('customer.orders.payment', $order))
            ->assertRedirect(route('customer.orders.show', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id, 'payment_status' => 'PAID', 'order_status' => 'PAID',
        ]);
    }

    public function test_customer_cannot_pay_another_customers_order(): void
    {
        [, $order] = $this->pendingOrder();
        $otherCustomer = $this->customer('other@example.test');

        $this->actingAs($otherCustomer)->post(route('customer.orders.payment', $order))
            ->assertForbidden();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'payment_status' => 'PENDING']);
    }

    public function test_repeated_mock_payment_keeps_order_paid(): void
    {
        [$customer, $order] = $this->pendingOrder();

        $this->actingAs($customer)->post(route('customer.orders.payment', $order));
        $this->actingAs($customer)->post(route('customer.orders.payment', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id, 'payment_status' => 'PAID', 'order_status' => 'PAID',
        ]);
    }

    public function test_cancelled_order_cannot_be_paid(): void
    {
        [$customer, $order] = $this->pendingOrder(['order_status' => 'CANCELLED']);

        $response = $this->from(route('customer.orders.show', $order))
            ->actingAs($customer)->post(route('customer.orders.payment', $order));

        $response->assertRedirect(route('customer.orders.show', $order));
        $response->assertSessionHasErrors('order');
    }

    private function pendingOrder(array $overrides = []): array
    {
        $customer = $this->customer();
        $partner = User::query()->create([
            'name' => 'Partner', 'email' => 'partner@example.test',
            'password' => Hash::make('Password123!'), 'role' => 'partner',
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
            'payment_status' => 'PENDING', 'order_status' => 'PENDING', 'pickup_code' => 'PAYMENTTEST1',
        ], $overrides));

        return [$customer, $order];
    }

    private function customer(string $email = 'customer@example.test'): User
    {
        return User::query()->create([
            'name' => 'Customer', 'email' => $email,
            'password' => Hash::make('Password123!'), 'role' => 'customer',
        ]);
    }
}
