<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Services\Transaction\PaymentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class PaymentController
{
    use AuthorizesRequests;

    public function __construct(
        private PaymentService $paymentService,
    ) {
    }

    public function store(Order $order): RedirectResponse
    {
        $this->authorize('pay', $order);

        $this->paymentService->completeMockPayment($order);

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('success', 'Payment successful. Your order is ready for pickup.');
    }
}