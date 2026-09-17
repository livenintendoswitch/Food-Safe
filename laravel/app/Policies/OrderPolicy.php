<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return $order->customer_id === $user->id
            || $order->restaurant?->owner_id === $user->id;
    }

    public function pay(User $user, Order $order): bool
    {
    return $user->role === 'customer'
        && $order->customer_id === $user->id;
    }

    public function completePickup(User $user, Order $order): bool
    {
    return $user->role === 'partner'
        && $order->restaurant?->owner_id === $user->id;
    }
}
