<?php

namespace App\Services\Transaction;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PickupService
{
    public function completePickup(
        Order $order,
        User $partner,
        string $pickupCode,
    ): Order {
        if ($partner->role !== 'partner') {
            throw new AuthorizationException('Only partners can complete pickups.');
        }

        return DB::transaction(function () use ($order, $partner, $pickupCode): Order {
            $order = Order::query()
                ->with('restaurant')
                ->lockForUpdate()
                ->findOrFail($order->id);

            if ($order->restaurant?->owner_id !== $partner->id) {
                throw new AuthorizationException(
                    'You do not own the restaurant for this order.'
                );
            }

            if (! hash_equals($order->pickup_code, strtoupper(trim($pickupCode)))) {
                throw ValidationException::withMessages([
                    'pickup_code' => 'The pickup code is invalid.',
                ]);
            }

            if (
                $order->payment_status !== 'PAID'
                || $order->order_status !== 'PAID'
            ) {
                throw ValidationException::withMessages([
                    'order' => 'Only paid orders can be picked up.',
                ]);
            }

            $order->update([
                'order_status' => 'COMPLETED',
            ]);

            return $order->fresh(['customer', 'restaurant', 'listing']);
        });
    }
}