<?php

namespace App\Services\Transaction;

use App\Models\Listing;
use App\Models\Order;
use App\Models\User;
use App\Services\Supply\InventoryService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(
        private InventoryService $inventoryService,
    ) {
    }

    public function createOrder(User $customer, int $listingId, int $quantity): Order
    {
        if ($customer->role !== 'customer') {
            throw new AuthorizationException('Only customers can create orders.');
        }

        return DB::transaction(function () use ($customer, $listingId, $quantity): Order {
            // Lock mencegah dua checkout mengambil stock yang sama secara bersamaan.
            $listing = Listing::query()
                ->lockForUpdate()
                ->findOrFail($listingId);

            if (! $this->inventoryService->validateStockAvailable($listing, $quantity)) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stock is insufficient or this listing is unavailable.',
                ]);
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'restaurant_id' => $listing->restaurant_id,
                'listing_id' => $listing->id,
                'quantity' => $quantity,
                'total_price' => round((float) $listing->surplus_price * $quantity, 2),
                'payment_status' => 'PENDING',
                'order_status' => 'PENDING',
                'pickup_code' => $this->generatePickupCode(),
            ]);

            // Inventory tetap sepenuhnya ditangani Backend 1.
            $this->inventoryService->decreaseStock($listing, $quantity);

            return $order;
        });
    }

    private function generatePickupCode(): string
    {
        do {
            $code = Str::upper(Str::random(12));
        } while (Order::query()->where('pickup_code', $code)->exists());

        return $code;
    }
}