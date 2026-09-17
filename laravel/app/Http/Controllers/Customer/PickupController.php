<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class PickupController
{
    use AuthorizesRequests;

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        abort_unless(
            $order->payment_status === 'PAID'
            && $order->order_status === 'PAID',
            403,
            'This order is not ready for pickup.'
        );

        return view('customer.pickup', compact('order'));
    }
}